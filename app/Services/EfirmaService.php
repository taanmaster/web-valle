<?php

namespace App\Services;

use RuntimeException;

class EfirmaService
{
    protected string $baseUrl;
    protected string $userId;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('efirma.base_url', 'https://mx.efirma.com'), '/');
        $this->userId  = (string) config('efirma.user_id', '');
        $this->apiKey  = (string) config('efirma.api_key', '');
    }

    /**
     * Verificar conectividad y credenciales (sanity check).
     * GET /api/account
     */
    public function isAvailable(): bool
    {
        try {
            $result = $this->request('GET', '/api/account');
            return $result['success'];
        } catch (RuntimeException $e) {
            return false;
        }
    }

    /**
     * Crear/subir documento a eFirma para firmado.
     * POST /api/document/  (multipart/form-data)
     *
     * @param string $pdfContent  Contenido binario del PDF
     * @param array  $metadata    Metadatos del documento (name, tags, etc.)
     */
    public function createDocument(string $pdfContent, array $metadata): array
    {
        return $this->requestMultipart('/api/document/', $pdfContent, $metadata);
    }

    /**
     * Consultar documento por ID.
     * GET /api/document/get/:id
     */
    public function getDocument(string $efirmaId): array
    {
        return $this->request('GET', '/api/document/get/' . urlencode($efirmaId));
    }

    /**
     * Obtener firmas de un documento.
     * POST /api/document/get_signatures
     */
    public function getSignatures(string $efirmaId): array
    {
        return $this->request('POST', '/api/document/get_signatures', ['id' => $efirmaId]);
    }

    /**
     * Enviar recordatorio de firma.
     * POST /api/document/send_reminder/
     */
    public function sendReminder(string $efirmaId): array
    {
        return $this->request('POST', '/api/document/send_reminder/', ['id' => $efirmaId]);
    }

    /**
     * Eliminar documento (solo si fue creado por la API Key y no está firmado).
     * GET /api/document/delete/:id
     */
    public function deleteDocument(string $efirmaId): array
    {
        return $this->request('GET', '/api/document/delete/' . urlencode($efirmaId));
    }

    // -------------------------------------------------------------------------
    // Métodos privados
    // -------------------------------------------------------------------------

    /**
     * Construir el valor del header X-eFirma-Auth.
     */
    protected function buildAuthHeader(): string
    {
        return json_encode([
            'user_id' => $this->userId,
            'api_key'  => $this->apiKey,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Ejecutar una solicitud JSON a la API de eFirma.
     *
     * @param  string $method   GET | POST
     * @param  string $endpoint Ruta relativa (ej. /api/account)
     * @param  array  $data     Datos a enviar en el body (solo para POST)
     * @return array  ['success' => bool, 'http_status' => int, 'data' => array]
     *
     * @throws RuntimeException en errores cURL o respuestas 4xx/5xx
     */
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $ch  = curl_init();

        $headers = [
            'X-eFirma-Auth: ' . $this->buildAuthHeader(),
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, config('efirma.timeout_connect', 10));
        curl_setopt($ch, CURLOPT_TIMEOUT, config('efirma.timeout_request', 60));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
            }
        }

        $response  = curl_exec($ch);
        $httpCode  = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new RuntimeException("cURL error comunicándose con eFirma: {$curlError}");
        }

        $decoded = json_decode($response, true) ?? [];

        if ($httpCode >= 400) {
            $message = $decoded['message'] ?? $decoded['error'] ?? $response;
            throw new RuntimeException("eFirma API error {$httpCode}: {$message}");
        }

        return [
            'success'     => $httpCode >= 200 && $httpCode < 300,
            'http_status' => $httpCode,
            'data'        => $decoded,
        ];
    }

    /**
     * Enviar documento como multipart/form-data.
     * Crea un archivo temporal del PDF y lo sube con CURLFile.
     */
    protected function requestMultipart(string $endpoint, string $pdfContent, array $metadata): array
    {
        $url = $this->baseUrl . $endpoint;
        $ch  = curl_init();

        $headers = [
            'X-eFirma-Auth: ' . $this->buildAuthHeader(),
            'Accept: application/json',
        ];

        // Archivo temporal para el PDF
        $tmpFile = tmpfile();
        fwrite($tmpFile, $pdfContent);
        $tmpPath  = stream_get_meta_data($tmpFile)['uri'];
        $filename = ($metadata['name'] ?? 'documento') . '.pdf';

        $postFields = [
            'file' => new \CURLFile($tmpPath, 'application/pdf', $filename),
            'data' => json_encode($metadata, JSON_UNESCAPED_UNICODE),
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, config('efirma.timeout_connect', 10));
        curl_setopt($ch, CURLOPT_TIMEOUT, config('efirma.timeout_request', 60));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        $response  = curl_exec($ch);
        $httpCode  = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        fclose($tmpFile);

        if ($curlError) {
            throw new RuntimeException("cURL error al subir documento a eFirma: {$curlError}");
        }

        $decoded = json_decode($response, true) ?? [];

        if ($httpCode >= 400) {
            $message = $decoded['message'] ?? $decoded['error'] ?? $response;
            throw new RuntimeException("eFirma API error {$httpCode}: {$message}");
        }

        return [
            'success'     => $httpCode >= 200 && $httpCode < 300,
            'http_status' => $httpCode,
            'data'        => $decoded,
        ];
    }
}
