@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-0">
                            <ion-icon name="document-text-outline"></ion-icon>
                            Solicitud SARE #{{ $sareRequest->request_num }}
                        </h2>
                        <small class="text-muted">
                            Creada el {{ $sareRequest->created_at->format('d/m/Y \a \l\a\s H:i') }}
                        </small>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge bg-{{ $sareRequest->status_color }} fs-6 px-3 py-2">
                            {{ $sareRequest->status_label }}
                        </span>
                        <br>
                        <small class="text-muted mt-2 d-block">
                            Última actualización: {{ $sareRequest->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-body">
                    <!-- Información General -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary">
                                <ion-icon name="information-circle-outline"></ion-icon> Información General
                            </h6>
                            <hr class="mt-2 mb-3">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Número de Solicitud:</label>
                            <p class="mb-0">{{ $sareRequest->request_num }}</p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Fecha de Solicitud:</label>
                            <p class="mb-0">{{ $sareRequest->request_date }}</p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Estado:</label>
                            <p class="mb-0">
                                <span
                                    class="badge bg-{{ $sareRequest->status === 'new' ? 'primary' : ($sareRequest->status === 'authorized' ? 'success' : ($sareRequest->status === 'rejected' ? 'danger' : 'warning')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $sareRequest->status)) }}
                                </span>
                            </p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Número Catastral:</label>
                            <p class="mb-0">{{ $sareRequest->catastral_num }}</p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tipo de Solicitud:</label>
                            <p class="mb-0">{{ ucfirst($sareRequest->request_type) }}</p>
                        </div>

                        @if ($sareRequest->description)
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Descripción:</label>
                                <p class="mb-0">{{ $sareRequest->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Datos del Solicitante -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary">
                                <ion-icon name="person-outline"></ion-icon> Datos del Solicitante
                            </h6>
                            <hr class="mt-2 mb-3">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nombre/Razón Social RFC:</label>
                            <p class="mb-0">{{ $sareRequest->rfc_name }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">RFC:</label>
                            <p class="mb-0">{{ $sareRequest->rfc_num }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Propietario del Inmueble:</label>
                            <p class="mb-0">{{ $sareRequest->property_owner }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Correo Electrónico:</label>
                            <p class="mb-0">{{ $sareRequest->email }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Teléfono de Oficina:</label>
                            <p class="mb-0">{{ $sareRequest->office_phone }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Teléfono Móvil:</label>
                            <p class="mb-0">{{ $sareRequest->mobile_phone }}</p>
                        </div>
                    </div>

                    @if ($sareRequest->legal_representative_name)
                        <!-- Datos del Representante Legal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <ion-icon name="person-add-outline"></ion-icon> Datos del Representante Legal
                                </h6>
                                <hr class="mt-2 mb-3">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Nombre Completo:</label>
                                <p class="mb-0">{{ $sareRequest->legal_representative_name }}
                                    {{ $sareRequest->legal_representative_father_last_name }}
                                    {{ $sareRequest->legal_representative_mother_last_name }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Teléfono de Oficina:</label>
                                <p class="mb-0">{{ $sareRequest->legal_representative_office_phone }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Teléfono Móvil:</label>
                                <p class="mb-0">{{ $sareRequest->legal_representative_mobile_phone }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Teléfono Personal:</label>
                                <p class="mb-0">{{ $sareRequest->legal_representative_personal_phone }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Correo Electrónico:</label>
                                <p class="mb-0">{{ $sareRequest->legal_representative_email }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Documento de Propiedad:</label>
                                <p class="mb-0">{{ $sareRequest->legal_representative_ownership_document }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Responsable del Establecimiento -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary">
                                <ion-icon name="business-outline"></ion-icon> Responsable del Establecimiento
                            </h6>
                            <hr class="mt-2 mb-3">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Causa Legal:</label>
                            <p class="mb-0">{{ $sareRequest->establishment_legal_cause }}</p>
                        </div>

                        @if ($sareRequest->establishment_legal_cause_addon)
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Especificar Otro:</label>
                                <p class="mb-0">{{ $sareRequest->establishment_legal_cause_addon }}</p>
                            </div>
                        @endif

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Cláusula de Buena Fe:</label>
                            <p class="mb-0">{{ $sareRequest->establishment_good_faith_clause }}</p>
                        </div>
                    </div>

                    <!-- Domicilio del Establecimiento -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary">
                                <ion-icon name="location-outline"></ion-icon> Domicilio del Establecimiento
                            </h6>
                            <hr class="mt-2 mb-3">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Dirección Completa:</label>
                            <p class="mb-0">
                                {{ $sareRequest->establishment_address_street }}
                                #{{ $sareRequest->establishment_address_number }}
                                <br>
                                Col. {{ $sareRequest->establishment_address_neighborhood }},
                                C.P. {{ $sareRequest->establishment_address_postal_code }}<br>
                                {{ $sareRequest->establishment_address_municipality }},
                                {{ $sareRequest->establishment_address_state }}
                            </p>
                        </div>
                    </div>

                    <!-- Datos del Uso de la Edificación -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary">
                                <ion-icon name="briefcase-outline"></ion-icon> Datos del Uso de la Edificación
                            </h6>
                            <hr class="mt-2 mb-3">
                        </div>

                        @if ($sareRequest->establishment_use)
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Uso del Establecimiento:</label>
                                <p class="mb-0">{{ $sareRequest->establishment_use }}</p>
                            </div>
                        @endif

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nombre Comercial:</label>
                            <p class="mb-0">{{ $sareRequest->commercial_name }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Inversión Aproximada:</label>
                            <p class="mb-0">{{ $sareRequest->aprox_investment }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Empleos a Generar:</label>
                            <p class="mb-0">{{ $sareRequest->jobs_to_generate }}</p>
                        </div>

                        @if ($sareRequest->operation_start_date)
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Fecha de Inicio de Operaciones:</label>
                                <p class="mb-0">{{ $sareRequest->operation_start_date }}</p>
                            </div>
                        @endif

                        @if ($sareRequest->business_hours)
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Horario de Negocio:</label>
                                <p class="mb-0">{{ $sareRequest->business_hours }}</p>
                            </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Local en Operación:</label>
                            <p class="mb-0">{{ $sareRequest->is_location_in_operation ? 'Sí' : 'No' }}</p>
                        </div>
                    </div>

                    <!-- Zonificación -->
                    @if ($sareRequest->zoning_front || $sareRequest->zoning_rear || $sareRequest->zoning_left || $sareRequest->zoning_right)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <ion-icon name="location-outline"></ion-icon> Zonificación
                                </h6>
                                <small class="text-muted">Indique las actividades de los locales colindantes a su
                                    negocio</small>
                                <hr class="mt-2 mb-3">
                            </div>

                            @if ($sareRequest->zoning_front)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Frente:</label>
                                    <p class="mb-0">{{ $sareRequest->zoning_front }}</p>
                                </div>
                            @endif

                            @if ($sareRequest->zoning_rear)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Fondo:</label>
                                    <p class="mb-0">{{ $sareRequest->zoning_rear }}</p>
                                </div>
                            @endif

                            @if ($sareRequest->zoning_left)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Izquierda:</label>
                                    <p class="mb-0">{{ $sareRequest->zoning_left }}</p>
                                </div>
                            @endif

                            @if ($sareRequest->zoning_right)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Derecha:</label>
                                    <p class="mb-0">{{ $sareRequest->zoning_right }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Información Municipal -->
                    @if ($sareRequest->license_num || $sareRequest->entry_date || $sareRequest->exit_date || $sareRequest->document_type)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <ion-icon name="home-outline"></ion-icon> Información Municipal
                                </h6>
                                <hr class="mt-2 mb-3">
                            </div>

                            @if ($sareRequest->license_num)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Número de Licencia:</label>
                                    <p class="mb-0">{{ $sareRequest->license_num }}</p>
                                </div>
                            @endif

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Visto Bueno Favorable:</label>
                                <p class="mb-0">{{ $sareRequest->vobo_favorable ? 'Sí' : 'No' }}</p>
                            </div>

                            @if ($sareRequest->entry_date)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Fecha de Ingreso:</label>
                                    <p class="mb-0">
                                        {{ \Carbon\Carbon::parse($sareRequest->entry_date)->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif

                            @if ($sareRequest->exit_date)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Fecha de Resolución:</label>
                                    <p class="mb-0">
                                        {{ \Carbon\Carbon::parse($sareRequest->exit_date)->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif

                            @if ($sareRequest->document_type)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Tipo de Documento:</label>
                                    <p class="mb-0">{{ $sareRequest->document_type }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Botones de Acción -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('citizen.profile.requests') }}" class="btn btn-secondary">
                                    <ion-icon name="arrow-back-outline"></ion-icon> Volver a Mis Solicitudes
                                </a>

                                <div>
                                    @if ($sareRequest->status === 'new')
                                        <a href="{{ route('citizen.sare.edit', $sareRequest) }}"
                                            class="btn btn-warning me-2">
                                            <ion-icon name="create-outline"></ion-icon> Editar Solicitud
                                        </a>

                                        <button type="button" class="btn btn-danger me-2" onclick="confirmDelete()">
                                            <ion-icon name="trash-outline"></ion-icon> Eliminar
                                        </button>
                                    @endif

                                    {{--
                                <button type="button" class="btn btn-info" onclick="window.print()">
                                    <i class="bx bx-printer me-2"></i>Imprimir
                                </button>
                                --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Lista de Verificación de Documentos -->
                <div class="card border-primary mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                            Lista de Verificación de Documentos
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="documents-checklist">
                            <!-- Los documentos se cargarán dinámicamente -->
                        </div>
                    </div>
                </div>

                <!-- Zona de Upload -->
                <div class="card border-success mb-3">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <ion-icon name="cloud-upload-outline"></ion-icon>
                            Subir Documento
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="fileUploadForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="sare_request_id" value="{{ $sareRequest->id }}">

                            <div class="mb-3">
                                <label for="document_type" class="form-label">Seleccionar tipo de documento</label>
                                <select class="form-select" id="document_type" name="document_type" required>
                                    <option value="">Seleccione un documento</option>
                                    <!-- Las opciones se cargarán dinámicamente -->
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">Archivo</label>
                                <input type="file" class="form-control" id="file" name="file"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                <div class="form-text">
                                    Formatos permitidos: PDF, DOC, DOCX, JPG, PNG. Tamaño máximo: 10MB
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" disabled>
                                <ion-icon name="cloud-upload-outline"></ion-icon> Subir Documento
                            </button>
                        </form>

                        <div id="upload-progress" class="mt-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Archivos Subidos -->
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <ion-icon name="folder-open-outline"></ion-icon>
                            Archivos Subidos
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="uploaded-files">
                            @if ($sareRequest->files->count() > 0)
                                @foreach ($sareRequest->files as $file)
                                    <div class="uploaded-file-item d-flex justify-content-between align-items-center p-2 border rounded mb-2"
                                        data-file-id="{{ $file->id }}">
                                        <div class="file-info">
                                            <div class="fw-bold">{{ $file->file_name }}</div>
                                            <small class="text-muted">{{ $file->formatted_size }}</small>
                                        </div>
                                        <div class="file-actions">
                                            <a href="{{ $file->url }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary me-1">
                                                <ion-icon name="eye-outline"></ion-icon>
                                            </a>
                                            @if ($sareRequest->status === 'new')
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-file"
                                                    data-file-id="{{ $file->id }}">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div id="no-files-message" class="text-center text-muted py-3">
                                    <ion-icon name="document-outline" style="font-size: 36px;"></ion-icon>
                                    <p class="mt-2">No hay archivos subidos</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar esta solicitud SARE?</p>
                    <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="deleteRequest()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Configuración de documentos requeridos para SARE
                const documentsConfig = [
                    'Documento que acredite propiedad del inmueble',
                    'Identificación oficial del solicitante',
                    'Identificación oficial del propietario',
                    'Comprobante de domicilio (no mayor a 2 meses)',
                    'Pago predial del presente año'
                ];

                // Documentos adicionales para persona moral
                const moralPersonDocuments = [
                    'Acta constitutiva de la Empresa',
                    'Poder simple o notariado del representante legal'
                ];

                // Nota para persona moral
                const moralPersonNote = "Si es persona moral anexar:";

                // Obtener archivos subidos actuales
                const uploadedFiles = @json($sareRequest->files);

                // Crear slugs para los archivos existentes
                const uploadedFileTypes = uploadedFiles.map(file => {
                    const name = file.name || file.file_name || '';
                    return name.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-');
                });

                // Cargar la lista de documentos
                const checklistContainer = document.getElementById('documents-checklist');
                if (checklistContainer) {
                    setTimeout(() => {
                        loadDocumentChecklist();
                        updateDocumentSelect();
                    }, 100);
                }

                function loadDocumentChecklist() {
                    const checklistContainer = document.getElementById('documents-checklist');

                    if (!checklistContainer) {
                        console.error('ERROR: documents-checklist container not found');
                        return;
                    }

                    // Crear mapa de documentos subidos por tipo
                    const uploadedFilesByType = {};
                    uploadedFiles.forEach(file => {
                        const fileName = file.name || file.file_name || '';
                        const documentName = file.document_type || file.name || '';
                        // Mapear nombres de archivos a tipos de documento
                        const docType = mapFileNameToDocType(fileName, documentName);
                        if (docType) {
                            uploadedFilesByType[docType] = file;
                        }
                    });

                    // Crear HTML de la lista de documentos con checkboxes individuales
                    let checklistHtml = '';

                    // Documentos requeridos básicos
                    const requiredDocs = [{
                            slug: 'documento-propiedad',
                            title: 'Documento que acredite propiedad del inmueble'
                        },
                        {
                            slug: 'id-solicitante',
                            title: 'Identificación oficial del solicitante'
                        },
                        {
                            slug: 'id-propietario',
                            title: 'Identificación oficial del propietario'
                        },
                        {
                            slug: 'comprobante-domicilio',
                            title: 'Comprobante de domicilio (no mayor a 2 meses)'
                        },
                        {
                            slug: 'pago-predial',
                            title: 'Pago predial del presente año'
                        }
                    ];

                    checklistHtml += '<div class="mb-3"><h6 class="text-primary">Documentos Requeridos:</h6>';

                    requiredDocs.forEach(doc => {
                        const isUploaded = uploadedFilesByType[doc.slug];
                        const statusClass = isUploaded ? 'border-success bg-success bg-opacity-10' :
                            'border-secondary';
                        const iconClass = isUploaded ? 'text-success' : 'text-muted';
                        const iconName = isUploaded ? 'checkmark-circle' : 'document-outline';

                        checklistHtml += `
                    <div class="checklist-item border rounded p-2 mb-2 ${statusClass}" data-doc-slug="${doc.slug}">
                        <div class="d-flex align-items-center">
                            <div class="check-icon me-2">
                                <ion-icon name="${iconName}" class="${iconClass}" style="font-size: 18px;"></ion-icon>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold ${isUploaded ? 'text-success' : ''}">${doc.title}</div>
                                <small class="text-muted">${isUploaded ? 'Documento subido' : 'Pendiente de subir'}</small>
                            </div>
                        </div>
                    </div>
                `;
                    });

                    checklistHtml += '</div>';

                    // Documentos adicionales para persona moral
                    const moralDocs = [{
                            slug: 'acta-constitutiva',
                            title: 'Acta constitutiva de la Empresa'
                        },
                        {
                            slug: 'poder-representante',
                            title: 'Poder simple o notariado del representante legal'
                        }
                    ];

                    checklistHtml += '<div class="mb-3"><h6 class="text-warning">Documentos para Persona Moral:</h6>';

                    moralDocs.forEach(doc => {
                        const isUploaded = uploadedFilesByType[doc.slug];
                        const statusClass = isUploaded ? 'border-success bg-success bg-opacity-10' :
                            'border-warning border-opacity-50';
                        const iconClass = isUploaded ? 'text-success' : 'text-warning';
                        const iconName = isUploaded ? 'checkmark-circle' : 'document-outline';

                        checklistHtml += `
                    <div class="checklist-item border rounded p-2 mb-2 ${statusClass}" data-doc-slug="${doc.slug}">
                        <div class="d-flex align-items-center">
                            <div class="check-icon me-2">
                                <ion-icon name="${iconName}" class="${iconClass}" style="font-size: 18px;"></ion-icon>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold ${isUploaded ? 'text-success' : ''}">${doc.title}</div>
                                <small class="text-muted">${isUploaded ? 'Documento subido' : 'Opcional'}</small>
                            </div>
                        </div>
                    </div>
                `;
                    });

                    checklistHtml += '</div>';

                    try {
                        checklistContainer.innerHTML = checklistHtml;
                    } catch (error) {
                        console.error('Error inserting HTML:', error);
                    }
                }

                function mapFileNameToDocType(fileName, documentName = '') {
                    // Primero verificar si hay un nombre de documento explícito
                    if (documentName) {
                        const docSlug = documentName.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-');

                        // Mapear nombres conocidos
                        if (docSlug.includes('documento') && docSlug.includes('propiedad')) {
                            return 'documento-propiedad';
                        }
                        if (docSlug.includes('identificacion') && docSlug.includes('solicitante')) {
                            return 'id-solicitante';
                        }
                        if (docSlug.includes('identificacion') && docSlug.includes('propietario')) {
                            return 'id-propietario';
                        }
                        if (docSlug.includes('comprobante') && docSlug.includes('domicilio')) {
                            return 'comprobante-domicilio';
                        }
                        if (docSlug.includes('pago') && docSlug.includes('predial')) {
                            return 'pago-predial';
                        }
                        if (docSlug.includes('acta') && docSlug.includes('constitutiva')) {
                            return 'acta-constitutiva';
                        }
                        if (docSlug.includes('poder') && docSlug.includes('representante')) {
                            return 'poder-representante';
                        }

                        // Mapear por slugs directos
                        const directMappings = {
                            'documento-propiedad': 'documento-propiedad',
                            'id-solicitante': 'id-solicitante',
                            'id-propietario': 'id-propietario',
                            'comprobante-domicilio': 'comprobante-domicilio',
                            'pago-predial': 'pago-predial',
                            'acta-constitutiva': 'acta-constitutiva',
                            'poder-representante': 'poder-representante'
                        };

                        if (directMappings[docSlug]) {
                            return directMappings[docSlug];
                        }
                    }

                    // Si no hay nombre de documento, intentar mapear por nombre de archivo
                    const nameLower = fileName.toLowerCase();

                    if (nameLower.includes('propiedad') || nameLower.includes('escritura') || nameLower.includes(
                            'titulo')) {
                        return 'documento-propiedad';
                    }
                    if (nameLower.includes('identificacion') && nameLower.includes('solicitante')) {
                        return 'id-solicitante';
                    }
                    if (nameLower.includes('identificacion') && nameLower.includes('propietario')) {
                        return 'id-propietario';
                    }
                    if (nameLower.includes('comprobante') && nameLower.includes('domicilio')) {
                        return 'comprobante-domicilio';
                    }
                    if (nameLower.includes('predial') || nameLower.includes('pago')) {
                        return 'pago-predial';
                    }
                    if (nameLower.includes('acta') && nameLower.includes('constitutiva')) {
                        return 'acta-constitutiva';
                    }
                    if (nameLower.includes('poder') && nameLower.includes('representante')) {
                        return 'poder-representante';
                    }

                    return null;
                }

                function updateDocumentSelect() {
                    const documentTypeSelect = document.getElementById('document_type');

                    if (!documentTypeSelect) return;

                    // Crear mapa de documentos subidos por tipo
                    const uploadedFilesByType = {};
                    uploadedFiles.forEach(file => {
                        const fileName = file.name || file.file_name || '';
                        const documentName = file.document_type || file.name || '';
                        const docType = mapFileNameToDocType(fileName, documentName);
                        if (docType) {
                            uploadedFilesByType[docType] = file;
                        }
                    });

                    // Todas las opciones de documentos
                    const allDocOptions = [{
                            value: 'documento-propiedad',
                            text: 'Documento que acredite propiedad del inmueble'
                        },
                        {
                            value: 'id-solicitante',
                            text: 'Identificación oficial del solicitante'
                        },
                        {
                            value: 'id-propietario',
                            text: 'Identificación oficial del propietario'
                        },
                        {
                            value: 'comprobante-domicilio',
                            text: 'Comprobante de domicilio'
                        },
                        {
                            value: 'pago-predial',
                            text: 'Pago predial del presente año'
                        },
                        {
                            value: 'acta-constitutiva',
                            text: 'Acta constitutiva de la Empresa'
                        },
                        {
                            value: 'poder-representante',
                            text: 'Poder del representante legal'
                        }
                    ];

                    // Filtrar opciones que no han sido subidas
                    let selectOptions = '<option value="">Seleccione un documento</option>';

                    allDocOptions.forEach(option => {
                        if (!uploadedFilesByType[option.value]) {
                            selectOptions += `<option value="${option.value}">${option.text}</option>`;
                        }
                    });

                    try {
                        documentTypeSelect.innerHTML = selectOptions;
                    } catch (error) {
                        console.error('Error inserting select options:', error);
                    }

                    updateSubmitButton();
                }

                function updateSubmitButton() {
                    const documentTypeSelect = document.getElementById('document_type');
                    const fileInput = document.getElementById('file');
                    const submitBtn = document.querySelector('#fileUploadForm button[type="submit"]');

                    if (documentTypeSelect && fileInput && submitBtn) {
                        const isValid = documentTypeSelect.value && fileInput.files.length > 0;
                        submitBtn.disabled = !isValid;
                    }
                }

                // Event listeners
                const documentTypeSelect = document.getElementById('document_type');
                const fileInput = document.getElementById('file');

                if (documentTypeSelect) {
                    documentTypeSelect.addEventListener('change', updateSubmitButton);
                }

                if (fileInput) {
                    fileInput.addEventListener('change', updateSubmitButton);
                }

                // Form submission
                const uploadForm = document.getElementById('fileUploadForm');
                if (uploadForm) {
                    uploadForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);
                        const submitBtn = this.querySelector('button[type="submit"]');
                        const progressContainer = document.getElementById('upload-progress');
                        const progressBar = progressContainer.querySelector('.progress-bar');

                        submitBtn.disabled = true;
                        submitBtn.innerHTML =
                            '<ion-icon name="sync-outline" class="spinner"></ion-icon> Subiendo...';
                        progressContainer.style.display = 'block';

                        fetch('{{ route('citizen.sare.file.upload') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .content
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Agregar archivo a la lista global
                                    uploadedFiles.push(data.file);

                                    // Actualizar checklist visual
                                    const docSlug = document.getElementById('document_type').value;
                                    updateChecklistItem(docSlug, true);

                                    // Agregar archivo a la lista de archivos subidos
                                    addUploadedFile(data.file);

                                    // Actualizar select para quitar la opción ya subida
                                    updateDocumentSelect();

                                    // Limpiar formulario
                                    this.reset();
                                    updateSubmitButton();

                                    alert('Archivo subido exitosamente');
                                } else {
                                    throw new Error(data.message || 'Error al subir el archivo');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error al subir el archivo: ' + error.message);
                            })
                            .finally(() => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML =
                                    '<ion-icon name="cloud-upload-outline"></ion-icon> Subir Documento';
                                progressContainer.style.display = 'none';
                                progressBar.style.width = '0%';
                            });
                    });
                }

                function updateChecklistItem(docSlug, isUploaded) {
                    const item = document.querySelector(`[data-doc-slug="${docSlug}"]`);
                    if (item) {
                        const checkIcon = item.querySelector('.check-icon ion-icon');
                        const title = item.querySelector('.fw-bold');
                        const subtitle = item.querySelector('small');

                        if (isUploaded) {
                            // Actualizar clases del contenedor
                            item.className =
                                'checklist-item border rounded p-2 mb-2 border-success bg-success bg-opacity-10';

                            // Actualizar icono
                            checkIcon.setAttribute('name', 'checkmark-circle');
                            checkIcon.className = 'text-success';

                            // Actualizar texto
                            title.className = 'fw-bold text-success';
                            subtitle.textContent = 'Documento subido';
                        } else {
                            // Restaurar estado pendiente
                            item.className = 'checklist-item border rounded p-2 mb-2 border-secondary';

                            // Restaurar icono
                            checkIcon.setAttribute('name', 'document-outline');
                            checkIcon.className = 'text-muted';

                            // Restaurar texto
                            title.className = 'fw-bold';
                            subtitle.textContent = 'Pendiente de subir';
                        }
                    }
                }

                function addUploadedFile(file) {
                    const uploadedFilesContainer = document.getElementById('uploaded-files');
                    const noFilesMessage = document.getElementById('no-files-message');

                    if (noFilesMessage) {
                        noFilesMessage.remove();
                    }

                    const fileHtml = `
                <div class="uploaded-file-item d-flex justify-content-between align-items-center p-2 border rounded mb-2" data-file-id="${file.id}">
                    <div class="file-info">
                        <div class="fw-bold">${file.name || file.file_name}</div>
                        <small class="text-muted">${file.formatted_size}</small>
                    </div>
                    <div class="file-actions">
                        <a href="${file.url}" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                            <ion-icon name="eye-outline"></ion-icon>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-file" data-file-id="${file.id}">
                            <ion-icon name="trash-outline"></ion-icon>
                        </button>
                    </div>
                </div>
            `;

                    uploadedFilesContainer.insertAdjacentHTML('beforeend', fileHtml);
                }

                // Delete file
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.delete-file')) {
                        const fileId = e.target.closest('.delete-file').dataset.fileId;

                        if (confirm('¿Estás seguro de que quieres eliminar este archivo?')) {
                            fetch(`{{ url('ciudadanos/sare/archivo') }}/${fileId}/eliminar`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .content
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Remover archivo de la lista global
                                        const fileIndex = uploadedFiles.findIndex(file => file.id ==
                                        fileId);
                                        if (fileIndex > -1) {
                                            uploadedFiles.splice(fileIndex, 1);
                                        }

                                        // Remover elemento del DOM
                                        const fileItem = document.querySelector(
                                            `[data-file-id="${fileId}"]`);
                                        if (fileItem) {
                                            fileItem.remove();
                                        }

                                        // Recargar checklist y select
                                        loadDocumentChecklist();
                                        updateDocumentSelect();

                                        alert('Archivo eliminado exitosamente');

                                        // Si no hay más archivos, mostrar mensaje
                                        const remainingFiles = document.querySelectorAll(
                                            '.uploaded-file-item');
                                        if (remainingFiles.length === 0) {
                                            const uploadedFilesContainer = document.getElementById(
                                                'uploaded-files');
                                            uploadedFilesContainer.innerHTML = `
                                    <div id="no-files-message" class="text-center text-muted py-3">
                                        <ion-icon name="document-outline" style="font-size: 36px;"></ion-icon>
                                        <p class="mt-2">No hay archivos subidos</p>
                                    </div>
                                `;
                                        }
                                    } else {
                                        throw new Error(data.message || 'Error al eliminar el archivo');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error al eliminar el archivo: ' + error.message);
                                });
                        }
                    }
                });

                // Initialize when page loads
                loadDocumentChecklist();
                updateDocumentSelect();
            });

            function confirmDelete() {
                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            }

            function deleteRequest() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('citizen.sare.destroy', $sareRequest) }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                const tokenField = document.createElement('input');
                tokenField.type = 'hidden';
                tokenField.name = '_token';
                tokenField.value = '{{ csrf_token() }}';

                form.appendChild(methodField);
                form.appendChild(tokenField);
                document.body.appendChild(form);
                form.submit();
            }
        </script>
    @endpush

    @push('styles')
        <style>
            @media print {

                .btn,
                .modal,
                .card-header .badge {
                    display: none !important;
                }

                .card {
                    border: none !important;
                    box-shadow: none !important;
                }

                .container-fluid {
                    padding: 0 !important;
                }
            }

            .checklist-item {
                transition: all 0.3s ease;
            }

            .checklist-item:hover {
                transform: translateX(5px);
            }

            .uploaded-file-item {
                transition: all 0.3s ease;
            }

            .uploaded-file-item:hover {
                background-color: #f8f9fa;
            }

            #upload-progress .progress {
                height: 8px;
            }

            .spinner {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    @endpush
@endsection
