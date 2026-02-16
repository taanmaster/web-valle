<div>
    {{-- Alertas --}}
    @if (session('booking_error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                <div>{{ session('booking_error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($step < 4)
        {{-- ════════════════════════════════════════════ --}}
        {{-- PASOS 1-3: Selección + Calendario + Horarios --}}
        {{-- ════════════════════════════════════════════ --}}
        <div class="card shadow-lg border-0 rounded-4 mb-5">
            <div class="card-body p-4 p-md-5">
                <div class="row">
                    {{-- Columna Izquierda: Selects + Horarios --}}
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        {{-- Paso 1: Selección de Dependencia y Trámite --}}
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-building text-primary me-2"></i> 1. Selecciona el Trámite
                        </h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Dependencia</label>
                            <select wire:model.live="selectedDependency" class="form-select">
                                <option value="">Seleccionar dependencia...</option>
                                @foreach ($dependencies as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if (count($availableAppointments) > 0)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Trámite</label>
                                <select wire:model.live="selectedAppointment" class="form-select">
                                    <option value="">Seleccionar trámite...</option>
                                    @foreach ($availableAppointments as $apt)
                                        <option value="{{ $apt['id'] }}">{{ $apt['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif ($selectedDependency)
                            <div class="alert alert-info border-0 py-2">
                                <small><i class="fas fa-info-circle me-1"></i> No hay trámites disponibles para esta dependencia.</small>
                            </div>
                        @endif

                        {{-- Paso 3: Horarios Disponibles --}}
                        @if ($selectedDate && count($availableSlots) > 0)
                            <hr class="my-3">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-clock text-primary me-2"></i> 3. Selecciona el Horario
                            </h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-calendar-day me-1"></i>
                                {{ \Carbon\Carbon::parse($selectedDate)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                            </p>

                            <div class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
                                @foreach ($availableSlots as $slot)
                                    @if ($slot['available'])
                                        <button type="button"
                                            wire:click="selectSlot('{{ $slot['start_time'] }}')"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 {{ $selectedSlot === $slot['start_time'] ? 'active' : '' }}">
                                            <span>
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $slot['start_time'] }} - {{ $slot['end_time'] }}
                                            </span>
                                            <span class="badge bg-success rounded-pill">Disponible</span>
                                        </button>
                                    @else
                                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 text-muted">
                                            <span>
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $slot['start_time'] }} - {{ $slot['end_time'] }}
                                            </span>
                                            <span class="badge bg-secondary rounded-pill">Ocupado</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @elseif ($selectedDate && count($availableSlots) === 0)
                            <hr class="my-3">
                            <div class="text-center py-3 text-muted">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <p class="mb-0 small">No hay horarios disponibles para esta fecha.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Columna Derecha: Calendario FullCalendar --}}
                    <div class="col-lg-8">
                        @if ($selectedAppointment)
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-calendar-alt text-primary me-2"></i> 2. Selecciona la Fecha
                            </h6>

                            {{-- Calendario FullCalendar --}}
                            <div wire:ignore id="appointment-calendar-container">
                                <div id="appointment-calendar"></div>
                            </div>

                            {{-- Leyenda de colores --}}
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

                            @if ($selectedDate)
                                <div class="text-center mt-3">
                                    <span class="badge bg-primary fs-6 py-2 px-3">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Fecha seleccionada: {{ \Carbon\Carbon::parse($selectedDate)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                                    </span>
                                </div>
                            @endif
                        @else
                            {{-- Estado vacío del calendario --}}
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-calendar-alt fa-4x mb-3"></i>
                                <h5>Selecciona una dependencia y un trámite</h5>
                                <p class="mb-0">El calendario de disponibilidad se mostrará aquí.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- ════════════════════════════════════════════ --}}
        {{-- PASO 4: Confirmación de Datos --}}
        {{-- ════════════════════════════════════════════ --}}
        <div class="card shadow-lg border-0 rounded-4 mb-5">
            <div class="card-body p-4 p-md-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h5 class="fw-bold mb-4 text-center">
                            <i class="fas fa-clipboard-check text-primary me-2"></i> Confirmar Datos de la Cita
                        </h5>

                        {{-- Resumen de la cita --}}
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Dependencia</small>
                                        <p class="mb-0 fw-semibold">{{ $dependencyName }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Trámite</small>
                                        <p class="mb-0 fw-semibold">{{ $appointmentName }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Fecha</small>
                                        <p class="mb-0 fw-semibold">
                                            {{ \Carbon\Carbon::parse($selectedDate)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Horario</small>
                                        <p class="mb-0 fw-semibold">
                                            @php
                                                $appointment = \App\Models\Appointment::find($selectedAppointment);
                                                $endTime = $appointment ? \Carbon\Carbon::parse($selectedSlot)->addMinutes($appointment->slot_duration)->format('H:i') : '';
                                            @endphp
                                            {{ $selectedSlot }} - {{ $endTime }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Formulario de datos del ciudadano --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                                <input type="text" wire:model="fullName"
                                    class="form-control @error('fullName') is-invalid @enderror"
                                    placeholder="Tu nombre completo">
                                @error('fullName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" wire:model="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="correo@ejemplo.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" wire:model="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="10 dígitos">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Notas adicionales</label>
                                <textarea wire:model="notes" class="form-control" rows="2"
                                    placeholder="¿Algún comentario o detalle adicional? (opcional)"></textarea>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-between">
                            <button type="button" wire:click="goBack" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Regresar
                            </button>
                            <button type="button" wire:click="bookAppointment" class="btn btn-primary btn-lg">
                                <i class="fas fa-calendar-check me-2"></i> Agendar Cita
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
