@push('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
@endpush

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                @switch($mode)
                    @case(0)
                        <h2>Nueva Vacante</h2>
                    @break

                    @case(1)
                        <h2>Ver Vacante</h2>
                        @if ($vacancy)
                            @php $computedStatus = $vacancy->computed_status; @endphp
                            <span
                                class="badge {{ $computedStatus == 'Abierta' ? 'bg-success' : ($computedStatus == 'Programada' ? 'bg-warning' : 'bg-danger') }}">
                                {{ $computedStatus }}
                            </span>
                        @endif
                    @break

                    @case(2)
                        <h2>Editar Vacante</h2>
                    @break

                @endswitch
            </div>
        </div>

        <form method="POST" wire:submit="save">
            {{ csrf_field() }}

            <div class="row justify-content-end">
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Estatus *</label>
                    <select name="status" id="status" class="form-select" wire:model="status"
                        @if ($mode == 1) disabled @endif>
                        <option value="">Seleccionar</option>
                        <option value="Abierta">Abierta</option>
                        <option value="Pausar Vacante">Pausar Vacante</option>
                        <option value="Cerrar Vacante">Cerrar Vacante</option>
                        <option value="Concluida">Concluida</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row m-3">
                <div class="col-md-6 mb-3">
                    <label for="position_name" class="form-label">Nombre del puesto *</label>
                    <input type="text" class="form-control" name="position_name" wire:model="position_name"
                        @if ($mode == 1) disabled @endif>
                    @error('position_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="dependency" class="form-label">Dependencia</label>
                    <input type="text" class="form-control" name="dependency" wire:model="dependency"
                        @if ($mode == 1) disabled @endif>
                </div>
            </div>

            <div class="row m-3">
                <div class="col-md-4 mb-3">
                    <label for="employment_type" class="form-label">Tipo de empleo</label>
                    <select class="form-select" name="employment_type" wire:model="employment_type"
                        @if ($mode == 1) disabled @endif>
                        <option value="">Seleccionar</option>
                        <option value="Tiempo completo">Tiempo completo</option>
                        <option value="Medio tiempo">Medio tiempo</option>
                        <option value="Temporal">Temporal</option>
                        <option value="Por contrato">Por contrato</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="work_schedule" class="form-label">Horario</label>
                    <input type="text" class="form-control" name="work_schedule" wire:model="work_schedule"
                        placeholder="Ej: Lunes a Viernes 8:00 - 16:00"
                        @if ($mode == 1) disabled @endif>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="location" class="form-label">Ubicacion</label>
                    <input type="text" class="form-control" name="location" wire:model="location"
                        @if ($mode == 1) disabled @endif>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">Descripcion del puesto</label>
                    <div wire:ignore>
                        <input id="description" type="hidden" wire:model.defer="description"
                            @if ($mode == 1) disabled @endif value="{{ $description }}">
                        <trix-editor wire:ignore input="description" id="trix-description"
                            @if ($mode == 1) disabled @endif></trix-editor>
                    </div>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-12 mb-3">
                    <label for="requirements" class="form-label">Requisitos</label>
                    <div wire:ignore>
                        <input id="requirements" type="hidden" wire:model.defer="requirements"
                            @if ($mode == 1) disabled @endif value="{{ $requirements }}">
                        <trix-editor wire:ignore input="requirements" id="trix-requirements"
                            @if ($mode == 1) disabled @endif></trix-editor>
                    </div>
                </div>
            </div>

            <div class="row m-3">
                <div class="col-md-6 mb-3">
                    <label for="published_at" class="form-label">Fecha de publicacion</label>
                    <input type="datetime-local" class="form-control" id="published_at" name="published_at"
                        wire:model="published_at" @if ($mode == 1) disabled @endif>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="closing_date" class="form-label">Fecha de cierre</label>
                    <input type="datetime-local" class="form-control" id="closing_date" name="closing_date"
                        wire:model="closing_date" @if ($mode == 1) disabled @endif>
                </div>
            </div>

            @if ($mode != 1)
                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('hr.vacancies.admin.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>
                    <button type="submit" style="max-width: 110px" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            @endif
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editorDescription = document.querySelector('#trix-description');
            const editorRequirements = document.querySelector('#trix-requirements');

            if (editorDescription) {
                editorDescription.addEventListener('trix-change', function() {
                    const value = document.querySelector('#description').value;
                    Livewire.dispatch('updateDescription', {
                        'payload': value
                    });
                });
            }

            if (editorRequirements) {
                editorRequirements.addEventListener('trix-change', function() {
                    const value = document.querySelector('#requirements').value;
                    Livewire.dispatch('updateRequirements', {
                        'payload': value
                    });
                });
            }
        });
    </script>
</div>
