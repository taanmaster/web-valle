@extends('layouts.master')

@section('title')Ver Coordinación @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.coordinations.index') }}">Coordinaciones</a> @endslot
        @slot('title') Ver Coordinación @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-eye"></i> Ver Coordinación
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.coordinations.edit', $coordination->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                            <a href="{{ route('dif.coordinations.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-info-circle"></i> Información General</h5>
                            <table class="table table-striped">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $coordination->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre:</th>
                                    <td>{{ $coordination->name }}</td>
                                </tr>
                                <tr>
                                    <th>Descripción:</th>
                                    <td>{{ $coordination->description ?: 'Sin descripción' }}</td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        @if($coordination->is_active)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha de Creación:</th>
                                    <td>{{ $coordination->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Última Actualización:</th>
                                    <td>{{ $coordination->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5><i class="fas fa-folder"></i> Programas Asociados 
                                <span class="badge bg-primary">{{ $coordination->programs->count() }}</span>
                            </h5>
                            
                            @if($coordination->programs->count() > 0)
                                <div class="programs-list" style="max-height: 400px; overflow-y: auto;">
                                    @foreach($coordination->programs as $program)
                                        <div class="card mb-2">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="card-title mb-1">
                                                            <i class="fas fa-folder-open text-primary"></i> 
                                                            {{ $program->name }}
                                                        </h6>
                                                        @if($program->description)
                                                            <p class="card-text text-muted mb-1">
                                                                <small>{{ Str::limit($program->description, 100) }}</small>
                                                            </p>
                                                        @endif
                                                        @if($program->full_address)
                                                            <p class="card-text mb-1">
                                                                <small class="text-info">
                                                                    <i class="fas fa-map-marker-alt"></i> {{ $program->full_address }}
                                                                </small>
                                                            </p>
                                                        @endif
                                                        <div>
                                                            @if($program->is_active)
                                                                <span class="badge bg-success">Activo</span>
                                                            @else
                                                                <span class="badge bg-danger">Inactivo</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('dif.programs.show', $program->id) }}" 
                                                           class="btn btn-sm btn-outline-primary" title="Ver programa">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No hay programas asociados a esta coordinación.
                                    <br>
                                    <a href="{{ route('dif.coordinations.edit', $coordination->id) }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-plus"></i> Asociar Programas
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dif.coordinations.utilities._modal')
@endsection

@section('script')

@endsection
