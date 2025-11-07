@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Proveedores CON Padrón @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-8 text-start">
                <h4 class="mb-0">
                    <ion-icon name="checkmark-circle-outline"></ion-icon> Proveedores CON Padrón
                </h4>
                <p class="text-muted">Proveedores con refrendo aprobado del año actual</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <!-- Filtros -->
                        <form method="GET" action="{{ route('acquisitions.suppliers.con_padron') }}" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-8">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Buscar por nombre o email"
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <ion-icon name="search-outline"></ion-icon> Buscar
                                        </button>
                                        <a href="{{ route('acquisitions.suppliers.con_padron') }}" class="btn btn-secondary">
                                            <ion-icon name="close-outline"></ion-icon> Limpiar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <ion-icon name="checkmark-circle-outline"></ion-icon> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Tabla de proveedores -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Altas Registradas</th>
                                        <th>Refrendos</th>
                                        <th>Fecha de Registro</th>
                                        <th class="text-center">Acciones</th>
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
                                                <strong>{{ $displayName }}</strong>
                                                @if($displayName !== $supplier->name)
                                                    <br><small class="text-muted">{{ $supplier->name }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $supplier->suppliers->count() }} alta(s)</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $supplier->endorsements->count() }} refrendo(s)</span>
                                            </td>
                                            <td>{{ $supplier->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                @if($supplier->suppliers->count() > 0)
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                                type="button" 
                                                                data-bs-toggle="dropdown">
                                                            <ion-icon name="eye-outline"></ion-icon> Ver Altas
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @foreach($supplier->suppliers as $alta)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('acquisitions.suppliers.show', $alta->id) }}">
                                                                        {{ $alta->registration_number }} - 
                                                                        @switch($alta->status)
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
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Sin altas</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <ion-icon name="information-circle-outline" style="font-size: 48px; color: #999;"></ion-icon>
                                                <p class="text-muted mt-3 mb-0">No hay proveedores con padrón registrados</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if($suppliers->hasPages())
                            <div class="mt-4">
                                {{ $suppliers->links('pagination::bootstrap-5') }}
                            </div>
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

    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    .badge {
        font-size: 0.75em;
    }
</style>
@endsection
@endsection
