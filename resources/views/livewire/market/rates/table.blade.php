<div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="mk-label">Ejercicio</label>
                    <select wire:model.live="filterYear" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mk-label">Tipo</label>
                    <select wire:model.live="filterType" class="form-select">
                        <option value="">Todos</option>
                        @foreach (\App\Models\MarketRate::SPACE_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mk-label">Estatus</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">Todos</option>
                        <option value="activa">Activa</option>
                        <option value="inactiva">Inactiva</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="button" wire:click="clearFilters" class="btn btn-link btn-sm">Limpiar filtros</button>
                    @if ($years->isNotEmpty())
                        <button type="button" wire:click="copyToNextYear" class="btn btn-outline-secondary btn-sm"
                            wire:confirm="¿Copiar las tarifas activas de {{ $years->first() }} al ejercicio {{ $years->first() + 1 }}?">
                            Copiar a {{ $years->first() + 1 }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($rates->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                <h4>No hay tarifas registradas</h4>
                <p class="mb-4">El padrón toma de aquí la cuota mensual de cada espacio.</p>
                <a href="{{ route('market.rates.create') }}" class="btn mk-btn">Crear tarifa</a>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="mk-thead">
                        <tr>
                            <th>Ejercicio</th>
                            <th>Tipo de espacio</th>
                            <th>Artículo</th>
                            <th>Inciso</th>
                            <th>Fracción</th>
                            <th>Descripción</th>
                            <th class="text-end">Monto mensual</th>
                            <th class="text-center">Espacios ligados</th>
                            <th>Estatus</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rates as $rate)
                            <tr wire:key="rate-{{ $rate->id }}">
                                <td class="fw-semibold mk-link">{{ $rate->fiscal_year }}</td>
                                <td class="fw-semibold">{{ $rate->space_type_label }}</td>
                                <td>{{ $rate->article }}</td>
                                <td>{{ $rate->subsection }}</td>
                                <td>{{ $rate->fraction }}</td>
                                <td>{{ $rate->description }}</td>
                                <td class="text-end fw-semibold">${{ number_format($rate->monthly_amount, 2) }}</td>
                                <td class="text-center">{{ $rate->stalls_count }}</td>
                                <td>
                                    <span @class(['badge rounded-pill', 'bg-success-subtle text-success' => $rate->is_active, 'bg-secondary-subtle text-secondary' => ! $rate->is_active])>
                                        {{ $rate->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('market.rates.edit', $rate) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
                                    <button type="button" wire:click="toggle({{ $rate->id }})" class="btn btn-outline-secondary btn-sm"
                                        @if ($rate->is_active) wire:confirm="¿Desactivar esta tarifa? Ya no se podrá asignar a nuevos espacios." @endif>
                                        {{ $rate->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
