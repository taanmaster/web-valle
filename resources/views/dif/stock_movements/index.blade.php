@extends('layouts.master')
@section('title')Inventario de Medicamentos @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Inventario de Medicamentos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Inventario de Medicamentos</h5>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dif.stock_movements.inbound') }}" class="btn btn-outline-success">
                                <i class="fas fa-arrow-down"></i> Ver Entradas
                            </a>
                            <a href="{{ route('dif.stock_movements.outbound') }}" class="btn btn-outline-danger">
                                <i class="fas fa-arrow-up"></i> Ver Salidas
                            </a>
                            <a href="{{ route('dif.stock_movements.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Registrar Movimiento
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Formulario de búsqueda y filtros -->
                        <form method="GET" action="{{ route('dif.stock_movements.index') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar por medicamento, variante o SKU..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="medication_status" class="form-select">
                                        <option value="">Todos los medicamentos</option>
                                        <option value="active" {{ request('medication_status') == 'active' ? 'selected' : '' }}>Solo activos</option>
                                        <option value="inactive" {{ request('medication_status') == 'inactive' ? 'selected' : '' }}>Solo inactivos</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="stock_status" class="form-select">
                                        <option value="">Todos los estados</option>
                                        <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Disponible</option>
                                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Resurtir pronto</option>
                                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Agotado</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                                </div>
                            </div>
                            @if(request()->hasAny(['search', 'medication_status', 'stock_status']))
                                <div class="mt-2">
                                    <a href="{{ route('dif.stock_movements.index') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-times"></i> Limpiar filtros
                                    </a>
                                </div>
                            @endif
                        </form>

                        @if($variants->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Nombre Variante</th>
                                            <th>SKU</th>
                                            <th>Estado</th>
                                            <th>Inventario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($variants as $variant)
                                            @php
                                                $stockStatus = $variant->getStockStatus();
                                                $currentStock = $variant->getCurrentStock();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="{{ route('dif.medications.show', $variant->medication->id) }}" class="text-decoration-none">
                                                        <strong>{{ $variant->medication->generic_name }}</strong>
                                                    </a>
                                                    @if($variant->medication->commercial_name)
                                                        <br><small class="text-muted">{{ $variant->medication->commercial_name }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $variant->name }}
                                                    @if($variant->type)
                                                        <br><small class="text-muted">
                                                            {{ $variant->type }}
                                                            @if($variant->type_num) - {{ $variant->type_num }} @endif
                                                            @if($variant->type_dosage) {{ $variant->type_dosage }} @endif
                                                        </small>
                                                    @endif
                                                </td>
                                                <td><code>{{ $variant->sku }}</code></td>
                                                <td>
                                                    @if($variant->medication->is_active)
                                                        <span class="badge bg-success">Activo</span>
                                                    @else
                                                        <span class="badge bg-secondary">Archivado</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="fw-bold">{{ $currentStock }}</span>
                                                        <span class="badge {{ $stockStatus['badge_class'] }}">
                                                            {{ $stockStatus['label'] }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}" 
                                                           class="btn btn-sm btn-success" title="Registrar Movimiento">
                                                            <i class="fas fa-exchange-alt"></i>
                                                        </a>
                                                        <a href="{{ route('dif.medication_variants.show', $variant->id) }}" 
                                                           class="btn btn-sm btn-info" title="Ver Variante">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            <div class="d-flex justify-content-center">
                                {{ $variants->appends(request()->query())->links() }}
                            </div>

                            <!-- Resumen estadístico -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Resumen del Inventario</h6>
                                            <div class="row">
                                                @php
                                                    $totalVariants = $variants->total();
                                                    $availableCount = 0;
                                                    $lowStockCount = 0;
                                                    $outOfStockCount = 0;
                                                    
                                                    foreach($variants as $variant) {
                                                        $status = $variant->getStockStatus();
                                                        switch($status['status']) {
                                                            case 'disponible':
                                                                $availableCount++;
                                                                break;
                                                            case 'resurtir':
                                                                $lowStockCount++;
                                                                break;
                                                            case 'agotado':
                                                                $outOfStockCount++;
                                                                break;
                                                        }
                                                    }
                                                @endphp
                                                
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h5 class="text-primary">{{ $totalVariants }}</h5>
                                                        <small class="text-muted">Total Variantes</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h5 class="text-success">{{ $availableCount }}</h5>
                                                        <small class="text-muted">Disponibles</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h5 class="text-warning">{{ $lowStockCount }}</h5>
                                                        <small class="text-muted">Resurtir Pronto</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h5 class="text-danger">{{ $outOfStockCount }}</h5>
                                                        <small class="text-muted">Agotados</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay variantes de medicamentos registradas</h5>
                                <p class="text-muted">Primero necesitas crear medicamentos y sus variantes antes de gestionar el inventario.</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('dif.medications.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Crear Medicamento
                                    </a>
                                    <a href="{{ route('dif.medication_variants.create') }}" class="btn btn-secondary">
                                        <i class="fas fa-plus"></i> Crear Variante
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection