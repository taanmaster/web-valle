@extends('layouts.master')
@section('title') Servicio @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Tesorería @endslot
        @slot('li_3') <a href="{{ route('admin.billable_services.index') }}">Servicios Cobrables</a> @endslot
        @slot('title') Detalle de Servicio @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="row">

            {{-- Detalle del servicio --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-tag me-2"></i> Detalle del Servicio</h5>
                        <a href="{{ route('admin.billable_services.edit', $servicio) }}" class="btn btn-sm btn-light">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>
                    </div>
                    <div class="card-body p-4">

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <small class="text-muted d-block">Nombre del Servicio</small>
                                <h5 class="mb-0">{{ $servicio->name }}</h5>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Estado</small>
                                @if($servicio->is_active)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle me-1"></i> Activo
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6">
                                        <i class="fas fa-times-circle me-1"></i> Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($servicio->description)
                        <h6 class="border-bottom pb-2 mb-3 mt-4">
                            <i class="fas fa-align-left me-2 text-primary"></i> Descripción
                        </h6>
                        <p class="text-muted">{{ $servicio->description }}</p>
                        @endif

                        <h6 class="border-bottom pb-2 mb-3 mt-4">
                            <i class="fas fa-dollar-sign me-2 text-primary"></i> Precio
                        </h6>
                        <div class="alert alert-success border-0">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Precio Unitario:</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h3 class="mb-0 text-success">${{ number_format($servicio->unit_price, 2) }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Fecha de Registro</small>
                                <strong>{{ $servicio->created_at->format('d/m/Y') }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Última Actualización</small>
                                <strong>{{ $servicio->updated_at->format('d/m/Y') }}</strong>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('admin.billable_services.edit', $servicio) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <form action="{{ route('admin.billable_services.destroy', $servicio) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Está seguro de eliminar este servicio?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i> Eliminar
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Resumen</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Precio Unitario</small>
                            <h4 class="mb-0 text-success">${{ number_format($servicio->unit_price, 2) }}</h4>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Visible para ciudadanos</small>
                            @if($servicio->is_active)
                                <span class="badge bg-success fs-6">Sí</span>
                            @else
                                <span class="badge bg-secondary fs-6">No</span>
                            @endif
                        </div>
                        <div>
                            <small class="text-muted d-block">Registrado el</small>
                            <strong>{{ $servicio->created_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.billable_services.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i> Volver al listado
                </a>
            </div>

        </div>
    </div>
@endsection
