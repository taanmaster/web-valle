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
                                <h4 class="mb-1">{{ $urbanDevRequest->request_type_label }}</h4>
                                <p class="text-muted mb-0">
                                    Solicitud #{{ $urbanDevRequest->id }} • 
                                    Solicitado por: <strong>{{ $urbanDevRequest->user->name }}</strong>
                                </p>
                                <small class="text-muted">
                                    Creado: {{ $urbanDevRequest->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-{{ $urbanDevRequest->status_color }} fs-6 px-3 py-2">
                                    {{ $urbanDevRequest->status_label }}
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">
                                    Actualizado: {{ $urbanDevRequest->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Información Principal -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Información General -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Información General</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Número de Solicitud:</small>
                                <p class="mb-0"><strong>#{{ $urbanDevRequest->id }}</strong></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Solicitud:</small>
                                <p class="mb-0">{{ $urbanDevRequest->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Tipo de Solicitud:</small>
                                <p class="mb-0">{{ $urbanDevRequest->request_type_label }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Estado Actual:</small>
                                <span class="badge bg-{{ $urbanDevRequest->status_color }}">{{ $urbanDevRequest->status_label }}</span>
                            </div>
                            
                            @if($urbanDevRequest->description)
                            <div class="col-12 mb-3">
                                <small class="text-muted">Descripción:</small>
                                <p class="mb-0">{{ $urbanDevRequest->description }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Datos del Solicitante -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Datos del Solicitante</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Nombre Completo:</small>
                                <p class="mb-0">{{ $urbanDevRequest->user->name }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Email:</small>
                                <p class="mb-0">{{ $urbanDevRequest->user->email }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Registro:</small>
                                <p class="mb-0">{{ $urbanDevRequest->user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <!-- Detalles del Tipo de Solicitud -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Detalles de la Solicitud</h5>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="alert alert-info">
                                    <h6 class="mb-2"><i class="fas fa-info-circle"></i> {{ $urbanDevRequest->request_type_label }}</h6>
                                    <p class="mb-0">
                                        @switch($urbanDevRequest->request_type)
                                            @case('uso_suelo')
                                                Solicitud para determinar el uso de suelo permitido en un predio específico.
                                                @break
                                            @case('constancia_factibilidad')
                                                Constancia que certifica la viabilidad de un proyecto de desarrollo urbano.
                                                @break
                                            @case('permiso_anuncios')
                                                Permiso para la instalación y operación de anuncios publicitarios.
                                                @break
                                            @case('certificacion_numero_oficial')
                                                Certificación del número oficial asignado a un predio.
                                                @break
                                            @case('permiso_division')
                                                Permiso para dividir un predio en fracciones menores.
                                                @break
                                            @case('uso_via_publica')
                                                Permiso para uso temporal o permanente de vía pública.
                                                @break
                                            @case('licencia_construccion')
                                                Licencia para realizar obras de construcción.
                                                @break
                                            @case('permiso_construccion_panteones')
                                                Permiso especial para construcciones en panteones.
                                                @break
                                            @default
                                                Solicitud general de desarrollo urbano.
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Historial de Estados -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Historial</h5>
                            </div>
                            
                            <div class="col-12">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Solicitud Creada</h6>
                                            <p class="text-muted mb-0">{{ $urbanDevRequest->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($urbanDevRequest->updated_at != $urbanDevRequest->created_at)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-{{ $urbanDevRequest->status_color }}"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Estado Actualizado a: {{ $urbanDevRequest->status_label }}</h6>
                                            <p class="text-muted mb-0">{{ $urbanDevRequest->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('urban_dev.requests.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Volver al Listado
                                    </a>
                                    <button type="button" class="btn btn-primary" onclick="window.print()">
                                        <i class="fas fa-print"></i> Imprimir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de Control -->
            <div class="col-md-4">
                <!-- Cambio de Estatus -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Gestión de Estatus</h6>
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

                <!-- Archivos Adjuntos -->
                @if($urbanDevRequest->files->count() > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Archivos Adjuntos ({{ $urbanDevRequest->files->count() }})</h6>
                    </div>
                    <div class="card-body">
                        @foreach($urbanDevRequest->files as $file)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <div class="fw-bold">{{ $file->name ?? $file->filename }}</div>
                                <small class="text-muted">{{ $file->filename }}</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Archivos Adjuntos</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">No hay archivos adjuntos en esta solicitud.</p>
                    </div>
                </div>
                @endif

                <!-- Información de Usuario -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Información del Usuario</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Nombre:</small>
                            <p class="mb-1">{{ $urbanDevRequest->user->name }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Email:</small>
                            <p class="mb-1">{{ $urbanDevRequest->user->email }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Fecha de Registro:</small>
                            <p class="mb-0">{{ $urbanDevRequest->user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Información Técnica -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Información Técnica</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">ID de Solicitud:</small>
                            <p class="mb-1">#{{ $urbanDevRequest->id }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Tipo de Solicitud:</small>
                            <p class="mb-1">{{ $urbanDevRequest->request_type }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Estado Actual:</small>
                            <p class="mb-0">{{ $urbanDevRequest->status }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -12px;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    margin-left: 20px;
}

/* Estilo de impresión */
@media print {
    .btn, .card-header, .breadcrumb-item a {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .container-fluid {
        padding: 0 !important;
    }
    .col-md-4:last-child {
        display: none !important;
    }
    .col-md-8 {
        width: 100% !important;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Funcionalidad adicional si es necesaria
document.addEventListener('DOMContentLoaded', function() {
    // Aquí se pueden agregar funcionalidades adicionales
});
</script>
@endsection
@endsection
