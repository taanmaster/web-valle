<div>
    {{-- Etapas --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" wire:click="$set('stage', '')" @class(['btn btn-sm rounded-pill', 'btn-dark' => ! $stage, 'btn-outline-dark' => $stage])>Todas · {{ $total }}</button>
        @foreach (\App\Models\MarketTicket::STAGES as $key => [$label, $color])
            <button type="button" wire:click="$set('stage', '{{ $key }}')"
                @class(['btn btn-sm rounded-pill', "btn-$color" => $stage === $key, "btn-outline-$color" => $stage !== $key])>
                {{ $label }} · {{ $counts[$key] }}
            </button>
        @endforeach
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="mk-label">Buscar</label>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Folio, locatario, padrón o espacio">
                </div>
                <div class="col-md-3">
                    <label class="mk-label">Emitida desde</label>
                    <input type="date" wire:model.live="dateFrom" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="mk-label">Hasta</label>
                    <input type="date" wire:model.live="dateTo" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="button" wire:click="clearFilters" class="btn btn-link btn-sm p-0">Limpiar</button>
                </div>
            </div>
        </div>
    </div>

    @if ($tickets->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                <h4>No hay boletas en esta etapa</h4>
                <p class="mb-0">Las boletas se emiten desde «Cobrar».</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="mk-thead">
                        <tr>
                            <th>Serie-Folio</th>
                            <th>Emitida</th>
                            <th>Locatario</th>
                            <th>Padrón</th>
                            <th>Espacio</th>
                            <th>Mes pagado</th>
                            <th class="text-end">Importe</th>
                            <th>Etapa</th>
                            <th class="text-end">Días</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            @php
                                // Días que lleva esperando en su etapa (recibo pendiente o por entregar)
                                $since = match ($ticket->stage) {
                                    'en_tesoreria' => $ticket->cut?->created_at,
                                    'recibo_listo' => $ticket->receipt_attached_at,
                                    default => null,
                                };
                            @endphp
                            <tr wire:key="t-{{ $ticket->id }}">
                                <td><a href="{{ route('market.tickets.show', $ticket) }}" class="fw-semibold mk-link">{{ $ticket->folio_label }}</a></td>
                                <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                <td class="fw-semibold">{{ $ticket->stall->tenant_name }}</td>
                                <td>{{ $ticket->stall->number }}</td>
                                <td>{{ $ticket->stall->space_label }}</td>
                                <td>{{ $ticket->period_label }}</td>
                                <td class="text-end fw-semibold">${{ number_format($ticket->amount, 2) }}</td>
                                <td><span class="badge rounded-pill bg-{{ $ticket->stage_color }}-subtle text-{{ $ticket->stage_color }}">{{ $ticket->stage_label }}</span></td>
                                <td @class(['text-end', 'text-danger fw-semibold' => $since && $since->diffInDays() > 30])>{{ $since ? (int) $since->diffInDays() : '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $tickets->links() }}</div>
    @endif
</div>
