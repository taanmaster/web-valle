<div>
    {{-- Header de Módulo --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-calendar-check text-primary me-2"></i> Trámites con Cita
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Gestión de trámites municipales que requieren cita previa
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nuevo Trámite
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filtros --}}
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
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0"
                            placeholder="Buscar por nombre del trámite...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Dependencia:</label>
                    <select wire:model.live="filterDependency" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($dependencies as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Estatus:</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">Todos</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    @if ($search || $filterDependency || $filterStatus !== '')
                        <button wire:click="clearFilters" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-1"></i> Limpiar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Trámite</th>
                                <th class="fw-semibold">Dependencia</th>
                                <th class="fw-semibold text-center">Duración Cita</th>
                                <th class="fw-semibold text-center">Estatus</th>
                                <th class="fw-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>
                                        <strong>{{ $appointment->name }}</strong>
                                        @if ($appointment->description)
                                            <br><small class="text-muted">{{ Str::limit($appointment->description, 60) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $appointment->dependency->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $appointment->slot_duration }} min</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($appointment->status)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('appointments.show', $appointment->id) }}"
                                                class="btn btn-outline-primary" title="Ver detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('appointments.edit', $appointment->id) }}"
                                                class="btn btn-outline-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('appointments.holidays', $appointment->id) }}"
                                                class="btn btn-outline-warning" title="Días Inhábiles">
                                                <i class="fas fa-calendar-times"></i>
                                            </a>
                                            <button wire:click="delete({{ $appointment->id }})"
                                                wire:confirm="¿Estás seguro de eliminar este trámite? Esta acción no se puede deshacer."
                                                class="btn btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $appointments->links('pagination::bootstrap-5') }}
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-calendar-alt fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">No hay trámites registrados</h5>
                    <p class="text-muted mb-4">Crea el primer trámite con cita para comenzar.</p>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Crear Primer Trámite
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
