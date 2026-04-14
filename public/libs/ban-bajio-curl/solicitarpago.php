<?php
$data = json_decode(file_get_contents('php://input'), true);
$privateKey = openssl_pkey_get_private(file_get_contents('test-privk-commerce.pem'));

$hash = openssl_digest(json_encode($data), 'sha256', TRUE);
openssl_sign($hash, $signature, $privateKey, OPENSSL_ALGO_SHA512);

$data['hash'] = base64_encode($signature);
$context_options = [
        'http' => [
            'method' => 'POST',
            'header'=> "Content-type: application/json",
            'content' => json_encode($data)
            ]
        ];
$response = file_get_contents('http://localhost:8080/multipagos/api/pruebas/solicitar', false, $context_options));

echo $response;
?>