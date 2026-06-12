<div>
@push('stylesheets')
<style>
    .gc-tabs { display: flex; gap: 2.5rem; border-bottom: 4px solid #2d2d86; margin-bottom: 1.5rem; }
    .gc-tab { background: none; border: none; padding: .75rem 0; font-weight: 700; text-transform: uppercase; letter-spacing: .03em; color: #1a1a1a; }
    .gc-tab.inactive { color: #6cb2f5; }
    .gc-day-btn { width: 38px; height: 38px; border: 1px solid #ced4da; background: #fff; border-radius: 6px; font-weight: 600; color: #555; }
    .gc-day-btn.active { background: #2d2d86; border-color: #2d2d86; color: #fff; }
    .gc-day-label { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #ced4da; border-radius: 6px; font-weight: 600; color: #555; }
    .btn-guardar { background: #F5C842; border: none; color: #212529; font-weight: 600; padding: 10px 48px; border-radius: 6px; }
    .btn-guardar:hover { background: #e9bb2f; color: #212529; }
    .btn-anadir { background: #FAE7B5; border: none; color: #212529; font-weight: 600; padding: 8px 40px; border-radius: 6px; }
    .btn-anadir:hover { background: #f5da90; color: #212529; }
    .gc-slot { display: inline-flex; align-items: center; justify-content: center; min-width: 86px; padding: .45rem .6rem; border-radius: 8px; font-weight: 600; font-size: .85rem; border: 1px solid #ced4da; background: #fff; color: #444; }
    .gc-slot.booked { background: #551312; border-color: #551312; color: #fff; cursor: help; }
    .gc-slot.free { border-color: #2d8653; color: #2d8653; }
</style>
@endpush

<div class="row layout-spacing">
    <div class="main-content">

        <h4 class="fw-bold text-uppercase mb-4">
            @if ($mode === 0)
                Nuevo Trámite o Servicio
            @else
                {{ $procedure->name }}
            @endif
        </h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-check-circle fs-5 me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabs --}}
        @if ($mode !== 0)
            <div class="gc-tabs">
                <button type="button" wire:click="setTab('detalles')"
                    class="gc-tab {{ $tab === 'detalles' ? '' : 'inactive' }}">
                    Detalles del Trámite
                </button>
                <button type="button" wire:click="setTab('disponibilidad')"
                    class="gc-tab {{ $tab === 'disponibilidad' ? '' : 'inactive' }}">
                    Configuración Disponibilidad
                </button>
            </div>
        @endif

        {{-- ─── TAB: DETALLES ─────────────────────────────────────── --}}
        @if ($tab === 'detalles' || $mode === 0)
            <form wire:submit="saveDetails">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-body p-4">

                        {{-- Estatus + fecha de creación --}}
                        <div class="row justify-content-end mb-4">
                            <div class="col-auto">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <label class="mb-0">Estatus</label>
                                    <button type="button"
                                        class="btn btn-sm rounded-pill px-4 fw-semibold {{ $status ? 'btn-success' : 'btn-secondary' }}"
                                        @if($mode===1) disabled @else wire:click="$toggle('status')" @endif
                                        title="{{ $status ? 'Activo: visible en el calendario. Clic para desactivar.' : 'Inactivo: no visible en el calendario. Clic para activar.' }}">
                                        {{ $status ? 'ACTIVO' : 'INACTIVO' }}
                                    </button>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <label class="mb-0">Fecha de creación</label>
                                    <input type="date" class="form-control" style="width: 170px;"
                                        wire:model="created_date" @if($mode===1) disabled @endif>
                                </div>
                            </div>
                        </div>

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label class="form-label">Nombre del trámite o servicio</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    wire:model="name" @if($mode===1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        {{-- Dependencia --}}
                        <div class="mb-3">
                            <label class="form-label">Dependencia</label>
                            <select class="form-select" wire:model="dependencia" @if($mode===1) disabled @endif>
                                <option value="">Seleccionar...</option>
                                @foreach ($dependencias as $dep)
                                    <option value="{{ $dep->name }}">{{ $dep->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nota --}}
                        <div class="mb-4">
                            <label class="form-label">Nota del trámite o servicio <small class="text-muted">(se muestra en el calendario público)</small></label>
                            <textarea class="form-control" rows="2" wire:model="note"
                                @if($mode===1) disabled @endif></textarea>
                        </div>

                        {{-- Días + horario de atención + requiere ID --}}
                        <div class="row g-4 align-items-start">
                            <div class="col-md-5">
                                <label class="form-label">Días de Atención</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach ($days as $dayNum => $dayLetter)
                                        <button type="button"
                                            class="gc-day-btn {{ in_array($dayNum, $attention_days) ? 'active' : '' }}"
                                            wire:click="toggleDay({{ $dayNum }})"
                                            @if($mode===1) disabled @endif
                                            title="{{ $dayNames[$dayNum] }}" aria-label="{{ $dayNames[$dayNum] }}">
                                            {{ $dayLetter }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Horario de Atención</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="time" class="form-control" wire:model="attention_start"
                                        @if($mode===1) disabled @endif>
                                    <input type="time" class="form-control" wire:model="attention_end"
                                        @if($mode===1) disabled @endif>
                                </div>
                                @error('attention_end')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">¿Requiere ID para poder generar la cita?</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="req_si"
                                            @checked($requires_id)
                                            @if($mode===1) disabled @else wire:click="$set('requires_id', true)" @endif>
                                        <label class="form-check-label" for="req_si">SÍ</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="req_no"
                                            @checked(!$requires_id)
                                            @if($mode===1) disabled @else wire:click="$set('requires_id', false)" @endif>
                                        <label class="form-check-label" for="req_no">NO</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                    <a href="{{ route('general_calendar.admin.index') }}" class="btn btn-secondary px-4">
                        {{ $mode === 1 ? 'Volver' : 'Cancelar' }}
                    </a>
                    @if ($mode !== 1)
                        <button type="submit" class="btn btn-guardar">
                            <span wire:loading wire:target="saveDetails" class="spinner-border spinner-border-sm me-2"></span>
                            Guardar
                        </button>
                    @else
                        <a href="{{ route('general_calendar.admin.edit', $procedure->id) }}" class="btn btn-primary px-4">
                            <i class="bx bx-edit"></i> Editar trámite
                        </a>
                    @endif
                </div>
            </form>
        @endif

        {{-- ─── TAB: DISPONIBILIDAD ───────────────────────────────── --}}
        @if ($tab === 'disponibilidad' && $mode !== 0)
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                        <h6 class="fw-bold mb-0">Configuración de disponibilidad por día</h6>
                        <span class="badge bg-light text-secondary border">NOTA: Delimitado a 30 min por cita</span>
                        <span class="badge bg-light text-secondary border">Solo en los días de atención del trámite</span>
                    </div>

                    <div class="row mb-2">
                        <div class="col-auto"><small class="text-muted">Días de<br>Atención</small></div>
                        <div class="col"><small class="text-muted">Bloques de citas</small></div>
                    </div>

                    {{-- Grid de bloques por día (solo días de atención habilitados) --}}
                    @foreach ($days as $dayNum => $dayLetter)
                        @php $dayEnabled = in_array($dayNum, $attention_days); @endphp
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap {{ $dayEnabled ? '' : 'opacity-50' }}"
                            wire:key="day-{{ $dayNum }}">
                            <span class="gc-day-label"
                                title="{{ $dayNames[$dayNum] }}{{ $dayEnabled ? '' : ' (fuera de los días de atención)' }}">
                                {{ $dayLetter }}
                            </span>
                            @for ($i = 0; $i < \App\Livewire\GeneralCalendar\Crud::BLOCKS_PER_DAY; $i++)
                                <input type="time" step="1800"
                                    class="form-control form-control-sm" style="width: 105px;"
                                    wire:model="blocks.{{ $dayNum }}.{{ $i }}"
                                    @if($mode===1 || !$dayEnabled) disabled @endif>
                            @endfor
                        </div>
                    @endforeach
                    @error('blocks')<div class="text-danger small mt-2">{{ $message }}</div>@enderror

                    {{-- Visor de citas agendadas (solo modo ver) --}}
                    @if ($mode === 1)
                        <hr class="my-4">
                        <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                            <h6 class="fw-bold mb-0">Citas agendadas por fecha</h6>
                            <input type="date" class="form-control" style="width: 180px;"
                                wire:model.live="view_date">
                            <small class="text-muted">Pasa el cursor sobre un bloque ocupado para ver la cita.</small>
                        </div>
                        <div class="d-flex gap-2 flex-wrap" id="gc-slots-viewer">
                            @forelse ($viewSlots as $slot)
                                @if ($slot['available'])
                                    <span class="gc-slot free"
                                        wire:key="slot-{{ $view_date }}-{{ $slot['start'] }}">{{ $slot['start'] }}</span>
                                @else
                                    {{-- Tooltip en modo texto: los datos vienen del formulario público --}}
                                    <span class="gc-slot booked" data-bs-toggle="tooltip"
                                        wire:key="slot-{{ $view_date }}-{{ $slot['start'] }}"
                                        title="{{ $slot['appointment']->folio }} · {{ $slot['appointment']->full_name }} · {{ $slot['appointment']->email }} · {{ $slot['appointment']->phone }}">
                                        {{ $slot['start'] }}
                                    </span>
                                @endif
                            @empty
                                <span class="text-muted small">No hay bloques configurados para esta fecha.</span>
                            @endforelse
                        </div>
                    @endif

                    <hr class="my-4">

                    {{-- Días inhábiles --}}
                    <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                        <h6 class="fw-bold mb-0">Gestión de días inhábiles, cierres o suspensiones</h6>
                        <span class="badge bg-light text-secondary border">NOTA: no delimitado a 30 min, se pueden bloquear periodos abiertos</span>
                    </div>

                    @forelse ($closures as $index => $closure)
                        <div class="d-flex align-items-center gap-3 mb-2 flex-wrap" wire:key="closure-{{ $index }}">
                            <span class="badge bg-light text-dark border px-4 py-2">
                                {{ \Carbon\Carbon::parse($closure['date'])->format('d/m/Y') }}
                            </span>
                            <span class="badge bg-light text-dark border px-4 py-2">
                                {{ \Carbon\Carbon::parse($closure['start_time'])->format('h:i a') }}
                            </span>
                            <span class="badge bg-light text-dark border px-4 py-2">
                                {{ \Carbon\Carbon::parse($closure['end_time'])->format('h:i a') }}
                            </span>
                            @if ($mode !== 1)
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    wire:click="removeClosure({{ $index }})"
                                    title="Quitar" aria-label="Quitar">
                                    <i class="bx bx-x"></i>
                                </button>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted small">Sin días inhábiles registrados.</p>
                    @endforelse
                    @error('closures')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

                    @if ($mode !== 1)
                        <div class="text-end mt-3">
                            <button type="button" class="btn-anadir" wire:click="openClosureModal">Añadir</button>
                        </div>
                    @endif

                </div>
            </div>

            @if ($mode !== 1)
                <div class="d-flex justify-content-center mb-4">
                    <button type="button" class="btn btn-guardar" wire:click="saveAvailability">
                        <span wire:loading wire:target="saveAvailability" class="spinner-border spinner-border-sm me-2"></span>
                        Guardar Cambios
                    </button>
                </div>
            @endif
        @endif

        {{-- ─── MODAL: día inhábil ────────────────────────────────── --}}
        @if ($showClosureModal)
            <div class="modal-backdrop fade show" style="z-index: 1040;"></div>
            <div class="modal fade show d-block" tabindex="-1" style="z-index: 1050;">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
                    <div class="modal-content" style="border-radius: 12px; border: none;">
                        <div class="modal-body p-4">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Fecha</label>
                                <input type="date" class="form-control @error('closure_date') is-invalid @enderror"
                                    wire:model="closure_date">
                                @error('closure_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <label class="form-label fw-semibold">Horario a bloquear</label>
                            <div class="d-flex gap-2 mb-1">
                                <input type="time" class="form-control @error('closure_start') is-invalid @enderror"
                                    wire:model="closure_start">
                                <input type="time" class="form-control @error('closure_end') is-invalid @enderror"
                                    wire:model="closure_end">
                            </div>
                            @error('closure_start')<div class="text-danger small">{{ $message }}</div>@enderror
                            @error('closure_end')<div class="text-danger small">{{ $message }}</div>@enderror

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-guardar px-4" wire:click="addClosure">Guardar</button>
                                <button type="button" class="btn btn-danger px-4" wire:click="closeClosureModal">Cancelar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Tooltip delegado: sobrevive a los re-renders de Livewire porque la
        // instancia vive en body y se resuelve por selector al hacer hover.
        new bootstrap.Tooltip(document.body, {
            selector: '#gc-slots-viewer [data-bs-toggle="tooltip"]',
            container: 'body'
        });
    });
</script>
@endpush
</div>
