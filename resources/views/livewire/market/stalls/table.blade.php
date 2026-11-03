<div>
    {{-- Cartera: las tarjetas filtran el padrón --}}
    <div class="row g-3 mb-4">
        @foreach ($kpis as $key => [$label, $value, $color, $hint])
            <div class="col-md-3">
                <button type="button" wire:click="$set('filterStatus', '{{ $filterStatus === $key ? '' : $key }}')"
                    @class(["card w-100 text-start h-100 mb-0 border-start border-4 border-$color", 'shadow' => $filterStatus === $key])>
                    <div class="card-body py-3">
                        <p class="mk-label mb-1">{{ $label }}</p>
                        <h4 class="mb-0 text-{{ $color }}">{{ $value }}</h4>
                        <small class="text-muted">{{ $hint }}</small>
                    </div>
                </button>
            </div>
        @endforeach
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-lg-4">
                    <label class="mk-label">Buscar</label>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Nombre, núm. de padrón o espacio">
                </div>
                <div class="col-lg-2">
                    <label class="mk-label">Tipo</label>
                    <select wire:model.live="filterType" class="form-select">
                        <option value="">Todos</option>
                        @foreach (\App\Models\MarketRate::SPACE_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="mk-label">Ubicación</label>
                    <select wire:model.live="filterLocation" class="form-select">
                        <option value="">Todas</option>
                        @foreach (\App\Models\MarketStall::LOCATIONS as $location)
                            <option value="{{ $location }}">{{ $location }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="mk-label">Giro</label>
                    <select wire:model.live="filterBusiness" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($businesses as $business)
                            <option value="{{ $business }}">{{ $business }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="mk-label">Estatus de pago</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">Todos</option>
                        <option value="con_adeudo">Con adeudo</option>
                        @foreach (\App\Models\MarketStall::PAYMENT_STATUSES as $key => [$label])
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="text-end mt-2">
                <button type="button" wire:click="clearFilters" class="btn btn-link btn-sm p-0">Limpiar filtros</button>
            </div>
        </div>
    </div>

    <p class="text-muted small mb-2">{{ $stalls->count() }} registro(s)</p>

    @if ($stalls->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                <h4>No hay registros que coincidan</h4>
                <p class="mb-0">Ajusta los filtros o da de alta un nuevo registro.</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="mk-thead">
                        <tr>
                            <th>Núm. padrón</th>
                            <th>Locatario</th>
                            <th>Espacio</th>
                            <th>Ubicación</th>
                            <th>Giro</th>
                            <th class="text-end">Cuota</th>
                            <th class="text-center">Meses de adeudo</th>
                            @if ($debtView)
                                <th class="text-end">Monto adeudado</th>
                                <th>Última gestión</th>
                            @endif
                            <th>Estatus de pago</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stalls as $stall)
                            <tr wire:key="stall-{{ $stall->id }}">
                                <td><a href="{{ route('market.stalls.show', $stall) }}" class="fw-semibold mk-link">{{ $stall->number }}</a></td>
                                <td class="fw-semibold">{{ $stall->tenant_name }}</td>
                                <td>{{ $stall->space_label }}{{ $stall->aisle ? ' · Pasillo '.$stall->aisle : '' }}</td>
                                <td>{{ $stall->location }}</td>
                                <td>{{ $stall->business }}</td>
                                <td class="text-end">${{ number_format($stall->rate->monthly_amount, 2) }}</td>
                                <td @class(['text-center fw-semibold', 'text-danger' => $stall->months_owed > 0])>{{ $stall->months_owed }}</td>
                                @if ($debtView)
                                    <td class="text-end fw-semibold">${{ number_format($stall->debt, 2) }}</td>
                                    <td class="small">
                                        @if ($note = $stall->collectionNotes->first())
                                            {{ $note->date->format('d/m/Y') }} · {{ \Illuminate\Support\Str::limit($note->comment, 30) }}
                                        @else
                                            <span class="text-muted">Sin gestiones</span>
                                        @endif
                                    </td>
                                @endif
                                <td><span class="badge rounded-pill bg-{{ $stall->payment_status_color }}-subtle text-{{ $stall->payment_status_color }}">{{ $stall->payment_status_label }}</span></td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('market.stalls.show', $stall) }}" class="btn btn-outline-secondary btn-sm">Ver detalle</a>
                                    @if ($debtView)
                                        <button type="button" wire:click="openNote({{ $stall->id }})" class="btn btn-outline-secondary btn-sm">Registrar gestión</button>
                                        @if (in_array($stall->payment_status, ['vencido', 'moroso']))
                                            <button type="button" wire:click="$set('noticeStallId', {{ $stall->id }})" class="btn btn-outline-secondary btn-sm">Imprimir aviso</button>
                                        @endif
                                    @endif
                                    @if ($stall->status === 'activo')
                                        <a href="{{ route('market.tickets.collect', ['stall' => $stall->id]) }}" class="btn mk-btn btn-sm">Cobrar</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($noteStall)
        @include('livewire.market.stalls._note_modal', ['stall' => $noteStall])
    @endif

    @if ($noticeStall)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="d-flex justify-content-end gap-2 p-2 mk-no-print">
                        <button type="button" class="btn mk-btn btn-sm" onclick="window.print()">Imprimir</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('noticeStallId', null)">Cerrar</button>
                    </div>
                    @include('market.stalls._debt_notice', ['stall' => $noticeStall])
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif
</div>
