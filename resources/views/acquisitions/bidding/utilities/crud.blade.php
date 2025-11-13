<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($bidding != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver Licitación</h2>
                            @break

                            @case(2)
                                <h2>Editar licitación</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva Licitación</h2>
                    @endif
                </div>
            </div>
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row justify-content-end m-3">
                    <div class="col-md-2">
                        <input type="text" class="form-control" disabled wire:model="folio" name="folio">
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-2">
                        <label class="col-form-label">Título de Licitación</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="title" wire:model="title" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>


                <div class="row m-3 align-items-center">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-form-label">Dependencia Solicitante</label>
                            </div>
                            <div class="col-md">
                                <select name="dependency_name" wire:model="dependency_name" id="dependency_name"
                                    class="form-control" @if ($mode == 1) disabled @endif required>
                                    <option selected>Seleccione una dependencia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-form-label" required>Subir Oficio de Solicitud</label>
                            </div>
                            <div class="col-md">
                                <input type="file" name="request_file" id="request_file" wire:model="request_file"
                                    @if ($mode == 1) disabled @endif class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="ammount" class="col-form-label" required>Monto</label>
                            </div>
                            <div class="col-md">
                                <input type="number" name="ammount" wire:model="ammount" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="service" class="col-form-label">Bien o servicio</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="service" wire:model="service" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-2">
                        <label class="col-form-label">Justificación</label>
                    </div>
                    <div class="col-md">
                        <textarea name="justification" id="justification" cols="10" rows="10" wire:model="justification"></textarea>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-2">
                        <label class="col-form-label">Requerimientos técnicos y económicos</label>
                    </div>
                    <div class="col-md">
                        <input type="file" name="requirement_file" id="requirement_file"
                            wire:model="requirement_file" @if ($mode == 1) disabled @endif
                            class="form-control">
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-2 d-flex justify-content-between align-items-center">
                        <label class="col-form-label">Tipo de licitación</label>
                        <button type="button" class="btn btn-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#fff"
                                viewBox="0 0 256 256">
                                <path
                                    d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM112,84a12,12,0,1,1,12,12A12,12,0,0,1,112,84Z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="col-md">
                        <select name="bidding_type" id="bidding_type" wire:model="bidding_type" class="form-control"
                            @if ($mode == 1) disabled @endif required>

                            <option selected>Seleccione un tipo</option>
                            <option value="Licitación pública">Licitación pública</option>
                            <option value="Licitación restringida">Licitación restringida</option>
                            <option value="Adjudicación directa">Adjudicación directa</option>
                            <option value="Con cotización de tres proveedores">Con cotización de tres proveedores
                            </option>

                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label class="col-form-label">Documentos adjuntos a la licitación</label>

                        <button class="btn btn-sm btn-outline-secondary" wire:click="addFile"
                            @if ($mode == 1) disabled @endif>
                            Agregar documento
                        </button>
                    </div>
                    <div class="col-md">

                        @if ($addFile == true)
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control"
                                        @if ($mode == 1) disabled @endif name="file_name"
                                        wire:model="file_name">
                                </div>
                                <div class="col-md-4">
                                    <input type="file" name="file" id="file" wire:model="file">
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button class="btn btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="#fff" viewBox="0 0 256 256">
                                            <path
                                                d="M208,32H83.31A15.86,15.86,0,0,0,72,36.69L36.69,72A15.86,15.86,0,0,0,32,83.31V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM88,48h80V80H88ZM208,208H48V83.31l24-24V80A16,16,0,0,0,88,96h80a16,16,0,0,0,16-16V48h24Zm-80-96a40,40,0,1,0,40,40A40,40,0,0,0,128,112Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,176Z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if ($bidding->files->count() != null)
                            @foreach ($files as $file)
                                {{ $file->file_name }}
                            @endforeach
                        @endif

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
