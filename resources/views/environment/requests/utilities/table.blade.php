<div>
    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
            <i class="fas fa-leaf fa-2x text-primary"></i>
        </div>
        <div>
            <h3 class="mb-1 fw-bold">Solicitudes Dirección de Medio Ambiente</h3>
            <p class="text-muted mb-0">Trámites de Poda, Tala y Donación de Árboles.</p>
        </div>
    </div>

    {{-- KPI cards --}}
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
                    <small class="text-muted text-uppercase">Nuevas</small>
                    <h3 class="mb-0 fw-bold text-warning">{{ $counts['nuevas'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100 border-start border-info border-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">En inspección</small>
                    <h3 class="mb-0 fw-bold text-info">{{ $counts['inspeccion'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100 border-start border-success border-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Aprobadas</small>
                    <h3 class="mb-0 fw-bold text-success">{{ $counts['aprobadas'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small">Tipo de trámite</label>
                    <select class="form-select form-select-sm" wire:model.live="requestType">
                        <option value="">Todos</option>
                        @foreach (\App\Models\EnvironmentRequest::REQUEST_TYPES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Estatus</label>
                    <select class="form-select form-select-sm" wire:model.live="status">
                        <option value="">Todos</option>
                        @foreach (\App\Models\EnvironmentRequest::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Folio</label>
                    <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="folio">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Nombre</label>
                    <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="nombre">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Desde</label>
                    <input type="date" class="form-control form-control-sm" wire:model.live="fecha_inicio">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Hasta</label>
                    <input type="date" class="form-control form-control-sm" wire:model.live="fecha_fin">
                </div>
            </div>

            @if ($requestType || $status || $folio || $nombre || $fecha_inicio || $fecha_fin)
                <div class="mt-3">
                    <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="clearFilters">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Tabla --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="fw-semibold">No. Solicitud</th>
                    <th class="fw-semibold">Tipo de Solicitud</th>
                    <th class="fw-semibold">Nombre</th>
                    <th class="fw-semibold">Fecha de Solicitud</th>
                    <th class="fw-semibold">Estatus</th>
                    <th class="fw-semibold text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $environmentRequest)
                    <tr>
                        <td class="fw-bold">{{ $environmentRequest->folio }}</td>
                        <td>{{ $environmentRequest->request_type_label }}</td>
                        <td>{{ $environmentRequest->nombre }}</td>
                        <td>{{ optional($environmentRequest->fecha_solicitud)->format('d/m/Y') }}</td>
                        <td><span class="badge bg-primary">{{ $environmentRequest->status_label }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('environment.requests.show', $environmentRequest) }}"
                                class="btn btn-sm btn-outline-primary" title="Ver solicitud" aria-label="Ver solicitud">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="text-center py-4">
                                <i class="far fa-folder-open fa-4x text-muted"></i>
                                <p class="mt-3 mb-0 text-muted">No hay solicitudes que coincidan con los filtros.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $requests->links('pagination::bootstrap-5') }}
    </div>
</div>
