@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Detalle de Refrendos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <!-- Header -->
        <div class="row align-items-center mb-4">
            <div class="col-md-8 text-start">
                @php
                    $userInfo = $user->userInfo;
                    $displayName = $user->name;
                    if($userInfo && isset($userInfo->additional_data['person_type'])) {
                        if($userInfo->additional_data['person_type'] === 'moral' && !empty($userInfo->additional_data['company_name'])) {
                            $displayName = $userInfo->additional_data['company_name'];
                        }
                    }
                @endphp
                <h4 class="mb-1">
                    <ion-icon name="receipt-outline"></ion-icon> Refrendos de: {{ $displayName }}
                </h4>
                <p class="text-muted mb-0">
                    <strong>Email:</strong> {{ $user->email }} | 
                    <strong>Total Refrendos:</strong> {{ $user->endorsements->count() }}
                </p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('acquisitions.endorsements.index') }}" class="btn btn-secondary btn-sm">
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

        <!-- Información del proveedor -->
        @if($user->suppliers->count() > 0)
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-header bg-info">
                            <h5 class="mb-0 text-white"><ion-icon name="person-outline"></ion-icon> Altas de Proveedor Asociadas</h5>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->suppliers as $supplier)
                                            <tr>
                                                <td><strong>{{ $supplier->registration_number }}</strong></td>
                                                <td>
                                                    @if($supplier->person_type == 'fisica')
                                                        Persona Física
                                                    @else
                                                        Persona Moral
                                                    @endif
                                                </td>
                                                <td>
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
                                                </td>
                                                <td>{{ $supplier->created_at->format('d/m/Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('acquisitions.suppliers.show', $supplier->id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <ion-icon name="eye-outline"></ion-icon> Ver
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <!-- Refrendos agrupados por año -->
        @if($endorsementsByYear->count() > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="accordion" id="endorsementsAccordion">
                        @foreach($endorsementsByYear as $year => $endorsements)
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="heading{{ $year }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $year }}" 
                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                        <strong>Año {{ $year }}</strong>
                                        <span class="badge bg-primary ms-2">{{ $endorsements->count() }} refrendo(s)</span>
                                        @php
                                            $approvedThisYear = $endorsements->where('is_approved', true)->count();
                                        @endphp
                                        @if($approvedThisYear > 0)
                                            <span class="badge bg-success ms-2">{{ $approvedThisYear }} aprobado(s)</span>
                                        @endif
                                    </button>
                                </h2>
                                <div id="collapse{{ $year }}" 
                                     class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                     aria-labelledby="heading{{ $year }}" 
                                     data-bs-parent="#endorsementsAccordion">
                                    <div class="accordion-body">
                                        @foreach($endorsements as $endorsement)
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h6>Información del Refrendo</h6>
                                                            <p class="mb-1">
                                                                <strong>Año:</strong> {{ $endorsement->year }}
                                                            </p>
                                                            <p class="mb-1">
                                                                <strong>Fecha de Registro:</strong> {{ $endorsement->created_at->format('d/m/Y H:i') }}
                                                            </p>
                                                            <p class="mb-1">
                                                                <strong>Estado:</strong> 
                                                                @if($endorsement->is_approved)
                                                                    <span class="badge bg-success">
                                                                        <ion-icon name="checkmark-outline"></ion-icon> Aprobado
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-warning">Pendiente</span>
                                                                @endif
                                                            </p>
                                                            @if($endorsement->supplier)
                                                                <p class="mb-1">
                                                                    <strong>Alta Asociada:</strong> 
                                                                    <a href="{{ route('acquisitions.suppliers.show', $endorsement->supplier_id) }}">
                                                                        {{ $endorsement->supplier->registration_number }}
                                                                    </a>
                                                                </p>
                                                            @else
                                                                <p class="mb-1">
                                                                    <strong>Alta Asociada:</strong> 
                                                                    <span class="badge bg-secondary">Sin Asociar</span>
                                                                </p>
                                                            @endif
                                                            <div class="mt-3">
                                                                <a href="{{ $endorsement->s3_url }}" 
                                                                   target="_blank" 
                                                                   class="btn btn-sm btn-outline-primary">
                                                                    <ion-icon name="download-outline"></ion-icon> Ver Comprobante
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h6>Validación</h6>
                                                            
                                                            <!-- Formulario de aprobación -->
                                                            <form action="{{ route('acquisitions.endorsements.updateStatus', $endorsement->id) }}" 
                                                                  method="POST"
                                                                  class="mb-3">
                                                                @csrf
                                                                <div class="row g-2">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Estado:</label>
                                                                        <select name="is_approved" 
                                                                                class="form-select form-select-sm"
                                                                                {{ $endorsement->is_approved ? 'disabled' : '' }}>
                                                                            <option value="0" {{ !$endorsement->is_approved ? 'selected' : '' }}>
                                                                                Pendiente
                                                                            </option>
                                                                            <option value="1" {{ $endorsement->is_approved ? 'selected' : '' }}>
                                                                                Aprobado
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Comentarios:</label>
                                                                        <input type="text" 
                                                                               name="comments" 
                                                                               class="form-control form-control-sm" 
                                                                               value="{{ $endorsement->comments }}"
                                                                               placeholder="Agregar comentarios..."
                                                                               {{ $endorsement->is_approved ? 'readonly' : '' }}>
                                                                    </div>
                                                                    <div class="col-md-2 d-flex align-items-end">
                                                                        @if(!$endorsement->is_approved)
                                                                            <button type="submit" class="btn btn-sm btn-success w-100">
                                                                                <ion-icon name="checkmark-outline"></ion-icon> Validar
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="btn btn-sm btn-secondary w-100" disabled>
                                                                                <ion-icon name="lock-closed-outline"></ion-icon> Aprobado
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </form>

                                                            @if($endorsement->approved_by)
                                                                <div class="alert alert-info mb-0">
                                                                    <ion-icon name="information-circle-outline"></ion-icon>
                                                                    <strong>Aprobado por:</strong> Usuario #{{ $endorsement->approved_by }} 
                                                                    el {{ $endorsement->approved_at->format('d/m/Y H:i') }}
                                                                </div>
                                                            @endif

                                                            <!-- Asociar a proveedor -->
                                                            @if(!$endorsement->supplier_id && $user->suppliers->count() > 0)
                                                                <div class="mt-3">
                                                                    <form action="{{ route('acquisitions.endorsements.associate', $endorsement->id) }}" 
                                                                          method="POST" 
                                                                          class="d-flex gap-2">
                                                                        @csrf
                                                                        <select name="supplier_id" class="form-select form-select-sm">
                                                                            <option value="">-- Asociar a un Alta --</option>
                                                                            @foreach($user->suppliers as $supplier)
                                                                                <option value="{{ $supplier->id }}">
                                                                                    {{ $supplier->registration_number }} - {{ $supplier->person_type == 'fisica' ? 'Física' : 'Moral' }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                                            <ion-icon name="link-outline"></ion-icon> Asociar
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-body text-center py-5">
                            <ion-icon name="information-circle-outline" style="font-size: 64px; color: #999;"></ion-icon>
                            <h5 class="mt-3">No hay refrendos registrados</h5>
                            <p class="text-muted">Este usuario aún no ha registrado ningún refrendo.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<style>
    .accordion-button {
        font-weight: 600;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: #e7f1ff;
        color: #0d6efd;
    }
    
    .box-header h5 {
        margin: 0;
    }
    
    .table th {
        background-color: #495057;
        color: white;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        font-size: 0.875rem;
    }

    .table td {
        vertical-align: middle;
        font-size: 0.875rem;
    }
</style>
@endsection
@endsection
