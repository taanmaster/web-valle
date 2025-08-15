@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') SARE @endslot
@slot('li_3') <a href="{{ route('sare.request.index') }}">Solicitudes</a> @endslot
@slot('title') Solicitud #{{ $sareRequest->request_num }} @endslot
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
                                <h4 class="mb-1">{{ $sareRequest->commercial_name }}</h4>
                                <p class="text-muted mb-0">
                                    Solicitud #{{ $sareRequest->request_num }} • 
                                    Solicitado por: <strong>{{ $sareRequest->user->name }}</strong>
                                </p>
                                <small class="text-muted">
                                    Creado: {{ $sareRequest->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-{{ $sareRequest->status_color }} fs-6 px-3 py-2">
                                    {{ $sareRequest->status_label }}
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">
                                    Actualizado: {{ $sareRequest->updated_at->format('d/m/Y H:i') }}
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
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Número de Solicitud:</small>
                                <p class="mb-0"><strong>{{ $sareRequest->request_num }}</strong></p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Fecha de Solicitud:</small>
                                <p class="mb-0">{{ $sareRequest->request_date }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Número Catastral:</small>
                                <p class="mb-0">{{ $sareRequest->catastral_num }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Tipo de Solicitud:</small>
                                <p class="mb-0">
                                    @switch($sareRequest->request_type)
                                        @case('general')
                                            General
                                            @break
                                        @case('nuevo')
                                            Nuevo
                                            @break
                                        @case('renovacion')
                                            Renovación
                                            @break
                                        @case('anuncio')
                                            Anuncio
                                            @break
                                        @default
                                            {{ $sareRequest->request_type }}
                                    @endswitch
                                </p>
                            </div>
                            
                            @if($sareRequest->description)
                            <div class="col-12 mb-3">
                                <small class="text-muted">Descripción:</small>
                                <p class="mb-0">{{ $sareRequest->description }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Datos del Solicitante -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Datos del Solicitante</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Nombre/Razón Social:</small>
                                <p class="mb-0">{{ $sareRequest->rfc_name }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">RFC:</small>
                                <p class="mb-0">{{ $sareRequest->rfc_num }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Propietario:</small>
                                <p class="mb-0">{{ $sareRequest->property_owner }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Teléfono Oficina:</small>
                                <p class="mb-0">{{ $sareRequest->office_phone }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Teléfono Móvil:</small>
                                <p class="mb-0">{{ $sareRequest->mobile_phone }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Email:</small>
                                <p class="mb-0">{{ $sareRequest->email }}</p>
                            </div>
                        </div>

                        @if($sareRequest->legal_representative_name)
                        <!-- Datos del Representante Legal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Representante Legal</h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Nombre:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_name }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Apellido Paterno:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_father_last_name }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Apellido Materno:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_mother_last_name }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Teléfono Oficina:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_office_phone }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Teléfono Móvil:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_mobile_phone }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Email:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_email }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Responsable del Establecimiento -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Responsable del Establecimiento</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Causa Legal:</small>
                                <p class="mb-0">{{ $sareRequest->establishment_legal_cause }}</p>
                            </div>
                            
                            @if($sareRequest->establishment_legal_cause_addon)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Especificación:</small>
                                <p class="mb-0">{{ $sareRequest->establishment_legal_cause_addon }}</p>
                            </div>
                            @endif
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Cláusula de Buena Fe:</small>
                                <p class="mb-0">{{ $sareRequest->establishment_good_faith_clause }}</p>
                            </div>
                        </div>

                        <!-- Domicilio del Establecimiento -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Domicilio del Establecimiento</h5>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <small class="text-muted">Dirección Completa:</small>
                                <p class="mb-0">
                                    {{ $sareRequest->establishment_address_street }} 
                                    {{ $sareRequest->establishment_address_number }}, 
                                    {{ $sareRequest->establishment_address_neighborhood }}, 
                                    {{ $sareRequest->establishment_address_municipality }}, 
                                    {{ $sareRequest->establishment_address_state }} 
                                    {{ $sareRequest->establishment_address_postal_code }}
                                </p>
                            </div>
                        </div>

                        <!-- Datos del Uso de la Edificación -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Datos del Negocio</h5>
                            </div>
                            
                            @if($sareRequest->establishment_use)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Uso del Establecimiento:</small>
                                <p class="mb-0">{{ $sareRequest->establishment_use }}</p>
                            </div>
                            @endif
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Nombre Comercial:</small>
                                <p class="mb-0">{{ $sareRequest->commercial_name }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Inversión Aproximada:</small>
                                <p class="mb-0">{{ $sareRequest->aprox_investment }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Empleos a Generar:</small>
                                <p class="mb-0">{{ $sareRequest->jobs_to_generate }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">En Operación:</small>
                                <p class="mb-0">{{ $sareRequest->is_location_in_operation ? 'Sí' : 'No' }}</p>
                            </div>
                            
                            @if($sareRequest->operation_start_date)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Inicio:</small>
                                <p class="mb-0">{{ $sareRequest->operation_start_date }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->business_hours)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Horario de Operación:</small>
                                <p class="mb-0">{{ $sareRequest->business_hours }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Zonificación -->
                        @if($sareRequest->zoning_front || $sareRequest->zoning_rear || $sareRequest->zoning_left || $sareRequest->zoning_right)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Zonificación</h5>
                            </div>
                            
                            @if($sareRequest->zoning_front)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Frente:</small>
                                <p class="mb-0">{{ $sareRequest->zoning_front }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->zoning_rear)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fondo:</small>
                                <p class="mb-0">{{ $sareRequest->zoning_rear }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->zoning_left)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Izquierda:</small>
                                <p class="mb-0">{{ $sareRequest->zoning_left }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->zoning_right)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Derecha:</small>
                                <p class="mb-0">{{ $sareRequest->zoning_right }}</p>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Información Municipal -->
                        @if($sareRequest->license_num || $sareRequest->entry_date || $sareRequest->exit_date || $sareRequest->document_type)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Información Municipal</h5>
                            </div>
                            
                            @if($sareRequest->license_num)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Número de Licencia:</small>
                                <p class="mb-0">{{ $sareRequest->license_num }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->document_type)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Tipo de Documento:</small>
                                <p class="mb-0">{{ $sareRequest->document_type }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->entry_date)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Ingreso:</small>
                                <p class="mb-0">{{ $sareRequest->entry_date->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->exit_date)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Resolución:</small>
                                <p class="mb-0">{{ $sareRequest->exit_date->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">VoBo Favorable:</small>
                                <p class="mb-0">{{ $sareRequest->vobo_favorable ? 'Sí' : 'No' }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('sare.request.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Volver al Listado
                                    </a>
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
                        <form method="POST" action="{{ route('sare.request.update', $sareRequest) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Cambiar Estatus:</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="new" {{ $sareRequest->status == 'new' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="initial_review" {{ $sareRequest->status == 'initial_review' ? 'selected' : '' }}>Revisión Inicial</option>
                                    <option value="requirement_validation" {{ $sareRequest->status == 'requirement_validation' ? 'selected' : '' }}>Validación de Requisitos</option>
                                    <option value="requires_correction" {{ $sareRequest->status == 'requires_correction' ? 'selected' : '' }}>Requiere Corrección</option>
                                    <option value="payment_pending" {{ $sareRequest->status == 'payment_pending' ? 'selected' : '' }}>Espera de Pago</option>
                                    <option value="authorization_process" {{ $sareRequest->status == 'authorization_process' ? 'selected' : '' }}>Proceso de Autorización</option>
                                    <option value="authorized" {{ $sareRequest->status == 'authorized' ? 'selected' : '' }}>Autorizada</option>
                                    <option value="rejected" {{ $sareRequest->status == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Actualizar Estatus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Archivos Adjuntos -->
                @if($sareRequest->files->count() > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Archivos Adjuntos ({{ $sareRequest->files->count() }})</h6>
                    </div>
                    <div class="card-body">
                        @foreach($sareRequest->files as $file)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <div class="fw-bold">{{ $file->name }}</div>
                                <small class="text-muted">{{ $file->filename }}</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        @endforeach
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
                            <p class="mb-1">{{ $sareRequest->user->name }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Email:</small>
                            <p class="mb-1">{{ $sareRequest->user->email }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Fecha de Registro:</small>
                            <p class="mb-0">{{ $sareRequest->user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Estilo de impresión
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.innerHTML = `
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
    `;
    document.head.appendChild(style);
});
</script>
@endsection
@endsection
