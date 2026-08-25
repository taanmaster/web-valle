<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /** Vista de selección de método de pago */
    public function index()
    {
        $cart = Auth::user()->cart()->with('items.billableService')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('citizen.cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        return view('front.checkout.index', compact('cart'));
    }

    /** Pantalla de éxito después del pago */
    public function success()
    {
        $orderId = session('checkout_order_id');
        $order   = $orderId ? Order::with('items')->find($orderId) : null;

        // Limpiar la sesión una vez mostrado
        session()->forget('checkout_order_id');

        return view('front.checkout.success', compact('order'));
    }

    /** Pantalla de pago fallido */
    public function failed()
    {
        return view('front.checkout.failed');
    }

    public function status(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        return response()->json([
            'payment_status' => $order->payment_status,
            'paid_at' => $order->paid_at?->toIso8601String(),
        ]);
    }
}
