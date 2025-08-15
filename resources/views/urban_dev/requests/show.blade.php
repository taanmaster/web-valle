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
                                    <ion-icon name="document-text-outline"></ion-icon>
                                    {{ $urbanDevRequest->getRequestTypeLabelAttribute() }}
                                </h4>
                                <p class="text-muted mb-0">
                                    Solicitud #{{ $urbanDevRequest->id }} • 
                                    Solicitado por: <strong>{{ $urbanDevRequest->user->name }}</strong>
                                </p>
                                <small class="text-muted">
                                    <ion-icon name="calendar-outline"></ion-icon> Creado: {{ $urbanDevRequest->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-{{ $urbanDevRequest->getStatusColorAttribute() }} fs-6 px-3 py-2">
                                    {{ $urbanDevRequest->getStatusLabelAttribute() }}
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">
                                    <ion-icon name="time-outline"></ion-icon> Actualizado: {{ $urbanDevRequest->updated_at->format('d/m/Y H:i') }}
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
                        <h6 class="mb-0">
                            <ion-icon name="person-outline"></ion-icon>
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
                        <h6 class="mb-0">
                            <ion-icon name="checkmark-circle-outline"></ion-icon>
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
                                    'Solicitud por escrito dirigida al Director',
                                    'Copia de identificación oficial vigente',
                                    'Escritura pública o documento de propiedad',
                                    'Último recibo de pago del impuesto predial',
                                    'Plano de localización del predio (escala 1:1000)',
                                    'Croquis de ubicación con referencias y medidas'
                                ],
                                'constancia-de-factibilidad' => [
                                    'Solicitud detallada del proyecto',
                                    'Proyecto arquitectónico o memoria descriptiva',
                                    'Escritura pública de propiedad',
                                    'Plano topográfico actualizado',
                                    'Estudio de factibilidad de servicios públicos',
                                    'Dictamen de uso de suelo vigente'
                                ],
                                'permiso-de-anuncios' => [
                                    'Solicitud especificando tipo y características',
                                    'Diseño gráfico y especificaciones técnicas',
                                    'Documento de propiedad o autorización',
                                    'Memoria de cálculo estructural (si aplica)',
                                    'Plano de localización y ubicación exacta',
                                    'Fotografías del lugar de instalación'
                                ],
                                'certificacion-numero-oficial' => [
                                    'Solicitud dirigida al Director',
                                    'Escritura pública o documento de propiedad',
                                    'Constancia de alineamiento vigente',
                                    'Plano de localización con medidas exactas',
                                    'Identificación oficial del propietario',
                                    'Último recibo de impuesto predial'
                                ],
                                'permiso-de-division' => [
                                    'Solicitud con proyecto de división',
                                    'Escritura pública de propiedad',
                                    'Levantamiento topográfico certificado',
                                    'Proyecto de lotificación completo',
                                    'Dictamen de factibilidad de servicios',
                                    'Estudio de impacto urbano y vial'
                                ],
                                'uso-de-via-publica' => [
                                    'Solicitud especificando uso y tiempo',
                                    'Croquis del área a ocupar',
                                    'Programa de actividades y horarios',
                                    'Medidas de seguridad propuestas',
                                    'Póliza de seguro de responsabilidad civil',
                                    'Autorización de vecinos (si aplica)'
                                ],
                                'licencia-de-construccion' => [
                                    'Solicitud con proyecto arquitectónico',
                                    'Planos estructurales firmados por DRO',
                                    'Memoria de cálculo y especificaciones',
                                    'Dictamen de uso de suelo compatible',
                                    'Factibilidades de servicios públicos',
                                    'Estudio de mecánica de suelos (si aplica)'
                                ],
                                'permiso-construccion-panteones' => [
                                    'Solicitud dirigida a Administración del Panteón',
                                    'Proyecto de construcción funeraria',
                                    'Documento de propiedad o concesión del lote',
                                    'Especificaciones de materiales y acabados',
                                    'Plano de ubicación dentro del cementerio',
                                    'Autorización de familiares o herederos'
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
                                    $uploadedFile = $uploadedFiles->where('slug', $docSlug)->first();
                                    $isUploaded = $uploadedFile !== null;
                                @endphp
                                
                                <div class="d-flex align-items-center mb-3 p-3 border rounded {{ $isUploaded ? 'border-success bg-light' : 'border-warning' }}">
                                    <div class="me-3">
                                        @if($isUploaded)
                                            <ion-icon name="checkmark-circle" style="font-size: 24px; color: #28a745;"></ion-icon>
                                        @else
                                            <ion-icon name="ellipse-outline" style="font-size: 24px; color: #6c757d;"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 {{ $isUploaded ? 'text-success' : '' }}">{{ $document }}</h6>
                                        <small class="text-muted">
                                            @if($isUploaded)
                                                <ion-icon name="document-outline"></ion-icon> Documento subido - {{ $uploadedFile->filename }}
                                                <br>
                                                <ion-icon name="calendar-outline"></ion-icon> {{ $uploadedFile->created_at->format('d/m/Y H:i') }}
                                                @if($uploadedFile->filesize)
                                                    <br>
                                                    <ion-icon name="resize-outline"></ion-icon> {{ $uploadedFile->getFormattedSizeAttribute() }}
                                                @endif
                                            @else
                                                <ion-icon name="alert-circle-outline"></ion-icon> Pendiente de subir
                                            @endif
                                        </small>
                                    </div>
                                    @if($isUploaded)
                                        <div class="ms-3">
                                            <a href="{{ $uploadedFile->getUrlAttribute() }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                <ion-icon name="download-outline"></ion-icon> Descargar
                                            </a>
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
                                        <ion-icon name="bar-chart-outline"></ion-icon>
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
                                        <ion-icon name="checkmark-outline"></ion-icon> {{ $uploadedCount }} documentos subidos
                                    </small>
                                    @if($totalDocuments - $uploadedCount > 0)
                                        <small class="text-muted">
                                            <ion-icon name="time-outline"></ion-icon> {{ $totalDocuments - $uploadedCount }} pendientes
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <ion-icon name="document-outline" style="font-size: 48px;"></ion-icon>
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
                        <h6 class="mb-0">
                            <ion-icon name="settings-outline"></ion-icon>
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
                                <ion-icon name="save-outline"></ion-icon> Actualizar Estatus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Información de la Solicitud -->
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <ion-icon name="information-circle-outline"></ion-icon>
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
                        <h6 class="mb-0">
                            <ion-icon name="folder-outline"></ion-icon>
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
                                        <span class="badge bg-outline-secondary">{{ $files->count() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <ion-icon name="document-outline" style="font-size: 36px;"></ion-icon>
                                <p class="mt-2 mb-0">No hay archivos adjuntos</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Administrativas -->
                <div class="card mt-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0">
                            <ion-icon name="cog-outline"></ion-icon>
                            Acciones Administrativas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('urban_dev.requests.index') }}" class="btn btn-secondary btn-sm">
                                <ion-icon name="arrow-back-outline"></ion-icon> Volver al Listado
                            </a>

                            <a href="mailto:{{ $urbanDevRequest->user->email }}?subject=Solicitud de Desarrollo Urbano #{{ $urbanDevRequest->id }}" 
                               class="btn btn-warning btn-sm">
                                <ion-icon name="mail-outline"></ion-icon> Contactar Solicitante
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de descarga masiva
    window.downloadAllFiles = function() {
        const files = @json($urbanDevRequest->files->map(function($file) {
            return [
                'name' => $file->name,
                'url' => $file->getUrlAttribute()
            ];
        }));
        
        if (files.length === 0) {
            alert('No hay archivos para descargar');
            return;
        }
        
        // Descargar archivos uno por uno
        files.forEach(function(file, index) {
            setTimeout(function() {
                const link = document.createElement('a');
                link.href = file.url;
                link.download = file.name;
                link.target = '_blank';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }, index * 1000); // Retrasar 1 segundo entre descargas
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
