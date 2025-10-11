<div>

    <div class="row layout-spacing">
        <div class="main-content">

            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($minute != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver acta</h2>
                            @break

                            @case(2)
                                <h2>Editar acta</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva acta</h2>
                    @endif

                    <div class="d-flex">

                    </div>
                </div>
            </div>

            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}


                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="title" class="col-form-label" required>Sesiones</label>
                            </div>
                            <div class="col-md">
                                <select name="session" id="session" wire:model="session" class="form-select"
                                    @if ($mode == 1) disabled @endif>
                                    <option selected>Seleccione una sesión</option>
                                    @foreach ($sessions as $session)
                                        <option value="{{ $session }}">{{ $session }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="row">
                            <div class="col-md-1">
                                <label for="year" class="col-form-label" required>Año</label>
                            </div>
                            <div class="col-md">
                                <select name="year" id="year" wire:model="year" class="form-select"
                                    @if ($mode == 1) disabled @endif>
                                    <option selected>Seleccione un año</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="publication_date" class="col-form-label">Nombre del Archivo</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="name" wire:model="name" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="file" class="col-form-label">Archivo</label>
                    </div>
                    <div class="col-md">
                        <input type="file" name="file" wire:model="file" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end" style="gap: 12px">

                    <a href="{{ route('institucional_development.regulations.index') }}"
                        class="btn btn-sm btn-secondary" style="max-width: 100px">Regresar</a>


                    @if ($mode != 1)
                        <button class="btn btn-sm btn-primary" type="submit" style="max-width: 100px">Guardar</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
