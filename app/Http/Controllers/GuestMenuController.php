<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestMenuController extends Controller
{
    public function index(string $qrToken): View
    {
        $table = $this->findTable($qrToken);
        $cart = $this->cart($qrToken);
        $categories = Category::with(['dishes' => fn ($query) => $query
            ->where('available', true)
            ->orderBy('name')])
            ->whereHas('dishes', fn ($query) => $query->where('available', true))
            ->orderBy('name')
            ->get();

        return view('guest.menu', [
            'table' => $table,
            'categories' => $categories,
            'cart' => $cart,
            'cartTotal' => $this->cartTotal($cart),
            'finished' => session()->get($this->finishedKey($qrToken), false),
        ]);
    }

    public function addToCart(Request $request, string $qrToken, Dish $dish): RedirectResponse
    {
        $table = $this->findTable($qrToken);

        if (! $dish->available) {
            return back()->with('error', 'Este plato está agotado y no se puede agregar.');
        }

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $cart = $this->cart($qrToken);
        $item = $cart[$dish->id] ?? [
            'dish_id' => $dish->id,
            'name' => $dish->name,
            'price' => (float) $dish->price,
            'quantity' => 0,
        ];

        $item['quantity'] += (int) $data['quantity'];
        $cart[$dish->id] = $item;

        session()->put($this->cartKey($qrToken), $cart);
        session()->forget($this->finishedKey($qrToken));

        if ($table->status === Table::STATUS_AVAILABLE) {
            $table->update(['status' => Table::STATUS_OCCUPIED]);
        }

        return back()->with('success', 'Plato agregado al carrito de pre-pedido.');
    }

    public function updateCart(Request $request, string $qrToken, Dish $dish): RedirectResponse
    {
        $this->findTable($qrToken);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $cart = $this->cart($qrToken);

        if (isset($cart[$dish->id])) {
            $cart[$dish->id]['quantity'] = (int) $data['quantity'];
            session()->put($this->cartKey($qrToken), $cart);
        }

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function removeFromCart(string $qrToken, Dish $dish): RedirectResponse
    {
        $this->findTable($qrToken);

        $cart = $this->cart($qrToken);
        unset($cart[$dish->id]);
        session()->put($this->cartKey($qrToken), $cart);

        return back()->with('success', 'Plato retirado del carrito.');
    }

    public function finishSession(string $qrToken): RedirectResponse
    {
        $table = $this->findTable($qrToken);
        $table->update(['status' => Table::STATUS_READY_FOR_SERVICE]);
        session()->put($this->finishedKey($qrToken), true);

        return back()->with('success', 'Sesión finalizada. El personal ya ve la mesa como “Cliente listo”.');
    }

    private function findTable(string $qrToken): Table
    {
        return Table::where('qr_token', $qrToken)->firstOrFail();
    }

    private function cart(string $qrToken): array
    {
        return session()->get($this->cartKey($qrToken), []);
    }

    private function cartTotal(array $cart): float
    {
        return collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    private function cartKey(string $qrToken): string
    {
        return 'pre_order_cart_' . $qrToken;
    }

    private function finishedKey(string $qrToken): string
    {
        return 'pre_order_finished_' . $qrToken;
    }
}
