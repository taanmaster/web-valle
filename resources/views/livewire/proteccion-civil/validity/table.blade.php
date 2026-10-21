<div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="d-flex flex-wrap gap-2">
            @foreach ($filters as $key => [$label, $count, $color])
                <button type="button" wire:click="$set('filterStatus', '{{ $key }}')"
                    @class(['btn btn-sm rounded-pill', "btn-$color" => $filterStatus === $key, "btn-outline-$color" => $filterStatus !== $key])>
                    {{ $label }} · {{ $count }}
                </button>
            @endforeach
        </div>
        <div class="d-flex gap-2">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Buscar empresa, ciudadano o número">
            <a href="{{ route('proteccion_civil.validity.export', ['status' => $filterStatus, 'search' => $search]) }}" class="btn btn-outline-secondary btn-sm text-nowrap">
                <i class="ti ti-download"></i> Exportar a Excel
            </a>
        </div>
    </div>

    @if ($cases->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                <h4>No hay documentos emitidos</h4>
                <p class="mb-0">Aquí aparecen los expedientes cerrados con opinión técnica o permiso emitido.</p>
                @if ($search || $filterStatus)
                    <button type="button" wire:click="clearFilters" class="btn btn-link">Limpiar filtros</button>
                @endif
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="pc-thead">
                        <tr>
                            <th class="text-end">Consec.</th>
                            <th>Empresa / Ciudadano</th>
                            <th>No. de opinión / permiso</th>
                            <th>Trámite</th>
                            <th>Emisión</th>
                            <th>Caducidad</th>
                            <th class="text-end">Días rest.</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $case)
                            @php [$label, $color] = ['vigente' => ['Vigente', 'success'], 'por_vencer' => ['Por vencer', 'warning'], 'vencida' => ['Vencida', 'danger']][$case->validity_status]; @endphp
                            <tr wire:key="val-{{ $case->id }}">
                                <td class="text-end">{{ $case->document_consecutive }}</td>
                                <td class="fw-semibold">{{ $case->applicant_name }}</td>
                                <td><a href="{{ route('proteccion_civil.cases.show', $case) }}" class="font-monospace fw-semibold text-dark">{{ $case->document_number }}</a></td>
                                <td>{{ $case->procedure->name }}</td>
                                <td>{{ $case->issued_at->format('d/m/Y') }}</td>
                                <td>{{ $case->expires_at->format('d/m/Y') }}</td>
                                <td class="text-end fw-semibold text-{{ $color }}">{{ $case->remaining_days }}</td>
                                <td><span class="badge rounded-pill bg-{{ $color }}-subtle text-{{ $color }}"><i class="ti ti-point-filled"></i>{{ $label }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
