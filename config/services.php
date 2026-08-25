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

    // Multipagos BanBajío — solicitud REST firmada con RSA/SHA512
    'bajio' => [
        'driver'           => env('BAJIO_DRIVER', 'rest'),
        // Valores proporcionados por BanBajío para Municipio Valle de Santiago.
        'servicio_id'      => '607',
        'concepto'         => '1',
        'api_url'          => env('APP_ENV') === 'production'
            ? 'https://multipagos.bb.com.mx/Estandar/solicitar'
            : 'https://multipagos.bb.com.mx/multipagos/api/pruebas/solicitar',
        'private_key_path' => env('BAJIO_PRIVATE_KEY_PATH', 'keys/bajio/private_key.pem'),
        'public_key_path'  => env('BAJIO_PUBLIC_KEY_PATH',  'keys/bajio/public_key_bajio.pem'),
        'timeout'          => (int) env('BAJIO_TIMEOUT', 15),
        'log_channel'      => env('BAJIO_LOG_CHANNEL', 'banbajio'),
        'hash_probe'       => (bool) env('BAJIO_HASH_PROBE', false),
    ],

];
