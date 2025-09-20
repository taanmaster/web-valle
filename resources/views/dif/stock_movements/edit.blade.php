@extends('layouts.master')
@section('title')Editar Movimiento #{{ $movement->id }} @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') <a href="{{ route('dif.stock_movements.index') }}">Inventario</a> @endslot
@slot('li_4') <a href="{{ route('dif.stock_movements.show', $movement->id) }}">Movimiento #{{ $movement->id }}</a> @endslot
@slot('title') Editar Movimiento @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Editar Movimiento de Inventario #{{ $movement->id }}</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('dif.stock_movements.update', $movement->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="variant_id" class="form-label">Variante de Medicamento <span class="text-danger">*</span></label>
                                <select class="form-select @error('variant_id') is-invalid @enderror" id="variant_id" name="variant_id" required>
                                    <option value="">Seleccionar variante...</option>
                                    @foreach($variants as $variant)
                                        <option value="{{ $variant->id }}" 
                                                data-current-stock="{{ $variant->getCurrentStock() }}"
                                                {{ old('variant_id', $movement->variant_id) == $variant->id ? 'selected' : '' }}>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="movement_type" class="form-label">Tipo de Movimiento <span class="text-danger">*</span></label>
                                        <select class="form-select @error('movement_type') is-invalid @enderror" id="movement_type" name="movement_type" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="inbound" {{ old('movement_type', $movement->movement_type) == 'inbound' ? 'selected' : '' }}>
                                                Entrada (Recepción)
                                            </option>
                                            <option value="outbound" {{ old('movement_type', $movement->movement_type) == 'outbound' ? 'selected' : '' }}>
                                                Salida (Entrega)
                                            </option>
                                        </select>
                                        @error('movement_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Cantidad <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                               id="quantity" name="quantity" value="{{ old('quantity', $movement->quantity) }}" min="1" required>
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
                                               id="date" name="date" value="{{ old('date', $movement->date->format('Y-m-d')) }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="expiration_date" class="form-label">Fecha de Vencimiento</label>
                                        <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" 
                                               id="expiration_date" name="expiration_date" value="{{ old('expiration_date', $movement->expiration_date?->format('Y-m-d')) }}">
                                        <div class="form-text">Solo para entradas de inventario</div>
                                        @error('expiration_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="external_reference" class="form-label">Referencia Externa</label>
                                <input type="text" class="form-control @error('external_reference') is-invalid @enderror" 
                                       id="external_reference" name="external_reference" value="{{ old('external_reference', $movement->external_reference) }}"
                                       placeholder="Número de factura, orden de compra, etc.">
                                @error('external_reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notas</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3" 
                                          placeholder="Información adicional sobre este movimiento...">{{ old('notes', $movement->additional_info['notes'] ?? '') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Actualizar Movimiento</button>
                                <a href="{{ route('dif.stock_movements.show', $movement->id) }}" class="btn btn-secondary">Cancelar</a>
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

    variantSelect.addEventListener('change', updateStockInfo);
    movementTypeSelect.addEventListener('change', function() {
        updateStockInfo();
        toggleExpirationDate();
    });

    // Inicializar
    updateStockInfo();
    toggleExpirationDate();
});
</script>
@endsection
