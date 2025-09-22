@extends('layouts.master')
@section('title')Registrar Movimiento de Inventario @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') <a href="{{ route('dif.stock_movements.index') }}">Inventario</a> @endslot
@slot('title') Registrar Movimiento @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Registrar Movimiento de Inventario</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('dif.stock_movements.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="variant_id" class="form-label">Variante de Medicamento <span class="text-danger">*</span></label>
                                <select class="form-select @error('variant_id') is-invalid @enderror" id="variant_id" name="variant_id" required>
                                    <option value="">Seleccionar variante...</option>
                                    @foreach($variants as $variant)
                                        <option value="{{ $variant->id }}" 
                                                data-current-stock="{{ $variant->getCurrentStock() }}"
                                                {{ old('variant_id', $variant_id) == $variant->id ? 'selected' : '' }}>
                                            {{ $variant->medication->generic_name }} - {{ $variant->name }} 
                                            (SKU: {{ $variant->sku }}) - Stock: {{ $variant->getCurrentStock() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('variant_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="movement_type" class="form-label">Tipo de Movimiento <span class="text-danger">*</span></label>
                                        <select class="form-select @error('movement_type') is-invalid @enderror" id="movement_type" name="movement_type" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="inbound" {{ old('movement_type') == 'inbound' ? 'selected' : '' }}>
                                                <i class="fas fa-arrow-down text-success"></i> Entrada (Recepción)
                                            </option>
                                            <option value="outbound" {{ old('movement_type') == 'outbound' ? 'selected' : '' }}>
                                                <i class="fas fa-arrow-up text-danger"></i> Salida (Entrega)
                                            </option>
                                        </select>
                                        @error('movement_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Subtipo para salidas -->
                                <div class="mb-3" id="movement-subtype-group" style="display:none;">
                                    <label for="movement_sub_type" class="form-label">Subtipo de Salida</label>
                                    <select class="form-select @error('movement_sub_type') is-invalid @enderror" id="movement_sub_type" name="movement_sub_type">
                                        <option value="">Seleccionar subtipo...</option>
                                        <option value="entrega_ciudadano">Entrega Ciudadano</option>
                                        <option value="venta">Venta</option>
                                        <option value="merma">Merma</option>
                                        <option value="donacion_externa">Donación Externa</option>
                                    </select>
                                    @error('movement_sub_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Selector de parent (lote/entrada) para salidas -->
                                <div class="col-md-6">
                                    <div class="mb-3" id="parent-group" style="display:none;">
                                        <label for="parent_id" class="form-label">Lote / Entrada vinculada</label>
                                        <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                            <option value="">Seleccionar lote (mostrar fecha de vencimiento)...</option>
                                        </select>
                                        <div class="form-text">Selecciona la entrada (por fecha de vencimiento) que se consumirá.</div>
                                        @error('parent_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Cantidad <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                               id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
                                        <div class="form-text" id="stock-info"></div>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Fecha del Movimiento <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                               id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="expiration_date" class="form-label">Fecha de Vencimiento</label>
                                        <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" 
                                               id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}">
                                        <div class="form-text">Solo para entradas de inventario</div>
                                        @error('expiration_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="external_reference" class="form-label">Referencia Externa / Beneficiario</label>
                                <input type="text" class="form-control @error('external_reference') is-invalid @enderror" 
                                       id="external_reference" name="external_reference" value="{{ old('external_reference') }}"
                                       placeholder="Nombre, Número de factura, orden de compra, etc.">
                                @error('external_reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notas</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3" 
                                          placeholder="Información adicional sobre este movimiento...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
                                <a href="{{ route('dif.stock_movements.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const variantSelect = document.getElementById('variant_id');
    const movementTypeSelect = document.getElementById('movement_type');
    const quantityInput = document.getElementById('quantity');
    const stockInfo = document.getElementById('stock-info');
    const expirationDate = document.getElementById('expiration_date');

    function updateStockInfo() {
        const selectedOption = variantSelect.options[variantSelect.selectedIndex];
        const currentStock = selectedOption.dataset.currentStock || 0;
        const movementType = movementTypeSelect.value;

        if (variantSelect.value) {
            if (movementType === 'outbound') {
                stockInfo.innerHTML = `<span class="text-warning">Stock actual: ${currentStock} unidades disponibles</span>`;
                quantityInput.max = currentStock;
            } else if (movementType === 'inbound') {
                stockInfo.innerHTML = `<span class="text-info">Stock actual: ${currentStock} unidades</span>`;
                quantityInput.removeAttribute('max');
            } else {
                stockInfo.innerHTML = `<span class="text-muted">Stock actual: ${currentStock} unidades</span>`;
            }
        } else {
            stockInfo.innerHTML = '';
        }
    }

    function toggleExpirationDate() {
        const movementType = movementTypeSelect.value;
        if (movementType === 'inbound') {
            expirationDate.disabled = false;
            expirationDate.parentElement.style.display = 'block';
        } else if (movementType === 'outbound') {
            expirationDate.disabled = true;
            expirationDate.value = '';
            expirationDate.parentElement.style.display = 'none';
        }
    }

    variantSelect.addEventListener('change', function() {
        updateStockInfo();
        loadBatches();
    });

    movementTypeSelect.addEventListener('change', function() {
        updateStockInfo();
        toggleExpirationDate();
        toggleOutboundFields();
        if (movementTypeSelect.value === 'outbound') {
            loadBatches();
        }
    });

    // Cuando se seleccione un lote, ajustar max quantity
    const parentSelect = document.getElementById('parent_id');
    parentSelect.addEventListener('change', function() {
        const opt = parentSelect.options[parentSelect.selectedIndex];
        const available = opt ? parseInt(opt.dataset.available || 0) : 0;
        if (available > 0) {
            quantityInput.max = available;
            // Si la cantidad actual excede el disponible, ajustar
            if (parseInt(quantityInput.value || 0) > available) {
                quantityInput.value = available;
            }
            stockInfo.innerHTML = `<span class="text-warning">Stock disponible en lote seleccionado: ${available} unidades</span>`;
        } else {
            quantityInput.removeAttribute('max');
        }
    });

    function toggleOutboundFields() {
        if (movementTypeSelect.value === 'outbound') {
            document.getElementById('movement-subtype-group').style.display = 'block';
            document.getElementById('parent-group').style.display = 'block';
        } else {
            document.getElementById('movement-subtype-group').style.display = 'none';
            document.getElementById('parent-group').style.display = 'none';
            // limpiar selección
            document.getElementById('movement_sub_type').value = '';
            document.getElementById('parent_id').innerHTML = '<option value="">Seleccionar lote (mostrar fecha de vencimiento)...</option>';
        }
    }

    // Cargar lotes via AJAX
    function loadBatches() {
        const variantId = variantSelect.value;
        const parentSelect = document.getElementById('parent_id');

        parentSelect.innerHTML = '<option value="">Cargando lotes...</option>';

        if (!variantId) {
            parentSelect.innerHTML = '<option value="">Selecciona una variante primero</option>';
            return;
        }

        fetch(`{{ route('dif.stock_movements.batches') }}?variant_id=${variantId}`)
            .then(res => res.json())
            .then(json => {
                parentSelect.innerHTML = '<option value="">Seleccionar lote (mostrar fecha de vencimiento)...</option>';
                if (json.data && json.data.length > 0) {
                    json.data.forEach(batch => {
                        const label = batch.expiration_date ? `${batch.expiration_date} — Disponible: ${batch.available_qty}` : `Sin fecha — Disponible: ${batch.available_qty}`;
                        const opt = document.createElement('option');
                        opt.value = batch.parent_id;
                        opt.dataset.available = batch.available_qty;
                        opt.text = label;
                        parentSelect.appendChild(opt);
                    });
                } else {
                    parentSelect.innerHTML = '<option value="">No hay lotes disponibles</option>';
                }
            }).catch(err => {
                parentSelect.innerHTML = '<option value="">Error cargando lotes</option>';
                console.error(err);
            });
    }

    // Inicializar
    updateStockInfo();
    toggleExpirationDate();
    toggleOutboundFields();
    // Si ya es salida por defecto, cargar lotes
    if (movementTypeSelect.value === 'outbound') {
        loadBatches();
    }
});
</script>
@endsection
