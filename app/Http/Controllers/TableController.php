<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TableController extends Controller
{
    public function index(): View
    {
        $tables = Table::orderBy('number')->get();
        return view('tables.index', compact('tables'));
    }

    public function create(): View
    {
        return view('tables.create', ['table' => new Table(['status' => Table::STATUS_AVAILABLE])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['qr_token'] = (string) Str::uuid();

        Table::create($data);

        return redirect()->route('tables.index')
            ->with('success', 'Mesa creada correctamente con su QR único.');
    }

    public function show(Table $table): View
    {
        return view('tables.show', compact('table'));
    }

    public function edit(Table $table): View
    {
        return view('tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table): RedirectResponse
    {
        $table->update($this->validatedData($request, $table->id));

        return redirect()->route('tables.index')
            ->with('success', 'Mesa actualizada correctamente.');
    }

    public function destroy(Table $table): RedirectResponse
    {
        if ($table->hasActiveService()) {
            return back()->with('error', 'No se puede eliminar una mesa ocupada, pendiente de pago o con cliente listo.');
        }

        $table->delete();

        return redirect()->route('tables.index')
            ->with('success', 'Mesa eliminada correctamente.');
    }

    public function statusFeed(): JsonResponse
    {
        $tables = Table::orderBy('number')->get()->map(fn (Table $table) => [
            'id' => $table->id,
            'number' => $table->number,
            'capacity' => $table->capacity,
            'status' => $table->status,
            'status_label' => $table->statusLabel(),
            'status_class' => $table->statusClass(),
            'menu_url' => route('guest.menu', $table->qr_token),
        ]);

        return response()->json($tables);
    }

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $uniqueRule = 'unique:tables,number';
        if ($ignoreId) {
            $uniqueRule .= ',' . $ignoreId;
        }

        return $request->validate([
            'number' => ['required', 'integer', 'min:1', $uniqueRule],
            'capacity' => ['required', 'integer', 'min:1', 'max:30'],
            'status' => ['required', 'in:' . implode(',', Table::STATUSES)],
        ]);
    }
}
