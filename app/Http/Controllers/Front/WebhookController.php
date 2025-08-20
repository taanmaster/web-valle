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
			
			if($data['data']['object']['payment_method']['object'] == 'bank_payment'){
				$reference = $data['data']['object']['order_id'];	
				$order = Order::where('payment_id', $reference)->where('payment_method', 'Pago con BanBajio')->first();
			
				if($order != NULL){
					$order->status = 'Pago Pendiente';
					$order->payment_id = $data['data']['object']['payment_method']['reference'];
					$order->save();
				
					return response()->json(['mensaje' => 'Orden Pendiente de Pago.', 'order' => $reference]);
				}else{
					return response()->json(['mensaje' => 'Ese numero de orden no existe.', 'order' => $reference]);
				}
			}else{
				return response()->json(['mensaje' => 'Evento recibido con éxito.']);
			}
		}

		if($data['type'] == 'charge.expired'){
			if($data['data']['object']['payment_method']['object'] == 'bank_payment'){
				$reference = $data['data']['object']['payment_method']['reference'];
				$order = Order::where('payment_id', $reference)->where('payment_method', 'Pago con BanBajio')->first();
			}
			
			if($order != NULL){
				if($order->status != 'Pagado'){
					$order->status = 'Referencia Expirada';
					$order->save();
					
					return response()->json(['mensaje' => 'Orden Expirada, asientos eliminados.', 'order' => $reference]);
				}else{
					return response()->json(['mensaje' => 'La orden ya esta pagada.', 'order' => $reference]);
				}
			}
		}

		if ($data['type'] == 'charge.paid') {
			if($data['data']['object']['payment_method']['object'] == 'bank_payment'){
				$reference = $data['data']['object']['payment_method']['reference'];
			}
			
			return response()->json(['mensaje' => 'Orden Pagada Exitosamente.', 'order' => $reference]);
		}

		return response()->json(['mensaje' => 'Evento recibido con éxito.']);
	}
}
