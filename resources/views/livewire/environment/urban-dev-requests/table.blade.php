<div>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-leaf fa-2x text-success"></i>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">Solicitudes de Visto Bueno Ambiental</h3>
                    <p class="text-muted mb-0">Solicitudes recibidas de Desarrollo Urbano</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-danger mb-1">{{ $counts['alto_impacto'] }}</h2>
                    <small class="text-muted">Alto Impacto · por atender</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-warning mb-1">{{ $counts['licencia_ambiental_funcionamiento'] }}</h2>
                    <small class="text-muted">Lic. Ambiental de Func. · por atender</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-info mb-1">{{ $counts['manejo_de_residuos'] }}</h2>
                    <small class="text-muted">Manejo de Residuos · por atender</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-success mb-1">{{ $counts['emitida'] }}</h2>
                    <small class="text-muted">Visto bueno emitido</small>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-light border small mb-4">
        <strong>Estatus:</strong>
        Recibida: es una solicitud nueva y falta el PDF adjunto. ·
        En revisión: cuando se está dictaminando. ·
        Visto bueno emitido: se adjuntó el PDF.
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="form-label fw-semibold"><i class="fas fa-search me-1"></i> Buscar:</label>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                        placeholder="Buscar por folio, solicitante o domicilio...">
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Estado:</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">Todas</option>
                        <option value="recibida">Por atender</option>
                        <option value="en_revision">En revisión</option>
                        <option value="emitida">Emitidas</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Formato:</label>
                    <select wire:model.live="filterFormat" class="form-select">
                        <option value="">Todos</option>
                        <option value="alto_impacto">Alto Impacto</option>
                        <option value="licencia_ambiental_funcionamiento">Licencia Ambiental de Funcionamiento</option>
                        <option value="manejo_de_residuos">Manejo de Residuos</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    @if ($search || $filterStatus !== '' || $filterFormat !== '')
                        <button wire:click="clearFilters" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-1"></i> Limpiar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($reviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Folio</th>
                                <th class="fw-semibold">Formato</th>
                                <th class="fw-semibold">Recibido</th>
                                <th class="fw-semibold">Solicitante</th>
                                <th class="fw-semibold">Domicilio del predio</th>
                                <th class="fw-semibold text-center">Días</th>
                                <th class="fw-semibold text-center">Estado</th>
                                <th class="fw-semibold text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                @php $req = $review->urbanDevRequest; @endphp
                                <tr>
                                    <td><span class="badge bg-success">{{ $req?->folio ?? '#'.$review->urban_dev_request_id }}</span></td>
                                    <td><small class="badge bg-light text-dark border">{{ $review->format_label }}</small></td>
                                    <td><small>{{ $review->sent_at?->format('d/m/Y') ?? '—' }}</small></td>
                                    <td><strong>{{ $req?->user?->name ?? 'N/D' }}</strong></td>
                                    <td><small>{{ $review->property_address ?: '—' }}</small></td>
                                    <td class="text-center">{{ $review->sent_at?->diffInDays(now()) ?? '—' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $review->status_color }}">{{ $review->status_label }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('environment.urban_dev_requests.show', $review) }}" class="btn btn-sm btn-success">
                                            {{ $review->status === 'emitida' ? 'Ver resolución' : 'Atender' }}
                                            <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $reviews->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-4x text-muted"></i>
                    <h5 class="text-muted mt-3">No hay solicitudes</h5>
                    <p class="text-muted mb-0">No se encontraron resultados con los filtros aplicados.</p>
                </div>
            @endif
        </div>
    </div>
</div>
