<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    @switch($mode)
                        @case(0)
                            Entrada
                        @break
                        @case(1)
                            Evento
                        @break
                        @case(2)
                            Editar Evento
                        @break
                    @endswitch
                </h6>
            </div>
            <div class="card-body">
                <form wire:submit="save">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                wire:model="title" @if ($mode == 1) disabled @endif>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha inicio</label>
                            <input type="date" class="form-control @error('date_start') is-invalid @enderror"
                                wire:model="date_start" @if ($mode == 1) disabled @endif>
                            @error('date_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Hora inicio</label>
                            <select class="form-select @error('time_start') is-invalid @enderror" wire:model="time_start"
                                @if ($mode == 1) disabled @endif>
                                <option value="">Selecciona</option>
                                @foreach ($this->timeOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('time_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha fin</label>
                            <input type="date" class="form-control @error('date_end') is-invalid @enderror"
                                wire:model="date_end" @if ($mode == 1) disabled @endif>
                            @error('date_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Hora fin</label>
                            <select class="form-select" wire:model="time_end" @if ($mode == 1) disabled @endif>
                                <option value="">Selecciona</option>
                                @foreach ($this->timeOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Lugar</label>
                            <input type="text" class="form-control" wire:model="location"
                                @if ($mode == 1) disabled @endif>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Link a artículo NOTICIAS</label>
                            <input type="text" class="form-control @error('blog_url') is-invalid @enderror"
                                wire:model="blog_url" placeholder="Inserta link creado en el panel de noticias"
                                @if ($mode == 1) disabled @endif>
                            @error('blog_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('environment_events.admin.index') }}" class="btn btn-secondary">
                            {{ $mode == 0 ? 'Cancelar' : 'Volver' }}
                        </a>

                        @if ($mode == 1)
                            <a href="{{ route('environment_events.admin.edit', $entry->id) }}" class="btn btn-warning">
                                Editar
                            </a>
                            <button type="button" class="btn btn-danger" wire:click="delete"
                                wire:confirm="¿Deseas borrar este elemento? Al confirmar, se eliminará permanentemente.">
                                Borrar
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
