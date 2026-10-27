<div>
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card h-100 mb-0"><div class="card-body">
                <label class="mk-label">Fecha del corte</label>
                <input type="date" wire:model.live="cutDate" class="form-control form-control-sm" max="{{ now()->toDateString() }}">
            </div></div>
        </div>
        @foreach (['Elaboró' => auth()->user()->name, 'Boletas' => $tickets->count(), 'Total sistema' => '$'.number_format($total, 2)] as $label => $value)
            <div class="col-md-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <p class="mk-label mb-1">{{ $label }}</p>
                    <h5 class="mb-0">{{ $value }}</h5>
                </div></div>
            </div>
        @endforeach
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h6>Boletas cobradas que aún no están en ningún corte</h6>
            @if ($tickets->isEmpty())
                <p class="text-muted mb-0">No hay boletas pendientes de corte hasta esta fecha.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="mk-soft"><tr><th>Folio</th><th>Locatario</th><th>Espacio</th><th>Mes/Año</th><th>Art.</th><th>Inc.</th><th>Frac.</th><th class="text-end">Importe</th></tr></thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr wire:key="ct-{{ $ticket->id }}">
                                    <td><a href="{{ route('market.tickets.show', $ticket) }}" class="mk-link fw-semibold">{{ $ticket->folio_label }}</a></td>
                                    <td>{{ $ticket->stall->tenant_name }}</td>
                                    <td>{{ $ticket->stall->space_label }}</td>
                                    <td>{{ mb_strtoupper($ticket->period->translatedFormat('M/Y')) }}</td>
                                    <td>{{ $ticket->article }}</td>
                                    <td>{{ $ticket->subsection }}</td>
                                    <td>{{ $ticket->fraction }}</td>
                                    <td class="text-end">${{ number_format($ticket->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <form wire:submit="close" class="card">
        <div class="card-header mk-section-header">Conciliación y entrega a Tesorería</div>
        <div class="card-body">
            <div class="row g-3 align-items-start">
                <div class="col-md-3">
                    <label class="form-label">Efectivo contado *</label>
                    <input type="number" step="0.01" min="0" wire:model.live.debounce.300ms="cashCounted" class="form-control" placeholder="0.00">
                    @error('cashCounted')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-2">
                    <p class="mk-label mb-1">Total sistema</p>
                    <p class="fs-5 fw-semibold mb-0">${{ number_format($total, 2) }}</p>
                </div>
                <div class="col-md-2">
                    <p class="mk-label mb-1">Diferencia</p>
                    @if ($difference === null)
                        <p class="fs-5 mb-0">—</p>
                    @else
                        <p @class(['fs-5 fw-semibold mb-0', 'text-success' => $difference == 0, 'text-danger' => $difference != 0])>${{ number_format($difference, 2) }}</p>
                        <small @class(['text-success' => $difference == 0, 'text-danger' => $difference != 0])>{{ $difference == 0 ? 'El efectivo cuadra con el sistema.' : 'No cuadra: explica la diferencia.' }}</small>
                    @endif
                </div>
                <div class="col-md-5">
                    <label class="form-label">Recibió en Tesorería *</label>
                    <input type="text" wire:model="receivedBy" class="form-control" placeholder="C.P. Laura Ibarra Solís">
                    @error('receivedBy')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Observaciones {{ $difference ? '*' : '' }}</label>
                    <textarea wire:model="notes" rows="2" class="form-control"></textarea>
                    @error('notes')<small class="text-danger">{{ $message }}</small>@enderror
                    @error('cutDate')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Al cerrar, el corte queda entregado a Tesorería y sus boletas ya no se pueden cancelar desde Mercado.</small>
            <button type="submit" class="btn mk-btn" @disabled($tickets->isEmpty()) wire:loading.attr="disabled"
                wire:confirm="¿Cerrar el corte y registrarlo como entregado a Tesorería?">Cerrar, entregar e imprimir relación</button>
        </div>
    </form>
</div>
