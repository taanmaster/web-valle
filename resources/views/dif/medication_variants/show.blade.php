@extends('layouts.master')
@section('title')Variante: {{ $variant->name }} @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') <a href="{{ route('dif.medication_variants.index') }}">Variantes de Medicamentos</a> @endslot
@slot('title') Variante: {{ $variant->name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $variant->name }}</h5>
                        <p class="card-text"><strong>SKU:</strong> <code>{{ $variant->sku }}</code></p>

                        @if($variant->price)
                            <p class="card-text"><strong>Precio:</strong> ${{ number_format($variant->price, 2) }}</p>
                        @endif

                        <hr>

                        <h6>Medicamento Base</h6>
                        <p class="card-text">
                            <strong>{{ $variant->medication->generic_name }}</strong>
                            @if($variant->medication->commercial_name)
                                <br><small class="text-muted">{{ $variant->medication->commercial_name }}</small>
                            @endif
                        </p>

                        <hr>

                        <div class="d-flex gap-2" role="group">
                            <a href="{{ route('dif.medication_variants.edit', $variant->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <a href="{{ route('dif.medications.show', $variant->medication->id) }}" class="btn btn-sm btn-info">Ver Medicamento</a>
                            <form method="POST" action="{{ route('dif.medication_variants.destroy', $variant->id) }}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta variante?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.medication_variants.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información de la Variante</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Presentación</h6>
                                <p class="text-muted">
                                    {{ $variant->type ?? 'N/A' }}
                                    @if($variant->type_num)
                                        - {{ $variant->type_num }}
                                    @endif
                                    @if($variant->type_dosage)
                                        {{ $variant->type_dosage }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Vía de administración</h6>
                                <p class="text-muted">{{ $variant->use_type ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h6>Metadatos</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $variant->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $variant->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Inventario</h5>
                        <a href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Registrar Movimiento
                        </a>
                    </div>
                    <div class="card-body">
                        @php
                            $stockStatus = $variant->getStockStatus();
                            $currentStock = $variant->getCurrentStock();
                        @endphp
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <h3 class="fw-bold {{ $currentStock > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $currentStock }}
                                    </h3>
                                    <p class="text-muted">Unidades en stock</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <span class="badge {{ $stockStatus['badge_class'] }} fs-6">
                                        {{ $stockStatus['label'] }}
                                    </span>
                                    <p class="text-muted mt-2">Estado del inventario</p>
                                </div>
                            </div>
                        </div>

                        @if($variant->stockMovements->count() > 0)
                            <hr>
                            <h6>Últimos Movimientos</h6>
                            <div class="list-group list-group-flush">
                                @foreach($variant->stockMovements()->orderBy('created_at', 'desc')->limit(5)->get() as $movement)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($movement->movement_type === 'inbound')
                                                <span class="badge bg-success">+{{ $movement->quantity }}</span>
                                            @else
                                                <span class="badge bg-danger">-{{ $movement->quantity }}</span>
                                            @endif
                                            <small class="text-muted ms-2">{{ $movement->date->format('d/m/Y') }}</small>
                                            @if($movement->external_reference)
                                                <br><small class="text-muted">Ref: {{ $movement->external_reference }}</small>
                                            @endif
                                        </div>
                                        <a href="{{ route('dif.stock_movements.show', $movement->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('dif.stock_movements.index', ['search' => $variant->sku]) }}" class="btn btn-sm btn-outline-secondary">
                                    Ver todos los movimientos
                                </a>
                            </div>
                        @else
                            <div class="text-center py-2">
                                <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No hay movimientos de inventario registrados.</p>
                                <a href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Registrar Primer Movimiento
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Historial y Notas</h5>

                        <hr>
                        
                        @if($logs->count() > 0)
                            <div class="table-responsive mb-0">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Acción</th>
                                            <th>Información</th>
                                            <th>Nota</th>
                                            <th>Fecha y Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logs as $log)
                                        <tr>
                                            <td>
                                                @if($log->model_action == 'create')
                                                    <span class="badge bg-success">Creado</span>
                                                @elseif($log->model_action == 'update')
                                                    <span class="badge bg-warning">Actualizado</span>
                                                @elseif($log->model_action == 'destroy')
                                                    <span class="badge bg-danger">Eliminado</span>
                                                @else
                                                    <span class="badge bg-info">{{ ucfirst($log->model_action) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $log->user->name ?? 'Invitado' }} {{ $log->data }}</td>
                                            <td>{{ $log->note ?? 'n/a' }}</td>
                                            <td class="text-muted">
                                                <i class="far fa-calendar-alt"></i> 
                                                {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y H:i a') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-history fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No hay historial disponible para esta variante.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
