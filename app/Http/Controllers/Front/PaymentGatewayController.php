<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentGatewayController extends Controller
{
    public function paymentStore(Request $request)
    {
        $allowedMethods = ['oxxopay', 'banbajio'];
        if (app()->environment('local')) {
            $allowedMethods[] = 'test_payment';
        }

        $request->validate([
            'payment_method' => 'required|in:' . implode(',', $allowedMethods),
        ]);

        $user = Auth::user();
        $cart = $user->cart()->with('items.billableService')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('citizen.cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total
        $total = $cart->items->sum(fn($item) => $item->billableService->unit_price * $item->quantity);
        // Las APIs esperan el monto en centavos (entero)
        $totalCentavos = (int) round($total * 100);

        $payment_method = $request->payment_method;

        switch ($payment_method) {

            case 'oxxopay':
                try {
                    $private_key  = config('services.femsa.private_key', env('FEMSA_PRIVATE_KEY'));
                    $customer_url = "https://api.digitalfemsa.io/customers";
                    $header = [
                        "Authorization: Bearer " . $private_key,
                        "Accept: application/vnd.app-v2.1.0+json",
                        "Content-Type: application/json",
                    ];

                    // Crear cliente en DigitalFemsa
                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL            => $customer_url,
                        CURLOPT_HTTPHEADER     => $header,
                        CURLOPT_CUSTOMREQUEST  => "POST",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS     => json_encode([
                            'name'      => $user->name,
                            'last_name' => '',
                            'phone'     => $user->userInfo->phone ?? '0000000000',
                            'email'     => $user->email,
                        ]),
                    ]);
                    $client = json_decode(curl_exec($ch), true);
                    curl_close($ch);

                    if (empty($client['id'])) {
                        return redirect()->back()->with('error', 'No se pudo conectar con OXXOPay. Intenta de nuevo.');
                    }

                    // Crear Order en BD
                    $dbOrder = DB::transaction(function () use ($user, $cart, $total, $payment_method) {
                        $order = Order::create([
                            'user_id'        => $user->id,
                            'folio'          => Order::generateFolio(),
                            'total'          => $total,
                            'payment_method' => $payment_method,
                        ]);

                        foreach ($cart->items as $item) {
                            OrderItem::create([
                                'order_id'            => $order->id,
                                'billable_service_id' => $item->billable_service_id,
                                'service_name'        => $item->billableService->name,
                                'unit_price'          => $item->billableService->unit_price,
                                'quantity'            => $item->quantity,
                                'subtotal'            => $item->billableService->unit_price * $item->quantity,
                                'related_model_type'  => $item->related_model_type,
                                'related_model_id'    => $item->related_model_id,
                                'related_folio'       => $item->related_folio,
                                'related_user_id'     => $item->related_user_id,
                            ]);
                        }

                        $cart->items()->delete();

                        return $order;
                    });

                    // Crear orden en DigitalFemsa
                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL            => "https://api.digitalfemsa.io/orders",
                        CURLOPT_HTTPHEADER     => $header,
                        CURLOPT_CUSTOMREQUEST  => "POST",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS     => json_encode([
                            'line_items' => [[
                                'name'       => 'Pago de servicios municipales - Folio ' . $dbOrder->folio,
                                'unit_price' => $totalCentavos,
                                'quantity'   => 1,
                            ]],
                            'checkout' => [
                                'allowed_payment_methods' => ['cash'],
                                'type'                    => 'HostedPayment',
                                'success_url'             => route('oxxopay.complete'),
                                'failure_url'             => route('oxxopay.failed'),
                                'redirection_time'        => 30,
                                'expires_at'              => Carbon::now()->addHours(36)->timestamp,
                            ],
                            'customer_info' => ['customer_id' => $client['id']],
                            'currency'      => 'mxn',
                            'metadata'      => ['order_id' => (string) $dbOrder->id],
                        ]),
                    ]);
                    $gatewayOrder = json_decode(curl_exec($ch), true);
                    curl_close($ch);

                    // Guardar payment_id (id de la orden en el gateway) y URL de pago
                    $dbOrder->update([
                        'payment_id'  => $gatewayOrder['id'] ?? null,
                        'payment_url' => $gatewayOrder['checkout']['url'] ?? null,
                    ]);

                    session(['checkout_order_id' => $dbOrder->id]);

                    if (!empty($gatewayOrder['checkout']['url'])) {
                        return redirect()->away($gatewayOrder['checkout']['url']);
                    }

                    return redirect()->route('oxxopay.complete');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }

            case 'banbajio':
                try {
                    // Crear Order en BD
                    $dbOrder = DB::transaction(function () use ($user, $cart, $total, $payment_method) {
                        $order = Order::create([
                            'user_id'        => $user->id,
                            'folio'          => Order::generateFolio(),
                            'total'          => $total,
                            'payment_method' => $payment_method,
                        ]);

                        foreach ($cart->items as $item) {
                            OrderItem::create([
                                'order_id'            => $order->id,
                                'billable_service_id' => $item->billable_service_id,
                                'service_name'        => $item->billableService->name,
                                'unit_price'          => $item->billableService->unit_price,
                                'quantity'            => $item->quantity,
                                'subtotal'            => $item->billableService->unit_price * $item->quantity,
                                'related_model_type'  => $item->related_model_type,
                                'related_model_id'    => $item->related_model_id,
                                'related_folio'       => $item->related_folio,
                                'related_user_id'     => $item->related_user_id,
                            ]);
                        }

                        $cart->items()->delete();

                        return $order;
                    });

                    session(['checkout_order_id' => $dbOrder->id]);

                    // --- Multipagos Bajío: form POST con firma RSA/SHA512 ---
                    // El folio numérico es el ID de la orden (cl_folio debe ser numérico 1-20)
                    $clFolio    = (string) $dbOrder->id;
                    $clRef      = $dbOrder->folio;
                    $dlMonto    = number_format($total, 2, '.', '');
                    $servicio   = (string) config('services.bajio.servicio_id');
                    $clConcepto = (string) config('services.bajio.concepto', '1');

                    // Cadena a firmar: cl_folio|cl_referencia|dl_monto|cl_concepto|servicio|
                    $cadena = "{$clFolio}|{$clRef}|{$dlMonto}|{$clConcepto}|{$servicio}|";

                    $privateKeyPath = storage_path(config('services.bajio.private_key_path', 'keys/bajio/private_key.pem'));
                    $privateKeyPem  = file_get_contents($privateKeyPath);
                    $privateKey     = openssl_get_privatekey($privateKeyPem);

                    if (!$privateKey) {
                        throw new \RuntimeException('No se pudo cargar la llave privada de BanBajío.');
                    }

                    openssl_sign($cadena, $rawSignature, $privateKey, OPENSSL_ALGO_SHA512);
                    $hash          = $this->base64UrlEncode($rawSignature);
                    $multipagosUrl = config('services.bajio.multipagos_url', 'https://multipagos.bb.com.mx/Estandar/index2.php');

                    // Devuelve una vista con un formulario oculto que se auto-envía al portal de BanBajío
                    return view('front.checkout.bajio-redirect', compact(
                        'clFolio', 'clRef', 'dlMonto', 'servicio', 'clConcepto', 'hash', 'multipagosUrl'
                    ));
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }

            case 'test_payment':
                abort_unless(app()->environment('local'), 403);

                try {
                    $dbOrder = DB::transaction(function () use ($user, $cart, $total, $payment_method) {
                        $order = Order::create([
                            'user_id'          => $user->id,
                            'folio'            => Order::generateFolio(),
                            'total'            => $total,
                            'payment_method'   => 'banbajio',
                            'payment_status'   => 'Pagado',
                            'paid_amount'      => $total,
                            'paid_at'          => Carbon::now(),
                            'payment_id'       => 'TEST-' . strtoupper(uniqid()),
                            'payment_reference'=> 'SIMULACIÓN DE PAGO — AMBIENTE LOCAL',
                        ]);

                        foreach ($cart->items as $item) {
                            OrderItem::create([
                                'order_id'            => $order->id,
                                'billable_service_id' => $item->billable_service_id,
                                'service_name'        => $item->billableService->name,
                                'unit_price'          => $item->billableService->unit_price,
                                'quantity'            => $item->quantity,
                                'subtotal'            => $item->billableService->unit_price * $item->quantity,
                                'related_model_type'  => $item->related_model_type,
                                'related_model_id'    => $item->related_model_id,
                                'related_folio'       => $item->related_folio,
                                'related_user_id'     => $item->related_user_id,
                            ]);
                        }

                        $cart->items()->delete();

                        return $order;
                    });

                    session(['checkout_order_id' => $dbOrder->id]);

                    return redirect()->route('bajiopay.complete');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
            default:
                return redirect()->back()->with('error', 'Método de pago no válido.');
        }
    }

    /**
     * Codificación base64 URL-safe usada por Multipagos Bajío (reemplaza +/= con -_,)
     */
    private function base64UrlEncode(string $data): string
    {
        return strtr(base64_encode($data), '+/=', '-_,');
    }
}


