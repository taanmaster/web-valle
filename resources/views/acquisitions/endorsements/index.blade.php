@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Refrendos de Proveedores @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-8 text-start">
                <h4 class="mb-0">
                    <ion-icon name="receipt-outline"></ion-icon> Refrendos de Proveedores
                </h4>
                <p class="text-muted">Gestión y validación de refrendos anuales</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <!-- Filtros -->
                        <form method="GET" action="{{ route('acquisitions.endorsements.index') }}" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Buscar:</label>
                                    <input type="text"
                                           name="search"
                                           class="form-control"
                                           placeholder="Buscar por nombre o email"
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Año:</label>
                                    <select name="year" class="form-select">
                                        <option value="">Todos los Años</option>
                                        @foreach($availableYears as $year)
                                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Estado:</label>
                                    <select name="status" class="form-select">
                                        <option value="">Todos los Estados</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprobados</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <ion-icon name="search-outline"></ion-icon> Filtrar
                                    </button>
                                </div>
                            </div>
                            @if(request()->hasAny(['search', 'year', 'status']))
                                <div class="mt-2">
                                    <a href="{{ route('acquisitions.endorsements.index') }}" class="btn btn-sm btn-secondary">
                                        <ion-icon name="close-outline"></ion-icon> Limpiar Filtros
                                    </a>
                                </div>
                            @endif
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <ion-icon name="checkmark-circle-outline"></ion-icon> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($users->count() == 0)
                            <div class="text-center" style="padding:80px 0px 100px 0px;">
                                <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                                <h4>¡No hay refrendos en la base de datos!</h4>
                                <p class="mb-4">Los refrendos aparecerán aquí cuando los proveedores los envíen desde el portal.</p>
                            </div>
                        @else
                            <!-- Tabla de usuarios con refrendos -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th class="text-center">Total Refrendos</th>
                                            <th class="text-center">Aprobados</th>
                                            <th class="text-center">Pendientes</th>
                                            <th>Último Refrendo</th>
                                            <th class="text-center">Acciones</th>
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
                                                    <strong>{{ $displayName }}</strong>
                                                    @if($displayName !== $user->name)
                                                        <br><small class="text-muted">{{ $user->name }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary">{{ $user->endorsements_count }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-success">{{ $approvedCount }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-warning">{{ $pendingCount }}</span>
                                                </td>
                                                <td>
                                                    @if($latestEndorsement)
                                                        {{ $latestEndorsement->endorsement_date->format('Y') }}
                                                        @if($latestEndorsement->is_approved)
                                                            <span class="badge bg-success">
                                                                <ion-icon name="checkmark-outline"></ion-icon> Aprobado
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">Pendiente</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('acquisitions.endorsements.show', $user->id) }}" 
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Ver refrendos y validar">
                                                        <ion-icon name="eye-outline"></ion-icon> Ver Refrendos
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($users->hasPages())
                                <div class="mt-4">
                                    {{ $users->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<style>
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

    .table-striped > tbody > tr:nth-of-type(odd) > td {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .badge {
        font-size: 0.75em;
    }
</style>
@endsection
@endsection    
    </div>
</div>

@section('scripts')
<style>
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

    .table-striped > tbody > tr:nth-of-type(odd) > td {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .dropdown-menu {
        box-shadow: 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    .badge {
        font-size: 0.75em;
    }

    .progress {
        height: 20px;
        min-width: 100px;
    }
</style>
@endsection
