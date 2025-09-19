@extends('layouts.master')
@section('title')Movimientos de Entrada @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') <a href="{{ route('dif.stock_movements.index') }}">Inventario de Medicamentos</a> @endslot
@slot('title') Movimientos de Entrada @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-arrow-down text-success me-2"></i>
                            Movimientos de Entrada
                        </h5>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dif.stock_movements.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Inventario
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
                        <!-- Sección de Filtros -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-filter me-1"></i>
                                    Filtros de Búsqueda
                                </h6>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('dif.stock_movements.inbound') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="date_from" class="form-label">Fecha Desde:</label>
                                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="date_to" class="form-label">Fecha Hasta:</label>
                                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="medication_id" class="form-label">Medicamento:</label>
                                            <select name="medication_id" id="medication_id" class="form-select">
                                                <option value="">Todos los medicamentos</option>
                                                @foreach($medications as $medication)
                                                    <option value="{{ $medication->id }}" {{ request('medication_id') == $medication->id ? 'selected' : '' }}>
                                                        {{ $medication->generic_name }}
                                                        @if($medication->commercial_name)
                                                            ({{ $medication->commercial_name }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-search"></i> Filtrar
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <div class="col-md-10">
                                            <input type="text" name="search" class="form-control" placeholder="Buscar por referencia externa, variante o SKU..." value="{{ request('search') }}">
                                        </div>
                                        <div class="col-md-2">
                                            @if(request()->hasAny(['date_from', 'date_to', 'medication_id', 'search']))
                                                <a href="{{ route('dif.stock_movements.inbound') }}" class="btn btn-outline-secondary w-100">
                                                    <i class="fas fa-times"></i> Limpiar
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if($movements->count() > 0)
                            <!-- Resumen -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h3 class="mb-1">{{ $movements->total() }}</h3>
                                            <p class="mb-0">Total de Entradas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            @php
                                                $totalQuantity = $movements->sum('quantity');
                                            @endphp
                                            <h3 class="mb-1">{{ number_format($totalQuantity) }}</h3>
                                            <p class="mb-0">Unidades Ingresadas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            @php
                                                $uniqueMedications = $movements->pluck('variant.medication.id')->unique()->count();
                                            @endphp
                                            <h3 class="mb-1">{{ $uniqueMedications }}</h3>
                                            <p class="mb-0">Medicamentos Diferentes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-success">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Medicamento</th>
                                            <th>Variante</th>
                                            <th>Cantidad</th>
                                            <th>Fecha Vencimiento</th>
                                            <th>Referencia Externa</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($movements as $movement)
                                            <tr>
                                                <td>
                                                    <strong>{{ $movement->date->format('d/m/Y') }}</strong>
                                                    <br><small class="text-muted">{{ $movement->date->format('H:i') }}</small>
                                                </td>
                                                <td>
                                                    <a href="{{ route('dif.medications.show', $movement->variant->medication->id) }}" class="text-decoration-none">
                                                        <strong>{{ $movement->variant->medication->generic_name }}</strong>
                                                    </a>
                                                    @if($movement->variant->medication->commercial_name)
                                                        <br><small class="text-muted">{{ $movement->variant->medication->commercial_name }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('dif.medication_variants.show', $movement->variant->id) }}" class="text-decoration-none">
                                                        {{ $movement->variant->name }}
                                                    </a>
                                                    <br><small class="text-muted">SKU: <code>{{ $movement->variant->sku }}</code></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success fs-6">
                                                        +{{ number_format($movement->quantity) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($movement->expiration_date)
                                                        @php
                                                            $now = now();
                                                            $expirationDate = \Carbon\Carbon::parse($movement->expiration_date);
                                                            $daysUntilExpiration = $now->diffInDays($expirationDate, false);
                                                        @endphp
                                                        
                                                        <span class="fw-bold {{ $daysUntilExpiration < 0 ? 'text-danger' : ($daysUntilExpiration <= 30 ? 'text-warning' : 'text-success') }}">
                                                            {{ $expirationDate->format('d/m/Y') }}
                                                        </span>
                                                        
                                                        @if($daysUntilExpiration < 0)
                                                            <br><small class="text-danger">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                                Vencido hace {{ abs($daysUntilExpiration) }} días
                                                            </small>
                                                        @elseif($daysUntilExpiration <= 30)
                                                            <br><small class="text-warning">
                                                                <i class="fas fa-clock"></i>
                                                                Vence en {{ $daysUntilExpiration }} días
                                                            </small>
                                                        @else
                                                            <br><small class="text-muted">
                                                                Vence en {{ $daysUntilExpiration }} días
                                                            </small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Sin fecha</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($movement->external_reference)
                                                        <code>{{ $movement->external_reference }}</code>
                                                    @else
                                                        <span class="text-muted">Sin referencia</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('dif.stock_movements.show', $movement->id) }}" 
                                                           class="btn btn-sm btn-info" title="Ver Detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('dif.stock_movements.edit', $movement->id) }}" 
                                                           class="btn btn-sm btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
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
                                {{ $movements->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-arrow-down fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay movimientos de entrada registrados</h5>
                                <p class="text-muted">
                                    @if(request()->hasAny(['date_from', 'date_to', 'medication_id', 'search']))
                                        No se encontraron movimientos de entrada con los filtros aplicados.
                                    @else
                                        Registra el primer movimiento de entrada para comenzar a gestionar el inventario.
                                    @endif
                                </p>
                                <div class="d-flex gap-2 justify-content-center">
                                    @if(request()->hasAny(['date_from', 'date_to', 'medication_id', 'search']))
                                        <a href="{{ route('dif.stock_movements.inbound') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> Limpiar Filtros
                                        </a>
                                    @endif
                                    <a href="{{ route('dif.stock_movements.create') }}" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Registrar Entrada
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
