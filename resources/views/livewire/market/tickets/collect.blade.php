<div>
    @if (! $stall)
        {{-- 1. Buscar locatario --}}
        <div class="card">
            <div class="card-body">
                <label class="form-label fw-semibold">Buscar locatario por nombre, padrón o espacio</label>
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control mb-3" placeholder="Ej. Graciela, P-004 o PL-21" autofocus>
                <div class="list-group list-group-flush">
                    @forelse ($results as $result)
                        <button type="button" wire:click="selectStall({{ $result->id }})" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" wire:key="r-{{ $result->id }}">
                            <span>
                                <span class="fw-semibold mk-link me-2">{{ $result->number }}</span>
                                <span class="fw-semibold">{{ $result->tenant_name }}</span>
                                <small class="d-block text-muted">{{ $result->space_label }} · {{ $result->location }} · {{ $result->business }}</small>
                            </span>
                            <span class="d-flex align-items-center gap-2">
                                <small class="text-muted">{{ $result->months_owed ? $result->months_owed.' mes(es) por pagar' : 'Al corriente' }}</small>
                                <span class="badge rounded-pill bg-{{ $result->payment_status_color }}-subtle text-{{ $result->payment_status_color }}">{{ $result->payment_status_label }}</span>
                                <span class="mk-link small">Seleccionar →</span>
                            </span>
                        </button>
                    @empty
                        <p class="text-muted mb-0">No se encontraron locatarios activos.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        {{-- Locatario seleccionado --}}
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="fw-semibold mb-0">{{ $stall->tenant_name }}</p>
                    <small class="text-muted">{{ $stall->number }} · {{ $stall->space_label }} · Cuota ${{ number_format($stall->rate->monthly_amount, 2) }} · {{ $stall->rate->legal_basis }}</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill bg-{{ $stall->payment_status_color }}-subtle text-{{ $stall->payment_status_color }}">{{ $stall->payment_status_label }}</span>
                    <button type="button" wire:click="changeStall" class="btn btn-outline-secondary btn-sm">Cambiar locatario</button>
                </div>
            </div>
        </div>

        {{-- Recibos de Tesorería listos para entregarle --}}
        @if ($pendingReceipts->isNotEmpty())
            <div class="card mb-3 border-info">
                <div class="card-body">
                    <h6 class="mb-1"><i class="ti ti-receipt"></i> Tiene {{ $pendingReceipts->count() }} recibo(s) de Tesorería por entregar</h6>
                    <small class="text-muted d-block mb-2">Aprovecha que está en ventanilla para entregárselos.</small>
                    @foreach ($pendingReceipts as $receipt)
                        <div class="form-check" wire:key="pr-{{ $receipt->id }}">
                            <input class="form-check-input" type="checkbox" wire:model="deliverIds" value="{{ $receipt->id }}" id="pr-{{ $receipt->id }}">
                            <label class="form-check-label small" for="pr-{{ $receipt->id }}">
                                {{ $receipt->folio_label }} · {{ $receipt->period_label }} · {{ $receipt->stall->space_label }}
                                · <a href="{{ $receipt->receipt_s3_url }}" target="_blank" rel="noopener">ver recibo</a>
                            </label>
                        </div>
                    @endforeach
                    <div class="d-flex gap-2 align-items-end mt-2">
                        <div>
                            <label class="mk-label">Recibió (puede ser otra persona)</label>
                            <input type="text" wire:model="deliverTo" class="form-control form-control-sm">
                        </div>
                        <button type="button" wire:click="deliver" class="btn btn-info btn-sm">Registrar entrega</button>
                    </div>
                    @error('deliverIds')<small class="text-danger d-block">{{ $message }}</small>@enderror
                    @error('deliverTo')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
            </div>
        @endif

        {{-- 2. Meses a cobrar --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="mb-0">Meses pendientes</h6>
                        <small class="text-muted">Del más antiguo al más reciente. Se emite una boleta por cada mes.</small>
                    </div>
                    @if ($stall->months_owed > 1)
                        <button type="button" wire:click="selectAll" class="btn btn-outline-secondary btn-sm">Seleccionar todos</button>
                    @endif
                </div>
                @forelse ($stall->unpaid_periods as $period)
                    @php $key = $period->format('Y-m'); $current = $period->isSameMonth(now()); @endphp
                    <label @class(['d-flex justify-content-between align-items-center border rounded-3 p-2 mb-1', 'border-danger bg-danger-subtle' => in_array($key, $periods)]) wire:key="p-{{ $key }}">
                        <span>
                            <input class="form-check-input me-2" type="checkbox" wire:model.live="periods" value="{{ $key }}">
                            <span class="fw-semibold">{{ ucfirst($period->translatedFormat('F Y')) }}</span>
                        </span>
                        <span class="d-flex gap-3 align-items-center">
                            <span @class(['badge rounded-pill', 'bg-warning-subtle text-warning' => $current, 'bg-danger-subtle text-danger' => ! $current])>{{ $current ? 'Mes actual' : 'Vencido' }}</span>
                            <span class="fw-semibold">${{ number_format($stall->rate->monthly_amount, 2) }}</span>
                        </span>
                    </label>
                @empty
                    <p class="text-success mb-0"><i class="ti ti-check"></i> Está al corriente; no tiene meses por pagar.</p>
                @endforelse
                @error('periods')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
            </div>
            @if ($stall->months_owed)
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>{{ count($periods) }} mes(es) seleccionado(s) · Total <strong class="fs-5">${{ number_format($selectedTotal, 2) }}</strong></span>
                    <button type="button" wire:click="collect" class="btn btn-success" wire:loading.attr="disabled" @disabled(! count($periods))
                        wire:confirm="¿Cobrar ${{ number_format($selectedTotal, 2) }} en efectivo y emitir {{ count($periods) }} boleta(s)?">
                        Cobrar e imprimir
                    </button>
                </div>
            @endif
        </div>
    @endif

    {{-- Boletas emitidas: 3 tantos por boleta --}}
    @if ($issued->isNotEmpty())
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="d-flex justify-content-between align-items-center gap-2 p-2 mk-no-print">
                        <span class="ms-2 fw-semibold">Boletas · {{ $issued->count() }} hoja(s) carta con 3 tantos</span>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn mk-btn btn-sm" onclick="window.print()">Imprimir</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('issuedIds', [])">Cerrar</button>
                        </div>
                    </div>
                    <div class="modal-body mk-print-area">
                        @foreach ($issued as $ticket)
                            @include('market.tickets._print', ['ticket' => $ticket])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif
</div>
