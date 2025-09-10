@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('li_3') <a href="{{ route('urban_dev.requests.index') }}">Solicitudes</a> @endslot
@slot('title') Solicitud #{{ $urbanDevRequest->id }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        
        <!-- Header con información básica -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-1">
                                    <i class="fas fa-file-alt"></i>
                                    {{ $urbanDevRequest->getRequestTypeLabelAttribute() }}
                                </h4>
                                <p class="text-muted mb-0">
                                    Solicitud #{{ $urbanDevRequest->id }} • 
                                    Solicitado por: <strong>{{ $urbanDevRequest->user->name }}</strong>
                                </p>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt"></i> Creado: {{ $urbanDevRequest->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-{{ $urbanDevRequest->getStatusColorAttribute() }} fs-6 px-3 py-2">
                                    {{ $urbanDevRequest->getStatusLabelAttribute() }}
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">
                                    <i class="far fa-clock"></i> Actualizado: {{ $urbanDevRequest->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Información Principal y Documentos -->
            <div class="col-md-8">
                <!-- Información del Solicitante -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="text-white">
                            <i class="fas fa-user"></i>
                            Información del Solicitante
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Nombre Completo:</small>
                                <p class="mb-0 fw-bold">{{ $urbanDevRequest->user->name }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Correo Electrónico:</small>
                                <p class="mb-0">
                                    <a href="mailto:{{ $urbanDevRequest->user->email }}">{{ $urbanDevRequest->user->email }}</a>
                                </p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Registro:</small>
                                <p class="mb-0">{{ $urbanDevRequest->user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        @if($urbanDevRequest->description)
                        <div class="row">
                            <div class="col-12">
                                <small class="text-muted">Descripción del Proyecto:</small>
                                <div class="alert alert-light mt-1">
                                    {{ $urbanDevRequest->description }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Lista de Verificación de Documentos -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="text-white">
                            <i class="fas fa-check-circle"></i>
                            Lista de Verificación de Documentos
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="documents-checklist">
                            <!-- Los documentos se cargarán dinámicamente -->
                        </div>
                        
                        @php
                            $documentsConfig = [
                                'uso-de-suelo' => [
                                    'Formato de solicitud para licencia de Uso de Suelo (FDDUEM-01)',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Contrato de arrendamiento simple.',
                                    'Copia del último pago del predial.',
                                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'constancia-de-factibilidad' => [
                                    'Formato de solicitud para licencia de Uso de Suelo (FDDUEM-01)',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Contrato de arrendamiento simple',
                                    'Poder Legal',
                                    'Copia del último pago del predial.',
                                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'permiso-de-anuncios' => [
                                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Contrato de arrendamiento simple',
                                    'Poder Legal',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'certificacion-numero-oficial' => [
                                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Contrato de arrendamiento simple',
                                    'Poder Legal',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'permiso-de-division' => [
                                    'Solicitud por escrito con proyecto de división',
                                    'Croquis del predio',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad'
                                ],
                                'uso-de-via-publica' => [
                                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'licencia-de-construccion' => [
                                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad',
                                    'Croquis de ubicación del inmueble',
                                    'Proyecto arquitectonico, en dos tantos físicos. Con escala 1:100 O 1:50 elaborados, avaldaos y firmados por DRO'
                                ],
                                'permiso-construccion-panteones' => [
                                    'Formato de solicitud para Licencia de Uso Suelo',
                                    'Copia de identificación del propietario',
                                    'Copia del documento de perpetuidad'
                                ]
                            ];
                            
                            $requiredDocuments = $documentsConfig[$urbanDevRequest->request_type] ?? [];
                            $uploadedFiles = $urbanDevRequest->files;
                            $uploadedFileTypes = $uploadedFiles->pluck('slug')->toArray();
                        @endphp

                        @if(count($requiredDocuments) > 0)
                            @foreach($requiredDocuments as $index => $document)
                                @php
                                    $docSlug = Str::slug($document);
                                    $documentFiles = $uploadedFiles->where('slug', $docSlug);
                                    $hasFiles = $documentFiles->count() > 0;
                                @endphp
                                
                                <div class="mb-4 p-3 border rounded {{ $hasFiles ? 'border-success bg-light' : 'border-warning' }}">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="me-3">
                                            @if($hasFiles)
                                                <i class="fas fa-check-circle text-success" style="font-size: 24px;"></i>
                                            @else
                                                <i class="far fa-circle text-muted" style="font-size: 24px;"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 {{ $hasFiles ? 'text-success' : '' }}">{{ $document }}</h6>
                                            <small class="text-muted">
                                                @if($hasFiles)
                                                    <i class="far fa-folder"></i> {{ $documentFiles->count() }} archivo(s) subido(s)
                                                @else
                                                    <i class="fas fa-exclamation-circle"></i> Pendiente de subir
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    
                                    @if($hasFiles)
                                        <div class="uploaded-files ms-5">
                                            @foreach($documentFiles as $file)
                                                <div class="file-card mb-2 p-3 bg-white border rounded shadow-sm">
                                                    <div class="d-flex align-items-center">
                                                        <div class="file-icon me-3">
                                                            @php
                                                                $extension = strtolower($file->file_extension ?? '');
                                                                $iconColor = '#6c757d';
                                                                $iconClass = 'far fa-file';
                                                                
                                                                if (in_array($extension, ['pdf'])) {
                                                                    $iconColor = '#dc3545';
                                                                    $iconClass = 'fas fa-file-pdf';
                                                                } elseif (in_array($extension, ['doc', 'docx'])) {
                                                                    $iconColor = '#0d6efd';
                                                                    $iconClass = 'fas fa-file-word';
                                                                } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                                    $iconColor = '#198754';
                                                                    $iconClass = 'fas fa-file-image';
                                                                } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                                                    $iconColor = '#198754';
                                                                    $iconClass = 'fas fa-file-excel';
                                                                }
                                                            @endphp
                                                            <i class="{{ $iconClass }}" style="font-size: 32px; color: {{ $iconColor }};"></i>
                                                        </div>
                                                        <div class="file-info flex-grow-1">
                                                            <div class="file-name fw-bold">{{ $file->filename }}</div>
                                                            <div class="file-details small text-muted">
                                                                <span><i class="far fa-calendar-alt"></i> {{ $file->created_at->format('d/m/Y H:i') }}</span>
                                                                @if($file->filesize)
                                                                    <span class="ms-3"><i class="fas fa-weight-hanging"></i> {{ $file->getFormattedSizeAttribute() }}</span>
                                                                @endif
                                                                @if($file->file_extension)
                                                                    <span class="ms-3"><i class="fas fa-code"></i> {{ strtoupper($file->file_extension) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="file-actions">
                                                            <a href="{{ $file->getUrlAttribute() }}" 
                                                               target="_blank" 
                                                               class="btn btn-sm btn-outline-primary me-2"
                                                               title="Descargar archivo">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            <a href="{{ $file->getUrlAttribute() }}" 
                                                               target="_blank" 
                                                               class="btn btn-sm btn-outline-secondary"
                                                               title="Ver archivo">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <!-- Resumen de progreso -->
                            @php
                                $totalDocuments = count($requiredDocuments);
                                $uploadedCount = $uploadedFiles->count();
                                $progressPercentage = $totalDocuments > 0 ? round(($uploadedCount / $totalDocuments) * 100) : 0;
                                
                                $progressColor = 'danger';
                                if ($progressPercentage >= 80) {
                                    $progressColor = 'success';
                                } elseif ($progressPercentage >= 50) {
                                    $progressColor = 'warning';
                                } elseif ($progressPercentage >= 25) {
                                    $progressColor = 'info';
                                }
                            @endphp

                            <div class="bg-{{ $progressColor == 'danger' ? 'light' : $progressColor }}-subtle border border-{{ $progressColor }} rounded p-3 mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-chart-bar"></i>
                                        Progreso de Documentación
                                    </h6>
                                    <span class="badge bg-{{ $progressColor }}">{{ $uploadedCount }}/{{ $totalDocuments }}</span>
                                </div>
                                
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-{{ $progressColor }}" 
                                         role="progressbar" 
                                         style="width: {{ $progressPercentage }}%"
                                         aria-valuenow="{{ $progressPercentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-{{ $progressColor }}">
                                        <i class="fas fa-check"></i> {{ $uploadedCount }} documentos subidos
                                    </small>
                                    @if($totalDocuments - $uploadedCount > 0)
                                        <small class="text-muted">
                                            <i class="far fa-clock"></i> {{ $totalDocuments - $uploadedCount }} pendientes
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="far fa-file" style="font-size: 48px;"></i>
                                <p class="mt-3">No hay documentos requeridos configurados para este tipo de trámite.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Panel de Control -->
            <div class="col-md-4">
                <!-- Cambio de Estatus -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h6>
                            <i class="fas fa-cogs"></i>
                            Gestión de Estatus
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('urban_dev.requests.update', $urbanDevRequest) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Cambiar Estatus:</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="new" {{ $urbanDevRequest->status == 'new' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="initial_review" {{ $urbanDevRequest->status == 'initial_review' ? 'selected' : '' }}>Revisión Inicial</option>
                                    <option value="requirement_validation" {{ $urbanDevRequest->status == 'requirement_validation' ? 'selected' : '' }}>Validación de Requisitos</option>
                                    <option value="requires_correction" {{ $urbanDevRequest->status == 'requires_correction' ? 'selected' : '' }}>Requiere Corrección</option>
                                    <option value="payment_pending" {{ $urbanDevRequest->status == 'payment_pending' ? 'selected' : '' }}>Espera de Pago</option>
                                    <option value="authorization_process" {{ $urbanDevRequest->status == 'authorization_process' ? 'selected' : '' }}>Proceso de Autorización</option>
                                    <option value="authorized" {{ $urbanDevRequest->status == 'authorized' ? 'selected' : '' }}>Autorizada</option>
                                    <option value="rejected" {{ $urbanDevRequest->status == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Actualizar Estatus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Información de la Solicitud -->
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h6>
                            <i class="fas fa-info-circle"></i>
                            Detalles de la Solicitud
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">ID de Solicitud:</small>
                            <p class="mb-1 fw-bold">#{{ $urbanDevRequest->id }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Tipo de Trámite:</small>
                            <p class="mb-1">{{ $urbanDevRequest->getRequestTypeLabelAttribute() }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Estado Técnico:</small>
                            <code class="small">{{ $urbanDevRequest->status }}</code>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Fecha de Creación:</small>
                            <p class="mb-1">{{ $urbanDevRequest->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted">Última Actualización:</small>
                            <p class="mb-0">{{ $urbanDevRequest->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Resumen de Archivos -->
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="text-white">
                            <i class="far fa-folder"></i>
                            Resumen de Archivos
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($urbanDevRequest->files->count() > 0)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Total de archivos:</span>
                                    <span class="badge bg-primary">{{ $urbanDevRequest->files->count() }}</span>
                                </div>
                            </div>
                            
                            @php
                                $totalSize = $urbanDevRequest->files->sum('filesize');
                                $formattedSize = 'N/A';
                                if ($totalSize) {
                                    if ($totalSize >= 1073741824) {
                                        $formattedSize = number_format($totalSize / 1073741824, 2) . ' GB';
                                    } elseif ($totalSize >= 1048576) {
                                        $formattedSize = number_format($totalSize / 1048576, 2) . ' MB';
                                    } elseif ($totalSize >= 1024) {
                                        $formattedSize = number_format($totalSize / 1024, 2) . ' KB';
                                    } else {
                                        $formattedSize = $totalSize . ' bytes';
                                    }
                                }
                            @endphp
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Tamaño total:</span>
                                    <span class="text-muted">{{ $formattedSize }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="small fw-bold">Archivos por tipo:</h6>
                                @php
                                    $fileTypes = $urbanDevRequest->files->groupBy('file_extension');
                                @endphp
                                @foreach($fileTypes as $extension => $files)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">{{ strtoupper($extension) }}</span>
                                        <span class="badge text-bg-secondary">{{ $files->count() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="far fa-file" style="font-size: 36px;"></i>
                                <p class="mt-2 mb-0">No hay archivos adjuntos</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Administrativas -->
                <div class="card mt-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="text-white">
                            <i class="fas fa-cog"></i>
                            Acciones Administrativas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('urban_dev.requests.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver al Listado
                            </a>

                            <a href="mailto:{{ $urbanDevRequest->user->email }}?subject=Solicitud de Desarrollo Urbano #{{ $urbanDevRequest->id }}" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-envelope"></i> Contactar Solicitante
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<style>
.file-card {
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.file-card:hover {
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.file-icon {
    transition: transform 0.3s ease;
}

.file-card:hover .file-icon {
    transform: scale(1.1);
}

.file-actions .btn {
    min-width: 90px;
}

.file-info h6 {
    color: #333;
    font-weight: 600;
}

.file-card .badge {
    font-size: 0.75em;
}

/* Animación para botones */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Mejoras para iconos FontAwesome */
.fas, .far {
    margin-right: 0.25rem;
}

.card-header .fas,
.card-header .far {
    margin-right: 0.5rem;
}

/* Responsive para tarjetas de archivos */
@media (max-width: 576px) {
    .file-card .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .file-actions {
        width: 100%;
        margin-top: 15px;
    }
    
    .file-actions .btn-group-vertical {
        width: 100%;
        flex-direction: row !important;
    }
    
    .file-actions .btn {
        flex: 1;
    }
}

/* Estilos para modal de previsualización */
.modal-dialog {
    margin: 1rem auto;
}

.modal-xl {
    max-width: 90vw;
}

.modal-lg {
    max-width: 80vw;
}

/* Mejoras para el preview de imágenes */
.modal-body img {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.modal-body img:hover {
    transform: scale(1.02);
}

/* Estilos para iframe de PDF */
.modal-body iframe {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Loading state para imágenes */
.modal-body img {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-body img.loaded {
    opacity: 1;
}

/* Mejoras para badges en Bootstrap 5 */
.badge {
    --bs-badge-font-size: 0.75em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Funcionalidad de previsualización de archivos
    window.previewFile = function(url, filename, extension) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'filePreviewModal';
        modal.setAttribute('tabindex', '-1');
        
        let modalContent = '';
        
        if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(extension.toLowerCase())) {
            // Preview para imágenes
            modalContent = `
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-image"></i> ${filename}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="${url}" class="img-fluid" alt="${filename}" style="max-height: 70vh;">
                        </div>
                        <div class="modal-footer">
                            <a href="${url}" download="${filename}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            `;
        } else if (extension.toLowerCase() === 'pdf') {
            // Preview para PDFs
            modalContent = `
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-file-pdf"></i> ${filename}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe src="${url}" style="width: 100%; height: 70vh;" frameborder="0"></iframe>
                        </div>
                        <div class="modal-footer">
                            <a href="${url}" download="${filename}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <a href="${url}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Para otros tipos de archivo, solo mostrar información
            modalContent = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="far fa-file"></i> ${filename}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <i class="far fa-file" style="font-size: 64px; color: #6c757d;"></i>
                            <h6 class="mt-3">${filename}</h6>
                            <p class="text-muted">Tipo de archivo: ${extension.toUpperCase()}</p>
                            <p class="small text-muted">Este tipo de archivo no puede ser previsualizado en el navegador.</p>
                        </div>
                        <div class="modal-footer">
                            <a href="${url}" download="${filename}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <a href="${url}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        modal.innerHTML = modalContent;
        document.body.appendChild(modal);
        
        // Mostrar el modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        // Limpiar el DOM cuando se cierre el modal
        modal.addEventListener('hidden.bs.modal', function() {
            document.body.removeChild(modal);
        });
    };
    
    // Funcionalidad de descarga masiva
    window.downloadAllFiles = function() {
        const files = @json($urbanDevRequest->files->map(function($file) {
            return [
                'name' => $file->name,
                'url' => $file->getUrlAttribute()
            ];
        })->filter(function($file) {
            return !empty($file['url']);
        })->values());
        
        if (files.length === 0) {
            alert('No hay archivos disponibles para descargar');
            return;
        }
        
        // Mostrar confirmación
        if (!confirm(`¿Deseas descargar ${files.length} archivo(s)?`)) {
            return;
        }
        
        // Crear un indicador de progreso
        const progressDiv = document.createElement('div');
        progressDiv.innerHTML = `
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Descargando archivos...</strong> 
                <span id="downloadProgress">0/${files.length}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.querySelector('.card-body').prepend(progressDiv);
        
        // Descargar archivos uno por uno
        files.forEach(function(file, index) {
            setTimeout(function() {
                const link = document.createElement('a');
                link.href = file.url;
                link.download = file.name;
                link.target = '_blank';
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // Actualizar progreso
                const progressSpan = document.getElementById('downloadProgress');
                if (progressSpan) {
                    progressSpan.textContent = `${index + 1}/${files.length}`;
                    
                    // Remover el indicador cuando termine
                    if (index === files.length - 1) {
                        setTimeout(() => {
                            progressDiv.remove();
                        }, 2000);
                    }
                }
            }, index * 500); // Retrasar 500ms entre descargas
        });
    };
    
    // Funcionalidad de exportar PDF (placeholder)
    window.exportToPDF = function() {
        // Esta función se puede implementar con una librería como jsPDF
        alert('Funcionalidad de exportar PDF en desarrollo');
    };
});
</script>
@endsection
@endsection
