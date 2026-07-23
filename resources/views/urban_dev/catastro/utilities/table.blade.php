<div>
    {{-- Descripción de la bandeja --}}
    <div class="mb-4">
        <h5 class="mb-1 fw-bold">Bandeja de solicitudes</h5>
        <p class="text-muted mb-0">
            Cada permiso recibido genera un renglón. Ábrelo para capturar la información del predio.
        </p>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100 border">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Total</small>
                    <h3 class="mb-0 fw-bold">{{ $counts['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100 border-start border-warning border-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Pendientes</small>
                    <h3 class="mb-0 fw-bold text-warning">{{ $counts['pendiente'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100 border-start border-danger border-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">En captura</small>
                    <h3 class="mb-0 fw-bold text-danger">{{ $counts['en_captura'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100 border-start border-success border-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Completadas</small>
                    <h3 class="mb-0 fw-bold text-success">{{ $counts['completado'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros y búsqueda --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="btn-group" role="group">
            <button type="button"
                class="btn btn-sm {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}"
                wire:click="setFilter('all')">Todas</button>
            <button type="button"
                class="btn btn-sm {{ $filter === 'pendiente' ? 'btn-primary' : 'btn-outline-primary' }}"
                wire:click="setFilter('pendiente')">Pendientes</button>
            <button type="button"
                class="btn btn-sm {{ $filter === 'en_captura' ? 'btn-primary' : 'btn-outline-primary' }}"
                wire:click="setFilter('en_captura')">En captura</button>
            <button type="button"
                class="btn btn-sm {{ $filter === 'completado' ? 'btn-primary' : 'btn-outline-primary' }}"
                wire:click="setFilter('completado')">Completadas</button>
        </div>

        <div style="max-width: 320px; width: 100%;">
            <div class="input-group input-group-sm">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Buscar por solicitante o cuenta predial"
                    wire:model.live.debounce.400ms="search">
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Folio Solicitud</th>
                    <th>Recibido</th>
                    <th>Solicitante</th>
                    <th>Trámite</th>
                    <th>Cuenta predial</th>
                    <th>Estado</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($castros as $castro)
                    @php $request = $castro->urbanDevRequest; @endphp
                    <tr>
                        <td class="fw-bold">{{ $request?->folio ?? '#' . $castro->urban_dev_request_id }}</td>
                        <td>
                            <small>{{ optional($request?->created_at)->format('d/m/Y') ?? '—' }}</small>
                        </td>
                        <td>
                            <strong>{{ $request?->user?->name ?? 'N/D' }}</strong>
                        </td>
                        <td>
                            <small>{{ $request?->request_type_label ?? '—' }}</small>
                        </td>
                        <td>
                            @if ($castro->cuenta_predial)
                                <span class="fw-bold">{{ $castro->cuenta_predial }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $castro->status_color }}">{{ $castro->status_label }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('urban_dev.catastro.show', $castro->id) }}"
                                class="btn btn-sm btn-primary">
                                @if ($castro->status === 'completado')
                                    Ver / editar <i class="fas fa-arrow-right"></i>
                                @else
                                    Capturar predio <i class="fas fa-arrow-right"></i>
                                @endif
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="far fa-folder-open" style="font-size: 32px;"></i>
                            <p class="mt-2 mb-0">No hay solicitudes de captura de predio.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $castros->links() }}
    </div>
</div>
