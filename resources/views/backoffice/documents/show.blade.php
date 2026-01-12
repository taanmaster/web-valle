@extends('layouts.master')
@section('title')Intranet @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<link href="{{ asset('libs/signature-pad-main/assets/jquery.signaturepad.css') }}" rel="stylesheet" />
<style>
    .signature-pad-wrapper {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        background: #f8f9fa;
    }
    .sigPad canvas {
        width: 100%;
        height: 200px;
    }
    .validation-progress {
        height: 20px;
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('li_3') <a href="{{ route('backoffice.documents.index') }}">Oficios</a> @endslot
@slot('title') Detalle del Oficio @endslot
@endcomponent

<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Sección de Notificaciones y Avisos -->
    @php
        $lastCorrectionRequest = $document->versions()
            ->where('activity_type', 'correccion_solicitada')
            ->orderBy('created_at', 'desc')
            ->first();
        
        $isCreatorViewing = $document->user_id == Auth::id();
        $isAssignedViewing = $document->assigned_to == Auth::id();
    @endphp

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <!-- Flujo de Trabajo -->
            <div class="row align-items-center mb-4">
                <div class="col-12">
                    <h6 class="text-muted mb-3"><i class="fas fa-stream me-2"></i> Flujo del Oficio</h6>
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <!-- Paso 1: Borrador -->
                        <div class="text-center flex-fill">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->status == 'borrador' ? 'bg-warning' : 'bg-success' }}" style="width: 50px; height: 50px;">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                            <small class="d-block mt-2 {{ $document->status == 'borrador' ? 'fw-bold text-warning' : 'text-success' }}">Borrador</small>
                        </div>
                        
                        <div class="text-muted"><i class="fas fa-arrow-right"></i></div>
                        
                        <!-- Paso 2: En Revisión -->
                        <div class="text-center flex-fill">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->status == 'revision' ? 'bg-info' : ($document->status == 'borrador' ? 'bg-secondary' : 'bg-success') }}" style="width: 50px; height: 50px;">
                                <i class="fas fa-search text-white"></i>
                            </div>
                            <small class="d-block mt-2 {{ $document->status == 'revision' ? 'fw-bold text-info' : ($document->status == 'borrador' ? 'text-muted' : 'text-success') }}">En Revisión</small>
                        </div>
                        
                        <div class="text-muted"><i class="fas fa-arrow-right"></i></div>
                        
                        <!-- Paso 3: Validaciones -->
                        <div class="text-center flex-fill">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->validations_count >= 3 ? 'bg-success' : ($document->status == 'revision' ? 'bg-primary' : 'bg-secondary') }}" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">{{ $document->validations_count }}/3</span>
                            </div>
                            <small class="d-block mt-2 {{ $document->validations_count >= 3 ? 'text-success fw-bold' : ($document->status == 'revision' ? 'text-primary' : 'text-muted') }}">Validaciones</small>
                        </div>
                        
                        <div class="text-muted"><i class="fas fa-arrow-right"></i></div>
                        
                        <!-- Paso 4: Firmado -->
                        <div class="text-center flex-fill">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center {{ $document->status == 'firmado' ? 'bg-success' : 'bg-secondary' }}" style="width: 50px; height: 50px;">
                                <i class="fas fa-signature text-white"></i>
                            </div>
                            <small class="d-block mt-2 {{ $document->status == 'firmado' ? 'fw-bold text-success' : 'text-muted' }}">Firmado</small>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Avisos Importantes -->
            <div class="row">
                <div class="col-12">
                    <h6 class="text-muted mb-3"><i class="fas fa-bell me-2"></i> Avisos y Notificaciones</h6>
                    
                    @if($document->status == 'firmado')
                        <div class="alert alert-success mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-double fa-lg me-3"></i>
                                <div>
                                    <strong>Oficio Completado</strong><br>
                                    <small>Este oficio ha sido firmado y su proceso ha concluido exitosamente.</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($lastCorrectionRequest && $document->status == 'borrador' && $isCreatorViewing)
                        <div class="alert alert-warning mb-2">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle fa-lg me-3 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong>Corrección Solicitada</strong><br>
                                    <small class="text-muted">Por {{ $lastCorrectionRequest->modifiedByUser->name ?? 'Usuario' }} - {{ $lastCorrectionRequest->created_at->format('d/m/Y H:i') }}</small>
                                    <p class="mb-0 mt-2">{{ Str::limit($lastCorrectionRequest->activity_detail, 200) }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($document->status == 'borrador' && $isCreatorViewing && !$lastCorrectionRequest)
                        <div class="alert alert-info mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-lg me-3"></i>
                                <div>
                                    <strong>Oficio en Borrador</strong><br>
                                    <small>Puedes editar este oficio. Cuando esté listo, envíalo para revisión a un colaborador de tu dependencia.</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($document->status == 'revision' && $isAssignedViewing)
                        <div class="alert alert-primary mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tasks fa-lg me-3"></i>
                                <div>
                                    <strong>Pendiente de tu Revisión</strong><br>
                                    <small>Este oficio te fue asignado para revisión. Puedes validarlo, solicitar correcciones o firmarlo (si tiene 3 validaciones).</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($document->status == 'revision' && $isCreatorViewing && !$isAssignedViewing)
                        <div class="alert alert-secondary mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-hourglass-half fa-lg me-3"></i>
                                <div>
                                    <strong>En Revisión por {{ $document->assignedUser->name ?? 'Colaborador' }}</strong><br>
                                    <small>Tu oficio está siendo revisado. Recibirás una notificación cuando sea validado o si se solicitan correcciones.</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($document->canBeSigned() && $isAssignedViewing)
                        <div class="alert alert-success mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-pen-fancy fa-lg me-3"></i>
                                <div>
                                    <strong>¡Listo para Firmar!</strong><br>
                                    <small>Este oficio ha alcanzado las 3 validaciones requeridas. Ya puedes proceder a firmarlo.</small>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($document->validations->count() == 0 && $document->status != 'borrador' && $document->status != 'firmado')
                        <div class="alert alert-light border mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock fa-lg me-3 text-muted"></i>
                                <div>
                                    <strong class="text-muted">Sin Validaciones Aún</strong><br>
                                    <small class="text-muted">Este oficio aún no ha recibido validaciones. Se requieren 3 para poder firmarse.</small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary  d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white"><i class="fas fa-file-alt me-2"></i> Oficio {{ $document->folio }}</h5>
                    <div>
                        {!! $document->status_badge !!}
                        {!! $document->priority_badge !!}
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Información General -->
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2 text-primary"></i> Información General</h6>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Folio</small>
                            <strong class="text-primary">{{ $document->folio }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Fecha de Expedición</small>
                            <strong>{{ $document->issue_date->format('d/m/Y') }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Tipo</small>
                            {!! $document->type_badge !!}
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Prioridad</small>
                            {!! $document->priority_badge !!}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Dependencia Destino</small>
                            <strong>{{ $document->dependency->name ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Remitente (Director Destino)</small>
                            <strong>{{ $document->sender }}</strong>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Creado por</small>
                            <strong>{{ $document->user->name ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Solicitante (Director Origen)</small>
                            <strong>{{ $document->requester }}</strong>
                        </div>
                    </div>

                    <!-- Asunto -->
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-tag me-2 text-primary"></i> Asunto</h6>
                    <p class="mb-4">{{ $document->subject }}</p>

                    <!-- Cuerpo del Oficio -->
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-file-alt me-2 text-primary"></i> Cuerpo del Oficio</h6>
                    <div class="bg-light p-4 rounded mb-4" style="white-space: pre-wrap;">{{ $document->body }}</div>

                    <!-- Firma y Sello (si existe) -->
                    @if($document->signature_s3_url)
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-signature me-2 text-primary"></i> Firma y Sello</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-2">Firma</small>
                                <img src="{{ $document->signature_s3_url }}" alt="Firma" class="img-fluid border rounded" style="max-height: 150px;">
                            </div>
                            @if($document->stamp_s3_url)
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2">Sello</small>
                                    <img src="{{ $document->stamp_s3_url }}" alt="Sello" class="img-fluid border rounded" style="max-height: 150px;">
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones para el colaborador asignado -->
            @if($document->assigned_to == Auth::id() && $document->status == 'revision')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4"><i class="fas fa-tasks me-2"></i> Acciones Disponibles</h5>
                        
                        <!-- Barra de progreso de validaciones -->
                        <div class="mb-4">
                            <label class="form-label">Progreso de Validaciones: {{ $document->validations_count }}/3</label>
                            <div class="progress validation-progress">
                                <div class="progress-bar bg-{{ $document->canBeSigned() ? 'success' : 'primary' }}" 
                                     role="progressbar" 
                                     style="width: {{ $document->validation_progress }}%"
                                     aria-valuenow="{{ $document->validations_count }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="3">
                                    {{ $document->validations_count }}/3
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Solicitar Corrección -->
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-danger w-100 py-3" data-bs-toggle="modal" data-bs-target="#correctionModal">
                                    <i class="fas fa-undo fa-2x d-block mb-2"></i>
                                    Solicitar Corrección
                                </button>
                            </div>

                            <!-- Validar -->
                            @if(!$document->hasBeenValidatedBy(Auth::id()) && $document->user_id != Auth::id())
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#validateModal">
                                        <i class="fas fa-check-circle fa-2x d-block mb-2"></i>
                                        Validar
                                    </button>
                                </div>
                            @else
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-secondary w-100 py-3" disabled>
                                        <i class="fas fa-check-circle fa-2x d-block mb-2"></i>
                                        @if($document->user_id == Auth::id())
                                            No puedes validar tu oficio
                                        @else
                                            Ya validaste
                                        @endif
                                    </button>
                                </div>
                            @endif

                            <!-- Firmar -->
                            <div class="col-md-4">
                                @if($document->canBeSigned())
                                    <button type="button" class="btn btn-outline-success w-100 py-3" data-bs-toggle="modal" data-bs-target="#signModal">
                                        <i class="fas fa-signature fa-2x d-block mb-2"></i>
                                        Firmar
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary w-100 py-3" disabled>
                                        <i class="fas fa-lock fa-2x d-block mb-2"></i>
                                        Firmar (Requiere 3 validaciones)
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Acción para enviar a revisión (solo creador, solo borrador) -->
            @if($document->user_id == Auth::id() && $document->status == 'borrador')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 text-center">
                        <h5 class="mb-3"><i class="fas fa-paper-plane me-2"></i> Enviar para Revisión</h5>
                        <p class="text-muted mb-4">Tu oficio está listo. Envíalo a un colaborador para su revisión.</p>
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#sendReviewModal">
                            <i class="fas fa-paper-plane me-2"></i> Enviar para su Revisión
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Información del Estado -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Estado del Oficio</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Estado:</span>
                        {!! $document->status_badge !!}
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Validaciones:</span>
                        <span class="badge bg-{{ $document->validations_count >= 3 ? 'success' : 'secondary' }}">
                            {{ $document->validations_count }}/3
                        </span>
                    </div>
                    @if($document->assigned_to)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Asignado a:</span>
                            <strong>{{ $document->assignedUser->name ?? '-' }}</strong>
                        </div>
                    @endif
                    @if($document->assignment_message)
                        <hr>
                        <small class="text-muted d-block">Mensaje:</small>
                        <p class="mb-0 small">{{ $document->assignment_message }}</p>
                    @endif
                </div>
            </div>

            <!-- Validaciones -->
            @if($document->validations->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-check-double me-2"></i> Validaciones</h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($document->validations as $validation)
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <div>
                                            <strong>{{ $validation->validator->name ?? 'Usuario' }}</strong>
                                            <small class="text-muted d-block">{{ $validation->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Control de Versiones -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-history me-2"></i> Control de Versiones</h6>
                    <div>
                        <a href="{{ route('backoffice.documents.versions', $document->id) }}" class="btn btn-sm btn-outline-primary">
                            Ver Todas
                        </a>
                    </div>
                    
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($document->versions->take(5) as $version)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        {!! $version->activity_type_badge !!}
                                        <small class="text-muted d-block mt-1">
                                            {{ $version->modifiedByUser->name ?? 'Sistema' }}
                                        </small>
                                    </div>
                                    <small class="text-muted">{{ $version->created_at->format('d/m H:i') }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2"></i> Acciones</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($document->user_id == Auth::id() && $document->status == 'borrador')
                            <a href="{{ route('backoffice.documents.edit', $document->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i> Editar Oficio
                            </a>
                        @endif
                        <a href="{{ route('backoffice.documents.versions', $document->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-history me-2"></i> Ver Historial
                        </a>
                        <a href="{{ route('backoffice.documents.index') }}" class="btn btn-outline-dark">
                            <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Confirmar Recibo -->
@if($showConfirmModal)
<div class="modal fade" id="confirmReceiptModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-envelope-open me-2"></i> Confirmar Recibo</h5>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-envelope-open-text fa-4x text-info mb-3"></i>
                <h5>Nuevo Oficio Asignado</h5>
                <p class="text-muted">Has recibido el oficio <strong>{{ $document->folio }}</strong> para su revisión.</p>
                <p class="mb-0">Por favor confirma que has recibido y leído este documento.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form action="{{ route('backoffice.documents.confirm-receipt', $document->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-info btn-lg">
                        <i class="fas fa-check me-2"></i> Confirmar Recibo y Leído
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal: Enviar para Revisión -->
<div class="modal fade" id="sendReviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-paper-plane me-2"></i> Enviar para Revisión</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backoffice.documents.send-review', $document->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Colaborador <span class="text-danger">*</span></label>
                        <select name="assigned_to" id="assigned_to_review" class="form-select" required>
                            <option value="">Buscar colaborador...</option>
                            @foreach($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje (opcional)</label>
                        <textarea name="assignment_message" class="form-control" rows="3" placeholder="Escriba un mensaje para el colaborador..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i> Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Solicitar Corrección -->
<div class="modal fade" id="correctionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-undo me-2"></i> Solicitar Corrección</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backoffice.documents.request-correction', $document->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        El oficio será devuelto a <strong>{{ $document->user->name ?? 'el creador' }}</strong> para correcciones.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especifique las correcciones requeridas <span class="text-danger">*</span></label>
                        <textarea name="correction_message" class="form-control" rows="5" placeholder="Describa detalladamente las correcciones necesarias..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-undo me-2"></i> Solicitar Corrección
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Validar -->
<div class="modal fade" id="validateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i> Validar Oficio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backoffice.documents.validate', $document->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check me-2"></i>
                        Esta será la validación #{{ $document->validations_count + 1 }} de 3 requeridas.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Enviar al siguiente colaborador <span class="text-danger">*</span></label>
                        <select name="next_assigned_to" id="next_assigned_to" class="form-select" required>
                            <option value="">Seleccionar colaborador...</option>
                            @foreach($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje (opcional)</label>
                        <textarea name="validation_message" class="form-control" rows="3" placeholder="Mensaje para el siguiente colaborador..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle me-2"></i> Validar y Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Firmar -->
<div class="modal fade" id="signModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-signature me-2"></i> Firmar Oficio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backoffice.documents.sign', $document->id) }}" method="POST" enctype="multipart/form-data" id="signForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-double me-2"></i>
                        Este oficio ha completado las 3 validaciones requeridas y está listo para ser firmado.
                    </div>
                    
                    <!-- Área de Firma -->
                    <div class="mb-4">
                        <label class="form-label"><strong>Firma Digital</strong> <span class="text-danger">*</span></label>
                        <div class="signature-pad-wrapper p-3">
                            <div class="sigPad" id="signaturePad">
                                <ul class="sigNav mb-2">
                                    <li class="clearButton btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-eraser me-1"></i> Limpiar
                                    </li>
                                </ul>
                                <div class="sig sigWrapper">
                                    <canvas class="pad" width="600" height="200"></canvas>
                                    <input type="hidden" name="signature" class="output" id="signatureOutput">
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">Dibuje su firma en el área de arriba usando el mouse o pantalla táctil.</small>
                    </div>

                    <!-- Subir Sello -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Sello (opcional)</strong></label>
                        <input type="file" name="stamp" class="form-control" accept=".png,.jpg,.jpeg">
                        <small class="text-muted">Suba una imagen PNG o JPG del sello que aparecerá decorativamente sobre el documento.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-signature me-2"></i> Firmar Documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('libs/signature-pad-main/jquery.signaturepad.min.js') }}"></script>
<script src="{{ asset('libs/signature-pad-main/assets/json2.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar modal de confirmación de recibo si es primera lectura
    @if($showConfirmModal)
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmReceiptModal'));
        confirmModal.show();
    @endif

    // Inicializar Select2 para búsqueda de usuarios
    $('#assigned_to_review, #next_assigned_to').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar colaborador...',
        allowClear: true,
        dropdownParent: $('.modal.show').length ? $('.modal.show') : $('body')
    });

    // Reinicializar Select2 cuando se abre cada modal
    $('#sendReviewModal').on('shown.bs.modal', function() {
        $('#assigned_to_review').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar colaborador...',
            dropdownParent: $(this)
        });
    });

    $('#validateModal').on('shown.bs.modal', function() {
        $('#next_assigned_to').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar colaborador...',
            dropdownParent: $(this)
        });
    });

    // Inicializar Signature Pad
    var signaturePad = null;
    $('#signModal').on('shown.bs.modal', function() {
        if (!signaturePad) {
            signaturePad = $('#signaturePad').signaturePad({
                drawOnly: true,
                lineTop: 180
            });
        }
    });

    // Antes de enviar el formulario de firma, obtener la imagen base64
    $('#signForm').on('submit', function(e) {
        if (signaturePad) {
            var signatureData = signaturePad.getSignatureImage();
            if (!signatureData || signaturePad.validateForm() === false) {
                e.preventDefault();
                alert('Por favor, dibuje su firma antes de continuar.');
                return false;
            }
            $('#signatureOutput').val(signatureData);
        }
    });
});
</script>
@endsection
