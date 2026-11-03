<div>
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <p class="mk-eyebrow mb-1">5 · Corte del día</p>
            <h4 class="mb-0">Corte del {{ $cut->cut_date->format('d/m/Y') }}</h4>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge rounded-pill bg-success-subtle text-success">Entregado a Tesorería</span>
            <button type="button" wire:click="$set('showPrint', true)" class="btn btn-outline-secondary btn-sm">Imprimir relación</button>
        </div>
    </div>

    <div class="row g-3 mb-3">
        @foreach (['Elaboró' => $cut->creator->name ?? '—', 'Boletas' => $cut->tickets_count, 'Total sistema' => '$'.number_format($cut->system_total, 2), 'Efectivo contado' => '$'.number_format($cut->cash_counted, 2)] as $label => $value)
            <div class="col-md-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <p class="mk-label mb-1">{{ $label }}</p>
                    <h5 class="mb-0">{{ $value }}</h5>
                </div></div>
            </div>
        @endforeach
    </div>

    <div @class(['alert', 'alert-success' => $cut->difference == 0, 'alert-danger' => $cut->difference != 0])>
        Entregado a Tesorería el {{ $cut->created_at->format('d/m/Y H:i') }} · Recibió {{ $cut->treasury_received_by }} ·
        Diferencia <strong>${{ number_format($cut->difference, 2) }}</strong>
        @if ($cut->notes)<br><small>{{ $cut->notes }}</small>@endif
    </div>

    {{-- Recibos de Tesorería en bloque --}}
    <div @class(['card mb-3', 'border-warning' => $missing->isNotEmpty()])>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h6 class="mb-0">Recibos de Tesorería</h6>
                    <small class="text-muted">
                        {{ $missing->isEmpty() ? 'Todos los recibos de este corte están adjuntos.' : 'Faltan '.$missing->count().' de '.$tickets->whereNull('cancelled_at')->count().'. Sube todos los archivos a la vez: si el nombre trae el folio (p. ej. «A-01311.pdf») se asignan solos.' }}
                    </small>
                </div>
                @if ($missing->isNotEmpty())
                    <label class="btn mk-btn btn-sm mb-0">
                        Subir recibos
                        <input type="file" class="d-none" wire:model="bulk" multiple accept=".pdf,.jpg,.jpeg,.png">
                    </label>
                @endif
            </div>
            <span wire:loading wire:target="bulk" class="small text-muted">Subiendo y emparejando...</span>
            @error('bulk.*')<small class="text-danger d-block">{{ $message }}</small>@enderror

            @if (count($bulk))
                <div class="border rounded-3 p-3 mt-3">
                    <p class="small fw-semibold mb-2">Estos archivos no traen un folio reconocible. Asígnalos a mano:</p>
                    @foreach ($bulk as $i => $file)
                        <div class="d-flex gap-2 align-items-center mb-2" wire:key="um-{{ $i }}">
                            <span class="small text-truncate flex-grow-1">{{ $file->getClientOriginalName() }}</span>
                            <select wire:model="assign.{{ $i }}" class="form-select form-select-sm w-auto">
                                <option value="">Boleta...</option>
                                @foreach ($missing as $ticket)
                                    <option value="{{ $ticket->id }}">{{ $ticket->folio_label }} · {{ $ticket->stall->tenant_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                    <div class="d-flex gap-2">
                        <button type="button" wire:click="assignUnmatched" class="btn mk-btn btn-sm">Asignar</button>
                        <button type="button" wire:click="discardUnmatched" class="btn btn-outline-secondary btn-sm">Descartar</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="mk-thead"><tr><th>Folio</th><th>Locatario</th><th>Espacio</th><th>Mes/Año</th><th>Art.</th><th>Inc.</th><th>Frac.</th><th class="text-end">Importe</th><th>Recibo</th><th>Etapa</th></tr></thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr wire:key="cs-{{ $ticket->id }}">
                            <td><a href="{{ route('market.tickets.show', $ticket) }}" class="mk-link fw-semibold">{{ $ticket->folio_label }}</a></td>
                            <td>{{ $ticket->stall->tenant_name }}</td>
                            <td>{{ $ticket->stall->space_label }}</td>
                            <td>{{ mb_strtoupper($ticket->period->translatedFormat('M/Y')) }}</td>
                            <td>{{ $ticket->article }}</td>
                            <td>{{ $ticket->subsection }}</td>
                            <td>{{ $ticket->fraction }}</td>
                            <td class="text-end">${{ number_format($ticket->amount, 2) }}</td>
                            <td>
                                @if ($ticket->receipt_s3_url)
                                    <a href="{{ $ticket->receipt_s3_url }}" target="_blank" rel="noopener" class="small text-success">✓ {{ \Illuminate\Support\Str::limit($ticket->receipt_name, 18) }}</a>
                                @elseif (! $ticket->cancelled_at)
                                    <label class="small mk-link text-decoration-underline mb-0">Adjuntar<input type="file" class="d-none" wire:model="single.{{ $ticket->id }}" accept=".pdf,.jpg,.jpeg,.png"></label>
                                    <span wire:loading wire:target="single.{{ $ticket->id }}" class="small text-muted">...</span>
                                @endif
                            </td>
                            <td><span class="badge rounded-pill bg-{{ $ticket->stage_color }}-subtle text-{{ $ticket->stage_color }}">{{ $ticket->stage_label }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($showPrint)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="d-flex justify-content-end gap-2 p-2 mk-no-print">
                        <button type="button" class="btn mk-btn btn-sm" onclick="window.print()">Imprimir</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showPrint', false)">Cerrar</button>
                    </div>
                    <div class="modal-body px-5 pb-5 mk-print-area">
                        <div class="d-flex justify-content-between align-items-center border-bottom border-2 mk-border pb-3">
                            <div class="d-flex align-items-center gap-3">
                                <span class="mk-seal">VS</span>
                                <div>
                                    <p class="mk-eyebrow mb-0">Municipio de Valle de Santiago, Gto. · Mercado Municipal</p>
                                    <h5 class="mb-0">Relación de corte diario</h5>
                                </div>
                            </div>
                            <div class="text-end small">
                                <p class="mb-0">Fecha del corte: <strong>{{ $cut->cut_date->format('d/m/Y') }}</strong></p>
                                <p class="mb-0">Elaboró: <strong>{{ $cut->creator->name ?? '' }}</strong></p>
                            </div>
                        </div>
                        <table class="table table-sm small mt-3">
                            <thead class="table-light"><tr><th>Folio</th><th>Locatario</th><th>Espacio</th><th>Mes/Año</th><th>Art.</th><th>Inc.</th><th>Frac.</th><th class="text-end">Importe</th></tr></thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr><td>{{ $ticket->folio_label }}</td><td>{{ $ticket->stall->tenant_name }}</td><td>{{ $ticket->stall->space_label }}</td><td>{{ mb_strtoupper($ticket->period->translatedFormat('M/Y')) }}</td><td>{{ $ticket->article }}</td><td>{{ $ticket->subsection }}</td><td>{{ $ticket->fraction }}</td><td class="text-end">${{ number_format($ticket->amount, 2) }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table table-sm small w-50 ms-auto">
                            <tr><td>Boletas</td><td class="text-end">{{ $cut->tickets_count }}</td></tr>
                            <tr><td>Total sistema</td><td class="text-end">${{ number_format($cut->system_total, 2) }}</td></tr>
                            <tr><td>Efectivo contado</td><td class="text-end">${{ number_format($cut->cash_counted, 2) }}</td></tr>
                            <tr class="fw-semibold"><td>Diferencia</td><td class="text-end">${{ number_format($cut->difference, 2) }}</td></tr>
                        </table>
                        <div class="d-flex justify-content-around mt-5 small text-center">
                            <div class="border-top px-5 pt-1">Elaboró · Mercado Municipal</div>
                            <div class="border-top px-5 pt-1">Recibió · {{ $cut->treasury_received_by }}<br>Tesorería Municipal</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif
</div>
