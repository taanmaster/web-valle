<?php

namespace App\Http\Controllers\Front;

// Ayudantes
use DB;
use Mail;
use Carbon\Carbon;

// Modelos
use App\Models\User;
/* Aqui estarán los modelos que gestionen las Ordenes de Compra y Pagos */

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
					$order->status = 'Pago Pendiente';
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
					$order->status = 'Pago Pendiente';
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
				if($order->status != 'Pagado'){
					$order->status = 'Referencia Expirada';
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
				$order->status = 'Pagado';
				$order->save();
				
				return response()->json(['mensaje' => 'Orden Pagada Exitosamente.', 'order' => $reference, 'gateway' => $gateway]);
			}else{
				return response()->json(['mensaje' => 'Orden no encontrada.', 'order' => $reference, 'gateway' => $gateway]);
			}
		}

		return response()->json(['mensaje' => 'Evento recibido con éxito.']);
	}
}
