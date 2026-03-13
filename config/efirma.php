<?php

return [
    /*
    |--------------------------------------------------------------------------
    | eFirma.com API Configuration
    |--------------------------------------------------------------------------
    |
    | Credentials for the eFirma.com electronic signature API.
    | These values must be set in the .env file and are only used server-side.
    | Never expose API keys to the frontend.
    |
    */

    'base_url' => env('EFIRMA_BASE_URL', 'https://mx.efirma.com'),

    'user_id' => env('EFIRMA_USER_ID'),

    'api_key' => env('EFIRMA_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeouts (seconds)
    |--------------------------------------------------------------------------
    */

    'timeout_connect' => 10,
    'timeout_request' => 60,
];
