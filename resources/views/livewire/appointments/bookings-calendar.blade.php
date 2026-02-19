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
                                <i class="fas fa-calendar-check text-primary me-2"></i> Calendario de Citas
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Selecciona un trámite y haz clic en un día para ver las citas agendadas
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Leyenda de colores --}}
    <div class="d-flex flex-wrap gap-3 mb-3">
        <span class="badge bg-secondary text-white px-3 py-2">
            <i class="fas fa-circle me-1" style="color: #6c757d;"></i> Sin disponibilidad
        </span>
        <span class="badge bg-danger text-white px-3 py-2">
            <i class="fas fa-circle me-1" style="color: #dc3545;"></i> Baja disponibilidad
        </span>
        <span class="badge bg-warning text-dark px-3 py-2">
            <i class="fas fa-circle me-1" style="color: #ffc107;"></i> Mediana disponibilidad
        </span>
        <span class="badge bg-success text-white px-3 py-2">
            <i class="fas fa-circle me-1" style="color: #198754;"></i> Alta disponibilidad
        </span>
    </div>

    <div class="row">
        {{-- Columna Izquierda: Calendario --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if ($selectedAppointment)
                        {{-- Calendario FullCalendar --}}
                        <div wire:ignore id="admin-calendar-container">
                            <div id="admin-bookings-calendar"></div>
                        </div>

                        {{-- Leyenda de colores debajo del calendario --}}
                        <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
                            <span class="d-flex align-items-center small">
                                <span class="rounded-circle d-inline-block me-1" style="width: 12px; height: 12px; background-color: #198754;"></span>
                                Alta disponibilidad
                            </span>
                            <span class="d-flex align-items-center small">
                                <span class="rounded-circle d-inline-block me-1" style="width: 12px; height: 12px; background-color: #ffc107;"></span>
                                Media disponibilidad
                            </span>
                            <span class="d-flex align-items-center small">
                                <span class="rounded-circle d-inline-block me-1" style="width: 12px; height: 12px; background-color: #dc3545;"></span>
                                Baja disponibilidad
                            </span>
                            <span class="d-flex align-items-center small">
                                <span class="rounded-circle d-inline-block me-1" style="width: 12px; height: 12px; background-color: #6c757d;"></span>
                                Sin disponibilidad
                            </span>
                        </div>
                    @else
                        {{-- Estado vacío del calendario --}}
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-alt fa-4x mb-3"></i>
                            <h5>Selecciona un trámite</h5>
                            <p class="mb-0">El calendario de disponibilidad se mostrará aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Filtros --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-filter text-primary me-2"></i> Filtros
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dependencia</label>
                        <select wire:model.live="selectedDependency" class="form-select">
                            <option value="">Todas las dependencias</option>
                            @foreach ($dependencies as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Servicio y/o trámite</label>
                        <select wire:model.live="selectedAppointment" class="form-select">
                            <option value="">Seleccionar trámite...</option>
                            @foreach ($appointments as $apt)
                                <option value="{{ $apt->id }}">{{ $apt->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($selectedAppointment)
                        <hr>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-hand-pointer me-1"></i>
                            Haz clic en un día del calendario para ver el detalle de las citas agendadas.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Campo oculto con el appointmentId para que el JS lo lea --}}
    <input type="hidden" id="admin-selected-appointment" value="{{ $selectedAppointment }}">
</div>
