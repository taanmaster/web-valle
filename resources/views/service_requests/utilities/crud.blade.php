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
                        <input type="text" name="name" wire:model.blur="name" class="form-control"
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

                {{--
                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="cost" class="col-form-label">Costo</label>
                    </div>
                    <div class="col-md">
                        <input type="number" name="cost" wire:model="cost" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>
                 --}}

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


            <div class="row m-3">
                <h5>Costos</h5>
                <div class="col-md-4">
                    <input type="number" class="form-control" @if ($mode == 1) disabled @endif
                        name="ammount" wire:model="ammount" placeholder="Valor">
                </div>
                <div class="col-md-6">
                    <input type="text" name="ammount_description" id="ammount_description"
                        wire:model="ammount_description" class="form-control"
                        @if ($mode == 1) disabled @endif placeholder="Descripción del costo">
                </div>
                <div class="col-md-2 d-flex justify-content-end align-items-center text-end">
                    <button class="btn btn-sm btn-primary" type="button" wire:click="saveCost"
                        style="max-width: fit-content">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                            viewBox="0 0 256 256">
                            <path
                                d="M208,32H83.31A15.86,15.86,0,0,0,72,36.69L36.69,72A15.86,15.86,0,0,0,32,83.31V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM88,48h80V80H88ZM208,208H48V83.31l24-24V80A16,16,0,0,0,88,96h80a16,16,0,0,0,16-16V48h24Zm-80-96a40,40,0,1,0,40,40A40,40,0,0,0,128,112Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,176Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            @if ($request != null && $request->costs->count() != 0)
                <div class="table-responsive m-3">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Valor</th>
                                <th>Descripción del valor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($request->costs as $cost)
                                <tr>
                                    <td>$ {{ $cost->ammount }}</td>
                                    <td>{{ $cost->description }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-original-title="Eliminar"
                                            wire:click="deleteCost({{ $cost->id }})">
                                            Eliminar costo
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif


        </div>
    </div>
</div>
