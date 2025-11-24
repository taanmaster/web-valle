<div>

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Registrar Movimiento de Inventario</h5>
                        </div>

                        <div class="card-body">
                            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="mb-3">
                                    <label for="variant_id" class="form-label">Variante de Medicamento <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('variant_id') is-invalid @enderror"
                                        id="variant_id" name="variant_id" required>
                                        <option value="">Seleccionar variante...</option>
                                        @foreach ($variants as $variant)
                                            <option value="{{ $variant->id }}"
                                                data-current-stock="{{ $variant->getCurrentStock() }}"
                                                {{ old('variant_id', $variant_id) == $variant->id ? 'selected' : '' }}>
                                                {{ $variant->medication->generic_name }} - {{ $variant->name }}
                                                (SKU: {{ $variant->sku }})
                                                - Stock: {{ $variant->getCurrentStock() }}
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
                                            <label for="movement_type" class="form-label">Tipo de Movimiento <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('movement_type') is-invalid @enderror"
                                                id="movement_type" name="movement_type" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="inbound"
                                                    {{ old('movement_type') == 'inbound' ? 'selected' : '' }}>
                                                    <i class="fas fa-arrow-down text-success"></i> Entrada (Recepción)
                                                </option>
                                                <option value="outbound"
                                                    {{ old('movement_type') == 'outbound' ? 'selected' : '' }}>
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
                                        <select class="form-select @error('movement_sub_type') is-invalid @enderror"
                                            id="movement_sub_type" name="movement_sub_type">
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
                                            <select class="form-select @error('parent_id') is-invalid @enderror"
                                                id="parent_id" name="parent_id">
                                                <option value="">Seleccionar lote (mostrar fecha de
                                                    vencimiento)...</option>
                                            </select>
                                            <div class="form-text">Selecciona la entrada (por fecha de vencimiento) que
                                                se consumirá.</div>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Cantidad <span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                id="quantity" name="quantity" value="{{ old('quantity') }}"
                                                min="1" required>
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
                                            <label for="date" class="form-label">Fecha del Movimiento <span
                                                    class="text-danger">*</span></label>
                                            <input type="date"
                                                class="form-control @error('date') is-invalid @enderror" id="date"
                                                name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="expiration_date" class="form-label">Fecha de Vencimiento</label>
                                            <input type="date"
                                                class="form-control @error('expiration_date') is-invalid @enderror"
                                                id="expiration_date" name="expiration_date"
                                                value="{{ old('expiration_date') }}">
                                            <div class="form-text">Solo para entradas de inventario</div>
                                            @error('expiration_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="external_reference" class="form-label">Referencia Externa /
                                        Beneficiario</label>
                                    <input type="text"
                                        class="form-control @error('external_reference') is-invalid @enderror"
                                        id="external_reference" name="external_reference"
                                        value="{{ old('external_reference') }}"
                                        placeholder="Nombre, Número de factura, orden de compra, etc.">
                                    @error('external_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notas</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"
                                        placeholder="Información adicional sobre este movimiento...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
                                    <a href="{{ route('dif.stock_movements.index') }}"
                                        class="btn btn-secondary">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
