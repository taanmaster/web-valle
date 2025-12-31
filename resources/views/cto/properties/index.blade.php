@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Propiedades del Predial @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-building fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-home text-primary me-2"></i> Propiedades del Predial
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Gestión de propiedades y contribuyentes
                            </p>
                        </div>
                    </div>
                </div>

                @hasanyrole(['all', 'cto_admin'])
                <div class="col-lg-4 text-end">
                    <a href="{{ route('properties.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nueva Propiedad
                    </a>
                </div>
                @endhasanyrole
                
                @if(Auth::user()->email == 'webmaster@valle.com')
                <a data-bs-toggle="modal" data-bs-target="#import" href="#" class="btn btn-outline-primary">Importar Excel</a>

                <!-- Modal -->
                <div class="modal fade" id="import" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Importar Excel de Predios</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('properties.import') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Selecciona tu Archivo</label>
                                        <input class="form-control" type="file" name="import_file" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Procesar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('properties.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1"></i> Buscar:
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="search"
                                           class="form-control border-start-0"
                                           placeholder="Buscar por nombre, cuenta o dirección..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tag me-1"></i> Tipo de Contribuyente:
                                </label>
                                <select name="taxpayer_type" class="form-select">
                                    <option value="">Todos los Tipos</option>
                                    <option value="fisica" {{ request('taxpayer_type') == 'fisica' ? 'selected' : '' }}>
                                        Persona Física
                                    </option>
                                    <option value="moral" {{ request('taxpayer_type') == 'moral' ? 'selected' : '' }}>
                                        Persona Moral
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-receipt me-1"></i> Tipo de Cuota:
                                </label>
                                <select name="cuota_type" class="form-select">
                                    <option value="">Todos los Tipos</option>
                                    <option value="cuota_minima" {{ request('cuota_type') == 'cuota_minima' ? 'selected' : '' }}>
                                        Cuota Mínima
                                    </option>
                                    <option value="cuota_normal" {{ request('cuota_type') == 'cuota_normal' ? 'selected' : '' }}>
                                        Cuota Normal
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i> Filtrar
                                </button>
                            </div>
                        </div>
                        @if(request()->hasAny(['search', 'taxpayer_type', 'cuota_type']))
                            <div class="mt-3">
                                <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Limpiar Filtros
                                </a>
                            </div>
                        @endif
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-lg me-3"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($properties->count() == 0)
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-home fa-5x text-muted opacity-50"></i>
                            </div>
                            <h4 class="fw-bold mb-3">No hay propiedades registradas</h4>
                            <p class="text-muted mb-4">
                                Comienza agregando la primera propiedad del sistema.
                            </p>
                            <a href="{{ route('properties.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Agregar Primera Propiedad
                            </a>
                        </div>
                    @else
                        <!-- Tabla de propiedades -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-white"><i class="fas fa-hashtag me-1"></i> Cuenta</th>
                                        <th class="text-white"><i class="fas fa-user me-1"></i> Contribuyente</th>
                                        <th class="text-white"><i class="fas fa-map-marker-alt me-1"></i> Dirección</th>
                                        <th class="text-white"><i class="fas fa-receipt me-1"></i> Tipo Cuota</th>
                                        <th class="text-center text-white"><i class="fas fa-ruler-combined me-1"></i> Superficie</th>
                                        <th class="text-end text-white"><i class="fas fa-dollar-sign me-1"></i> Valor Catastral</th>
                                        <th class="text-center text-white"><i class="fas fa-file-invoice me-1"></i> Recibos</th>
                                        <th class="text-center text-white"><i class="fas fa-cog me-1"></i> Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($properties as $property)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <i class="fas fa-hashtag me-1"></i>
                                                    {{ $property->location_account ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="fas fa-user text-success"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $property->taxpayer_name ?? 'Sin nombre' }}</div>
                                                        @if($property->taxpayer_type)
                                                            <small class="text-muted">
                                                                <i class="fas fa-tag me-1"></i>
                                                                {{ ucfirst($property->taxpayer_type) }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $property->street }} {{ $property->street_num }}
                                                    @if($property->int_num)
                                                        <small>Int. {{ $property->int_num }}</small>
                                                    @endif
                                                    <br>
                                                    <small>{{ $property->suburb }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($property->cuota_type)
                                                    <span class="badge {{ $property->cuota_type == 'cuota_minima' ? 'bg-info' : 'bg-warning' }} bg-opacity-10 text-{{ $property->cuota_type == 'cuota_minima' ? 'info' : 'warning' }}">
                                                        {{ $property->cuota_type == 'cuota_minima' ? 'Cuota Mínima' : 'Cuota Normal' }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($property->location_surface)
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                        {{ number_format($property->location_surface, 2) }} m²
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if($property->location_law_value)
                                                    <span class="fw-semibold text-success">
                                                        ${{ number_format($property->location_law_value, 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('property_taxes.index', ['property_id' => $property->id]) }}" 
                                                   class="badge bg-primary bg-opacity-10 text-primary text-decoration-none">
                                                    <i class="fas fa-file-invoice me-1"></i>
                                                    {{ $property->property_taxes_count ?? 0 }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('properties.show', $property->id) }}" 
                                                       class="btn btn-sm btn-outline-info"
                                                       data-bs-toggle="tooltip"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    @hasanyrole(['all', 'cto_admin'])
                                                    <a href="{{ route('properties.edit', $property->id) }}" 
                                                       class="btn btn-sm btn-outline-warning"
                                                       data-bs-toggle="tooltip"
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('properties.destroy', $property->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('¿Está seguro de eliminar esta propiedad?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger"
                                                                data-bs-toggle="tooltip"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endhasanyrole
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if($properties->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Mostrando <strong>{{ $properties->firstItem() }}</strong> a <strong>{{ $properties->lastItem() }}</strong> de <strong>{{ $properties->total() }}</strong> registros
                                </div>
                                <div>
                                    {{ $properties->links('pagination::bootstrap-5') }}
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
    // Inicializar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
