@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Fiscalización @endslot
@slot('title') Personal de Fiscalización @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-8 text-start">
                <h4 class="mb-0">Personal de Fiscalización</h4>
                <p class="text-muted">Gestión del directorio de personal de Fiscalización</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('fiscalizacion.workers.create') }}" class="btn btn-success">
                    <i class='fas fa-plus-circle me-2'></i> Agregar Personal
                </a>
            </div>
        </div>

        @if($workers->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <div class="mb-4">
                                <i class="fas fa-user-shield" style="font-size: 120px; color: #6c757d; opacity: 0.3;"></i>
                            </div>
                            <h4>¡No hay personal registrado!</h4>
                            <p class="text-muted mb-4">Empieza a crear el directorio de personal de Fiscalización.</p>
                            <a href="{{ route('fiscalizacion.workers.create') }}" class="btn btn-success">
                                <i class='fas fa-plus-circle me-2'></i> Agregar Personal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Foto</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th style="width: 140px;">No. Empleado</th>
                                        <th>Puesto/Cargo</th>
                                        <th style="width: 200px;">Contacto</th>
                                        <th style="width: 180px;">Vigencia</th>
                                        <th style="width: 140px;" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workers as $worker)
                                    <tr>
                                        <td class="text-center">
                                            @if($worker->s3_asset_url)
                                                <img src="{{ $worker->s3_asset_url }}" alt="{{ $worker->full_name }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #dee2e6;">
                                            @else
                                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width: 45px; height: 45px; font-weight: 600; font-size: 16px;">
                                                    {{ strtoupper(substr($worker->name, 0, 1)) }}{{ strtoupper(substr($worker->last_name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $worker->name }}</strong>
                                        </td>
                                        <td>{{ $worker->last_name }}</td>
                                        <td class="text-center">
                                            @if($worker->employee_number)
                                                <span class="badge bg-secondary">{{ $worker->employee_number }}</span>
                                            @else
                                                <small class="text-muted">Sin asignar</small>
                                            @endif
                                        </td>
                                        <td>{{ $worker->position }}</td>
                                        <td>
                                            @if($worker->email || $worker->phone || $worker->extension)
                                                @if($worker->email)
                                                    <small class="d-block text-muted">
                                                        <i class="fas fa-envelope me-1"></i>
                                                        <a href="mailto:{{ $worker->email }}" class="text-decoration-none">{{ $worker->email }}</a>
                                                    </small>
                                                @endif
                                                @if($worker->phone)
                                                    <small class="d-block text-muted">
                                                        <i class="fas fa-phone me-1"></i>
                                                        <a href="tel:{{ $worker->phone }}" class="text-decoration-none">{{ $worker->phone }}</a>
                                                        @if($worker->extension)
                                                            <span class="badge bg-light text-dark ms-1">Ext. {{ $worker->extension }}</span>
                                                        @endif
                                                    </small>
                                                @elseif($worker->extension)
                                                    <small class="d-block text-muted">
                                                        <i class="fas fa-phone me-1"></i>
                                                        <span class="badge bg-light text-dark">Ext. {{ $worker->extension }}</span>
                                                    </small>
                                                @endif
                                            @else
                                                <small class="text-muted">Sin información</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($worker->validity_date_end)
                                                @php
                                                    $now = \Carbon\Carbon::now();
                                                    $isExpired = $worker->validity_date_end < $now;
                                                @endphp
                                                @if($worker->validity_date_start)
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $worker->validity_date_start->format('d/m/Y') }}
                                                </small>
                                                @endif
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar-times me-1"></i>
                                                    {{ $worker->validity_date_end->format('d/m/Y') }}
                                                </small>
                                                @if($isExpired)
                                                    <span class="badge bg-danger mt-1">Vencida</span>
                                                @else
                                                    <span class="badge bg-success mt-1">Vigente</span>
                                                @endif
                                            @elseif($worker->validity_date_start)
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar-check me-1"></i>
                                                    Desde: {{ $worker->validity_date_start->format('d/m/Y') }}
                                                </small>
                                                <span class="badge bg-success mt-1">Vigente</span>
                                            @else
                                                <small class="text-muted">Sin información</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('fiscalizacion.workers.edit', $worker->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $worker->id }})" title="Eliminar">
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                            </div>
                                            <form id="delete-form-{{ $worker->id }}" action="{{ route('fiscalizacion.workers.destroy', $worker->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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

        <div class="align-items-center mt-4">
            {{ $workers->links('pagination::bootstrap-5') }}
        </div>
        @endif
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

    .btn-group .btn {
        padding: 0.375rem 0.75rem;
    }
</style>
<script>
    function confirmDelete(workerId) {
        if (confirm('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.')) {
            document.getElementById('delete-form-' + workerId).submit();
        }
    }
</script>
@endsection
@endsection
