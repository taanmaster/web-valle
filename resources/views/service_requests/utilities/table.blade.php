<div>
    @if ($mode == 0)
        {{-- ================= BACKOFFICE ================= --}}

        {{-- 1. HEADER DE MÓDULO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">Trámites y Servicios</h3>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-landmark me-1"></i>
                                    Catálogo municipal del Portal Ciudadano Único.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <a href="{{ route('institucional_development.requests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo trámite
                        </a>
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

        {{-- 3. TARJETAS KPI --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center" role="button" wire:click="setTab('')">
                    <div class="card-body py-3">
                        <h2 class="fw-bold text-primary mb-1">{{ $stats['total'] }}</h2>
                        <small class="text-muted">Total registrados</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center" role="button"
                    wire:click="setTab('{{ \App\Models\ServiceRequest::STATUS_PUBLISHED }}')">
                    <div class="card-body py-3">
                        <h2 class="fw-bold text-success mb-1">{{ $stats['published'] }}</h2>
                        <small class="text-muted">Publicados</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center" role="button"
                    wire:click="setTab('{{ \App\Models\ServiceRequest::STATUS_REVIEW }}')">
                    <div class="card-body py-3">
                        <h2 class="fw-bold text-warning mb-1">{{ $stats['review'] }}</h2>
                        <small class="text-muted">En revisión</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center" role="button"
                    wire:click="setTab('{{ \App\Models\ServiceRequest::STATUS_DRAFT }}')">
                    <div class="card-body py-3">
                        <h2 class="fw-bold text-secondary mb-1">{{ $stats['drafts'] }}</h2>
                        <small class="text-muted">Borradores</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. PANEL DE FILTROS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-search me-1"></i> Buscar:
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="form-control border-start-0"
                                placeholder="Buscar por nombre, homoclave o dependencia...">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Dependencia:</label>
                        <select wire:model.live="filterDependency" class="form-select">
                            <option value="">Todas</option>
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label fw-semibold">Tipo:</label>
                        <select wire:model.live="filterType" class="form-select">
                            <option value="">Todos</option>
                            <option value="Trámite">Trámite</option>
                            <option value="Servicio">Servicio</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label fw-semibold">Estado:</label>
                        <select wire:model.live="filterStatus" class="form-select">
                            <option value="">Todos</option>
                            @foreach (\App\Models\ServiceRequest::STATUS_LABELS as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1">
                        @if ($search || $filterDependency !== '' || $filterType !== '' || $filterStatus !== '')
                            <button wire:click="clearFilters" class="btn btn-outline-secondary w-100"
                                title="Limpiar filtros" aria-label="Limpiar filtros">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. TABLA --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                {{-- Tabs de estado --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $filterStatus === '' ? 'active' : '' }}"
                            wire:click="setTab('')">Todos</button>
                    </li>
                    @foreach (\App\Models\ServiceRequest::STATUS_LABELS as $value => $label)
                        <li class="nav-item">
                            <button type="button" class="nav-link {{ $filterStatus === $value ? 'active' : '' }}"
                                wire:click="setTab('{{ $value }}')">{{ $label }}s</button>
                        </li>
                    @endforeach
                </ul>

                @if ($requests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-semibold">Trámite / Servicio</th>
                                    <th class="fw-semibold">Dependencia</th>
                                    <th class="fw-semibold">Tipo</th>
                                    <th class="fw-semibold">Modalidad</th>
                                    <th class="fw-semibold text-center">Estado</th>
                                    <th class="fw-semibold text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr wire:key="request-{{ $request->id }}">
                                        <td>
                                            <strong>{{ $request->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                @if ($request->homoclave)
                                                    {{ $request->homoclave }} ·
                                                @endif
                                                act. {{ $request->updated_at?->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>{{ $request->dependency_name ?: '—' }}</td>
                                        <td>
                                            @if ($request->type)
                                                <span class="badge bg-info">{{ $request->type }}</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $request->modality_label }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $request->status_color }}">
                                                {{ $request->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button wire:click="toggleFavorite({{ $request->id }})"
                                                    class="btn btn-outline-warning"
                                                    title="{{ $request->is_favorite ? 'Quitar de populares' : 'Marcar como popular' }}"
                                                    aria-label="Marcar como popular">
                                                    <i
                                                        class="{{ $request->is_favorite ? 'fas' : 'far' }} fa-star"></i>
                                                </button>
                                                <a href="{{ route('institucional_development.requests.show', $request->id) }}"
                                                    class="btn btn-outline-primary" title="Ver detalle"
                                                    aria-label="Ver detalle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('institucional_development.requests.edit', $request->id) }}"
                                                    class="btn btn-outline-secondary" title="Editar"
                                                    aria-label="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button wire:click="delete({{ $request->id }})"
                                                    wire:confirm="¿Estás seguro de eliminar este trámite? Esta acción no se puede deshacer."
                                                    class="btn btn-outline-danger" title="Eliminar"
                                                    aria-label="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
                        <small class="text-muted">
                            Mostrando {{ $requests->count() }} de {{ $requests->total() }}
                        </small>
                        <div>
                            {{ $requests->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted">No hay trámites registrados</h5>
                        <p class="text-muted mb-4">No se encontraron resultados con los filtros aplicados.</p>
                        <a href="{{ route('institucional_development.requests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Crear primer trámite
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        {{-- ================= PORTAL CIUDADANO ================= --}}

        <div class="row g-3 mb-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold">Buscar un trámite o servicio</label>
                <input type="text" class="form-control" placeholder="Nombre, homoclave o dependencia"
                    wire:model.live.debounce.300ms="search" />
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Filtrar por dependencia</label>
                <select class="form-select" aria-label="Filtrar por dependencia" wire:model.live="filterDependency">
                    <option value="">Todas las dependencias</option>
                    @foreach ($dependencies as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 text-end">
                @if ($search !== '' || $filterDependency !== '')
                    <button class="btn btn-secondary btn-sm" wire:click="clearFilters">Limpiar filtros</button>
                @endif
            </div>
        </div>

        <div class="row">
            @if ($search === '' && $filterDependency === '' && count($popularRequests) > 0)
                <div class="col-md-6">
                    <h3 class="mb-3">Los más populares</h3>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dependencia</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($popularRequests as $request)
                                    <tr wire:key="popular-{{ $request->id }}">
                                        <td>{{ $request->name }}</td>
                                        <td>{{ $request->dependency_name }}</td>
                                        <td>
                                            <a href="{{ route('tramites_y_servicios.show', $request->id) }}"
                                                class="btn btn-link btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div @if ($search === '' && $filterDependency === '' && count($popularRequests) > 0) class="col-md-6" @else class="col-md-12" @endif>

                <h3 class="mb-3">Trámites en línea</h3>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Dependencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                <tr wire:key="front-request-{{ $request->id }}">
                                    <td>
                                        {{ $request->name }}
                                        @if ($request->homoclave)
                                            <br><small class="text-muted">{{ $request->homoclave }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $request->dependency_name }}</td>
                                    <td>
                                        <a href="{{ route('tramites_y_servicios.show', $request->id) }}"
                                            class="btn btn-link btn-sm">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $requests->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>
