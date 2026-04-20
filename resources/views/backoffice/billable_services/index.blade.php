@extends('layouts.master')
@section('title') Cobros en Línea — Servicios @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Tesorería @endslot
        @slot('title') Servicios Cobrables @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-tags fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">
                                    <i class="fas fa-tags text-primary me-2"></i> Servicios Cobrables
                                </h3>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    Catálogo de servicios municipales disponibles para cobro en línea
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <a href="{{ route('admin.billable_services.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Servicio
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg me-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        @if($services->count() == 0)
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-tags fa-5x text-muted opacity-50"></i>
                                </div>
                                <h4 class="fw-bold mb-3">No hay servicios registrados</h4>
                                <p class="text-muted mb-4">
                                    Comienza agregando el primer servicio cobrable.
                                </p>
                                <a href="{{ route('admin.billable_services.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i> Agregar Primer Servicio
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-white">#</th>
                                            <th class="text-white"><i class="fas fa-tag me-1"></i> Nombre</th>
                                            <th class="text-white"><i class="fas fa-align-left me-1"></i> Descripción</th>
                                            <th class="text-end text-white"><i class="fas fa-dollar-sign me-1"></i> Precio Unitario</th>
                                            <th class="text-center text-white"><i class="fas fa-toggle-on me-1"></i> Activo</th>
                                            <th class="text-center text-white"><i class="fas fa-cog me-1"></i> Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $servicio)
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark">{{ $servicio->id }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="fas fa-tag text-primary"></i>
                                                    </div>
                                                    <span class="fw-semibold">{{ $servicio->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-muted small">{{ Str::limit($servicio->description, 60) ?? '—' }}</td>
                                            <td class="text-end fw-bold text-success">
                                                ${{ number_format($servicio->unit_price, 2) }}
                                            </td>
                                            <td class="text-center">
                                                @if($servicio->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i> Activo
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times-circle me-1"></i> Inactivo
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.billable_services.show', $servicio) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       data-bs-toggle="tooltip" title="Ver detalle">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.billable_services.edit', $servicio) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       data-bs-toggle="tooltip" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.billable_services.destroy', $servicio) }}"
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Eliminar este servicio?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                data-bs-toggle="tooltip" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($services->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Mostrando <strong>{{ $services->firstItem() }}</strong> a <strong>{{ $services->lastItem() }}</strong> de <strong>{{ $services->total() }}</strong> registros
                                    </div>
                                    <div>
                                        {{ $services->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
    });
</script>
@endpush
@endsection
