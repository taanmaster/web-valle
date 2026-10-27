<div>
    <form wire:submit="save">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mb-3">
            <div class="card-header mk-section-header">Locatario</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Nombre completo *</label>
                        <input type="text" wire:model="tenant_name" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Teléfono *</label>
                        <input type="tel" wire:model="phone" maxlength="10" class="form-control" placeholder="456 000 0000">
                        <small class="text-muted">Con él se relacionan los otros espacios de la misma persona.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header mk-section-header">Espacio</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Núm. de padrón *</label>
                        <input type="text" wire:model="number" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo de espacio *</label>
                        <select wire:model.live="space_type" class="form-select">
                            <option value="">Selecciona...</option>
                            @foreach (\App\Models\MarketRate::SPACE_TYPES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Núm. de espacio *</label>
                        <input type="text" wire:model="space_number" class="form-control" placeholder="PL-21">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pasillo</label>
                        <input type="text" wire:model="aisle" class="form-control" placeholder="D">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ubicación *</label>
                        <select wire:model="location" class="form-select">
                            <option value="">Selecciona...</option>
                            @foreach (\App\Models\MarketStall::LOCATIONS as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Giro *</label>
                        <input type="text" wire:model="business" class="form-control" list="market-businesses" placeholder="Escribe para buscar...">
                        <datalist id="market-businesses">
                            @foreach (\App\Models\MarketStall::BUSINESSES as $business)
                                <option value="{{ $business }}">
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header mk-section-header">Cobro</div>
            <div class="card-body">
                <label class="form-label">Tarifa *</label>
                <select wire:model.live="market_rate_id" class="form-select" @disabled(! $space_type)>
                    <option value="">{{ $space_type ? 'Selecciona la tarifa...' : 'Elige primero el tipo de espacio' }}</option>
                    @foreach ($rates as $rate)
                        <option value="{{ $rate->id }}">{{ $rate->fiscal_year }} · {{ $rate->description }} · {{ $rate->legal_basis }} · ${{ number_format($rate->monthly_amount, 2) }}</option>
                    @endforeach
                </select>
                @if ($space_type && $rates->isEmpty())
                    <small class="text-danger">No hay tarifas activas para este tipo de espacio. <a href="{{ route('market.rates.create') }}">Crear tarifa</a></small>
                @endif
                <div class="row g-2 mt-2">
                    @foreach (['Cuota mensual' => $selectedRate ? '$'.number_format($selectedRate->monthly_amount, 2) : '—', 'Artículo' => $selectedRate->article ?? '—', 'Inciso' => $selectedRate->subsection ?? '—', 'Fracción' => $selectedRate->fraction ?? '—'] as $label => $value)
                        <div class="col-md-3">
                            <div class="mk-soft rounded-3 p-2">
                                <p class="mk-label mb-0">{{ $label }}</p>
                                <p class="fw-semibold mb-0">{{ $value }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Cuota, artículo, inciso y fracción se toman de la tarifa y no se editan aquí.</small>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header mk-section-header">Control</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha de alta</label>
                        <input type="date" wire:model="registered_at" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mes desde el que debe pagar *</label>
                        <input type="month" wire:model="billing_month" class="form-control">
                        <small class="text-muted">El adeudo se cuenta desde este mes.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ $stall ? route('market.stalls.show', $stall) : route('market.stalls.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn mk-btn">Guardar registro</button>
        </div>
    </form>
</div>
