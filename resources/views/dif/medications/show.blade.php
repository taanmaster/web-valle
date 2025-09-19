@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Medicamento: {{ $medication->generic_name }} @endslot
@endcomponent

<div class="container-fluid">
    <!-- Encabezado del medicamento -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <h2 class="mb-0 me-3">{{ $medication->generic_name }}</h2>
                                @if($medication->is_active)
                                    <span class="badge bg-success fs-6">Activo</span>
                                @else
                                    <span class="badge bg-danger fs-6">Inactivo</span>
                                @endif
                            </div>
                            
                            @if($medication->commercial_name)
                                <p class="text-muted mb-2">
                                    <i class="fas fa-tag me-1"></i>
                                    <strong>Nombre comercial:</strong> {{ $medication->commercial_name }}
                                </p>
                            @endif

                            @if($medication->formula)
                                <p class="text-muted mb-0">
                                    <i class="fas fa-flask me-1"></i>
                                    <strong>Fórmula:</strong> {{ $medication->formula }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="col-md-4 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('dif.medications.edit', $medication->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>
                                <a href="{{ route('dif.medications.index') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                            </div>
                            
                            <div class="mt-2">
                                <form method="POST" action="{{ route('dif.medications.destroy', $medication->id) }}" style="display: inline-block;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este medicamento?')">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($medication->description)
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted mb-2">Descripción</h6>
                                <p class="mb-0">{{ $medication->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="far fa-calendar-plus me-1"></i>
                                <strong>Registrado:</strong> {{ $medication->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="far fa-calendar-edit me-1"></i>
                                <strong>Última actualización:</strong> {{ $medication->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Variantes -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h5 class="text-white ">
                        <i class="fas fa-pills me-2"></i>
                        Variantes del Medicamento
                    </h5>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createVariantModal">
                            <i class="fas fa-plus me-1"></i> Agregar Variante
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if(isset($medication->variants) && $medication->variants->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Presentación</th>
                                        <th class="border-0">Vía de Administración</th>
                                        <th class="border-0">Precio</th>
                                        <th class="border-0">Stock</th>
                                        <th class="border-0 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medication->variants as $variant)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <strong class="text-dark">{{ $variant->name }}</strong>
                                                    <small class="text-muted">
                                                        <i class="fas fa-capsules me-1"></i>
                                                        {{ $variant->type ?? 'Sin especificar' }}
                                                        @if($variant->type_num && $variant->type_dosage)
                                                            - {{ $variant->type_num }}{{ $variant->type_dosage }}
                                                        @endif
                                                    </small>
                                                    <small class="text-info">
                                                        <i class="fas fa-barcode me-1"></i>
                                                        {{ $variant->sku }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($variant->use_type)
                                                    <span class="badge bg-light text-dark">{{ $variant->use_type }}</span>
                                                @else
                                                    <span class="text-muted">Sin especificar</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($variant->price)
                                                    <span class="fw-bold text-success">${{ number_format($variant->price, 2) }}</span>
                                                @else
                                                    <span class="text-muted">Sin precio</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $stockStatus = $variant->getStockStatus();
                                                    $currentStock = $variant->getCurrentStock();
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold me-2">{{ $currentStock }}</span>
                                                    <span class="badge {{ $stockStatus['badge_class'] }}">
                                                        {{ $stockStatus['label'] }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}" 
                                                       class="btn btn-outline-success" 
                                                       title="Registrar Movimiento de Stock">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </a>
                                                    <a href="{{ route('dif.medication_variants.show', $variant->id) }}" 
                                                       class="btn btn-outline-info" 
                                                       title="Ver Detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('dif.medication_variants.edit', $variant->id) }}" 
                                                       class="btn btn-outline-primary" 
                                                       title="Editar Variante">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-pills text-muted" style="font-size: 3rem;"></i>
                            <h6 class="text-muted mt-3">No hay variantes registradas</h6>
                            <p class="text-muted">Agrega la primera variante de este medicamento para comenzar a gestionar el inventario.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createVariantModal">
                                <i class="fas fa-plus me-1"></i> Crear Primera Variante
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Historial y Notas -->
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
                    @if($logs && $logs->count() > 0)
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
                                                @switch($log->model_action)
                                                    @case('destroy')
                                                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </div>
                                                        <span class="ms-2 fw-bold text-danger">Eliminación</span>
                                                        @break
                                        
                                                    @case('update')
                                                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-edit"></i>
                                                        </div>
                                                        <span class="ms-2 fw-bold text-warning">Actualización</span>
                                                        @break
                                
                                                    @case('create')
                                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-plus"></i>
                                                        </div>
                                                        <span class="ms-2 fw-bold text-success">Creación</span>
                                                        @break
                                        
                                                    @default
                                                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-bell"></i>
                                                        </div>
                                                        <span class="ms-2 fw-bold text-info">Notificación</span>
                                                @endswitch
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
                                                {{ Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y') }}
                                                <br>
                                                <small>{{ Carbon\Carbon::parse($log->created_at)->translatedFormat('H:i a') }}</small>
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
                    <input type="hidden" name="model_id" value="{{ $medication->id }}">
                    <input type="hidden" name="type" value="medication">
                    <input type="hidden" name="model_action" value="update">
                    <input type="hidden" name="data" value="creó una nota interna">

                    <div class="mb-3">
                        <label for="note" class="form-label fw-bold">Contenido de la Nota</label>
                        <textarea name="note" id="note" class="form-control" rows="4" 
                                  placeholder="Describe los detalles que deseas agregar al historial de este medicamento..." 
                                  required></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            La nota se asociará automáticamente a tu perfil y al medicamento "{{ $medication->generic_name }}".
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

<!-- Modal: Crear Variante -->
<div class="modal fade" id="createVariantModal" tabindex="-1" aria-labelledby="createVariantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('dif.medication_variants.store') }}">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createVariantModalLabel">
                        <i class="fas fa-pills me-2"></i>
                        Nueva Variante de {{ $medication->generic_name }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="medication_id" value="{{ $medication->id }}">
                    <input type="hidden" name="redirect_to_medication" value="1">

                    <!-- Información Básica -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3 text-primary">
                                <i class="fas fa-info-circle me-1"></i> Información Básica
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="variant_name" class="form-label fw-bold">
                                    Nombre de la Variante <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" id="variant_name" name="name" 
                                       placeholder="ej. Paracetamol 500mg Tabletas" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="variant_sku" class="form-label fw-bold">
                                    SKU / Código <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" id="variant_sku" name="sku" 
                                       placeholder="Se generará automáticamente..." required>
                                <div class="form-text">El código se genera automáticamente al escribir el nombre</div>
                            </div>
                        </div>
                    </div>

                    <!-- Características del Medicamento -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3 text-primary">
                                <i class="fas fa-prescription-bottle-alt me-1"></i> Características del Medicamento
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="variant_type" class="form-label fw-bold">Presentación</label>
                                <select class="form-select" id="variant_type" name="type">
                                    <option value="">Seleccionar presentación...</option>
                                    <option value="Tableta">Tableta</option>
                                    <option value="Cápsula">Cápsula</option>
                                    <option value="Píldora">Píldora</option>
                                    <option value="Supositorio">Supositorio</option>
                                    <option value="Jarabe">Jarabe</option>
                                    <option value="Gotas">Gotas</option>
                                    <option value="Crema">Crema</option>
                                    <option value="Gel">Gel</option>
                                    <option value="Pomada">Pomada</option>
                                    <option value="Spray">Spray</option>
                                    <option value="Parche">Parche</option>
                                    <option value="Inyectable">Inyectable</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="variant_use_type" class="form-label fw-bold">Vía de Administración</label>
                                <select class="form-select" id="variant_use_type" name="use_type">
                                    <option value="">Seleccionar vía...</option>
                                    <option value="Oral">Oral</option>
                                    <option value="Tópica">Tópica</option>
                                    <option value="Oftálmica">Oftálmica</option>
                                    <option value="Ótica">Ótica</option>
                                    <option value="Inyectable">Inyectable</option>
                                    <option value="Intravenosa">Intravenosa</option>
                                    <option value="Intramuscular">Intramuscular</option>
                                    <option value="Subcutánea">Subcutánea</option>
                                    <option value="Rectal">Rectal</option>
                                    <option value="Vaginal">Vaginal</option>
                                    <option value="Nasal">Nasal</option>
                                    <option value="Inhalatoria">Inhalatoria</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Concentración y Precio -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3 text-primary">
                                <i class="fas fa-balance-scale me-1"></i> Concentración y Precio
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="variant_type_num" class="form-label fw-bold">Concentración</label>
                                <input type="text" class="form-control" id="variant_type_num" name="type_num" 
                                       placeholder="ej. 500, 30, 10">
                                <div class="form-text">Cantidad de ingrediente activo</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="variant_type_dosage" class="form-label fw-bold">Unidad de Medida</label>
                                <select class="form-select" id="variant_type_dosage" name="type_dosage">
                                    <option value="">Seleccionar unidad...</option>
                                    <option value="mg">mg (miligramos)</option>
                                    <option value="g">g (gramos)</option>
                                    <option value="ml">ml (mililitros)</option>
                                    <option value="l">l (litros)</option>
                                    <option value="mcg">mcg (microgramos)</option>
                                    <option value="UI">UI (Unidades Internacionales)</option>
                                    <option value="%">% (porcentaje)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="variant_price" class="form-label fw-bold">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="variant_price" name="price" 
                                           step="0.01" min="0" placeholder="0.00">
                                </div>
                                <div class="form-text">Precio por unidad (opcional)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Crear Variante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para mejorar la interactividad -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Configuración para modales
    const createNoteModal = document.getElementById('createManualNoteModal');
    const createVariantModal = document.getElementById('createVariantModal');
    
    // Auto-generar SKU basado en el nombre de la variante
    const variantNameInput = document.getElementById('variant_name');
    const variantSkuInput = document.getElementById('variant_sku');
    
    if (variantNameInput && variantSkuInput) {
        variantNameInput.addEventListener('input', function() {
            const name = this.value.trim();
            if (name && !variantSkuInput.value) {
                // Generar SKU automáticamente
                const medicationSlug = '{{ Str::slug($medication->generic_name, '-') }}';
                const variantSlug = name.toLowerCase()
                    .replace(/[^a-z0-9\s]/g, '')
                    .replace(/\s+/g, '-')
                    .substring(0, 15);
                const randomSuffix = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                const sku = `${medicationSlug}-${variantSlug}-${randomSuffix}`.toUpperCase();
                variantSkuInput.value = sku;
            }
        });
        
        // Limpiar SKU si se borra el nombre
        variantNameInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
                variantSkuInput.value = '';
            }
        });
    }
    
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
            
            if (confirm('⚠️ ¿Estás completamente seguro?\n\nEsta acción eliminará permanentemente el medicamento "{{ $medication->generic_name }}" y todas sus variantes asociadas.\n\nEsta acción NO se puede deshacer.')) {
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
});
</script>

@endsection
