<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DishController extends Controller
{
    public function index(): View
    {
        $dishes = Dish::with('category')
            ->orderBy('available', 'desc')
            ->orderBy('name')
            ->get();

        return view('dishes.index', compact('dishes'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('dishes.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        Dish::create($this->validatedData($request));

        return redirect()->route('dishes.index')
            ->with('success', 'Plato registrado correctamente y disponible en el menú digital.');
    }

    public function show(Dish $dish): View
    {
        $dish->load('category');
        return view('dishes.show', compact('dish'));
    }

    public function edit(Dish $dish): View
    {
        $categories = Category::orderBy('name')->get();
        return view('dishes.edit', compact('dish', 'categories'));
    }

    public function update(Request $request, Dish $dish): RedirectResponse
    {
        $data = $this->validatedData($request, $dish);

        if (isset($data['image']) && $dish->image) {
            Storage::disk('public')->delete($dish->image);
        }

        $dish->update($data);

        return redirect()->route('dishes.index')
            ->with('success', 'Plato actualizado correctamente.');
    }

    public function destroy(Dish $dish): RedirectResponse
    {
        if ($dish->image) {
            Storage::disk('public')->delete($dish->image);
        }

        $dish->delete();

        return redirect()->route('dishes.index')
            ->with('success', 'Plato eliminado del catálogo administrativo.');
    }

    public function toggleAvailability(Dish $dish): RedirectResponse
    {
        $dish->update(['available' => ! $dish->available]);

        $message = $dish->available
            ? 'El plato fue reactivado y vuelve a aparecer en el menú del comensal.'
            : 'El plato fue marcado como agotado y desaparece del menú del comensal.';

        return back()->with('success', $message);
    }

    private function validatedData(Request $request, ?Dish $dish = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'available' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['available'] = $request->boolean('available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('dishes', 'public');
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
