@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Refrendos de Proveedores @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-file-invoice fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-sync-alt text-primary me-2"></i> Refrendos de Proveedores
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-check me-1"></i>
                                Gestión y validación de refrendos anuales
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
                    <form method="GET" action="{{ route('acquisitions.endorsements.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1"></i> Buscar:
                                </label>
                                <div class="input-group">
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
                            <div class="col-lg-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i> Año:
                                </label>
                                <select name="year" class="form-select">
                                    <option value="">Todos los Años</option>
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-filter me-1"></i> Estado:
                                </label>
                                <select name="status" class="form-select">
                                    <option value="">Todos los Estados</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle"></i> Aprobados
                                    </option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        <i class="fas fa-clock"></i> Pendientes
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i> Filtrar
                                </button>
                            </div>
                        </div>
                        @if(request()->hasAny(['search', 'year', 'status']))
                            <div class="mt-3">
                                <a href="{{ route('acquisitions.endorsements.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Limpiar Filtros
                                </a>
                            </div>
                        @endif
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

                    @if($users->count() == 0)
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-inbox fa-5x text-muted opacity-50"></i>
                            </div>
                            <h4 class="fw-bold mb-3">¡No hay refrendos en la base de datos!</h4>
                            <p class="text-muted mb-4">
                                Los refrendos aparecerán aquí cuando los proveedores los envíen desde el portal.
                            </p>
                        </div>
                    @else
                        <!-- Tabla de usuarios con refrendos -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-white"><i class="fas fa-user me-1"></i> Usuario</th>
                                        <th class="text-white"><i class="fas fa-envelope me-1"></i> Email</th>
                                        <th class="text-center text-white"><i class="fas fa-list-ol me-1"></i> Total Refrendos</th>
                                        <th class="text-center text-white"><i class="fas fa-check-circle me-1"></i> Aprobados</th>
                                        <th class="text-center text-white"><i class="fas fa-clock me-1"></i> Pendientes</th>
                                        <th class="text-white"><i class="fas fa-calendar-check me-1"></i> Último Refrendo</th>
                                        <th class="text-center text-white"><i class="fas fa-cog me-1"></i> Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        @php
                                            $userInfo = $user->userInfo;
                                            $displayName = $user->name;
                                            if($userInfo && isset($userInfo->additional_data['person_type'])) {
                                                if($userInfo->additional_data['person_type'] === 'moral' && !empty($userInfo->additional_data['company_name'])) {
                                                    $displayName = $userInfo->additional_data['company_name'];
                                                }
                                            }
                                            $approvedCount = $user->endorsements->where('is_approved', true)->count();
                                            $pendingCount = $user->endorsements->where('is_approved', false)->count();
                                            $latestEndorsement = $user->endorsements->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $displayName }}</div>
                                                        @if($displayName !== $user->name)
                                                            <small class="text-muted">{{ $user->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    {{ $user->email }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <i class="fas fa-list-ol me-1"></i>
                                                    {{ $user->endorsements_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success bg-opacity-10 text-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    {{ $approvedCount }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $pendingCount }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($latestEndorsement)
                                                    <div class="d-flex align-items-center">
                                                        <i class="far fa-calendar-alt text-muted me-2"></i>
                                                        <span>{{ $latestEndorsement->endorsement_date->format('Y') }}</span>
                                                        @if($latestEndorsement->is_approved)
                                                            <span class="badge bg-success ms-2">
                                                                <i class="fas fa-check me-1"></i> Aprobado
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning ms-2">
                                                                <i class="fas fa-clock me-1"></i> Pendiente
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('acquisitions.endorsements.show', $user->id) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   data-bs-toggle="tooltip"
                                                   title="Ver refrendos y validar">
                                                    <i class="fas fa-eye me-1"></i> Ver Refrendos
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if($users->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Mostrando <strong>{{ $users->firstItem() }}</strong> a <strong>{{ $users->lastItem() }}</strong> de <strong>{{ $users->total() }}</strong> registros
                                </div>
                                <div>
                                    {{ $users->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
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
        background-color: #0d6efd;
        color: white !important;
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

    .card {
        border-radius: 12px;
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
    }

    .form-control, .form-select {
        border-radius: 8px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
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
@endpush
@endsection
