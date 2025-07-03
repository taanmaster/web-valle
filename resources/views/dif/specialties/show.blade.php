@extends('layouts.master')

@section('title')Ver Especialidad @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.specialties.index') }}">Especialidades</a> @endslot
        @slot('title') Ver Especialidad @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-eye"></i> Ver Especialidad
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.specialties.edit', $specialty->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                            <a href="{{ route('dif.specialties.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $specialty->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre:</th>
                                    <td>{{ $specialty->name }}</td>
                                </tr>
                                <tr>
                                    <th>Descripción:</th>
                                    <td>{{ $specialty->description ?: 'Sin descripción' }}</td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        @if($specialty->is_active)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha de Creación:</th>
                                    <td>{{ $specialty->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Última Actualización:</th>
                                    <td>{{ $specialty->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dif.specialties.utilities._modal')
@endsection

@section('script')

@endsection
