@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Proveedores SIN Padrón @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-clipboard-list text-danger me-2"></i> Proveedores SIN Padrón
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar-times me-1"></i>
                                Proveedores sin refrendo aprobado del año actual
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('acquisitions.suppliers.sin_padron') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-8">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1"></i> Buscar Proveedor
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="search" 
                                           class="form-control border-start-0" 
                                           placeholder="Buscar por nombre o email..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                        <i class="fas fa-search me-2"></i> Buscar
                                    </button>
                                    <a href="{{ route('acquisitions.suppliers.sin_padron') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-lg me-3"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Tabla de proveedores -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-white"><i class="fas fa-user me-1"></i> Nombre</th>
                                    <th class="text-white"><i class="fas fa-envelope me-1"></i> Email</th>
                                    <th class="text-center text-white"><i class="fas fa-list me-1"></i> Altas Registradas</th>
                                    <th class="text-center text-white"><i class="fas fa-sync-alt me-1"></i> Refrendos</th>
                                    <th class="text-white"><i class="fas fa-calendar me-1"></i> Fecha de Registro</th>
                                    <th class="text-center text-white"><i class="fas fa-cog me-1"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suppliers as $supplier)
                                    @php
                                        $userInfo = $supplier->userInfo;
                                        $displayName = $supplier->name;
                                        if($userInfo && isset($userInfo->additional_data['person_type'])) {
                                            if($userInfo->additional_data['person_type'] === 'moral' && !empty($userInfo->additional_data['company_name'])) {
                                                $displayName = $userInfo->additional_data['company_name'];
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="fas fa-user-clock text-warning"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $displayName }}</div>
                                                    @if($displayName !== $supplier->name)
                                                        <small class="text-muted">{{ $supplier->name }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-muted">
                                                <i class="fas fa-envelope me-1"></i>
                                                {{ $supplier->email }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                <i class="fas fa-file-alt me-1"></i>
                                                {{ $supplier->suppliers->count() }} alta(s)
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $supplier->endorsements->count() }} refrendo(s)
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ $supplier->created_at->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($supplier->suppliers->count() > 0)
                                                <div class="btn-group" role="group">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        <i class="fas fa-eye me-1"></i> Ver Altas
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                                        @foreach($supplier->suppliers as $alta)
                                                            <li>
                                                                <a class="dropdown-item d-flex justify-content-between align-items-center" 
                                                                   href="{{ route('acquisitions.suppliers.show', $alta->id) }}">
                                                                    <span>
                                                                        <i class="fas fa-file-contract text-primary me-2"></i>
                                                                        {{ $alta->registration_number }}
                                                                    </span>
                                                                    @switch($alta->status)
                                                                        @case('solicitud')
                                                                            <span class="badge bg-secondary ms-2">Solicitud</span>
                                                                            @break
                                                                        @case('validacion')
                                                                            <span class="badge bg-warning ms-2">Validación</span>
                                                                            @break
                                                                        @case('aprobacion')
                                                                            <span class="badge bg-info ms-2">Aprobación</span>
                                                                            @break
                                                                        @case('pago_pendiente')
                                                                            <span class="badge bg-primary ms-2">Pago Pendiente</span>
                                                                            @break
                                                                        @case('padron_activo')
                                                                            <span class="badge bg-success ms-2">Padrón Activo</span>
                                                                            @break
                                                                        @case('rechazado')
                                                                            <span class="badge bg-danger ms-2">Rechazado</span>
                                                                            @break
                                                                    @endswitch
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus-circle me-1"></i> Sin altas
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="fas fa-inbox fa-4x text-muted opacity-50 mb-3"></i>
                                                <p class="text-muted mb-0">No hay proveedores sin padrón registrados</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($suppliers->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Mostrando <strong>{{ $suppliers->firstItem() }}</strong> a <strong>{{ $suppliers->lastItem() }}</strong> de <strong>{{ $suppliers->total() }}</strong> registros
                            </div>
                            <div>
                                {{ $suppliers->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    /* Estilos personalizados */
    .table {
        font-size: 0.9rem;
    }
    
    .table-dark th {
        background-color: #dc3545;
        color: white;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        border: none;
        padding: 1rem 0.75rem;
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

    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        min-width: 280px;
    }
    
    .dropdown-item {
        padding: 0.75rem 1.25rem;
    }

    .card {
        border-radius: 12px;
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
    }

    .form-control {
        border-radius: 0 8px 8px 0;
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
@endpush
@endsection
