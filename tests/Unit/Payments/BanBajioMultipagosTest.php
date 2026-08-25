<?php

namespace Tests\Unit\Payments;

use App\Services\Payments\BanBajioMultipagos;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BanBajioMultipagosTest extends TestCase
{
    public function test_signs_the_rest_request_with_the_local_test_keys(): void
    {
        $privateKeyPath = storage_path('keys/bajio/private_key.pem');
        $publicKeyPath = storage_path('keys/bajio/public_key_bajio.pem');

        $this->assertFileExists($privateKeyPath);
        $this->assertFileExists($publicKeyPath);

        config([
            'services.bajio.private_key_path' => 'keys/bajio/private_key.pem',
            'services.bajio.public_key_path' => 'keys/bajio/public_key_bajio.pem',
            'services.bajio.servicio_id' => '9999',
            'services.bajio.concepto' => '1',
        ]);

        $service = app(BanBajioMultipagos::class);
        $data = [
            'folio' => '123',
            'referencia' => 'ABC1234567',
            'monto' => '485.22',
            'concepto' => '1',
            'servicio' => '9999',
        ];

        $cadena = $service->cadenaSolicitud($data);
        $signature = base64_decode($service->firmar($cadena), true);
        $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyPath));

        $this->assertSame('123|ABC1234567|485.22|1|9999|', $cadena);
        $this->assertSame(1, openssl_verify($cadena, $signature, $publicKey, OPENSSL_ALGO_SHA512));
    }

    public function test_verifies_url_safe_notification_hashes_with_the_local_test_keys(): void
    {
        config([
            'services.bajio.private_key_path' => 'keys/bajio/private_key.pem',
            'services.bajio.public_key_path' => 'keys/bajio/public_key_bajio.pem',
            'services.bajio.hash_probe' => false,
        ]);

        $service = app(BanBajioMultipagos::class);
        $payload = [
            'cl_folio' => '123',
            't_concepto' => '1',
            'cl_referencia' => 'ABC1234567',
            'dl_monto' => '485.22',
            'dt_fechaPago' => '2026-08-25',
            'nl_tipoPago' => '02',
            'nl_status' => '01',
        ];

        $hash = strtr(base64_encode(base64_decode($service->firmar($service->cadenaNotificacionCompleta($payload)))), '+/=', '-_,');

        $this->assertSame('completa', $service->verificarNotificacion($payload, $hash));
    }

    public function test_requests_and_parses_a_payment_url_without_exposing_the_signature_to_the_browser(): void
    {
        config([
            'services.bajio.private_key_path' => 'keys/bajio/private_key.pem',
            'services.bajio.servicio_id' => '9999',
            'services.bajio.concepto' => '1',
            'services.bajio.api_url' => 'https://multipagos.test/solicitar',
        ]);

        Http::fake([
            'https://multipagos.test/solicitar' => Http::response('{"body":"https://multipagos.test/pago/123"}'),
        ]);

        $paymentUrl = app(BanBajioMultipagos::class)->solicitarPago('123', 'ABC1234567', '485.22');

        $this->assertSame('https://multipagos.test/pago/123', $paymentUrl);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://multipagos.test/solicitar'
                && $request['monto'] === '485.22'
                && base64_decode($request['hash'], true) !== false;
        });
    }

    public function test_turns_a_connection_failure_into_a_controlled_exception(): void
    {
        config([
            'services.bajio.private_key_path' => 'keys/bajio/private_key.pem',
            'services.bajio.servicio_id' => '9999',
            'services.bajio.api_url' => 'https://multipagos.test/solicitar',
        ]);
        Http::fake(function () {
            throw new ConnectionException('timeout');
        });

        $this->expectException(\App\Services\Payments\BanBajioException::class);

        app(BanBajioMultipagos::class)->solicitarPago('123', 'ABC1234567', '485.22');
    }
}