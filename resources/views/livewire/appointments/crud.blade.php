<div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="text-white">
                        @if ($mode === 0)
                            <i class="fas fa-plus-circle me-2"></i> Nuevo Trámite con Cita
                        @elseif ($mode === 1)
                            <i class="fas fa-eye me-2"></i> Detalle del Trámite
                        @else
                            <i class="fas fa-edit me-2"></i> Editar Trámite
                        @endif
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if (session('schedule_error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                                <div>{{ session('schedule_error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form wire:submit="save">
                        {{-- Nombre y Dependencia --}}
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label">Nombre del Trámite <span class="text-danger">*</span></label>
                                <input type="text" wire:model="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Ej: Pago de Predial, Licencia de Construcción..."
                                    {{ $mode === 1 ? 'disabled' : '' }}>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Duración por Cita <span class="text-danger">*</span></label>
                                <select wire:model="slot_duration"
                                    class="form-select @error('slot_duration') is-invalid @enderror"
                                    {{ $mode === 1 ? 'disabled' : '' }}>
                                    <option value="15">15 minutos</option>
                                    <option value="20">20 minutos</option>
                                    <option value="30">30 minutos</option>
                                    <option value="45">45 minutos</option>
                                    <option value="60">60 minutos</option>
                                    <option value="90">90 minutos</option>
                                    <option value="120">120 minutos</option>
                                </select>
                                @error('slot_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label">Dependencia <span class="text-danger">*</span></label>
                                <select wire:model="backoffice_dependency_id"
                                    class="form-select @error('backoffice_dependency_id') is-invalid @enderror"
                                    {{ $mode === 1 ? 'disabled' : '' }}>
                                    <option value="">Seleccionar dependencia...</option>
                                    @foreach ($dependencies as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                                @error('backoffice_dependency_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Estatus</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" wire:model="status"
                                        id="statusSwitch" {{ $mode === 1 ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="statusSwitch">
                                        {{ $status ? 'Activo' : 'Inactivo' }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea wire:model="description" class="form-control" rows="3"
                                    placeholder="Descripción opcional del trámite..."
                                    {{ $mode === 1 ? 'disabled' : '' }}></textarea>
                            </div>
                        </div>

                        {{-- Sección de Horarios --}}
                        <hr class="my-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-clock text-primary me-2"></i> Horarios de Atención
                        </h6>

                        {{-- Formulario para agregar horario --}}
                        @if ($mode !== 1)
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body p-3">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label">Día de la semana</label>
                                            <select wire:model="newScheduleDay" class="form-select">
                                                @foreach ($dayNames as $key => $dayName)
                                                    <option value="{{ $key }}">{{ $dayName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Hora inicio</label>
                                            <input type="time" wire:model="newScheduleStart" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Hora fin</label>
                                            <input type="time" wire:model="newScheduleEnd" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" wire:click="addSchedule"
                                                class="btn btn-primary w-100">
                                                <i class="fas fa-plus me-1"></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Lista de horarios --}}
                        @if (count($schedules) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold">Día</th>
                                            <th class="fw-semibold">Hora Inicio</th>
                                            <th class="fw-semibold">Hora Fin</th>
                                            @if ($mode !== 1)
                                                <th class="fw-semibold text-center">Acción</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schedules as $index => $schedule)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        {{ $dayNames[$schedule['day_of_week']] ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>{{  \Carbon\Carbon::parse($schedule['start_time'])->format('h:i A') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($schedule['end_time'])->format('h:i A') }}</td>
                                                @if ($mode !== 1)
                                                    <td class="text-center">
                                                        <button type="button"
                                                            wire:click="removeSchedule({{ $index }})"
                                                            class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <p class="mb-0">No hay horarios configurados</p>
                            </div>
                        @endif

                        {{-- Botones --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            @if ($mode !== 1)
                                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> {{ $mode === 0 ? 'Guardar' : 'Actualizar' }}
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
