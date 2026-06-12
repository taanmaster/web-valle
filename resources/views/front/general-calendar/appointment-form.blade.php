<div>
@push('styles')
<style>
    .gcf-hero { border-radius: 16px; background: linear-gradient(135deg, #551312 0%, #7a2422 100%); min-height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; color: #fff; padding: 3rem 1.5rem; margin-bottom: 2.5rem; }
    .gcf-hero h1 { font-weight: 700; font-size: clamp(1.7rem, 4vw, 2.8rem); max-width: 760px; }
    .gcf-hero .gcf-note { font-size: .95rem; opacity: .85; max-width: 640px; margin-top: 1rem; margin-bottom: 0; }
    .gcf-honeypot { position: absolute; left: -9999px; top: -9999px; height: 1px; width: 1px; overflow: hidden; }
    .btn-agendar { background: #86d684; border: none; color: #1a3d1a; font-weight: 600; padding: 12px 0; width: 100%; max-width: 280px; border-radius: 8px; }
    .btn-agendar:hover { background: #6fc96d; color: #1a3d1a; }
    .btn-cancelar { background: #e05c3a; border: none; color: #fff; font-weight: 600; padding: 12px 0; width: 100%; max-width: 280px; border-radius: 8px; }
    .btn-cancelar:hover { background: #c94e2f; color: #fff; }
</style>
@endpush

<div>
    {{-- Hero --}}
    <div class="gcf-hero">
        <h1>
            @if ($this->selectedProcedure)
                Cita para "{{ $this->selectedProcedure->name }}"
            @else
                Calendario General
            @endif
        </h1>
        @if ($this->selectedProcedure?->note)
            <p class="gcf-note">{{ $this->selectedProcedure->note }}</p>
        @elseif (!$this->selectedProcedure)
            <p class="gcf-note">Selecciona la dependencia y el servicio o trámite para agendar tu cita.</p>
        @endif
    </div>

    {{-- Confirmación --}}
    @if ($successFolio)
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert">
            <i class="bx bx-calendar-check fs-2"></i>
            <div>
                <strong>¡Tu cita fue agendada correctamente!</strong><br>
                Guarda tu folio: <strong>{{ $successFolio }}</strong>. Preséntalo el día de tu cita.
            </div>
        </div>
    @endif

    <form wire:submit="save">

        {{-- Honeypot anti-spam: este campo debe permanecer vacío --}}
        <div class="gcf-honeypot" aria-hidden="true">
            <label for="website">No llenar este campo</label>
            <input type="text" id="website" wire:model="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="row g-5">
            {{-- Columna izquierda: selección --}}
            <div class="col-lg-5">
                <div class="mb-3">
                    <label class="form-label">Dependencia</label>
                    <select class="form-select rounded-pill" wire:model.live="filter_dependencia">
                        <option value="">Todos</option>
                        @foreach ($dependencias as $dep)
                            <option value="{{ $dep }}">{{ $dep }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Servicio y/o trámite</label>
                    <select class="form-select rounded-pill @error('procedure_id') is-invalid @enderror"
                        wire:model.live="procedure_id">
                        <option value="">Seleccionar...</option>
                        @foreach ($procedures as $proc)
                            <option value="{{ $proc->id }}">{{ $proc->name }}</option>
                        @endforeach
                    </select>
                    @error('procedure_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                @if ($this->selectedProcedure)
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control rounded-pill @error('fecha') is-invalid @enderror"
                            wire:model.live="fecha" min="{{ now()->toDateString() }}">
                        @error('fecha')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    @if ($fecha)
                        <div class="mb-3">
                            <label class="form-label">Horario</label>
                            <select class="form-select rounded-pill @error('horario') is-invalid @enderror"
                                wire:model="horario">
                                <option value="">Seleccionar horario...</option>
                                @foreach ($this->availableSlots as $slot)
                                    <option value="{{ $slot['start'] }}">{{ $slot['start'] }} - {{ $slot['end'] }}</option>
                                @endforeach
                            </select>
                            @if (empty($this->availableSlots))
                                <small class="text-muted">No hay horarios disponibles para esta fecha; intenta con otra.</small>
                            @endif
                            @error('horario')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    @endif
                @endif
            </div>

            {{-- Columna derecha: datos del ciudadano --}}
            <div class="col-lg-7">
                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                            wire:model="full_name" autocomplete="name">
                        <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                    </div>
                    @error('full_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            wire:model="email" autocomplete="email">
                        <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                    </div>
                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono de contacto</label>
                    <div class="input-group">
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                            wire:model="phone" autocomplete="tel">
                        <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                    </div>
                    @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                @if ($this->selectedProcedure?->requires_id)
                    <div class="mb-3">
                        <label class="form-label">ID de aprobación de generación de cita</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('approval_id') is-invalid @enderror"
                                wire:model="approval_id">
                            <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                        </div>
                        @error('approval_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                @endif
            </div>
        </div>

        {{-- Acciones --}}
        <div class="d-flex flex-column align-items-center gap-3 mt-5">
            <button type="submit" class="btn-agendar">
                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                Agendar Cita
            </button>
            <button type="button" class="btn-cancelar" wire:click="cancel">Cancelar</button>
        </div>

    </form>
</div>
</div>
