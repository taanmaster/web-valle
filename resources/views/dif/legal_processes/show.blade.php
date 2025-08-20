@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Caso: {{ $process->case_num }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Expediente: {{ $process->case_num }}</h5>
                        <div class="mb-3">
                            <span class="badge bg-info">{{ $process->status }}</span>
                        </div>

                        <div class="mb-3">
                            <strong>Asesorado:</strong> {{ $process->advised_person }}<br>
                            <strong>Teléfono:</strong> {{ $process->advised_phone ?? '—' }}
                        </div>

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
                                <h6>Datos generales</h6>
                                <p class="text-muted">
                                    <strong>Demandado:</strong> {{ $process->sued_person }}<br>
                                    <strong>Parentesco:</strong> {{ $process->relation_with_advised ?? '—' }}
                                </p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Características del servicio</h6>
                                <p class="text-muted">
                                    <strong>Expediente:</strong> {{ $process->case_num }}<br>
                                    <strong>Estado:</strong> {{ $process->status ?? '—' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Fechas importantes</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $process->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>
altima actualizacin:</strong> {{ $process->updated_at->format('d/m/Y H:i') }}
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
