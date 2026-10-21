<div>
    <div class="row g-3 mb-4">
        @foreach ($kpis as $label => $count)
            <div class="col">
                <div class="card h-100 mb-0">
                    <div class="card-body py-3">
                        <p class="pc-label mb-1">{{ $label }}</p>
                        <h4 class="mb-0">{{ $count }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex align-items-center gap-3 mb-3">
        <input type="text" wire:model.live.debounce.300ms="search" class="form-control w-auto flex-grow-1" placeholder="Buscar folio, solicitante o trámite">
        <small class="text-muted text-nowrap">{{ $inspections->total() }} de {{ $total }} asignadas</small>
        @if ($search)
            <button type="button" wire:click="clearFilters" class="btn btn-link btn-sm p-0 text-nowrap">Limpiar filtros</button>
        @endif
    </div>

    @if ($inspections->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                <h4>No tienes inspecciones asignadas</h4>
                <p class="mb-0">Aparecerán aquí cuando el consultor te asigne una.</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="pc-thead">
                        <tr>
                            <th>Fecha programada</th>
                            <th>Folio</th>
                            <th>Ciudadano / Empresa</th>
                            <th>Trámite</th>
                            <th>Contacto</th>
                            <th>Inspección</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inspections as $inspection)
                            @php $pending = $inspection->result === 'pendiente'; @endphp
                            <tr wire:key="insp-{{ $inspection->id }}">
                                <td>
                                    <span class="fw-semibold">{{ $inspection->scheduled_at->format($pending ? 'd/m/Y · H:i' : 'd/m/Y') }}</span>
                                    @if ($pending && $inspection->scheduled_at->isToday())
                                        <small class="d-block text-warning fw-semibold">Hoy</small>
                                    @elseif ($pending && $inspection->scheduled_at->isPast())
                                        <small class="d-block text-danger fw-semibold">Atrasada</small>
                                    @elseif ($inspection->result === 'no_realizada')
                                        <small class="d-block text-muted">Sin realizar · expediente {{ strtolower($inspection->case->status_label) }}</small>
                                    @elseif ($inspection->visit_date)
                                        <small class="d-block text-muted">Realizada {{ $inspection->visit_date->format('d/m/Y') }}</small>
                                    @endif
                                </td>
                                <td class="fw-semibold pc-link">{{ $inspection->case->folio }}</td>
                                <td>{{ $inspection->case->applicant_name }}</td>
                                <td>{{ $inspection->case->procedure->name }}</td>
                                <td class="text-nowrap">Tel. {{ $inspection->case->phone }}</td>
                                <td><span class="badge rounded-pill bg-{{ $inspection->result_color }}-subtle text-{{ $inspection->result_color }}">{{ $inspection->result_label }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('proteccion_civil.cases.show', $inspection->case) }}"
                                        @class(['btn btn-sm text-nowrap', 'pc-btn' => $pending, 'btn-outline-secondary' => ! $pending])>
                                        {{ $pending ? 'Registrar resultado' : 'Ver' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">{{ $inspections->links() }}</div>
    @endif
</div>
