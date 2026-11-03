<div>
    {{-- KPIs: al hacer clic filtran la bandeja --}}
    <div class="row g-3 mb-4">
        @foreach ($kpis as $key => [$label, $count])
            <div class="col">
                <button type="button" wire:click="$set('filterStatus', '{{ $filterStatus === $key ? '' : $key }}')"
                    @class(['card w-100 text-start h-100 mb-0', 'border-warning bg-warning-subtle' => $key === 'por_vencer', 'border-dark' => $filterStatus === $key])>
                    <div class="card-body py-3">
                        <p class="pc-label mb-1">{{ $label }}</p>
                        <h4 class="mb-0">{{ $count }}</h4>
                    </div>
                </button>
            </div>
        @endforeach
    </div>

    {{-- Filtros --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-lg-3">
                    <label class="pc-label">Buscar</label>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Folio o solicitante">
                </div>
                <div class="col-lg-2">
                    <label class="pc-label">Estatus</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">Todos</option>
                        @foreach (\App\Models\CivilProtectionCase::STATUSES as $key => [$number, $label])
                            @continue($key === 'borrador')
                            <option value="{{ $key }}">{{ $number ? $number.'. ' : '' }}{{ $label }}</option>
                        @endforeach
                        <option value="por_vencer">Por vencer</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="pc-label">Trámite</label>
                    <select wire:model.live="filterProcedure" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($procedures as $procedure)
                            <option value="{{ $procedure->id }}">{{ $procedure->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-1">
                    <label class="pc-label">Origen</label>
                    <select wire:model.live="filterOrigin" class="form-select">
                        <option value="">Todos</option>
                        <option value="online">En línea</option>
                        <option value="presencial">Presencial</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="pc-label">Solicitud desde</label>
                    <input type="date" wire:model.live="dateFrom" class="form-control">
                </div>
                <div class="col-lg-2">
                    <label class="pc-label">Hasta</label>
                    <input type="date" wire:model.live="dateTo" class="form-control">
                </div>
            </div>
            <div class="text-end mt-2">
                <button type="button" wire:click="clearFilters" class="btn btn-link btn-sm p-0">Limpiar filtros</button>
            </div>
        </div>
    </div>

    <p class="text-muted small mb-2">{{ $cases->total() }} expedientes</p>

    @if ($cases->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                <h4>No hay expedientes que coincidan</h4>
                <p class="mb-0">Ajusta los filtros o crea una carpeta presencial.</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="pc-thead">
                        <tr>
                            <th>Folio</th>
                            <th>Ciudadano / Empresa</th>
                            <th>Trámite</th>
                            <th>Origen</th>
                            <th>Solicitud</th>
                            <th>Estatus</th>
                            <th class="text-end">Días</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $case)
                            <tr wire:key="case-{{ $case->id }}">
                                <td>
                                    <a href="{{ route('proteccion_civil.cases.show', $case) }}" class="fw-semibold pc-link">{{ $case->folio }}</a>
                                    @if ($case->next_action)
                                        <small class="d-block text-danger fw-semibold"><i class="ti ti-point-filled"></i>{{ $case->next_action }}</small>
                                    @endif
                                </td>
                                <td>{{ $case->applicant_name }}</td>
                                <td>{{ $case->procedure->name }}</td>
                                <td>{{ $case->origin_label }}</td>
                                <td>{{ ($case->submitted_at ?? $case->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $case->status_color }}-subtle text-{{ $case->status_color }}">{{ $case->status_label }}</span>
                                    @if ($validity = $case->validity)
                                        <small class="d-block fw-semibold text-{{ $validity[1] }}"><i class="ti ti-point-filled"></i>{{ $validity[0] }}</small>
                                    @endif
                                </td>
                                <td @class(['text-end', 'text-danger fw-semibold' => $case->days_elapsed > 5 && ! in_array($case->status, \App\Models\CivilProtectionCase::FINAL_STATUSES)])>
                                    {{ $case->days_elapsed }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">{{ $cases->links() }}</div>
    @endif
</div>
