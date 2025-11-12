@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Detalle de Refrendos @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-sm bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-file-invoice fa-lg text-primary"></i>
                </div>
                <div>
                    @php
                        $userInfo = $user->userInfo;
                        $displayName = $user->name;
                        if($userInfo && isset($userInfo->additional_data['person_type'])) {
                            if($userInfo->additional_data['person_type'] === 'moral' && !empty($userInfo->additional_data['company_name'])) {
                                $displayName = $userInfo->additional_data['company_name'];
                            }
                        }
                    @endphp
                    <h4 class="mb-1 fw-bold">{{ $displayName }}</h4>
                    <div class="text-muted">
                        <i class="fas fa-envelope me-1"></i> {{ $user->email }}
                        <span class="mx-2">|</span>
                        <i class="fas fa-list-ol me-1"></i> 
                        <strong>{{ $user->endorsements->count() }}</strong> Refrendos
                    </div>
                </div>
            </div>
            <div class="page-title-right">
                <a href="{{ route('acquisitions.endorsements.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg me-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Información del proveedor -->
        @if($user->suppliers->count() > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-store me-2"></i> Altas de Proveedor Asociadas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-white"><i class="fas fa-hashtag me-1"></i> Folio</th>
                                    <th class="text-white"><i class="fas fa-user-tag me-1"></i> Tipo</th>
                                    <th class="text-white"><i class="fas fa-info-circle me-1"></i> Estado</th>
                                    <th class="text-white"><i class="fas fa-calendar me-1"></i> Fecha</th>
                                    <th class="text-center text-white"><i class="fas fa-cog me-1"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->suppliers as $supplier)
                                    <tr>
                                        <td>
                                            <span class="badge bg-dark">
                                                <i class="fas fa-file-alt me-1"></i>
                                                {{ $supplier->registration_number }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($supplier->person_type == 'fisica')
                                                <span class="badge bg-info bg-opacity-10 text-info">
                                                    <i class="fas fa-user me-1"></i> Persona Física
                                                </span>
                                            @else
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <i class="fas fa-building me-1"></i> Persona Moral
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($supplier->status)
                                                @case('solicitud')
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-file me-1"></i> Solicitud
                                                    </span>
                                                    @break
                                                @case('validacion')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-spinner me-1"></i> Validación
                                                    </span>
                                                    @break
                                                @case('aprobacion')
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-clipboard-check me-1"></i> Aprobación
                                                    </span>
                                                    @break
                                                @case('pago_pendiente')
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-credit-card me-1"></i> Pago Pendiente
                                                    </span>
                                                    @break
                                                @case('padron_activo')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i> Padrón Activo
                                                    </span>
                                                    @break
                                                @case('rechazado')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i> Rechazado
                                                    </span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <i class="far fa-calendar-alt text-muted me-1"></i>
                                            {{ $supplier->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('acquisitions.suppliers.show', $supplier->id) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               data-bs-toggle="tooltip"
                                               title="Ver detalles del proveedor">
                                                <i class="fas fa-eye me-1"></i> Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


        <!-- Refrendos agrupados por año -->
        @if($endorsementsByYear->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-calendar-alt me-2"></i> Refrendos por Año
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="accordion accordion-flush" id="endorsementsAccordion">
                        @foreach($endorsementsByYear as $year => $endorsements)
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header" id="heading{{ $year }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fw-semibold" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $year }}" 
                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                            style="background-color: {{ $loop->first ? 'rgba(111, 66, 193, 0.05)' : 'transparent' }};">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-calendar-check text-primary"></i>
                                            <span>Año {{ $year }}</span>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                <i class="fas fa-list-ol me-1"></i>
                                                {{ $endorsements->count() }} refrendo(s)
                                            </span>
                                            @php
                                                $approvedThisYear = $endorsements->where('is_approved', true)->count();
                                            @endphp
                                            @if($approvedThisYear > 0)
                                                <span class="badge bg-success bg-opacity-10 text-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    {{ $approvedThisYear }} aprobado(s)
                                                </span>
                                            @endif
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $year }}" 
                                     class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                     aria-labelledby="heading{{ $year }}" 
                                     data-bs-parent="#endorsementsAccordion">
                                    <div class="accordion-body p-3">
                                        @foreach($endorsements as $endorsement)
                                            <div class="card mb-3 shadow-sm border">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4 border-end">
                                                            <h6 class="fw-bold mb-3 text-primary">
                                                                <i class="fas fa-info-circle me-2"></i>Información del Refrendo
                                                            </h6>
                                                            <div class="mb-2">
                                                                <small class="text-muted d-block">
                                                                    <i class="far fa-calendar me-1"></i> Año
                                                                </small>
                                                                <span class="badge bg-dark">{{ $endorsement->year }}</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <small class="text-muted d-block">
                                                                    <i class="far fa-clock me-1"></i> Fecha de Registro
                                                                </small>
                                                                <span>{{ $endorsement->created_at->format('d/m/Y H:i') }}</span>
                                                            </div>
                                                            <div class="mb-0">
                                                                <small class="text-muted d-block mb-1">
                                                                    <i class="fas fa-flag me-1"></i> Estado
                                                                </small>
                                                                @if($endorsement->is_approved)
                                                                    <span class="badge bg-success">
                                                                        <i class="fas fa-check-circle me-1"></i> Aprobado
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-warning">
                                                                        <i class="fas fa-clock me-1"></i> Pendiente
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            @if($endorsement->supplier)
                                                                <div class="mb-2 mt-3 pt-3 border-top">
                                                                    <small class="text-muted d-block mb-1">
                                                                        <i class="fas fa-link me-1"></i> Alta Asociada
                                                                    </small>
                                                                    <a href="{{ route('acquisitions.suppliers.show', $endorsement->supplier_id) }}" 
                                                                       class="btn btn-sm btn-outline-info">
                                                                        <i class="fas fa-external-link-alt me-1"></i>
                                                                        {{ $endorsement->supplier->registration_number }}
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <div class="mb-2 mt-3 pt-3 border-top">
                                                                    <small class="text-muted d-block mb-1">
                                                                        <i class="fas fa-link me-1"></i> Alta Asociada
                                                                    </small>
                                                                    <span class="badge bg-secondary">
                                                                        <i class="fas fa-unlink me-1"></i> Sin Asociar
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            <div class="mt-3 pt-3 border-top">
                                                                <a href="{{ $endorsement->s3_url }}" 
                                                                   target="_blank" 
                                                                   class="btn btn-sm btn-outline-primary w-100">
                                                                    <i class="fas fa-file-download me-2"></i> Ver Comprobante de Pago
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h6 class="fw-bold mb-3 text-success">
                                                                <i class="fas fa-clipboard-check me-2"></i>Validación del Refrendo
                                                            </h6>
                                                            
                                                            <!-- Formulario de aprobación -->
                                                            <form action="{{ route('acquisitions.endorsements.updateStatus', $endorsement->id) }}" 
                                                                  method="POST"
                                                                  class="mb-3">
                                                                @csrf
                                                                <div class="row g-3">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label fw-semibold">
                                                                            <i class="fas fa-flag me-1"></i> Estado:
                                                                        </label>
                                                                        <select name="is_approved" 
                                                                                class="form-select"
                                                                                {{ $endorsement->is_approved ? 'disabled' : '' }}>
                                                                            <option value="0" {{ !$endorsement->is_approved ? 'selected' : '' }}>
                                                                                <i class="fas fa-clock"></i> Pendiente
                                                                            </option>
                                                                            <option value="1" {{ $endorsement->is_approved ? 'selected' : '' }}>
                                                                                <i class="fas fa-check"></i> Aprobado
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-semibold">
                                                                            <i class="fas fa-comment-dots me-1"></i> Comentarios:
                                                                        </label>
                                                                        <input type="text" 
                                                                               name="comments" 
                                                                               class="form-control" 
                                                                               value="{{ $endorsement->comments }}"
                                                                               placeholder="Agregar comentarios..."
                                                                               {{ $endorsement->is_approved ? 'readonly disabled' : '' }}>
                                                                    </div>
                                                                    <div class="col-md-2 d-flex align-items-end">
                                                                        @if(!$endorsement->is_approved)
                                                                            <button type="submit" class="btn btn-success w-100">
                                                                                <i class="fas fa-check-circle me-1"></i> Validar
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="btn btn-secondary w-100" disabled>
                                                                                <i class="fas fa-lock me-1"></i> Aprobado
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </form>

                                                            @if($endorsement->approved_by)
                                                                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-0">
                                                                    <i class="fas fa-info-circle fa-lg me-3"></i>
                                                                    <div>
                                                                        <strong>Aprobado por:</strong> Usuario #{{ $endorsement->approved_by }} 
                                                                        el {{ $endorsement->approved_at->format('d/m/Y H:i') }}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <!-- Asociar a proveedor -->
                                                            @if(!$endorsement->supplier_id && $user->suppliers->count() > 0)
                                                                <div class="mt-4 pt-3 border-top">
                                                                    <h6 class="fw-bold mb-3">
                                                                        <i class="fas fa-link me-2 text-info"></i>Asociar con Alta de Proveedor
                                                                    </h6>
                                                                    <form action="{{ route('acquisitions.endorsements.associate', $endorsement->id) }}" 
                                                                          method="POST" 
                                                                          class="d-flex gap-2 align-items-end">
                                                                        @csrf
                                                                        <div class="flex-grow-1">
                                                                            <label class="form-label fw-semibold small">
                                                                                <i class="fas fa-store me-1"></i> Seleccionar Alta
                                                                            </label>
                                                                            <select name="supplier_id" class="form-select">
                                                                                <option value="">-- Seleccione un Alta --</option>
                                                                                @foreach($user->suppliers as $supplier)
                                                                                    <option value="{{ $supplier->id }}">
                                                                                        {{ $supplier->registration_number }} - 
                                                                                        @if($supplier->person_type == 'fisica')
                                                                                            <i class="fas fa-user"></i> Física
                                                                                        @else
                                                                                            <i class="fas fa-building"></i> Moral
                                                                                        @endif
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="fas fa-link me-1"></i> Asociar
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-inbox fa-5x text-muted opacity-50"></i>
                    </div>
                    <h4 class="fw-bold mb-3">No hay refrendos registrados</h4>
                    <p class="text-muted mb-0">Este usuario aún no ha registrado ningún refrendo en el sistema.</p>
                </div>
            </div>
        @endif
    </div>
</div>
</div>

@section('scripts')
<style>
    /* Estilos personalizados */
    .accordion-button {
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, rgba(111, 66, 193, 0.1) 0%, rgba(90, 50, 163, 0.05) 100%) !important;
        color: #6f42c1;
        box-shadow: 0 2px 4px rgba(111, 66, 193, 0.1);
    }

    .accordion-button:hover {
        background-color: rgba(111, 66, 193, 0.05);
    }

    .accordion-item {
        border: 1px solid rgba(0,0,0,.125);
        border-radius: 8px !important;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    .table-dark th {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white !important;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        border: none;
        padding: 1rem 0.75rem;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .badge {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .form-control, .form-select {
        border-radius: 8px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .form-control:disabled, .form-select:disabled {
        background-color: #f8f9fa;
        opacity: 0.7;
    }

    .page-title-box {
        padding: 1.5rem 0;
    }

    .avatar-sm {
        width: 48px;
        height: 48px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table {
            font-size: 0.8rem;
        }
        
        .table td, .table th {
            padding: 0.5rem 0.25rem;
        }
    }
</style>

<script>
    // Inicializar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
@endsection
