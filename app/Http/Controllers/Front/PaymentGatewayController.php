<?php

namespace App\Http\Controllers\Front;

// Ayudantes
use Carbon\Carbon;

// Modelos
/* Aqui estarán los modelos que gestionen las Ordenes de Compra y Pagos */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    // Simulación de proceso de Pago antes de existencia de flujo de usuario
    public function paymentStore(Request $request)
    {
        try {
            // Configure Bearer authorization: bearerAuth
            $private_key_bajio = env('BAJIO_PRIVATE_KEY');
            $public_key_bajio = env('BAJIO_PUBLIC_KEY');

            /* Crear Cliente */
            $customer_url = "https://api.banbajio.io/customers";

            $ch = curl_init();
            $customer_fields = array(
                'name' => $request->name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email
            );

            $customer_fields_string = json_encode($customer_fields);
            $header = array(
                "Authorization: Bearer " . $private_key_bajio,
                "Accept: application/vnd.app-v2.1.0+json",
                "Content-Type: application/json"
            );

            curl_setopt($ch, CURLOPT_URL, $customer_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $customer_fields_string);

            $result = curl_exec($ch);
            curl_close($ch);

            $bajiopay_client = json_decode($result, true);
            /*dd($bajiopay_client);*/

            /* Crear Orden */
            $order_url = "https://api.banbajio.io/orders";

            $ch = curl_init();
            $order_fields = array(
                'line_items'=> array(
                array(
                    "name" => 'Tu pago de servicios del Ayuntamiento',
                    "unit_price" => $request->final_total . '00',
                    "quantity" => 1,
                )
                ),
                'checkout' => array(
                    'allowed_payment_methods' => array("cash"),
                    'type' => 'HostedPayment',
                    'success_url' => route('bajiopay.complete'),
                    'failure_url' => route('bajiopay.failed'),
                    "redirection_time" => 30,
                    "expires_at" => Carbon::now()->addHours(36)->timestamp,
                ),
                    'customer_info' => array(
                    'customer_id'   =>  $bajiopay_client['id'],
                ),
                'currency'    => 'mxn',
                'metadata'    => array('description' => 'Pago con BanBajio')
            );

            $order_fields_string = json_encode($order_fields);
            $header = array(
                "Authorization: Bearer " . $private_key_bajio,
                "Accept: application/vnd.app-v2.1.0+json",
                "Content-Type: application/json"
            );

            curl_setopt($ch, CURLOPT_URL, $order_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $order_fields_string);

            $result = curl_exec($ch);
            curl_close($ch);

            $bajiopay_order = json_decode($result, true);
            //dd($bajiopay_order);
            
        } 
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
