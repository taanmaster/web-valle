<div>
    {{-- Header de Módulo --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                Citas del {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-building me-1"></i>
                                {{ $appointment->dependency->name ?? '' }} —
                                <strong>{{ $appointment->name }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('appointment-bookings.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Volver al Calendario
                    </a>
                    @if ($bookings->count() > 0)
                        <button wire:click="exportDay" class="btn btn-success">
                            <i class="fas fa-file-excel me-1"></i> Exportar Excel
                        </button>
                    @endif
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

    {{-- Resumen rápido --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-primary mb-1">{{ $bookings->count() }}</h2>
                    <small class="text-muted">Total de Citas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-success mb-1">{{ $bookings->where('attendance_status', 'attended')->count() }}</h2>
                    <small class="text-muted">Asistieron</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-danger mb-1">{{ $bookings->where('attendance_status', 'not_attended')->count() }}</h2>
                    <small class="text-muted">No Asistieron</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-info mb-1">{{ $bookings->whereNull('attendance_status')->count() }}</h2>
                    <small class="text-muted">Pendientes</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Citas --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Horario</th>
                                <th class="fw-semibold">Folio</th>
                                <th class="fw-semibold">Ciudadano</th>
                                <th class="fw-semibold">Contacto</th>
                                <th class="fw-semibold text-center">Confirmación</th>
                                <th class="fw-semibold text-center">Asistencia</th>
                                <th class="fw-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark border fs-6">
                                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $booking->folio }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $booking->full_name }}</strong>
                                    </td>
                                    <td>
                                        <small class="d-block text-muted">
                                            <i class="fas fa-envelope me-1"></i> {{ $booking->email }}
                                        </small>
                                        <small class="d-block text-muted">
                                            <i class="fas fa-phone me-1"></i> {{ $booking->phone }}
                                        </small>
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

                {{-- Acciones Administrativas --}}
                <hr class="my-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-cogs text-primary me-2"></i> Acciones Administrativas
                    </h6>

                    <div class="d-flex justify-content-end">
                        <button wire:click="exportDay" class="btn btn-success">
                            <i class="fas fa-file-excel me-2"></i> Exportar Corte de Fecha Filtrada
                        </button>
                    </div>
                    
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-calendar-times fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">No hay citas agendadas</h5>
                    <p class="text-muted mb-0">No se encontraron citas para este trámite en la fecha {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}.</p>
                    <a href="{{ route('appointment-bookings.index') }}" class="btn btn-outline-primary mt-3">
                        <i class="fas fa-arrow-left me-1"></i> Volver al Calendario
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
