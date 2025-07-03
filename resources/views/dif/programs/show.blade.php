@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Programa: {{ $program->name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $program->name }}</h5>
                        
                        <div class="mb-3">
                            @if($program->is_active)
                                <span class="badge bg-success">Programa Activo</span>
                            @else
                                <span class="badge bg-danger">Programa Inactivo</span>
                            @endif
                        </div>
                        
                        @if($program->description)
                            <p class="card-text"><strong>Descripción:</strong></p>
                            <p class="card-text">{{ $program->description }}</p>
                        @endif
                        
                        @if($program->full_address)
                            <p class="card-text"><strong>Dirección:</strong></p>
                            <p class="card-text">{{ $program->full_address }}</p>
                        @endif

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.programs.edit', $program->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.programs.destroy', $program->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este programa?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.programs.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información adicional del Programa</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Estado del Programa</h6>
                                <p class="text-muted">
                                    @if($program->is_active)
                                        <i class="fas fa-check-circle text-success"></i> Programa activo y disponible
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i> Programa inactivo
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Información del programa</h6>
                                <p class="text-muted">
                                    @if($program->description)
                                        <i class="fas fa-info-circle text-info"></i> Descripción disponible
                                    @else
                                        <i class="fas fa-exclamation-circle text-warning"></i> Sin descripción
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <h6>Fechas importantes</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $program->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $program->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
