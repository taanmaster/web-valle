<?php

namespace App\Http\Controllers\Front;

// Ayudantes
use DB;
use Mail;
use Carbon\Carbon;

// Modelos
use App\Models\User;
use App\Models\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $clFolio   = $request->input('cl_folio', '');
        $tConcepto = $request->input('t_concepto', '');
        $clRef     = $request->input('cl_referencia', '');
        $dlMonto   = $request->input('dl_monto', '');
        $dtFecha   = $request->input('dt_fechaPago', '');
        $tipoPago  = $request->input('nl_tipoPago', '');
        $nlStatus  = $request->input('nl_status', '');
        $hashRaw   = $request->input('hash', '');

        // Cadena BAJÍO: cl_folio|t_concepto|cl_referencia|dl_monto|dt_fechaPago|nl_tipoPago|nl_status|
        $originalString = "{$clFolio}|{$tConcepto}|{$clRef}|{$dlMonto}|{$dtFecha}|{$tipoPago}|{$nlStatus}|";

        // Decodificar la firma en base64 URL-safe (- → +, _ → /, , → =)
        $signature = base64_decode(strtr($hashRaw, '-_,', '+/='));

        // Verificar con la llave pública de BanBajío
        $publicKeyPath = storage_path(config('services.bajio.public_key_path', 'keys/bajio/public_key_bajio.pem'));
        $publicKeyPem  = @file_get_contents($publicKeyPath);

        if ($publicKeyPem) {
            $publicKey = openssl_get_publickey($publicKeyPem);
            $valid     = openssl_verify($originalString, $signature, $publicKey, OPENSSL_ALGO_SHA512) === 1;
        } else {
            // Si aún no se tiene la llave pública configurada, aceptar la notificación
            // (solo durante desarrollo; en producción la llave debe estar presente)
            $valid = app()->environment('local');
        }

        if ($valid) {
            $order = Order::find((int) $clFolio);

            if ($order && $order->payment_method === 'banbajio') {
                if ($nlStatus === '01') {
                    // Cobrado → Pagado
                    if ($order->payment_status !== 'Pagado') {
                        $order->update([
                            'payment_status'    => 'Pagado',
                            'paid_at'           => Carbon::now(),
                            'paid_amount'       => $order->total,
                            'payment_reference' => $clRef,
                        ]);
                    }
                } elseif ($nlStatus === '02') {
                    // Rechazo
                    $order->update(['payment_status' => 'Fallido']);
                } elseif ($nlStatus === '03') {
                    // Procesado (domiciliación, CLABE) — pendiente de acreditación
                    if ($order->payment_status === 'Pendiente') {
                        $order->update(['payment_status' => 'Pago Pendiente']);
                    }
                }
            }
        }

        // BanBajío requiere esta respuesta exacta en texto plano para considerar la notificación exitosa
        return response('estatus_notificacion=0', 200)
            ->header('Content-Type', 'text/plain');
    }
}
