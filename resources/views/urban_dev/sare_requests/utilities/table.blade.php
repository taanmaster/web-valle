<div>
    {{-- 1. HEADER DE MÓDULO --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-clipboard-check fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Solicitudes SARE</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Solicitudes SARE enviadas para inspección, emisión de permiso y entero de pago.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-primary mb-1">{{ $counts['total'] }}</h2>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-secondary mb-1">{{ $counts['nuevo'] }}</h2>
                    <small class="text-muted">Nuevas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-warning mb-1">{{ $counts['en_proceso'] }}</h2>
                    <small class="text-muted">En proceso</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-success mb-1">{{ $counts['completado'] }}</h2>
                    <small class="text-muted">Completadas</small>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. ALERTAS FLASH --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 3. PANEL DE FILTROS --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1"></i> Buscar:
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                            wire:model.live.debounce.300ms="search"
                            class="form-control border-start-0"
                            placeholder="Buscar por folio o solicitante...">
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">Estado:</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">Todos</option>
                        <option value="nuevo">Nuevo</option>
                        <option value="en_proceso">En proceso</option>
                        <option value="completado">Completado</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    @if ($search || $filterStatus !== '')
                        <button wire:click="clearFilters" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-1"></i> Limpiar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- 4. TABLA --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($reviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Folio SARE</th>
                                <th class="fw-semibold">Recibido</th>
                                <th class="fw-semibold">Solicitante</th>
                                <th class="fw-semibold">Giro</th>
                                <th class="fw-semibold text-center">Estado</th>
                                <th class="fw-semibold text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                @php $sareRequest = $review->sareRequest; @endphp
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $sareRequest?->request_num ?? '#' . $review->sare_request_id }}</span>
                                    </td>
                                    <td>
                                        <small>{{ optional($review->sent_at)->format('d/m/Y H:i') ?? '—' }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $sareRequest?->user?->name ?? 'N/D' }}</strong>
                                    </td>
                                    <td>
                                        <small>{{ $sareRequest?->commercial_name ?? '—' }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $review->status_color }}">{{ $review->status_label }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('urban_dev.sare_requests.show', $review) }}"
                                            class="btn btn-sm btn-primary" title="Abrir">
                                            Abrir <i class="fas fa-arrow-right ms-1"></i>
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
                    <div class="mb-4">
                        <i class="fas fa-folder-open fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">No hay solicitudes</h5>
                    <p class="text-muted mb-0">No se encontraron resultados con los filtros aplicados.</p>
                </div>
            @endif
        </div>
    </div>
</div>
