# Integración eFirma.com — Documentación Técnica

**API:** eFirma.com  
**Fecha:** Marzo 2026

---

## Variables de Entorno

```env
EFIRMA_BASE_URL=https://mx.efirma.com
EFIRMA_USER_ID=        # ID de usuario en el panel eFirma
EFIRMA_API_KEY=        # API Key del panel eFirma
```

> **⚠️ IMPORTANTE:** `EFIRMA_BASE_URL` debe apuntar al servidor regional correcto (ej. `https://mx.efirma.com`).
> **NO** usar `https://efirma.com` directamente — causa un redirect que pierde el archivo PDF durante el upload multipart, resultando en `{"id":""}`.
>
> Asegúrese también de que `APP_URL` en `.env` sea el dominio público real del sitio (no `http://localhost`), ya que de él se generan las URLs de `callback_url` y `return_url` enviadas a eFirma.

Las credenciales se gestionan en: https://efirma.com/panel/api-management

---

## Flujo Completo de Firma

El flujo de firma se activa cuando un oficio alcanza el estado `validado` (mínimo 2 validaciones). Solo el colaborador asignado (`assigned_to`) puede firmar.

```
[Usuario hace clic en "Firmar"]
        │
        ▼
POST /admin/backoffice/documents/{id}/efirma/initiate
        │
        ├─── eFirma disponible ──────────────────────────────────────────────┐
        │     1. GET /api/account          (sanity check)                    │
        │     2. Genera PDF del oficio     (DomPDF)                          │
        │     3. POST /api/document/       (multipart/form-data)             │
        │     4. Guarda efirma_document_id + efirma_iframe_url en BD         │
        │     5. Registra en efirma_logs (event: create_document)            │
        │     6. Versión: ACTIVITY_EFIRMA_SUBMITTED                          │
        │     7. Responde JSON → { mode: 'efirma', iframe_url }              │
        │                                        │                           │
        │                              Modal muestra iFrame                  │
        │                              con panel de firma eFirma             │
        │                                        │                           │
        │                              [Firmante completa firma]             │
        │                                        │                           │
        │                              POST /efirma/confirm                  │
        │                                        │                           │
        │                              1. POST /api/document/get_signatures  │
        │                              2. Guarda efirma_signatures en BD     │
        │                              3. efirma_status = 'signed_complete'  │
        │                              4. status = 'firmado'                 │
        │                              5. Versión: ACTIVITY_EFIRMA_SIGNED   ◄┘
        │
        └─── eFirma NO disponible ─────────────────────────────────────────┐
              Registra error en efirma_logs (event: create_document_error)   │
              Responde JSON → { mode: 'canvas', warning }                    │
                                      │                                      │
                            Modal muestra canvas                             │
                            signature-pad (fallback)                         │
                                      │                                      │
                            [Firmante dibuja firma]                          │
                                      │                                      │
                            POST /documents/{id}/sign                        │
                            Sube firma como PNG a S3                         │
                            status = 'firmado'                              ◄┘
                            Versión: ACTIVITY_SIGNED
```

---

## Endpoints Internos

| Método | Ruta | Nombre | Descripción |
|--------|------|--------|-------------|
| `POST` | `/admin/backoffice/documents/{id}/efirma/initiate` | `backoffice.documents.efirma-initiate` | Inicia proceso eFirma o retorna modo canvas |
| `POST` | `/admin/backoffice/documents/{id}/efirma/confirm` | `backoffice.documents.efirma-confirm` | Confirma firma, obtiene firmas de eFirma |
| `POST` | `/admin/backoffice/documents/{id}/efirma/reminder` | `backoffice.documents.efirma-reminder` | Envía recordatorio al firmante (AJAX) |
| `POST` | `/admin/backoffice/documents/{id}/sign` | `backoffice.documents.sign` | Fallback: firma con canvas signature-pad |

---

## Endpoints eFirma Consumidos

| Método | Endpoint eFirma | Uso en sistema |
|--------|----------------|----------------|
| `GET`  | `/api/account` | Sanity check de conectividad y credenciales |
| `POST` | `/api/document/` | Crear/subir el PDF para firma (multipart/form-data) |
| `GET`  | `/api/document/get/:id` | Consultar estado del documento (disponible pero no usado activamente) |
| `POST` | `/api/document/get_signatures` | Obtener firmas al confirmar |
| `POST` | `/api/document/send_reminder/` | Enviar recordatorio al firmante |
| `GET`  | `/api/document/delete/:id` | Eliminar documento (disponible en servicio, no expuesto como ruta) |

---

## Campos Agregados a `backoffice_documents`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `efirma_document_id` | `string` nullable | ID del documento en eFirma |
| `efirma_status` | `string` nullable | `created` / `signed_complete` / `error` |
| `efirma_iframe_url` | `text` nullable | URL del iFrame para la firma |
| `efirma_signatures` | `JSON` nullable | Payload de firmas devuelto por eFirma |
| `efirma_error` | `text` nullable | Último mensaje de error de eFirma |
| `efirma_sent_at` | `timestamp` nullable | Fecha en que se envió a eFirma |

---

## Tabla `efirma_logs`

Bitácora de todos los eventos con la API. Nunca expone la API key.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `document_id` | FK | Oficio relacionado |
| `event` | `string` | `create_document`, `get_signatures`, `send_reminder`, `*_error` |
| `payload` | `JSON` | Parámetros enviados (folio, nombre, etc.) |
| `response` | `JSON` | Respuesta recibida de eFirma |
| `http_status` | `int` | Código HTTP de la respuesta |
| `success` | `bool` | Si la operación fue exitosa |

---

## Clases Involucradas

- **`App\Services\EfirmaService`** — Cliente cURL. Toda comunicación con eFirma pasa por aquí.
- **`App\Models\EfirmaLog`** — Modelo para la tabla `efirma_logs`.
- **`App\Http\Controllers\BackofficeDocumentController`** — Métodos `efirmaInitiate`, `efirmaConfirm`, `efirmaReminder`, `sign`.
- **`config/efirma.php`** — Lectura de credenciales desde `.env`.

---

## Debugging

### 1. eFirma siempre cae a modo canvas

**Causas posibles:**

- Credenciales no configuradas en `.env` (`EFIRMA_USER_ID` o `EFIRMA_API_KEY` vacíos).
- `EFIRMA_BASE_URL` incorrecto (revisar si el servidor es `mx` o `es`).
- eFirma caído o sin acceso a internet desde el servidor.

**Verificación rápida:**

```bash
php artisan tinker
# En Tinker:
app(\App\Services\EfirmaService::class)->isAvailable();
```

Debe retornar `true`. Si retorna `false`, revisar los logs y la tabla `efirma_logs`:

```sql
SELECT event, http_status, success, response, created_at
FROM efirma_logs
ORDER BY created_at DESC
LIMIT 20;
```

---

### 2. Error "cURL error comunicándose con eFirma"

Problema de conectividad de red desde el servidor hacia `efirma.com`.

```bash
# Verificar desde el servidor
curl -I https://mx.efirma.com/api/account
```

Si no hay respuesta, revisar firewall, proxy saliente o DNS del servidor.

---

### 3. Error HTTP 401 / 403 de eFirma

Credenciales inválidas. Verificar en el panel de eFirma que:
- El `EFIRMA_USER_ID` corresponde al ID de cuenta correcto.
- La `EFIRMA_API_KEY` está activa y no expirada.
- El header `X-eFirma-Auth` se construye correctamente en `EfirmaService::buildAuthHeader()`.

---

### 4. El iFrame aparece en blanco o no carga

- `efirma_iframe_url` puede estar vacío si eFirma no lo devolvió en la respuesta de creación.
- Revisar en la tabla `efirma_logs` el campo `response` del evento `create_document` para ver la estructura real que devuelve eFirma.
- Es posible que el campo en la respuesta se llame diferente a `iframe_url`. Ajustar en `efirmaInitiate()`:

```php
$iframeUrl = $result['data']['iframe_url'] ?? null;
// Cambiar 'iframe_url' por el nombre real del campo según la documentación
```

---

### 5. Confirmar firma falla ("No hay proceso eFirma activo")

El documento no tiene `efirma_document_id`. Puede ocurrir si:
- El proceso se inició pero la BD no guardó el ID (revisar `efirma_logs` para `create_document`).
- El documento fue reiniciado manualmente.

---

### 6. Verificar estado completo de un documento en eFirma

```bash
php artisan tinker
$svc = app(\App\Services\EfirmaService::class);
$doc = \App\Models\BackofficeDocument::find(ID_DOCUMENTO);
$svc->getDocument($doc->efirma_document_id);
```

---

### 7. Limpiar estado eFirma de un documento (solo desarrollo)

```bash
php artisan tinker
\App\Models\BackofficeDocument::find(ID)->update([
    'efirma_document_id' => null,
    'efirma_iframe_url'  => null,
    'efirma_status'      => null,
    'efirma_signatures'  => null,
    'efirma_error'       => null,
    'efirma_sent_at'     => null,
]);
```

---

> **Nota:** La estructura exacta del payload de respuesta de eFirma (especialmente el nombre del campo `iframe_url` y el formato de `get_signatures`) debe validarse con la documentación oficial vigente o mediante pruebas con las credenciales reales antes de liberar a producción.
