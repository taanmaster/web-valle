<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;

use App\Models\Order;
use App\Models\BanBajioNotification;
use App\Services\Payments\BanBajioMultipagos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function testJson()
	{
        // Este archivo existe local, ajustar ruta.
		$body = @file_get_contents('./test_webhook.json');
		$data = json_decode($body, true);

		//dd($data['data']['object']);
	}

    public function order()
	{	
		$body = @file_get_contents('php://input');
		$data = json_decode($body, true);
		http_response_code(200); 

		if($data['type'] == 'charge.created'){
			$order = NULL;
			$reference = '';
			$payment_method = '';
			
			// Determinar el método de pago y obtener la referencia
			if($data['data']['object']['payment_method']['object'] == 'bank_payment'){
				// BanBajio
				$reference = $data['data']['object']['order_id'];	
				$payment_method = 'banbajio';
				$order = Order::where('payment_id', $reference)->where('payment_method', $payment_method)->first();
			
				if($order != NULL){
					$order->payment_status = 'Pago Pendiente';
					$order->payment_id = $data['data']['object']['payment_method']['reference'];
					$order->save();
				
					return response()->json(['mensaje' => 'Orden Pendiente de Pago.', 'order' => $reference, 'gateway' => 'BanBajio']);
				}else{
					return response()->json(['mensaje' => 'Ese numero de orden no existe.', 'order' => $reference, 'gateway' => 'BanBajio']);
				}
			}elseif($data['data']['object']['payment_method']['object'] == 'cash_payment'){
				// Oxxo (DigitalFemsa)
				$reference = $data['data']['object']['order_id'];
				$payment_method = 'oxxopay';
				$order = Order::where('payment_id', $reference)->where('payment_method', $payment_method)->first();
			
				if($order != NULL){
					$order->payment_status = 'Pago Pendiente';
					$order->payment_id = $data['data']['object']['payment_method']['reference'];
					$order->save();
				
					return response()->json(['mensaje' => 'Orden Pendiente de Pago.', 'order' => $reference, 'gateway' => 'Oxxo']);
				}else{
					return response()->json(['mensaje' => 'Ese numero de orden no existe.', 'order' => $reference, 'gateway' => 'Oxxo']);
				}
			}else{
				return response()->json(['mensaje' => 'Evento recibido con éxito.']);
			}
		}

		if($data['type'] == 'charge.expired'){
			$order = NULL;
			$reference = '';
			$gateway = '';
			
			if($data['data']['object']['payment_method']['object'] == 'bank_payment'){
				// BanBajio
				$reference = $data['data']['object']['payment_method']['reference'];
				$order = Order::where('payment_id', $reference)->where('payment_method', 'banbajio')->first();
				$gateway = 'BanBajio';
			}elseif($data['data']['object']['payment_method']['object'] == 'cash_payment'){
				// Oxxo (DigitalFemsa)
				$reference = $data['data']['object']['payment_method']['reference'];
				$order = Order::where('payment_id', $reference)->where('payment_method', 'oxxopay')->first();
				$gateway = 'Oxxo';
			}
			
			if($order != NULL){
				if($order->payment_status != 'Pagado'){
					$order->payment_status = 'Referencia Expirada';
					$order->save();
					
					return response()->json(['mensaje' => 'Orden Expirada.', 'order' => $reference, 'gateway' => $gateway]);
				}else{
					return response()->json(['mensaje' => 'La orden ya esta pagada.', 'order' => $reference, 'gateway' => $gateway]);
				}
			}else{
				return response()->json(['mensaje' => 'Orden no encontrada.', 'order' => $reference, 'gateway' => $gateway]);
			}
		}

		if ($data['type'] == 'charge.paid') {
			$order = NULL;
			$reference = '';
			$gateway = '';
			
			if($data['data']['object']['payment_method']['object'] == 'bank_payment'){
				// BanBajio
				$reference = $data['data']['object']['payment_method']['reference'];
				$order = Order::where('payment_id', $reference)->where('payment_method', 'banbajio')->first();
				$gateway = 'BanBajio';
			}elseif($data['data']['object']['payment_method']['object'] == 'cash_payment'){
				// Oxxo (DigitalFemsa)
				$reference = $data['data']['object']['payment_method']['reference'];
				$order = Order::where('payment_id', $reference)->where('payment_method', 'oxxopay')->first();
				$gateway = 'Oxxo';
			}
			
			if($order != NULL){
				$order->payment_status = 'Pagado';
				$order->paid_at = Carbon::now();
				$order->paid_amount = $order->total;
				$order->save();

				// Avanza los trámites vinculados (ej. alta de proveedor → padron_activo)
				$order->applyPaidSideEffects();

				return response()->json(['mensaje' => 'Orden Pagada Exitosamente.', 'order' => $reference, 'gateway' => $gateway]);
			}else{
				return response()->json(['mensaje' => 'Orden no encontrada.', 'order' => $reference, 'gateway' => $gateway]);
			}
		}

		return response()->json(['mensaje' => 'Evento recibido con éxito.']);
	}

    /**
     * Notificación de pago de Multipagos Bajío.
     *
     * BanBajío hace un POST con fields: cl_folio, t_concepto, cl_referencia,
     * dl_monto, dt_fechaPago, nl_tipoPago, nl_status, hash.
     * El cliente debe responder con el texto exacto "estatus_notificacion=0"
     * para que BanBajío considere la notificación exitosa.
     */
    public function bajioNotification(Request $request)
    {
		$payload = $request->all();
		$hash = (string) ($payload['hash'] ?? '');
		$reference = (string) ($payload['cl_referencia'] ?? '');
		$notificationAmount = $payload['dl_monto'] ?? null;
		$service = app(BanBajioMultipagos::class);
		$variant = $service->verificarNotificacion($payload, $hash);
		$order = $reference === '' ? null : Order::where('payment_reference', $reference)->first();

		$notification = BanBajioNotification::create([
			'order_id' => $order?->id,
			'cl_folio' => $payload['cl_folio'] ?? null,
			'cl_referencia' => $reference ?: null,
			'cl_servicio' => $payload['cl_servicio'] ?? null,
			't_concepto' => $payload['t_concepto'] ?? null,
			'dl_monto' => is_numeric($notificationAmount) ? number_format((float) $notificationAmount, 2, '.', '') : null,
			'dt_fecha_pago' => $payload['dt_fechaPago'] ?? null,
			'nl_tipo_pago' => $payload['nl_tipoPago'] ?? null,
			'nl_status' => $payload['nl_status'] ?? null,
			'hash' => $hash,
			'hash_valid' => $variant !== null,
			'hash_variant' => $variant,
			'raw_payload' => $payload,
			'response_sent' => 'estatus_notificacion=1',
		]);

		if ($variant === null || !$order || $order->payment_method !== 'banbajio' || (string) $order->id !== (string) ($payload['cl_folio'] ?? '')) {
			Log::channel((string) config('services.bajio.log_channel', 'banbajio'))->warning('banbajio.notification.rejected', [
				'order_id' => $order?->id,
				'hash_valid' => $variant !== null,
			]);

			return $this->bajioResponse($notification, false);
		}

		$status = (string) ($payload['nl_status'] ?? '');
		$reportedAmount = (string) ($payload['dl_monto'] ?? '');

		if ($status === '01') {
			if ($order->payment_status !== 'Pagado') {
				if (!$this->bajioAmountMatches($order->total, $reportedAmount)) {
					$order->update([
						'payment_status' => 'Pago Pendiente',
						'paid_amount' => is_numeric($reportedAmount) ? number_format((float) $reportedAmount, 2, '.', '') : null,
						'admin_note' => 'Monto reportado por BanBajío distinto al total de la orden: ' . $reportedAmount,
					]);

					return $this->bajioResponse($notification, true);
				}

				$order->update([
					'payment_status' => 'Pagado',
					'paid_at' => Carbon::now(),
					'paid_amount' => $reportedAmount,
				]);
				$order->applyPaidSideEffects();
			}
		} elseif ($status === '02') {
			if ($order->payment_status !== 'Pagado') {
				$order->update(['payment_status' => 'Fallido']);
			}
		} elseif ($status === '03') {
			if ($order->payment_status !== 'Pagado') {
				$order->update(['payment_status' => 'Pago Pendiente']);
			}
		} else {
			return $this->bajioResponse($notification, false);
		}

		return $this->bajioResponse($notification, true);
    }

	private function bajioAmountMatches($expected, string $reported): bool
	{
		return preg_match('/^\d+(?:\.\d{1,2})?$/', $reported) === 1
			&& number_format((float) $expected, 2, '.', '') === number_format((float) $reported, 2, '.', '');
	}

	private function bajioResponse(BanBajioNotification $notification, bool $accepted)
	{
		$response = 'estatus_notificacion=' . ($accepted ? '0' : '1');
		$notification->update([
			'response_sent' => $response,
			'processed_at' => $accepted ? Carbon::now() : null,
		]);

		return response($response, 200)->header('Content-Type', 'text/plain');
	}
}
