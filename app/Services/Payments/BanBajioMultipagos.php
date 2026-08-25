<?php

namespace App\Services\Payments;

use App\Services\Payments\BanBajioException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class BanBajioMultipagos
{
    public function solicitarPago(string $folio, string $referencia, string $monto): string
    {
        $data = [
            'servicio' => (string) config('services.bajio.servicio_id'),
            'concepto' => (string) config('services.bajio.concepto', '1'),
            'folio' => $folio,
            'referencia' => $referencia,
            'monto' => $monto,
        ];

        if ($data['servicio'] === '') {
            throw new BanBajioException('No está configurado el servicio de Multipagos BanBajío.');
        }

        $data['hash'] = $this->firmar($this->cadenaSolicitud($data));

        try {
            $response = Http::timeout((int) config('services.bajio.timeout', 15))
                ->asJson()
                ->post((string) config('services.bajio.api_url'), $data);
        } catch (ConnectionException $exception) {
            Log::channel((string) config('services.bajio.log_channel', 'banbajio'))->error('banbajio.request.connection_failed', [
                'folio' => $folio,
                'message' => $exception->getMessage(),
            ]);

            throw new BanBajioException('No fue posible conectar con BanBajío.', 0, $exception);
        }

        if (!$response->successful()) {
            Log::channel((string) config('services.bajio.log_channel', 'banbajio'))->error('banbajio.request.failed', [
                'folio' => $folio,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new BanBajioException('No fue posible iniciar el pago con BanBajío.');
        }

        $paymentUrl = $this->extraerUrlPago($response->body());

        if ($paymentUrl === null) {
            Log::channel((string) config('services.bajio.log_channel', 'banbajio'))->error('banbajio.request.invalid_response', [
                'folio' => $folio,
                'body' => $response->body(),
            ]);

            throw new BanBajioException('BanBajío devolvió una respuesta de pago inválida.');
        }

        return $paymentUrl;
    }

    public function cadenaSolicitud(array $data): string
    {
        return implode('|', [
            $data['folio'],
            $data['referencia'],
            $data['monto'],
            $data['concepto'],
            $data['servicio'],
        ]) . '|';
    }

    public function firmar(string $cadena): string
    {
        $privateKeyPem = $this->leerLlave('private_key_path', 'privada');
        $privateKey = openssl_pkey_get_private($privateKeyPem);

        if ($privateKey === false) {
            throw new BanBajioException('No se pudo cargar la llave privada de BanBajío.');
        }

        if (!openssl_sign($cadena, $signature, $privateKey, OPENSSL_ALGO_SHA512)) {
            throw new BanBajioException('No se pudo firmar la solicitud de BanBajío.');
        }

        return base64_encode($signature);
    }

    public function verificarNotificacion(array $post, string $hash): ?string
    {
        try {
            $publicKeyPem = $this->leerLlave('public_key_path', 'pública');
        } catch (BanBajioException $exception) {
            Log::channel((string) config('services.bajio.log_channel', 'banbajio'))->error('banbajio.notification.public_key_unavailable', [
                'message' => $exception->getMessage(),
            ]);

            return null;
        }

        $publicKey = openssl_pkey_get_public($publicKeyPem);
        $signature = base64_decode($this->normalizarHash($hash), true);

        if ($publicKey === false || $signature === false) {
            return null;
        }

        $variants = [
            'completa' => $this->cadenaNotificacionCompleta($post),
        ];

        if (config('services.bajio.hash_probe', false)) {
            $variants['resumida'] = $this->cadenaNotificacionResumida($post);
        }

        foreach ($variants as $variant => $cadena) {
            if (openssl_verify($cadena, $signature, $publicKey, OPENSSL_ALGO_SHA512) === 1) {
                Log::channel((string) config('services.bajio.log_channel', 'banbajio'))->info('banbajio.notification.hash_variant', [
                    'variant' => $variant,
                ]);

                return $variant;
            }
        }

        return null;
    }

    public function cadenaNotificacionCompleta(array $post): string
    {
        return implode('|', [
            $post['cl_folio'] ?? '',
            $post['t_concepto'] ?? '',
            $post['cl_referencia'] ?? '',
            $post['dl_monto'] ?? '',
            $post['dt_fechaPago'] ?? '',
            $post['nl_tipoPago'] ?? '',
            $post['nl_status'] ?? '',
        ]) . '|';
    }

    public function normalizarHash(string $hash): string
    {
        $normalized = strtr(trim($hash), '-_,', '+/=');
        $remainder = strlen($normalized) % 4;

        return $remainder === 0 ? $normalized : $normalized . str_repeat('=', 4 - $remainder);
    }

    private function cadenaNotificacionResumida(array $post): string
    {
        return implode('|', [
            $post['cl_folio'] ?? '',
            $post['cl_referencia'] ?? '',
            $post['dl_monto'] ?? '',
            $post['t_concepto'] ?? '',
            $post['cl_servicio'] ?? '',
        ]) . '|';
    }

    private function leerLlave(string $configKey, string $tipo): string
    {
        $path = storage_path((string) config("services.bajio.{$configKey}"));
        $contents = is_readable($path) ? file_get_contents($path) : false;

        if ($contents === false || $contents === '') {
            throw new BanBajioException("No se pudo leer la llave {$tipo} de BanBajío.");
        }

        return $contents;
    }

    private function extraerUrlPago(string $body): ?string
    {
        $decoded = json_decode($body, true);
        $candidate = is_array($decoded) ? ($decoded['body'] ?? $decoded['url'] ?? null) : $body;

        if (!is_string($candidate)) {
            return null;
        }

        $url = trim($candidate, " \t\n\r\0\x0B\"");
        $scheme = parse_url($url, PHP_URL_SCHEME);

        return filter_var($url, FILTER_VALIDATE_URL) && in_array($scheme, ['http', 'https'], true) ? $url : null;
    }
}