<div>
    <form wire:submit="save" class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Ejercicio fiscal *</label>
                    <select wire:model.live="fiscal_year" class="form-select">
                        @foreach (range(now()->year - 1, now()->year + 1) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipo de espacio *</label>
                    <select wire:model.live="space_type" class="form-select">
                        <option value="">Selecciona...</option>
                        @foreach (\App\Models\MarketRate::SPACE_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Artículo *</label>
                    <input type="text" wire:model.live.debounce.300ms="article" class="form-control" placeholder="11">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Inciso *</label>
                    <input type="text" wire:model.live.debounce.300ms="subsection" class="form-control text-uppercase" placeholder="D">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fracción *</label>
                    <input type="text" wire:model.live.debounce.300ms="fraction" class="form-control text-uppercase" placeholder="XI">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Monto mensual *</label>
                    <input type="number" step="0.01" min="0" wire:model.live.debounce.300ms="monthly_amount" class="form-control" placeholder="151.00">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Descripción *</label>
                    <input type="text" wire:model="description" class="form-control" placeholder="Plancha zona sur">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Vigente desde *</label>
                    <input type="date" wire:model="effective_from" class="form-control">
                </div>
            </div>

            <div class="mk-soft rounded-3 p-3 mt-3">
                <p class="mk-label mb-0">Así aparecerá en el padrón</p>
                <p class="fw-semibold mb-0">{{ $preview }}</p>
            </div>

            @if ($linked)
                <div class="alert alert-info mt-3 mb-0">
                    Esta tarifa tiene {{ $linked }} espacio(s) ligado(s). Si cambias el monto, su cuota se actualizará a partir de la fecha de vigencia; las boletas ya emitidas conservan su monto y fundamento.
                </div>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('market.rates.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn mk-btn">Guardar tarifa</button>
        </div>
    </form>
</div>
