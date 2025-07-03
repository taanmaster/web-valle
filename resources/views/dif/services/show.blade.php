@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Servicio: {{ $service->name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        
                        <div class="mb-3">
                            @if($service->is_active)
                                <span class="badge bg-success">Servicio Activo</span>
                            @else
                                <span class="badge bg-danger">Servicio Inactivo</span>
                            @endif
                        </div>
                        
                        @if($service->description)
                            <p class="card-text"><strong>Descripción:</strong></p>
                            <p class="card-text">{{ $service->description }}</p>
                        @endif

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.services.edit', $service->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.services.destroy', $service->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este servicio?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.services.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información adicional del Servicio</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Estado del Servicio</h6>
                                <p class="text-muted">
                                    @if($service->is_active)
                                        <i class="fas fa-check-circle text-success"></i> Servicio activo y disponible
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i> Servicio inactivo
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Información del servicio</h6>
                                <p class="text-muted">
                                    @if($service->description)
                                        <i class="fas fa-info-circle text-info"></i> Descripción disponible
                                    @else
                                        <i class="fas fa-exclamation-circle text-warning"></i> Sin descripción
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Características del servicio</h6>
                                <p class="text-muted">
                                    <strong>Nombre:</strong> {{ $service->name }}<br>
                                    <strong>Estado:</strong> {{ $service->is_active ? 'Disponible' : 'No disponible' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Fechas importantes</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $service->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $service->updated_at->format('d/m/Y H:i') }}
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
