@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Detalle del Contratista @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <!-- Información del contratista -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5>#{{ $contractor->id }} - {{ $contractor->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>RFC:</strong> {{ $contractor->rfc ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $contractor->email ?? 'N/A' }}</p>
                        <p><strong>Teléfono:</strong> {{ $contractor->phone ?? 'N/A' }}</p>
                        <p><strong>Cuenta Bancaria:</strong></p>
                        <ul>
                            <li><strong>Nombre:</strong> {{ $contractor->account_name ?? 'N/A' }}</li>
                            <li><strong>Número:</strong> {{ $contractor->account_number ?? 'N/A' }}</li>
                            <li><strong>Banco:</strong> {{ $contractor->bank_name ?? 'N/A' }}</li>
                        </ul>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Creado: {{ $contractor->created_at }}</small><br>
                        <small>Actualizado: {{ $contractor->updated_at }}</small>
                        <div class="btn-group mt-4" role="group">
                            <a href="{{ route('treasury_account_payable_contractors.edit', $contractor->id) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-edit"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('treasury_account_payable_contractors.destroy', $contractor->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de checklists -->
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Checklists del Contratista</h5>
                        <a href="{{ route('contractor_checklists.create', ['contractor_id' => $contractor->id]) }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus"></i> Crear Nuevo Checklist
                        </a>
                    </div>
                    <div class="card-body">
                        @if($contractor->checklists->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Fecha de Creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contractor->checklists as $checklist)
                                    <tr>
                                        <td>{{ $checklist->id }}</td>
                                        <td>{{ $checklist->name }}</td>
                                        <td>{{ $checklist->description ?? 'N/A' }}</td>
                                        <td>{{ $checklist->created_at }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('contractor_checklists.show', $checklist->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-show-alt"></i> Ver
                                                </a>
                                                <form method="POST" action="{{ route('contractor_checklists.destroy', $checklist->id) }}" style="display: inline-block;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bx bx-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center my-4">
                            <h5>No hay checklists asociados a este contratista.</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection