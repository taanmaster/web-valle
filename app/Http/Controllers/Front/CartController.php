<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\BillableService;
use App\Models\IdentificationCertificate;
use App\Models\Supplier;
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

        // Servicios solo-por-trámite no se agregan genéricamente; van por su flujo (ej. alta de proveedor)
        if ($service->requires_procedure) {
            return redirect()->back()
                ->with('error', 'Este servicio solo puede pagarse desde su trámite correspondiente.');
        }

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

        // Trámites vinculados: 1 por orden (regla de negocio). No se permite cambiar la cantidad.
        if ($cartItem->related_model_id) {
            return redirect()->route('citizen.cart.index');
        }

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

    /**
     * Pagar en línea una constancia de identificación.
     * Vacía el carrito actual y agrega únicamente el servicio de constancia solicitado,
     * vinculando el trámite (modelo, folio, usuario) al item del carrito.
     */
    public function addCertificateToCart(Request $request, int $id)
    {
        $certificate = IdentificationCertificate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($certificate->status !== 'Pago pendiente') {
            return redirect()->back()
                ->with('error', 'Solo se pueden pagar en línea constancias con estatus "Pago pendiente".');
        }

        $billableServiceId = $request->input('billable_service_id');
        $service = $billableServiceId
            ? BillableService::where('id', $billableServiceId)->where('is_active', true)->first()
            : BillableService::where('name', 'Constancia de Origen e Identidad')->where('is_active', true)->first();

        if (!$service) {
            return redirect()->back()
                ->with('error', 'El servicio de pago no está disponible en este momento.');
        }

        $cart = $this->getOrCreateCart();

        // Regla: 1 documento por orden — vaciar carrito antes de agregar
        $cart->items()->delete();

        $cart->items()->create([
            'billable_service_id' => $service->id,
            'quantity'            => 1,
            'related_model_type'  => IdentificationCertificate::class,
            'related_model_id'    => $certificate->id,
            'related_folio'       => $certificate->folio,
            'related_user_id'     => $certificate->user_id,
        ]);

        return redirect()->route('citizen.cart.index')
            ->with('success', 'Constancia "' . $certificate->folio . '" agregada al carrito. Procede al pago.');
    }

    /**
     * Pagar en línea una Solicitud de Alta de Proveedor.
     * Misma mecánica que addCertificateToCart: vacía el carrito (1 trámite por orden)
     * y vincula la alta (modelo, folio, usuario) al item.
     */
    public function addSupplierAltaToCart(Request $request, int $id)
    {
        $supplier = Supplier::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($supplier->status !== 'pago_pendiente') {
            return redirect()->back()
                ->with('error', 'Solo se pueden pagar en línea las altas con estatus "Pago pendiente".');
        }

        $service = BillableService::where('name', 'Solicitud Alta de Proveedor')
            ->where('is_active', true)
            ->first();

        if (!$service) {
            return redirect()->back()
                ->with('error', 'El servicio de pago no está disponible en este momento.');
        }

        $cart = $this->getOrCreateCart();

        // Regla: 1 trámite por orden — vaciar carrito antes de agregar
        $cart->items()->delete();

        $cart->items()->create([
            'billable_service_id' => $service->id,
            'quantity'            => 1,
            'related_model_type'  => Supplier::class,
            'related_model_id'    => $supplier->id,
            'related_folio'       => $supplier->registration_number,
            'related_user_id'     => $supplier->user_id,
        ]);

        // Vuelve al listado de altas y dispara el modal de confirmación
        return redirect()->route('supplier.alta.index')
            ->with('cart_added_folio', $supplier->registration_number);
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
