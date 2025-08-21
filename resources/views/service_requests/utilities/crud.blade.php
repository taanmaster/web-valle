<div>

    <div class="row layout-spacing">
        <div class="main-content">

            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($request != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver trámite</h2>
                            @break

                            @case(2)
                                <h2>Editar trámite</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva trámite</h2>
                    @endif

                    <div class="d-flex">

                    </div>
                </div>
            </div>

            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}


                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="name" class="col-form-label">Título</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="name" wire:model="name" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="dependency_name" class="col-form-label">Dependencia</label>
                    </div>
                    <div class="col-md">
                        <select name="dependency_name" id="dependency_name" wire:model="dependency_name"
                            class="form-select" @if ($mode == 1) disabled @endif>
                            <option>Seleccione un tipo</option>
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="description" class="col-form-label">Descripción</label>
                    </div>
                    <div class="col-md">
                        <textarea name="description" class="form-control" wire:model="description" cols="10"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="requirements" class="col-form-label">Requisitos</label>
                    </div>
                    <div class="col-md">
                        <textarea name="requirements" class="form-control" wire:model="requirements" cols="10"></textarea>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="cost" class="col-form-label">Costo</label>
                    </div>
                    <div class="col-md">
                        <input type="number" name="cost" wire:model="cost" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="steps_filename" class="col-form-label">Pasos para realizar el trámite</label>
                    </div>
                    <div class="col-md">
                        <input type="file" name="steps_filename" wire:model="steps_filename" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="procedure_filename" class="col-form-label">Ficha del trámite</label>
                    </div>
                    <div class="col-md">
                        <input type="file" name="procedure_filename" wire:model="procedure_filename"
                            class="form-control" @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end" style="gap: 12px">

                    <a href="{{ route('institucional_development.requests.index') }}" class="btn btn-sm btn-secondary"
                        style="max-width: 100px">Regresar</a>


                    @if ($mode != 1)
                        <button class="btn btn-sm btn-primary" type="submit" style="max-width: 100px">Guardar</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
