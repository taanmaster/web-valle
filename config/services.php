<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'recaptcha' => [
        'public_key' => env('GOOGLE_RECAPTCHA2_KEY'),
        'secret_key' => env('GOOGLE_RECAPTCHA2_SECRET'),
    ],

    // Multipagos BanBajío — firma RSA/SHA512 + form POST a multipagos.bb.com.mx
    'bajio' => [
        // ID de servicio y concepto proporcionados por BanBajío al contratar Multipagos
        'servicio_id'     => env('BAJIO_SERVICIO_ID'),
        'concepto'        => env('BAJIO_CONCEPTO', '1'),
        // Rutas relativas a storage_path() para las llaves PEM
        'private_key_path' => env('BAJIO_PRIVATE_KEY_PATH', 'keys/bajio/private_key.pem'),
        'public_key_path'  => env('BAJIO_PUBLIC_KEY_PATH',  'keys/bajio/public_key_bajio.pem'),
        // URL del portal de Multipagos (puede cambiarse a QA para pruebas)
        'multipagos_url'   => env('BAJIO_MULTIPAGOS_URL', 'https://multipagos.bb.com.mx/Estandar/index2.php'),
    ],

];
