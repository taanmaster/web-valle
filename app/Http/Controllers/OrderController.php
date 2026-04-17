<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user', 'items')
            ->when($request->search, fn($q) => $q->where('folio', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%')))
            ->when($request->payment_status, fn($q) => $q->where('payment_status', $request->payment_status))
            ->when($request->delivery_status, fn($q) => $q->where('delivery_status', $request->delivery_status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('backoffice.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items');
        return view('backoffice.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'delivery_status' => 'required|in:Pendiente,Entregado,Cancelado',
        ]);

        $data = ['delivery_status' => $request->delivery_status];

        if ($request->delivery_status === 'Entregado' && is_null($order->delivered_at)) {
            $data['delivered_at'] = Carbon::now();
        }

        if ($request->delivery_status === 'Cancelado' && is_null($order->cancelled_at)) {
            $data['cancelled_at'] = Carbon::now();
        }

        $order->update($data);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Estado actualizado correctamente.');
    }

    public function updateNote(Request $request, Order $order)
    {
        $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        $order->update(['admin_note' => $request->admin_note]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Nota guardada correctamente.');
    }
}
