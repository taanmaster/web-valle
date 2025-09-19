@extends('layouts.master')
@section('title')Movimiento de Inventario #{{ $movement->id }} @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') <a href="{{ route('dif.stock_movements.index') }}">Inventario</a> @endslot
@slot('title') Movimiento #{{ $movement->id }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Movimiento de Inventario #{{ $movement->id }}</h5>
                            @if($movement->movement_type === 'inbound')
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-arrow-down"></i> Entrada
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-arrow-up"></i> Salida
                                </span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <h6>Medicamento y Variante</h6>
                            <p class="card-text">
                                <strong>{{ $movement->variant->medication->generic_name }}</strong>
                                @if($movement->variant->medication->commercial_name)
                                    <br><small class="text-muted">{{ $movement->variant->medication->commercial_name }}</small>
                                @endif
                            </p>
                            <p class="card-text">
                                <strong>Variante:</strong> {{ $movement->variant->name }}<br>
                                <strong>SKU:</strong> <code>{{ $movement->variant->sku }}</code>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Cantidad</h6>
                                <p class="text-muted fs-4 fw-bold">
                                    @if($movement->movement_type === 'inbound')
                                        <span class="text-success">+{{ $movement->quantity }}</span>
                                    @else
                                        <span class="text-danger">-{{ $movement->quantity }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Stock Actual</h6>
                                @php
                                    $stockStatus = $movement->variant->getStockStatus();
                                    $currentStock = $movement->variant->getCurrentStock();
                                @endphp
                                <p class="text-muted">
                                    <span class="fw-bold">{{ $currentStock }}</span>
                                    <span class="badge {{ $stockStatus['badge_class'] }} ms-2">
                                        {{ $stockStatus['label'] }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2" role="group">
                            <a href="{{ route('dif.stock_movements.edit', $movement->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <a href="{{ route('dif.medication_variants.show', $movement->variant->id) }}" class="btn btn-sm btn-info">Ver Variante</a>
                            @if($movement->movement_type === 'outbound')
                                <a href="{{ route('dif.stock_movements.receipt', $movement->id) }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fas fa-receipt me-1"></i> Descargar Recibo
                                </a>
                            @endif
                            <form method="POST" action="{{ route('dif.stock_movements.destroy', $movement->id) }}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este movimiento?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.stock_movements.index') }}" class="btn btn-sm btn-primary">Volver al inventario</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Detalles del Movimiento</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Fecha del Movimiento</h6>
                                <p class="text-muted">{{ $movement->date->format('d/m/Y') }}</p>
                            </div>
                            @if($movement->expiration_date)
                                <div class="col-md-6">
                                    <h6>Fecha de Vencimiento</h6>
                                    @php
                                        $exp = $movement->expiration_date;
                                        $isExpired = $exp->lt(\Carbon\Carbon::now());
                                        $isSoon = !$isExpired && $exp->lte(\Carbon\Carbon::now()->addMonth());
                                    @endphp
                                    <p class="text-muted">
                                        @if($isExpired)
                                            <span class="text-danger fw-bold">{{ $exp->format('d/m/Y') }}</span>
                                            <span class="badge bg-danger ms-1">Vencido</span>
                                        @elseif($isSoon)
                                            <span class="text-warning fw-bold">{{ $exp->format('d/m/Y') }}</span>
                                            <span class="badge bg-warning text-dark ms-1">Vence pronto</span>
                                        @else
                                            {{ $exp->format('d/m/Y') }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if($movement->external_reference)
                            <div class="mb-3">
                                <h6>Referencia Externa</h6>
                                <p class="text-muted">{{ $movement->external_reference }}</p>
                            </div>
                        @endif

                        @if($movement->additional_info && isset($movement->additional_info['notes']))
                            <div class="mb-3">
                                <h6>Notas</h6>
                                <p class="text-muted">{{ $movement->additional_info['notes'] }}</p>
                            </div>
                        @endif

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h6>Metadatos</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $movement->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $movement->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Historial de la Variante</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $recentMovements = $movement->variant->stockMovements()
                                                ->orderBy('created_at', 'desc')
                                                ->limit(5)
                                                ->get();
                        @endphp
                        
                        @if($recentMovements->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentMovements as $recentMovement)
                                    <div class="list-group-item {{ $recentMovement->id == $movement->id ? 'bg-light border-primary' : '' }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @if($recentMovement->movement_type === 'inbound')
                                                    <span class="badge bg-success">+{{ $recentMovement->quantity }}</span>
                                                @else
                                                    <span class="badge bg-danger">-{{ $recentMovement->quantity }}</span>
                                                @endif
                                                <small class="text-muted ms-2">{{ $recentMovement->date->format('d/m/Y') }}</small>
                                            </div>
                                            @if($recentMovement->id == $movement->id)
                                                <span class="badge bg-primary">Actual</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center">No hay movimientos registrados.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Historial de Notificaciones</h5>

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
                                <p class="text-muted">No hay historial disponible para este movimiento.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
