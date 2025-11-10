@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Detalle de Solicitud @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <!-- Header -->
        <div class="row align-items-center mb-4">
            <div class="col-md-8 text-start">
                <h4 class="mb-1">
                    <ion-icon name="document-text-outline"></ion-icon> Alta de Proveedor: {{ $supplier->registration_number }}
                </h4>
                <p class="text-muted mb-0">
                    <strong>Tipo:</strong> 
                    @if($supplier->person_type == 'fisica')
                        Persona Física
                    @else
                        Persona Moral
                    @endif
                    | 
                    <strong>Usuario:</strong> {{ $supplier->user->name }} |
                    @switch($supplier->status)
                        @case('solicitud')
                            <span class="badge bg-secondary">Solicitud</span>
                            @break
                        @case('validacion')
                            <span class="badge bg-warning">Validación</span>
                            @break
                        @case('aprobacion')
                            <span class="badge bg-info">Aprobación</span>
                            @break
                        @case('pago_pendiente')
                            <span class="badge bg-primary">Pago Pendiente</span>
                            @break
                        @case('padron_activo')
                            <span class="badge bg-success">Padrón Activo</span>
                            @break
                        @case('rechazado')
                            <span class="badge bg-danger">Rechazado</span>
                            @break
                    @endswitch
                </p>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#contactModal">
                    <ion-icon name="mail-outline"></ion-icon> Contactar
                </button>
                <a href="{{ route('acquisitions.suppliers.index') }}" class="btn btn-secondary btn-sm">
                    <ion-icon name="arrow-back-outline"></ion-icon> Volver
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <ion-icon name="checkmark-circle-outline"></ion-icon> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Gestión de Estatus -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header bg-warning">
                        <h5 class="mb-0"><ion-icon name="settings-outline"></ion-icon> Gestión de Estatus</h5>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('acquisitions.suppliers.updateStatus', $supplier->id) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Cambiar Estatus:</label>
                                    <select name="status" class="form-select" required>
                                        <option value="solicitud" {{ $supplier->status == 'solicitud' ? 'selected' : '' }}>Solicitud</option>
                                        <option value="validacion" {{ $supplier->status == 'validacion' ? 'selected' : '' }}>Validación</option>
                                        <option value="aprobacion" {{ $supplier->status == 'aprobacion' ? 'selected' : '' }}>Aprobación</option>
                                        <option value="pago_pendiente" {{ $supplier->status == 'pago_pendiente' ? 'selected' : '' }}>Pago Pendiente</option>
                                        <option value="padron_activo" {{ $supplier->status == 'padron_activo' ? 'selected' : '' }}>Padrón Activo</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Notas:</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Agregar observaciones...">{{ $supplier->notes }}</textarea>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <ion-icon name="save-outline"></ion-icon> Actualizar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs de Navegación -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#formulario">
                            <ion-icon name="document-outline"></ion-icon> Formulario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#documentos">
                            <ion-icon name="folder-outline"></ion-icon> Validación de Documentos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#autorizacion">
                            <ion-icon name="shield-checkmark-outline"></ion-icon> Autorización
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <!-- TAB 1: Formulario -->
                    <div class="tab-pane fade show active" id="formulario">
                        <div class="box">
                            <div class="box-header bg-primary">
                                <h5 class="mb-0 text-white"><ion-icon name="document-text-outline"></ion-icon> Datos del Formulario</h5>
                            </div>
                            <div class="box-body">
                                @if($supplier->person_type === 'fisica')
                                    @include('acquisitions.suppliers.partials._form_fisica', ['supplier' => $supplier, 'readonly' => true])
                                @else
                                    @include('acquisitions.suppliers.partials._form_moral', ['supplier' => $supplier, 'readonly' => true])
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: Validación de Documentos -->
                    <div class="tab-pane fade" id="documentos">
                        <div class="box">
                            <div class="box-header bg-info">
                                <h5 class="mb-0 text-white">
                                    <ion-icon name="folder-open-outline"></ion-icon> Validación y Aprobación de Documentos
                                </h5>
                            </div>
                            <div class="box-body">
                                @foreach($requiredDocuments as $doc)
                                    @php
                                        $docFiles = $supplier->files->where('file_type', $doc['slug']);
                                    @endphp
                                    
                                    <div class="document-validation-item mb-4 pb-4 border-bottom">
                                        <h6 class="mb-3">{{ $doc['name'] }}</h6>
                                        
                                        @if($docFiles->count() > 0)
                                            @foreach($docFiles as $file)
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-4">
                                                                <ion-icon name="document-outline" style="font-size: 24px;"></ion-icon>
                                                                <strong>{{ $file->filename }}</strong>
                                                                <br>
                                                                <small class="text-muted">Subido: {{ $file->created_at->format('d/m/Y H:i') }}</small>
                                                                <br>
                                                                <a href="{{ $file->s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                                    <ion-icon name="eye-outline"></ion-icon> Ver Documento
                                                                </a>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <form action="{{ route('acquisitions.suppliers.updateFileStatus', [$supplier->id, $file->id]) }}" method="POST">
                                                                    @csrf
                                                                    <div class="row g-2">
                                                                        <div class="col-md-3">
                                                                            <label class="form-label">Estado:</label>
                                                                            <select name="status" class="form-select form-select-sm">
                                                                                <option value="pendiente" {{ $file->status == 'pendiente' ? 'selected' : '' }}>Pendiente a Aprobar</option>
                                                                                <option value="aprobado" {{ $file->status == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                                                                <option value="rechazado" {{ $file->status == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                            <label class="form-label">Nota/Comentario:</label>
                                                                            <input type="text" name="comments" class="form-control form-control-sm" 
                                                                                   value="{{ $file->comments }}" 
                                                                                   placeholder="Agregar nota sobre el documento...">
                                                                        </div>
                                                                        <div class="col-md-2 d-flex align-items-end">
                                                                            <button type="submit" class="btn btn-sm btn-success w-100">
                                                                                <ion-icon name="save-outline"></ion-icon> Guardar
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    @if($file->approved_by)
                                                                        <small class="text-muted d-block mt-2">
                                                                            Revisado por: Usuario #{{ $file->approved_by }} el {{ $file->approved_at->format('d/m/Y H:i') }}
                                                                        </small>
                                                                    @endif
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-warning">
                                                <ion-icon name="information-circle-outline"></ion-icon> El proveedor aún no ha subido este documento.
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: Autorización -->
                    <div class="tab-pane fade" id="autorizacion">
                        <div class="box">
                            <div class="box-header bg-success">
                                <h5 class="mb-0 text-white"><ion-icon name="shield-checkmark-outline"></ion-icon> Autorización y Firmas</h5>
                            </div>
                            <div class="box-body">
                                <form action="{{ route('acquisitions.suppliers.saveApprovals', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="row">
                                        <!-- Autorización Enlace -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">Autorización Enlace</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                   name="link_approval" 
                                                                   value="1" 
                                                                   id="linkApproval"
                                                                   class="form-check-input"
                                                                   {{ $supplier->approval && $supplier->approval->link_approval ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="linkApproval">
                                                                <strong>Autorizo el alta de proveedor</strong>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Ingresar Firma Digital:</label>
                                                        <textarea name="link_approval_signature" 
                                                                  class="form-control" 
                                                                  rows="3" 
                                                                  placeholder="Firma del Enlace">{{ $supplier->approval->link_approval_signature ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Autorización Director -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">Autorización Director</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                   name="director_approval" 
                                                                   value="1" 
                                                                   id="directorApproval"
                                                                   class="form-check-input"
                                                                   {{ $supplier->approval && $supplier->approval->director_approval ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="directorApproval">
                                                                <strong>Autorizo el alta de proveedor</strong>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Ingresar Firma Digital:</label>
                                                        <textarea name="director_approval_signature" 
                                                                  class="form-control" 
                                                                  rows="3" 
                                                                  placeholder="Firma del Director">{{ $supplier->approval->director_approval_signature ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Comentarios Generales:</label>
                                        <textarea name="comments" class="form-control" rows="3" placeholder="Comentarios adicionales...">{{ $supplier->approval->comments ?? '' }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subir Documento de Formato de Aprobación Firmado (PDF):</label>
                                        <input type="file" name="approval_file" class="form-control" accept=".pdf">
                                        @if($supplier->approval && $supplier->approval->filepath)
                                            <small class="text-muted">
                                                Archivo actual: 
                                                <a href="{{ Storage::disk('s3')->url($supplier->approval->filepath) }}" target="_blank">
                                                    {{ $supplier->approval->filename }}
                                                </a>
                                            </small>
                                        @endif
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <ion-icon name="save-outline"></ion-icon> Guardar Autorizaciones
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Contactar Proveedor -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><ion-icon name="mail-outline"></ion-icon> Contactar al Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('acquisitions.suppliers.contact', $supplier->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Destinatario:</label>
                        <input type="text" class="form-control" value="{{ $supplier->user->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje:</label>
                        <textarea name="message" class="form-control" rows="5" required placeholder="Escribir mensaje..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="send-outline"></ion-icon> Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<style>
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        font-weight: 600;
    }
    
    .box-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .box-header h5 {
        margin: 0;
    }
    
    .document-validation-item:last-child {
        border-bottom: none !important;
    }
    
    .card-header.bg-light h6 {
        color: #495057;
    }
</style>
@endsection
@endsection
