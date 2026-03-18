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
     * @param string $pdfPath    Ruta absoluta al archivo PDF en disco
     * @param array  $metadata   Metadatos del documento (name, tags, etc.)
     */
    public function createDocument(string $pdfPath, array $metadata): array
    {
        // SIN trailing slash: /api/document (no /api/document/)
        // Con slash redirige 301 → pierde el archivo en el redirect.
        // curl CLI que funcionó usó /api/document sin slash.
        return $this->requestMultipart('/api/document', $pdfPath, $metadata);
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
     * Usa CURLFile con archivo en disco (réplica exacta del curl CLI que funcionó).
     * curl -v -X POST 'https://mx.efirma.com/api/document' \
     *  -H 'X-eFirma-Auth: {"uid":"USER_ID","key":"API_KEY"}' \
     *  -H 'Accept: application/json' \
     *  -F 'file=@/tmp/oficio_real.pdf;type=application/pdf' \
     *  -F 'data={"name":"Test_real_pdf","signature_type":2,"send_mails":false,"users":[{"email":"webmaster@valle.com","type":"signer"}]}'
     */
    protected function requestMultipart(string $endpoint, string $pdfPath, array $metadata): array
    {
        $url = $this->baseUrl . $endpoint;
        $ch  = curl_init();

        if (!file_exists($pdfPath) || filesize($pdfPath) === 0) {
            throw new RuntimeException("Archivo PDF no encontrado o vacío: {$pdfPath}");
        }

        $filename = basename($pdfPath);

        $postFields = [
            'file' => new \CURLFile($pdfPath, 'application/pdf', $filename),
            'data' => json_encode($metadata, JSON_UNESCAPED_UNICODE),
        ];

        $headers = [
            'X-eFirma-Auth: ' . $this->buildAuthHeader(),
            'Accept: application/json',
        ];

        \Log::debug('[eFirma] requestMultipart enviando', [
            'url'       => $url,
            'pdf_path'  => $pdfPath,
            'pdf_size'  => filesize($pdfPath),
            'filename'  => $filename,
            'data'      => $metadata,
        ]);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, config('efirma.timeout_connect', 10));
        curl_setopt($ch, CURLOPT_TIMEOUT, config('efirma.timeout_request', 120));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_POSTREDIR, CURL_REDIR_POST_ALL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        $response      = curl_exec($ch);
        $httpCode      = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $effectiveUrl  = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        $uploadSize    = curl_getinfo($ch, CURLINFO_SIZE_UPLOAD);
        $redirectCount = (int) curl_getinfo($ch, CURLINFO_REDIRECT_COUNT);
        $curlError     = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new RuntimeException("cURL error al subir documento a eFirma: {$curlError}");
        }

        \Log::debug('[eFirma] requestMultipart raw response', [
            'http_status'    => $httpCode,
            'effective_url'  => $effectiveUrl,
            'upload_size'    => $uploadSize,
            'redirect_count' => $redirectCount,
            'body'           => $response,
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
