@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Detalle de Solicitud @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-file-contract fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Alta de Proveedor</h3>
                            <h5 class="text-muted mb-0">{{ $supplier->registration_number }}</h5>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle text-primary me-2"></i>
                            <span class="fw-semibold me-1">Tipo:</span>
                            <span class="badge bg-light text-dark">
                                @if($supplier->person_type == 'fisica')
                                    <i class="fas fa-user me-1"></i> Persona Física
                                @else
                                    <i class="fas fa-building me-1"></i> Persona Moral
                                @endif
                            </span>
                        </div>
                        
                        <div class="vr d-none d-md-block"></div>
                        
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user text-primary me-2"></i>
                            <span class="fw-semibold me-1">Usuario:</span>
                            <span>{{ $supplier->user->name }}</span>
                        </div>
                        
                        <div class="vr d-none d-md-block"></div>
                        
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <span class="fw-semibold me-1">Estado:</span>
                            @switch($supplier->status)
                                @case('solicitud')
                                    <span class="badge bg-secondary"><i class="fas fa-file-alt me-1"></i> Solicitud</span>
                                    @break
                                @case('validacion')
                                    <span class="badge bg-warning"><i class="fas fa-tasks me-1"></i> Validación</span>
                                    @break
                                @case('aprobacion')
                                    <span class="badge bg-info"><i class="fas fa-check-circle me-1"></i> Aprobación</span>
                                    @break
                                @case('pago_pendiente')
                                    <span class="badge bg-primary"><i class="fas fa-money-bill-wave me-1"></i> Pago Pendiente</span>
                                    @break
                                @case('padron_activo')
                                    <span class="badge bg-success"><i class="fas fa-check-double me-1"></i> Padrón Activo</span>
                                    @break
                                @case('rechazado')
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Rechazado</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <button type="button" class="btn btn-warning mb-2 mb-lg-0 me-2" data-bs-toggle="modal" data-bs-target="#contactModal">
                        <i class="fas fa-envelope me-2"></i> Contactar
                    </button>
                    <button type="button" class="btn btn-info mb-2 mb-lg-0 me-2" data-bs-toggle="modal" data-bs-target="#messagesModal">
                        <i class="fas fa-comments me-2"></i> 
                        Ver Mensajes
                        @if($supplier->messages->count() > 0)
                            <span class="badge bg-danger ms-1">{{ $supplier->messages->count() }}</span>
                        @endif
                    </button>
                    <a href="{{ route('acquisitions.suppliers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Gestión de Estatus -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-gradient bg-warning bg-opacity-10 border-0 py-3">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-cog me-2"></i> Gestión de Estatus
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('acquisitions.suppliers.updateStatus', $supplier->id) }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-exchange-alt text-primary me-2"></i> Cambiar Estatus:
                        </label>
                        <select name="status" class="form-select form-select-lg" required>
                            <option value="solicitud" {{ $supplier->status == 'solicitud' ? 'selected' : '' }}>
                                📄 Solicitud
                            </option>
                            <option value="validacion" {{ $supplier->status == 'validacion' ? 'selected' : '' }}>
                                ⚠️ Validación
                            </option>
                            <option value="aprobacion" {{ $supplier->status == 'aprobacion' ? 'selected' : '' }}>
                                ℹ️ Aprobación
                            </option>
                            <option value="pago_pendiente" {{ $supplier->status == 'pago_pendiente' ? 'selected' : '' }}>
                                💵 Pago Pendiente
                            </option>
                            <option value="padron_activo" {{ $supplier->status == 'padron_activo' ? 'selected' : '' }}>
                                ✅ Padrón Activo
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-sticky-note text-primary me-2"></i> Notas u Observaciones:
                        </label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Agregar observaciones o comentarios relevantes...">{{ $supplier->notes }}</textarea>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-save me-2"></i> Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabs de Navegación -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <ul class="nav nav-pills nav-fill gap-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active rounded-3 d-flex align-items-center justify-content-center py-3" 
                       data-bs-toggle="tab" 
                       href="#formulario"
                       role="tab">
                        <i class="fas fa-file-alt fa-lg me-2"></i>
                        <span class="fw-semibold">Formulario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-3 d-flex align-items-center justify-content-center py-3" 
                       data-bs-toggle="tab" 
                       href="#documentos"
                       role="tab">
                        <i class="fas fa-folder-open fa-lg me-2"></i>
                        <span class="fw-semibold">Validación de Documentos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-3 d-flex align-items-center justify-content-center py-3" 
                       data-bs-toggle="tab" 
                       href="#autorizacion"
                       role="tab">
                        <i class="fas fa-shield-alt fa-lg me-2"></i>
                        <span class="fw-semibold">Autorización</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content">
                <!-- TAB 1: Formulario -->
                <div class="tab-pane fade show active" id="formulario" role="tabpanel">
                    <div class="mb-3">
                        <h5 class="fw-bold text-primary border-bottom pb-3 mb-4">
                            <i class="fas fa-clipboard-list me-2"></i> Datos del Formulario
                        </h5>
                        @if($supplier->person_type === 'fisica')
                            @include('acquisitions.suppliers.partials._form_fisica', ['supplier' => $supplier, 'readonly' => true])
                        @else
                            @include('acquisitions.suppliers.partials._form_moral', ['supplier' => $supplier, 'readonly' => true])
                        @endif
                    </div>
                </div>

                <!-- TAB 2: Validación de Documentos -->
                <div class="tab-pane fade" id="documentos" role="tabpanel">
                    <div class="mb-3">
                        <h5 class="fw-bold text-info border-bottom pb-3 mb-4">
                            <i class="fas fa-folder-open me-2"></i> Validación y Aprobación de Documentos
                        </h5>
                        @foreach($requiredDocuments as $doc)
                            @php
                                $docFiles = $supplier->files->where('file_type', $doc['slug']);
                            @endphp
                            
                            <div class="document-section mb-4 pb-4 border-bottom">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-file-pdf text-danger me-2"></i> {{ $doc['name'] }}
                                </h6>
                                
                                @if($docFiles->count() > 0)
                                    @foreach($docFiles as $file)
                                        <div class="card border-0 shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 mb-3 mb-lg-0">
                                                        <div class="d-flex align-items-start">
                                                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-1 fw-semibold">{{ $file->filename }}</h6>
                                                                <small class="text-muted d-block mb-2">
                                                                    <i class="far fa-calendar me-1"></i>
                                                                    Subido: {{ $file->created_at->format('d/m/Y H:i') }}
                                                                </small>
                                                                <a href="{{ $file->s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye me-1"></i> Ver Documento
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <form action="{{ route('acquisitions.suppliers.updateFileStatus', [$supplier->id, $file->id]) }}" method="POST">
                                                            @csrf
                                                            <div class="row g-3">
                                                                <div class="col-md-3">
                                                                    <label class="form-label fw-semibold">
                                                                        <i class="fas fa-info-circle me-1"></i> Estado:
                                                                    </label>
                                                                    <select name="status" class="form-select">
                                                                        <option value="pendiente" {{ $file->status == 'pendiente' ? 'selected' : '' }}>
                                                                            ⏳ Pendiente
                                                                        </option>
                                                                        <option value="aprobado" {{ $file->status == 'aprobado' ? 'selected' : '' }}>
                                                                            ✅ Aprobado
                                                                        </option>
                                                                        <option value="rechazado" {{ $file->status == 'rechazado' ? 'selected' : '' }}>
                                                                            ❌ Rechazado
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <label class="form-label fw-semibold">
                                                                        <i class="fas fa-comment-alt me-1"></i> Nota/Comentario:
                                                                    </label>
                                                                    <input type="text" name="comments" class="form-control" 
                                                                           value="{{ $file->comments }}" 
                                                                           placeholder="Agregar nota sobre el documento...">
                                                                </div>
                                                                <div class="col-md-2 d-flex align-items-end">
                                                                    <button type="submit" class="btn btn-success w-100">
                                                                        <i class="fas fa-save me-1"></i> Guardar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            @if($file->approved_by)
                                                                <div class="alert alert-light border mt-3 mb-0">
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-user-check me-1"></i>
                                                                        <strong>Revisado por:</strong> Usuario {{ $file->approvedBy->name }}
                                                                        <i class="far fa-clock ms-2 me-1"></i>
                                                                        {{ $file->approved_at->format('d/m/Y H:i') }}
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning border-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i> 
                                        El proveedor aún no ha subido este documento.
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- TAB 3: Autorización -->
                <div class="tab-pane fade" id="autorizacion" role="tabpanel">
                    <div class="mb-3">
                        <h5 class="fw-bold text-success border-bottom pb-3 mb-4">
                            <i class="fas fa-shield-alt me-2"></i> Autorización y Firmas
                        </h5>
                        <form action="{{ route('acquisitions.suppliers.saveApprovals', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row g-4 mb-4">
                                <!-- Autorización Enlace -->
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-header bg-gradient bg-primary bg-opacity-10 border-0 py-3">
                                            <h6 class="mb-0 fw-bold text-dark">
                                                <i class="fas fa-user-tie me-2"></i> Autorización Enlace
                                            </h6>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" 
                                                           name="link_approval" 
                                                           value="1" 
                                                           id="linkApproval"
                                                           class="form-check-input"
                                                           style="width: 3rem; height: 1.5rem;"
                                                           {{ $supplier->approval && $supplier->approval->link_approval ? 'checked' : '' }}>
                                                    <label class="form-check-label ms-2 fw-semibold" for="linkApproval">
                                                        <i class="fas fa-check-circle text-success me-1"></i> Autorizo el alta de proveedor
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-signature me-2"></i> Firma Digital:
                                                </label>
                                                <textarea name="link_approval_signature" 
                                                          class="form-control" 
                                                          rows="4" 
                                                          placeholder="Ingrese su firma digital o nombre completo...">{{ $supplier->approval->link_approval_signature ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Autorización Director -->
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-header bg-gradient bg-success bg-opacity-10 border-0 py-3">
                                            <h6 class="mb-0 fw-bold text-dark">
                                                <i class="fas fa-user-shield me-2"></i> Autorización Director
                                            </h6>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" 
                                                           name="director_approval" 
                                                           value="1" 
                                                           id="directorApproval"
                                                           class="form-check-input"
                                                           style="width: 3rem; height: 1.5rem;"
                                                           {{ $supplier->approval && $supplier->approval->director_approval ? 'checked' : '' }}>
                                                    <label class="form-check-label ms-2 fw-semibold" for="directorApproval">
                                                        <i class="fas fa-check-circle text-success me-1"></i> Autorizo el alta de proveedor
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-signature me-2"></i> Firma Digital:
                                                </label>
                                                <textarea name="director_approval_signature" 
                                                          class="form-control" 
                                                          rows="4" 
                                                          placeholder="Ingrese su firma digital o nombre completo...">{{ $supplier->approval->director_approval_signature ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-comments me-2"></i> Comentarios Generales:
                                        </label>
                                        <textarea name="comments" class="form-control" rows="4" placeholder="Agregar comentarios adicionales sobre la autorización...">{{ $supplier->approval->comments ?? '' }}</textarea>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-file-pdf me-2"></i> Documento de Formato de Aprobación Firmado (PDF):
                                        </label>
                                        <input type="file" name="approval_file" class="form-control form-control-lg" accept=".pdf">
                                        @if($supplier->approval && $supplier->approval->filepath)
                                            <div class="alert alert-info border-0 mt-3 mb-0">
                                                <i class="fas fa-paperclip me-2"></i>
                                                <strong>Archivo actual:</strong> 
                                                <a href="{{ Storage::disk('s3')->url($supplier->approval->filepath) }}" 
                                                   target="_blank" 
                                                   class="alert-link">
                                                    {{ $supplier->approval->filename }}
                                                    <i class="fas fa-external-link-alt ms-1"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5 py-3">
                                    <i class="fas fa-save me-2"></i> Guardar Autorizaciones
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Contactar Proveedor -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="contactModalLabel">
                    <i class="fas fa-envelope me-2"></i> Contactar al Proveedor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('acquisitions.suppliers.contact', $supplier->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    {{--  
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-at me-2 text-primary"></i> Destinatario:
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 bg-light" value="{{ $supplier->user->email }}" readonly>
                        </div>
                    </div>
                    --}}
                    <div class="mb-0">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-comment-dots me-2 text-primary"></i> Mensaje:
                        </label>
                        <textarea name="message" 
                                  class="form-control" 
                                  rows="6" 
                                  required 
                                  placeholder="Escriba aquí el mensaje que desea enviar al proveedor..."></textarea>
                        <small class="text-muted form-text">
                            <i class="fas fa-info-circle me-1"></i> El mensaje será mostrará en el panel del Proveedor.
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i> Enviar Mensaje
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver Mensajes -->
<div class="modal fade" id="messagesModal" tabindex="-1" aria-labelledby="messagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient bg-info text-white border-0">
                <h5 class="modal-title fw-bold" id="messagesModalLabel">
                    <i class="fas fa-comments me-2"></i> Mensajes Enviados al Proveedor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                @if($supplier->messages->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($supplier->messages->sortByDesc('created_at') as $message)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="fas fa-user-shield text-info"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Administrador</h6>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $message->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge {{ $message->status === 'read' ? 'bg-success' : 'bg-warning' }}">
                                        <i class="fas {{ $message->status === 'read' ? 'fa-check-double' : 'fa-envelope' }} me-1"></i>
                                        {{ $message->status === 'read' ? 'Leído' : 'No leído' }}
                                    </span>
                                </div>
                                <div class="message-content ps-5">
                                    <p class="mb-0 text-muted">{{ $message->message }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-inbox fa-5x text-muted opacity-50"></i>
                        </div>
                        <h5 class="fw-bold mb-3">No hay mensajes</h5>
                        <p class="text-muted mb-0">
                            Aún no se han enviado mensajes a este proveedor.
                        </p>
                    </div>
                @endif
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<style>
    /* Estilos personalizados para la vista de alta de proveedor */
    
    /* Transiciones suaves */
    * {
        transition: all 0.3s ease;
    }
    
    /* Estilo para las tabs */
    .nav-pills .nav-link {
        color: #6c757d;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .nav-pills .nav-link:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        border-color: #0d6efd;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        transform: translateY(-2px);
    }
    
    .nav-pills .nav-link i {
        font-size: 1.1rem;
    }
    
    /* Cards con mejor diseño */
    .card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .card-header {
        border-radius: 12px 12px 0 0;
    }
    
    /* Formularios más estéticos */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 0.6rem 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    /* Campos readonly/disabled */
    .form-control.disabled,
    .form-control:disabled,
    .form-control[readonly] {
        background-color: #f8f9fa;
        border-color: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
        opacity: 0.75;
    }
    
    textarea.form-control.disabled,
    textarea.form-control:disabled,
    textarea.form-control[readonly] {
        background-color: #f8f9fa;
        resize: none;
    }
    
    .form-label {
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .form-label i {
        opacity: 0.7;
    }
    
    /* Botones mejorados */
    .btn {
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1.1rem;
    }
    
    /* Badges mejorados */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    /* Alertas mejoradas */
    .alert {
        border-radius: 10px;
        border-left: 4px solid;
        padding: 1rem 1.5rem;
    }
    
    .alert-success {
        border-left-color: #198754;
        background-color: #d1e7dd;
    }
    
    .alert-warning {
        border-left-color: #ffc107;
        background-color: #fff3cd;
    }
    
    .alert-info {
        border-left-color: #0dcaf0;
        background-color: #cff4fc;
    }
    
    /* Secciones de documentos */
    .document-section {
        border-left: 4px solid #0d6efd;
        padding-left: 1.5rem;
    }
    
    .document-section:last-child {
        border-bottom: none !important;
    }
    
    /* Modal mejorado */
    .modal-content {
        border-radius: 15px;
    }
    
    .modal-header {
        border-radius: 15px 15px 0 0;
    }

    /* Mensajes en el modal */
    .list-group-item {
        border-left: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        border-left-color: #0dcaf0;
        transform: translateX(3px);
    }

    .message-content {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 0.5rem;
        border-left: 3px solid #0dcaf0;
    }
    
    /* Iconos con mejor espaciado */
    i.fas, i.far, i.fab {
        min-width: 1.25rem;
    }
    
    /* Divisores verticales */
    .vr {
        width: 2px;
        background-color: #dee2e6;
        opacity: 0.5;
    }
    
    /* Backgrounds con gradientes sutiles */
    .bg-gradient {
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    }
    
    /* Sombras personalizadas */
    .shadow-sm {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
    }
    
    /* Mejora en switches */
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
    
    /* Hover en enlaces */
    a {
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    a:hover {
        opacity: 0.8;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .nav-pills {
            flex-direction: column;
        }
        
        .nav-pills .nav-link {
            margin-bottom: 0.5rem;
        }
        
        .card {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection
@endsection
