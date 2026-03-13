# Flujo del Oficio — Documentos Backoffice

Este documento describe los estados posibles de un oficio, las transiciones entre ellos, quién puede ejecutar cada acción y qué archivos intervienen. Sirve como guía de diagnóstico para ubicar rápidamente el código involucrado en un problema específico.

---

## Estados y transiciones

```
[borrador] ──enviar a revisión──► [revision] ──solicitar corrección──► [borrador]
                                       │
                                 validar (≥2 veces)
                                       │
                                       ▼
                                 [revision] ──firmar──► [firmado] ──enviar──► (enviado)
```

> El estado "enviado" no es un valor de columna separado. Se detecta porque `sent_to_user_id` tiene valor (`!= null`).

---

## Paso 1 — Borrador (`status = 'borrador'`)

| Atributo | Valor |
|---|---|
| **Quién puede actuar** | El creador del oficio (`document->user_id == Auth::id()`) |
| **Acciones disponibles** | Editar, enviar a revisión |

### Subacciones

#### Editar
- **Vista**: `backoffice/documents/edit.blade.php`
- **Ruta**: `backoffice.documents.edit`
- **Controlador**: método `edit` / `update`

#### Enviar a revisión
- **Vista (modal)**: `partials/modal-send-review.blade.php`
- **Vista (CTA)**: `partials/actions-send-review.blade.php`
- **Ruta**: `backoffice.documents.send-review`
- **Transición**: `borrador` → `revision`
- **Efectos**: asigna `assigned_to`, guarda `assignment_message`, registra versión con `activity_type = 'enviado_revision'`

### Variables de diagnóstico (show.blade.php)
- `$isCreatorViewing = true` → muestra aviso azul "Oficio en Borrador" o naranja "Corrección Solicitada"
- `$lastCorrectionRequest` → si existe, muestra la última corrección solicitada al creador

---

## Paso 2 — En Revisión (`status = 'revision'`)

| Atributo | Valor |
|---|---|
| **Quién puede actuar** | El colaborador asignado (`document->assigned_to == Auth::id()`) |
| **Acciones disponibles** | Solicitar corrección, validar, firmar (si `validations_count >= 2`) |

### Subacciones

#### Confirmar recibo (primera visita)
- **Vista (modal)**: `partials/modal-confirm-receipt.blade.php`
- **Ruta**: `backoffice.documents.confirm-receipt`
- **Trigger**: controlador envía `$showConfirmModal = true` si el revisor no ha confirmado lectura aún
- **Efectos**: registra fecha de primera lectura

#### Solicitar corrección
- **Vista (card acciones)**: `partials/actions-reviewer.blade.php`
- **Vista (modal)**: `partials/modal-correction.blade.php`
- **Ruta**: `backoffice.documents.request-correction`
- **Transición**: `revision` → `borrador`
- **Efectos**: devuelve oficio al creador, registra versión con `activity_type = 'correccion_solicitada'`, limpia `assigned_to`

#### Validar
- **Vista (card acciones)**: `partials/actions-reviewer.blade.php`
- **Vista (modal)**: `partials/modal-validate.blade.php`
- **Ruta**: `backoffice.documents.validate`
- **Transición**: permanece en `revision`, incrementa `validations_count`
- **Efectos**: crea registro en tabla `document_validations`, reasigna `assigned_to` al siguiente colaborador, registra versión con `activity_type = 'validado'`
- **Restricción**: el creador no puede validar su propio oficio; tampoco puede validar dos veces el mismo usuario

#### Firmar
- **Vista (card acciones)**: `partials/actions-reviewer.blade.php` (botón `#initSignBtn`)
- **Vista (modal)**: `partials/modal-sign.blade.php`
- **Script**: `partials/scripts.blade.php` (función `initSignaturePad`, llamada AJAX a `efirma-initiate`)
- **Condición para habilitar**: `$document->canBeSigned()` → requiere `validations_count >= 2`

**Submodos de firma:**

| Modo | Descripción | Ruta |
|---|---|---|
| **eFirma** | El endpoint `efirma-initiate` devuelve `mode: 'efirma'` con `iframe_url`. Se muestra el iframe del SAT/proveedor. | `backoffice.documents.efirma-initiate` (POST) → `backoffice.documents.efirma-confirm` (POST) |
| **Canvas (fallback)** | Si eFirma falla o devuelve `mode: 'canvas'`, se activa el plugin `signaturePad`. | `backoffice.documents.sign` (POST) |

- **Transición**: `revision` → `firmado`
- **Efectos**: guarda imagen de firma en S3 (`signature_s3_url`), guarda sello opcional (`stamp_s3_url`), registra versión con `activity_type = 'firmado'`

**Recordatorio eFirma** (botón `#reminderBtn`):
- Solo visible si `$document->hasEfirmaDocument()`
- **Ruta**: `backoffice.documents.efirma-reminder` (POST)

---

## Paso 3 — Firmado (`status = 'firmado'`)

| Atributo | Valor |
|---|---|
| **Quién puede actuar** | Cualquier usuario con acceso al oficio (generalmente quien lo firmó) |
| **Acciones disponibles** | Generar PDF, enviar a destinatario |

### Subacciones

#### Generar PDF
- **Vista (botón)**: `partials/sidebar.blade.php` → enlace a `backoffice.documents.pdf`
- **Ruta**: `backoffice.documents.pdf`
- **Archivo de vista PDF**: `backoffice/documents/pdf.blade.php`

#### Enviar a destinatario
- **Vista (CTA)**: `partials/actions-send-recipient.blade.php`
- **Vista (modal)**: `partials/modal-send-recipient.blade.php`
- **Ruta**: `backoffice.documents.send-to-recipient`
- **Select2 AJAX**: busca usuarios de la dependencia destino vía `backoffice.documents.search-dependency-users`
- **Transición**: marca `sent_to_user_id` y `sent_at` (el status sigue siendo `firmado`)
- **Efectos**: registra versión con `activity_type = 'enviado'`, notifica al destinatario

---

## Mapa de partials por paso

| Paso | Partial(s) involucrado(s) |
|---|---|
| Visualización general | `workflow-banner.blade.php` |
| Alertas flash | `alerts.blade.php` |
| Cuerpo del documento | `document-body.blade.php` |
| Sidebar (estado, validaciones, versiones, acciones) | `sidebar.blade.php` |
| Borrador → revisión | `actions-send-review.blade.php`, `modal-send-review.blade.php` |
| Revisión — confirmar recibo | `modal-confirm-receipt.blade.php` |
| Revisión — solicitar corrección | `actions-reviewer.blade.php`, `modal-correction.blade.php` |
| Revisión — validar | `actions-reviewer.blade.php`, `modal-validate.blade.php` |
| Revisión — firmar | `actions-reviewer.blade.php`, `modal-sign.blade.php` |
| Firmado — enviar a destinatario | `actions-send-recipient.blade.php`, `modal-send-recipient.blade.php` |
| JavaScript (Select2, eFirma, signaturePad) | `scripts.blade.php` |

---

## Modelo y métodos clave

| Método / atributo | Descripción |
|---|---|
| `$document->canBeSigned()` | `true` si `validations_count >= 2` |
| `$document->hasBeenValidatedBy($userId)` | Evita doble validación del mismo usuario |
| `$document->hasEfirmaDocument()` | `true` si ya existe un documento eFirma pendiente de confirmar |
| `$document->status_badge` | HTML del badge de estado |
| `$document->validations_count` | Número de validaciones registradas |
| `$document->sent_to_user_id` | `null` si no se ha enviado; con valor si ya fue enviado |
| `$document->sentToUser` | Relación al usuario destinatario final |
| `$document->assignedUser` | Relación al colaborador asignado actualmente |
| `$document->versions()` | Historial de actividad (tabla `document_versions`) |
| `$document->validations` | Colección de validaciones (tabla `document_validations`) |

---

## Archivos de referencia

| Archivo | Ruta |
|---|---|
| Vista orquestadora | `resources/views/backoffice/documents/show.blade.php` |
| Partials | `resources/views/backoffice/documents/partials/` |
| Controlador | `app/Http/Controllers/Backoffice/DocumentController.php` (o similar) |
| Modelo | `app/Models/Document.php` |
| Servicio eFirma | Ver `_prds/prd_efirma.md` y `config/efirma.php` |
| Rutas | `routes/web.php` — grupo `backoffice.documents.*` |
