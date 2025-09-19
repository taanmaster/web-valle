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

<div class="container-fluid">
    <!-- Encabezado de la variante -->
    <div class="row mb-4">
        <div class="col-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <h2 class="mb-0 me-3">{{ $variant->name }}</h2>
                                <span class="badge bg-info fs-6">Variante</span>
                            </div>
                            
                            <p class="text-muted mb-2">
                                <i class="fas fa-barcode me-1"></i>
                                <strong>SKU:</strong> <code class="bg-light px-2 py-1 rounded">{{ $variant->sku }}</code>
                            </p>

                            <p class="text-muted mb-2">
                                <i class="fas fa-pills me-1"></i>
                                <strong>Medicamento base:</strong> 
                                <a href="{{ route('dif.medications.show', $variant->medication->id) }}" class="text-decoration-none">
                                    {{ $variant->medication->generic_name }}
                                </a>
                                @if($variant->medication->commercial_name)
                                    <small class="text-muted">({{ $variant->medication->commercial_name }})</small>
                                @endif
                            </p>

                            @if($variant->price)
                                <p class="text-muted mb-0">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    <strong>Precio:</strong> 
                                    <span class="fw-bold text-success">${{ number_format($variant->price, 2) }}</span>
                                </p>
                            @endif
                        </div>
                        
                        <div class="col-md-6 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('dif.medication_variants.edit', $variant->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>
                                <a href="{{ route('dif.medications.show', $variant->medication->id) }}" class="btn btn-outline-info">
                                    <i class="fas fa-pills me-1"></i> Ver Medicamento
                                </a>
                                <a href="{{ route('dif.medication_variants.index') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                            </div>
                            
                            <div class="mt-2">
                                <form method="POST" action="{{ route('dif.medication_variants.destroy', $variant->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta variante?')">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="far fa-calendar-plus me-1"></i>
                                <strong>Registrado:</strong> {{ $variant->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="far fa-calendar-edit me-1"></i>
                                <strong>Última actualización:</strong> {{ $variant->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <!-- Información de la Variante -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary">
                    <h5 class="text-white">
                        <i class="fas fa-info-circle me-2"></i>
                        Características de la Variante
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h6 class="text-muted mb-2">Presentación</h6>
                            <div class="d-flex align-items-center">
                                @if($variant->type)
                                    <span class="badge bg-light text-dark me-2">{{ $variant->type }}</span>
                                @endif
                                @if($variant->type_num && $variant->type_dosage)
                                    <span class="fw-bold">{{ $variant->type_num }}{{ $variant->type_dosage }}</span>
                                @elseif($variant->type_num)
                                    <span class="fw-bold">{{ $variant->type_num }}</span>
                                @else
                                    <span class="text-muted">Sin especificar</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <h6 class="text-muted mb-2">Vía de Administración</h6>
                            @if($variant->use_type)
                                <span class="badge bg-secondary">{{ $variant->use_type }}</span>
                            @else
                                <span class="text-muted">Sin especificar</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Inventario -->
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success d-flex justify-content-between align-items-center">
                    <h5 class="text-white">
                        <i class="fas fa-boxes me-2"></i>
                        Inventario
                    </h5>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}" class="btn btn-light">
                            <i class="fas fa-plus me-1"></i> Registrar Movimiento
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $stockStatus = $variant->getStockStatus();
                        $currentStock = $variant->getCurrentStock();
                    @endphp
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <h3 class="fw-bold {{ $currentStock > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $currentStock }}
                            </h3>
                            <p class="text-muted mb-0">Unidades en stock</p>
                        </div>
                        <div class="col-6">
                            <span class="badge {{ $stockStatus['badge_class'] }} fs-6 p-2">
                                {{ $stockStatus['label'] }}
                            </span>
                            <p class="text-muted mt-2 mb-0">Estado del inventario</p>
                        </div>
                    </div>

                    @if($variant->stockMovements->count() > 0)
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Últimos Movimientos</h6>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('dif.stock_movements.index', ['search' => $variant->sku]) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-list me-1"></i> Ver todos
                                </a>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 fw-bold">Tipo</th>
                                        <th class="border-0 fw-bold">Cantidad</th>
                                        <th class="border-0 fw-bold">Fecha</th>
                                        <th class="border-0 fw-bold">Expiración</th>
                                        <th class="border-0 fw-bold">Referencia</th>
                                        <th class="border-0 fw-bold text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($variant->stockMovements()->orderBy('created_at', 'desc')->limit(3)->get() as $movement)
                                        <tr>
                                            <td>
                                                @if($movement->movement_type === 'inbound')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                        <i class="fas fa-arrow-down me-1"></i> Entrada
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                        <i class="fas fa-arrow-up me-1"></i> Salida
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($movement->movement_type === 'inbound')
                                                    <span class="fw-bold text-success">+{{ $movement->quantity }}</span>
                                                @else
                                                    <span class="fw-bold text-danger">-{{ $movement->quantity }}</span>
                                                @endif
                                                <small class="text-muted"> unidades</small>
                                            </td>
                                            <td>
                                                <span class="text-dark">{{ $movement->date->format('d/m/Y') }}</span>
                                            </td>
                                            <td>
                                                @if($movement->expiration_date)
                                                    @php
                                                        $exp = $movement->expiration_date;
                                                        $isExpired = $exp->lt(\Carbon\Carbon::now());
                                                        $isSoon = !$isExpired && $exp->lte(\Carbon\Carbon::now()->addMonth());
                                                    @endphp
                                                    @if($isExpired)
                                                        <span class="text-danger fw-bold">{{ $exp->format('d/m/Y') }}</span>
                                                        <br>
                                                        <span class="badge bg-danger">Vencido</span>
                                                    @elseif($isSoon)
                                                        <span class="text-warning fw-bold">{{ $exp->format('d/m/Y') }}</span>
                                                        <br>
                                                        <span class="badge bg-warning text-dark">Vence pronto</span>
                                                    @else
                                                        <span class="text-dark">{{ $exp->format('d/m/Y') }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted fst-italic">Sin fecha</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($movement->external_reference)
                                                    <code class="text-info bg-info-subtle px-2 py-1 rounded">{{ $movement->external_reference }}</code>
                                                @else
                                                    <span class="text-muted fst-italic">Sin referencia</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('dif.stock_movements.show', $movement->id) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="Ver detalles del movimiento">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($variant->stockMovements->count() > 3)
                            <div class="text-center mt-3 py-2 bg-light rounded">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Mostrando los 3 movimientos más recientes de {{ $variant->stockMovements->count() }} total
                                </small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-box-open text-muted" style="font-size: 2rem;"></i>
                            <h6 class="text-muted mt-2">Sin movimientos registrados</h6>
                            <p class="text-muted mb-3">Registra el primer movimiento para comenzar a gestionar el inventario.</p>
                            <a href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i> Primer Movimiento
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Historial y Notas -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
                    <h5 class="text-white">
                        <i class="fas fa-history me-2"></i>
                        Historial y Notas
                    </h5>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createManualNoteModal">
                            <i class="fas fa-plus me-1"></i> Crear Nota
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Acción</th>
                                        <th class="border-0">Usuario y Detalles</th>
                                        <th class="border-0">Nota</th>
                                        <th class="border-0">Fecha y Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($log->model_action == 'create')
                                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-plus"></i>
                                                    </div>
                                                    <span class="ms-2 fw-bold text-success">Creación</span>
                                                @elseif($log->model_action == 'update')
                                                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-edit"></i>
                                                    </div>
                                                    <span class="ms-2 fw-bold text-warning">Actualización</span>
                                                @elseif($log->model_action == 'destroy')
                                                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </div>
                                                    <span class="ms-2 fw-bold text-danger">Eliminación</span>
                                                @else
                                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-bell"></i>
                                                    </div>
                                                    <span class="ms-2 fw-bold text-info">{{ ucfirst($log->model_action) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-dark">{{ $log->user->name ?? 'Usuario Invitado' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $log->data }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($log->note)
                                                <span class="text-dark">{{ $log->note }}</span>
                                            @else
                                                <span class="text-muted fst-italic">Sin nota adicional</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y') }}
                                                <br>
                                                <small>{{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('H:i a') }}</small>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history text-muted" style="font-size: 3rem;"></i>
                            <h6 class="text-muted mt-3">No hay registros de historial</h6>
                            <p class="text-muted">El historial de actividades aparecerá aquí conforme se realicen acciones.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Crear Nota Manual -->
<div class="modal fade" id="createManualNoteModal" tabindex="-1" aria-labelledby="createManualNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('create.manual.notification') }}">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createManualNoteModalLabel">
                        <i class="fas fa-sticky-note me-2"></i>
                        Crear Nota Manual
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="model_id" value="{{ $variant->id }}">
                    <input type="hidden" name="type" value="medication_variant">
                    <input type="hidden" name="model_action" value="update">
                    <input type="hidden" name="data" value="creó una nota interna">

                    <div class="mb-3">
                        <label for="note" class="form-label fw-bold">Contenido de la Nota</label>
                        <textarea name="note" id="note" class="form-control" rows="4" 
                                  placeholder="Describe los detalles que deseas agregar al historial de esta variante..." 
                                  required></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            La nota se asociará automáticamente a tu perfil y a la variante "{{ $variant->name }}".
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Nota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para mejorar la interactividad -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mejorar experiencia de usuario en formularios
    const requiredInputs = document.querySelectorAll('input[required], textarea[required]');
    requiredInputs.forEach(input => {
        input.addEventListener('invalid', function() {
            this.classList.add('is-invalid');
        });
        
        input.addEventListener('input', function() {
            if (this.validity.valid) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });

    // Confirmación mejorada para eliminación
    const deleteForm = document.querySelector('form[action*="destroy"]');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('⚠️ ¿Estás completamente seguro?\n\nEsta acción eliminará permanentemente la variante "{{ $variant->name }}" y todos sus movimientos de inventario asociados.\n\nEsta acción NO se puede deshacer.')) {
                this.submit();
            }
        });
    }

    // Tooltip para botones de acción
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Preloader para formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Procesando...';
            }
        });
    });

    // Actualizar badge de stock en tiempo real (opcional - si tienes actualización automática)
    const stockBadge = document.querySelector('.badge');
    if (stockBadge) {
        // Agregar animación sutil al badge cuando cambie el stock
        stockBadge.addEventListener('animationend', function() {
            this.style.animation = '';
        });
    }
});
</script>

@endsection
