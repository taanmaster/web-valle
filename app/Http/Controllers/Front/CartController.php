<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\BillableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /** Mostrar el carrito */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.billableService');

        return view('front.checkout.cart', compact('cart'));
    }

    /** Agregar o incrementar un servicio al carrito */
    public function store(Request $request)
    {
        $request->validate(['billable_service_id' => 'required|exists:billable_services,id']);

        $service = BillableService::where('id', $request->billable_service_id)
            ->where('is_active', true)
            ->firstOrFail();

        $cart = $this->getOrCreateCart();

        $item = $cart->items()->where('billable_service_id', $service->id)->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'billable_service_id' => $service->id,
                'quantity'            => 1,
            ]);
        }

        return redirect()->route('citizen.cart.index')
            ->with('success', '\"' . $service->name . '\" agregado al carrito.');
    }

    /** Actualizar cantidad de un item */
    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);

        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('citizen.cart.index');
    }

    /** Eliminar un item del carrito */
    public function destroy(CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);
        $cartItem->delete();

        return redirect()->route('citizen.cart.index')
            ->with('success', 'Servicio eliminado del carrito.');
    }

    // -------------------------------------------------------------------------

    private function getOrCreateCart(): Cart
    {
        return Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);
    }

    private function authorizeCartItem(CartItem $cartItem): void
    {
        $cart = Auth::user()->cart;
        abort_if(!$cart || $cartItem->cart_id !== $cart->id, 403);
    }
}
