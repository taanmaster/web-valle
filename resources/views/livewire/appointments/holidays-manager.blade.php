<div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            {{-- Header --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5>
                        <i class="fas fa-calendar-times me-2"></i> Días Inhábiles — {{ $appointmentName }}
                    </h5>
                </div>
                <div class="card-body p-4">

                    {{-- Alertas --}}
                    @if (session('holiday_success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-lg me-3"></i>
                                <div>{{ session('holiday_success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('holiday_error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                                <div>{{ session('holiday_error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Formulario para agregar --}}
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body p-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Fecha <span class="text-danger">*</span></label>
                                    <input type="date" wire:model="newDate"
                                        class="form-control @error('newDate') is-invalid @enderror"
                                        min="{{ date('Y-m-d') }}">
                                    @error('newDate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Motivo</label>
                                    <input type="text" wire:model="newReason" class="form-control"
                                        placeholder="Ej: Día festivo, Mantenimiento...">
                                </div>
                                <div class="col-md-3">
                                    <button wire:click="addHoliday" class="btn btn-primary w-100">
                                        <i class="fas fa-plus me-1"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Lista de días inhábiles --}}
                    @if ($holidays->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Fecha</th>
                                        <th class="fw-semibold">Día</th>
                                        <th class="fw-semibold">Motivo</th>
                                        <th class="fw-semibold text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($holidays as $holiday)
                                        <tr>
                                            <td>
                                                <strong>{{ $holiday->date->format('d/m/Y') }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ \App\Models\AppointmentSchedule::DAY_NAMES[$holiday->date->dayOfWeek] ?? '' }}
                                                </span>
                                            </td>
                                            <td>{{ $holiday->reason ?? '—' }}</td>
                                            <td class="text-center">
                                                <button wire:click="removeHoliday({{ $holiday->id }})"
                                                    wire:confirm="¿Eliminar este día inhábil?"
                                                    class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-check fa-2x mb-2"></i>
                            <p class="mb-0">No hay días inhábiles configurados para este trámite</p>
                        </div>
                    @endif

                    {{-- Botón regresar --}}
                    @if (!$hideBackButton)
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('appointments.edit', $appointmentId) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Regresar al Trámite
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
