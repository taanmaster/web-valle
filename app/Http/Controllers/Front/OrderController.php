<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /** Listado de órdenes del ciudadano */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->latest()
            ->paginate(10);

        return view('front.orders.index', compact('orders'));
    }

    /** Detalle de una orden */
    public function show(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        $order->load('items');

        return view('front.orders.show', compact('order'));
    }

    /** Descarga recibo PDF */
    public function receipt(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        $order->load('items', 'user');

        $pdf = Pdf::loadView('front.orders.receipt', compact('order'));

        return $pdf->download('recibo-' . $order->folio . '.pdf');
    }
}
