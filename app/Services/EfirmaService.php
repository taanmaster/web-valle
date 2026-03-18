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
        // Trailing slash requerido: /api/document/ es el endpoint de creación.
        // /api/document (sin slash) acepta la request pero NO crea el documento (devuelve {"id":""}).
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
     * La API espera el campo 'docid' (no 'id').
     */
    public function getSignatures(string $efirmaId): array
    {
        return $this->request('POST', '/api/document/get_signatures', ['docid' => $efirmaId]);
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
     * Listar todos los documentos accesibles.
     * GET /api/document/get_all
     */
    public function getDocumentAll(array $queryParams = []): array
    {
        $endpoint = '/api/document/get_all';
        if (!empty($queryParams)) {
            $endpoint .= '?' . http_build_query($queryParams);
        }
        return $this->request('GET', $endpoint);
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
            'uid' => $this->userId,
            'key' => $this->apiKey,
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
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTREDIR, CURL_REDIR_POST_ALL); // preservar POST en 301/302/307

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

        // Escribir el PDF en un archivo temporal con ruta explícita
        // (CURLFile requiere un path real en disco; tmpfile() puede quedar bloqueado)
        $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $metadata['name'] ?? 'documento') . '.pdf';
        $tmpPath  = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'efirma_' . uniqid() . '_' . $filename;
        $bytesWritten = file_put_contents($tmpPath, $pdfContent);

        if ($bytesWritten === false || !file_exists($tmpPath) || filesize($tmpPath) === 0) {
            throw new RuntimeException(
                "No se pudo escribir el archivo temporal para eFirma en: {$tmpPath} "
                . '(bytes_written: ' . var_export($bytesWritten, true) . ', '
                . 'content_length: ' . strlen($pdfContent) . ')'
            );
        }

        $postFields = [
            'file' => new \CURLFile($tmpPath, 'application/pdf', $filename),
            'data' => json_encode($metadata, JSON_UNESCAPED_UNICODE),
        ];

        \Log::debug('[eFirma] requestMultipart enviando', [
            'url'       => $url,
            'file_size' => filesize($tmpPath),
            'filename'  => $filename,
            'data'      => $metadata,
        ]);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, config('efirma.timeout_connect', 10));
        curl_setopt($ch, CURLOPT_TIMEOUT, config('efirma.timeout_request', 60));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        $response     = curl_exec($ch);
        $httpCode     = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        $uploadSize   = curl_getinfo($ch, CURLINFO_SIZE_UPLOAD);
        $curlError    = curl_error($ch);
        curl_close($ch);
        @unlink($tmpPath); // limpiar archivo temporal

        if ($curlError) {
            throw new RuntimeException("cURL error al subir documento a eFirma: {$curlError}");
        }

        // Detectar redirect (3xx) — indica URL base incorrecta; el archivo se pierde en el redirect
        if ($httpCode >= 300 && $httpCode < 400) {
            $location = $response; // el body suele contener la URL destino
            throw new RuntimeException(
                "eFirma respondió con redirect {$httpCode}. "
                . "Esto causa pérdida del archivo PDF en el upload. "
                . "Verifique que EFIRMA_BASE_URL apunte al servidor regional correcto (ej. https://mx.efirma.com). "
                . "URL solicitada: {$url}"
            );
        }

        \Log::debug('[eFirma] requestMultipart raw response', [
            'http_status'   => $httpCode,
            'effective_url' => $effectiveUrl,
            'upload_size'   => $uploadSize,
            'body'          => $response,
        ]);

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
