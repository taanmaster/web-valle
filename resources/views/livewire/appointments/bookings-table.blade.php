<div>
    {{-- Header de Módulo --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-clipboard-check fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-list-alt text-primary me-2"></i> Citas Agendadas
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Listado general de todas las citas agendadas por ciudadanos
                            </p>
                        </div>
                    </div>
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
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1"></i> Buscar:
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="form-control border-start-0"
                            placeholder="Folio, nombre, correo...">
                    </div>
                </div>
                <div class="col-lg-2">
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
                        <option value="scheduled">Agendada</option>
                        <option value="confirmed">Confirmada</option>
                        <option value="cancelled">Cancelada</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Asistencia:</label>
                    <select wire:model.live="filterAttendance" class="form-select">
                        <option value="">Todas</option>
                        <option value="pending">Pendiente</option>
                        <option value="attended">Asistió</option>
                        <option value="not_attended">No Asistió</option>
                    </select>
                </div>
                <div class="col-lg-1">
                    <label class="form-label fw-semibold">Desde:</label>
                    <input type="date" wire:model.live="filterDateFrom" class="form-control">
                </div>
                <div class="col-lg-1">
                    <label class="form-label fw-semibold">Hasta:</label>
                    <input type="date" wire:model.live="filterDateTo" class="form-control">
                </div>
                <div class="col-lg-1">
                    @if ($search || $filterDependency || $filterStatus || $filterAttendance || $filterDateFrom || $filterDateTo)
                        <button wire:click="clearFilters" class="btn btn-outline-secondary w-100" title="Limpiar filtros">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Folio</th>
                                <th class="fw-semibold">Ciudadano</th>
                                <th class="fw-semibold">Trámite</th>
                                <th class="fw-semibold text-center">Fecha</th>
                                <th class="fw-semibold text-center">Horario</th>
                                <th class="fw-semibold text-center">Estatus</th>
                                <th class="fw-semibold text-center">Asistencia</th>
                                <th class="fw-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $booking->folio }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $booking->full_name }}</strong>
                                        <br><small class="text-muted">{{ $booking->email }}</small>
                                        <br><small class="text-muted">{{ $booking->phone }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->appointment->name ?? 'N/A' }}
                                        <br><small class="text-muted">{{ $booking->appointment->dependency->name ?? '' }}</small>
                                    </td>
                                    <td class="text-center">
                                        {{ $booking->date->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $booking->status_color }}">
                                            {{ $booking->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $booking->attendance_color }}">
                                            {{ $booking->attendance_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($booking->status !== 'cancelled')
                                            <div class="btn-group btn-group-sm">
                                                <button wire:click="markAttendance({{ $booking->id }}, 'attended')"
                                                    class="btn btn-outline-success" title="Marcar Asistió">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button wire:click="markAttendance({{ $booking->id }}, 'not_attended')"
                                                    class="btn btn-outline-danger" title="Marcar No Asistió">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $bookings->links('pagination::bootstrap-5') }}
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-check fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">No hay citas agendadas</h5>
                    <p class="text-muted mb-0">Las citas aparecerán aquí cuando los ciudadanos agenden sus trámites.</p>
                </div>
            @endif
        </div>
    </div>
</div>
