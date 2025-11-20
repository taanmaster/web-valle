<div>
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
                <input type="text" name="title" wire:model="title" class="form-control" required>
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
                            class="form-control" required>
                            <option selected>Seleccione una dependencia</option>
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                            @endforeach

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
                            class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label for="ammount" class="col-form-label" required>Monto</label>
                    </div>
                    <div class="col-md">
                        <input type="number" name="ammount" wire:model="ammount" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-2">
                        <label for="service" class="col-form-label">Bien o servicio</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="service" wire:model="service" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-md-2">
                <label class="col-form-label">Justificación</label>
            </div>
            <div class="col-md">
                <textarea class="form-control" name="justification" id="justification" cols="10" rows="6"
                    wire:model="justification" required></textarea>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-md-2">
                <label class="col-form-label">Requerimientos técnicos y económicos</label>
            </div>
            <div class="col-md">
                <input type="file" name="requirement_file" id="requirement_file" wire:model="requirement_file"
                    class="form-control" required>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-md-2 d-flex justify-content-between align-items-center">
                <label class="col-form-label">Tipo de licitación</label>
                <button type="button" class="btn btn-sm btn-info" style="max-width: fit-content" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                        viewBox="0 0 256 256">
                        <path
                            d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM112,84a12,12,0,1,1,12,12A12,12,0,0,1,112,84Z">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="col-md">
                <select name="bidding_type" id="bidding_type" wire:model="bidding_type" class="form-control" required>

                    <option selected>Seleccione un tipo</option>
                    <option value="Licitación pública">Licitación pública</option>
                    <option value="Licitación restringida">Licitación restringida</option>
                    <option value="Adjudicación directa">Adjudicación directa</option>
                    <option value="Con cotización de tres proveedores">Con cotización de tres proveedores
                    </option>

                </select>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-md-2">
                <label class="col-form-label">Documentos adjuntos a la licitación</label>

                <button class="btn btn-sm btn-outline-secondary" wire:click="addFile" type="button">
                    Agregar documento
                </button>
            </div>
            <div class="col-md">

                @if ($fileUpload == true)
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="file_name" wire:model="file_name"
                                placeholder="Nombre del archivo">
                        </div>
                        <div class="col-md-4">
                            <input type="file" name="file" id="file" wire:model="file"
                                class="form-control">
                        </div>
                        <div class="col-md-2 d-flex align-items-center text-end">
                            <button class="btn btn-sm btn-primary" type="button" wire:click="saveFile"
                                style="max-width: fit-content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M208,32H83.31A15.86,15.86,0,0,0,72,36.69L36.69,72A15.86,15.86,0,0,0,32,83.31V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM88,48h80V80H88ZM208,208H48V83.31l24-24V80A16,16,0,0,0,88,96h80a16,16,0,0,0,16-16V48h24Zm-80-96a40,40,0,1,0,40,40A40,40,0,0,0,128,112Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,176Z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif



                @if ($bidding->files->count() != null)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre de archivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bidding->files as $file)
                                    <tr>
                                        <td>{{ $file->file_name }}</td>
                                        <td>
                                            <a href="{{ $file->file }}" class="btn btn-sm btn-primary">
                                                Ver archivo
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                data-original-title="Eliminar"
                                                wire:click="deleteFile({{ $file->id }})">
                                                Eliminar archivo
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

        <div class="d-flex m-3 justify-content-end align-items-center" style="gap: 12px">
            @if ($mode == 0)
                <button wire:click="clear" class="btn btn-sm btn-outline-danger" type="button"
                    style="max-width: fit-content">Cancelar</button>
            @else
                <a href="{{ route('acquisitions.biddings.index') }}"
                    class="btn btn-sm btn-secondary"style="max-width: fit-content">Regresar</a>
            @endif
            <button class="btn btn-sm btn-primary" type="submit" style="max-width: fit-content">Guardar</button>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>
                        <strong>Artículo 38.</strong> Los contratos de adquisiciones y de prestación de servicios, de
                        acuerdo a los
                        montos autorizados, se adjudicarán mediante los procedimientos siguientes:
                    </p>
                    <ol>
                        <li>I. Licitación pública </li>
                        <li>II. Licitación restringida</li>
                        <li>III. De manera directa con tres cotizaciones</li>
                        <li>IV. De manera directa</li>
                    </ol>
                    <p><strong>Artículo 39.</strong> Los montos mínimos y máximos de las adquisiciones, arrendamientos o
                        contratación de
                        servicios, relacionados con bienes muebles e inmuebles se regirán conforme a los siguientes
                        montos:</p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>PROCEDIMIENTO</th>
                                    <th>DE</th>
                                    <th>HASTA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>I. Licitación pública</td>
                                    <td>$3 000 000.01</td>
                                    <td>En adelante</td>
                                </tr>
                                <tr>
                                    <td>II. Licitación restringida</td>
                                    <td>$2 000 000.01</td>
                                    <td>$3 000 000.00</td>
                                </tr>
                                <tr>
                                    <td>III. De manera directa con tres cotizaciones</td>
                                    <td>$1 000 000.01</td>
                                    <td>$2 000 000.00</td>
                                </tr>
                                <tr>
                                    <td>IV. De manera directa</td>
                                    <td>$0.01</td>
                                    <td>$1 000 000.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
