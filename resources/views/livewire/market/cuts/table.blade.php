<div>
    {{-- Corte pendiente de hoy --}}
    <div @class(['card mb-3', 'border-primary' => $pendingCount])>
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0">Pendiente de corte</h6>
                <small class="text-muted">{{ $pendingCount }} boleta(s) cobrada(s) · ${{ number_format($pendingTotal, 2) }} en efectivo por entregar a Tesorería</small>
            </div>
            <a href="{{ route('market.cuts.create') }}" @class(['btn', 'mk-btn' => $pendingCount, 'btn-outline-secondary disabled' => ! $pendingCount])>Hacer corte del día</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="mk-label">Desde</label>
                    <input type="date" wire:model.live="dateFrom" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="mk-label">Hasta</label>
                    <input type="date" wire:model.live="dateTo" class="form-control">
                </div>
                <div class="col-md-4">
                    <button type="button" wire:click="clearFilters" class="btn btn-link btn-sm p-0">Limpiar filtros</button>
                </div>
            </div>
        </div>
    </div>

    @if ($cuts->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                <h4>Aún no hay cortes</h4>
                <p class="mb-0">El corte se hace al final del día con las boletas cobradas.</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="mk-thead">
                        <tr>
                            <th>Fecha</th>
                            <th>Elaboró</th>
                            <th class="text-center">Boletas</th>
                            <th class="text-end">Total sistema</th>
                            <th class="text-end">Efectivo contado</th>
                            <th class="text-end">Diferencia</th>
                            <th>Recibió en Tesorería</th>
                            <th>Recibos de Tesorería</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuts as $cut)
                            <tr wire:key="cut-{{ $cut->id }}">
                                <td><a href="{{ route('market.cuts.show', $cut) }}" class="fw-semibold mk-link">{{ $cut->cut_date->format('d/m/Y') }}</a></td>
                                <td>{{ $cut->creator->name ?? '—' }}</td>
                                <td class="text-center">{{ $cut->tickets_count }}</td>
                                <td class="text-end fw-semibold">${{ number_format($cut->system_total, 2) }}</td>
                                <td class="text-end">${{ number_format($cut->cash_counted, 2) }}</td>
                                <td @class(['text-end fw-semibold', 'text-success' => $cut->difference == 0, 'text-danger' => $cut->difference != 0])>${{ number_format($cut->difference, 2) }}</td>
                                <td>{{ $cut->treasury_received_by }}</td>
                                <td>
                                    @if ($cut->missing_receipts)
                                        <span class="badge rounded-pill bg-warning-subtle text-warning">Faltan {{ $cut->missing_receipts }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-success-subtle text-success">Completos</span>
                                    @endif
                                </td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('market.cuts.show', $cut) }}" @class(['btn btn-sm', 'mk-btn' => $cut->missing_receipts, 'btn-outline-secondary' => ! $cut->missing_receipts])>
                                        {{ $cut->missing_receipts ? 'Adjuntar recibos' : 'Ver detalle' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $cuts->links() }}</div>
    @endif
</div>
