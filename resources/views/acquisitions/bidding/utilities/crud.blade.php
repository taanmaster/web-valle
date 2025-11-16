<div>


    <style>
        .card {
            border-radius: 23px;
            padding-left: 0px;
            padding-right: 0px;
            overflow: hidden;
        }

        .elements .element {
            border-right: 1px solid rgba(0, 0, 0, 0.09);
            padding: 0 12px;
        }

        .nav-link.disabled {
            opacity: .5;
        }
    </style>

    <div class="row layout-spacing">
        <div class="main-content">
            @if ($mode != 3)
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
            @else
                <a href="{{ route('supplier.bidding.index') }}" class="btn btn-secondary">Regresar a listado</a>
            @endif

            @if ($mode == 0 && $mode == 2)
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
                                    <input type="file" name="request_file" id="request_file"
                                        wire:model="request_file" @if ($mode == 1) disabled @endif
                                        class="form-control">
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
                                    <input type="number" name="ammount" wire:model="ammount" class="form-control"
                                        @if ($mode == 1) disabled @endif>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                            <textarea class="form-control" name="justification" id="justification" cols="10" rows="6"
                                wire:model="justification" @if ($mode == 1) disabled @endif></textarea>
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
                            <button type="button" class="btn btn-sm btn-info" style="max-width: fit-content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
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

                    <div class="row m-3">
                        <div class="col-md-2">
                            <label class="col-form-label">Documentos adjuntos a la licitación</label>

                            <button class="btn btn-sm btn-outline-secondary" wire:click="addFile"
                                @if ($mode == 1) disabled @endif type="button">
                                Agregar documento
                            </button>
                        </div>
                        <div class="col-md">

                            @if ($fileUpload == true)
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control"
                                            @if ($mode == 1) disabled @endif name="file_name"
                                            wire:model="file_name" placeholder="Nombre del archivo">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="file" name="file" id="file" wire:model="file"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-center text-end">
                                        <button class="btn btn-sm btn-primary" type="button" wire:click="saveFile"
                                            style="max-width: fit-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                        <button @if ($mode == 0) wire:click="clear" @else wire:click="return" @endif
                            class="btn btn-sm btn-secondary" type="button"
                            style="max-width: fit-content">Regresar</button>
                        @if ($mode != 1)
                            <button class="btn btn-sm btn-primary" type="submit"
                                style="max-width: fit-content">Guardar</button>
                        @endif
                    </div>

                </form>
            @else
                <div class="row m-3">
                    <div class="card">
                        <div class="card-header px-4 d-flex justify-content-between align-items-center">
                            <h2>{{ $bidding->title }}</h2>
                            <h5>Folio: {{ $bidding->id }}</h5>
                        </div>
                        <div class="card-body px-4">
                            <div class="d-flex elements">
                                <div class="element">
                                    <p class="col-form-label">Estatus</p>
                                    <span class="badge rounded-pill text-bg-secondary">{{ $bidding->status }}</span>
                                </div>
                                <div class="element">
                                    <label class="col-form-label">Tipo</label>
                                    <p>{{ $bidding->bidding_type }}</p>
                                </div>
                                <div class="element">
                                    <label class="col-form-label">Monto</label>
                                    <p>$ {{ $bidding->ammount }}</p>
                                </div>
                                <div class="element">
                                    <label class="col-form-label">Dependencia solicitantes</label>
                                    <p>{{ $bidding->dependency_name }}</p>
                                </div>
                                <div class="element">
                                    <p class="col-form-label">Justificación</p>
                                    <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                        data-bs-target="#justificacionModal">
                                        Leer
                                    </button>
                                </div>

                                <div class="col-md">
                                    <div class="d-flex justify-content-end align-items-center mb-3" style="gap: 12px">
                                        <h5>Bien o servicio: {{ $bidding->service }}</h5>

                                        <a href="{{ route('acquisitions.biddings.edit', $bidding->id) }}"
                                            class="btn btn-sm btn-light"
                                            style="max-width: fit-content; max-height:fit-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.68,147.31,64l24-24L216,84.68Z">
                                                </path>
                                            </svg>
                                            Editar
                                        </a>
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center">
                                        <a href="{{ $bidding->request_file }}" class="btn btn-sm btn-light"
                                            style="max-width: fit-content; max-height:fit-content" target="_blanck">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                                </path>
                                            </svg>
                                            Oficio Oficial de Solicitud
                                        </a>
                                        <a href="{{ $bidding->requirement_file }}" class="btn btn-sm btn-light"
                                            style="max-width: fit-content; max-height:fit-content" target="_blanck">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                                </path>
                                            </svg>
                                            Requerimientos técnicos y económicos
                                        </a>

                                        @if ($bidding->files->count() != null)
                                            <button type="button" class="btn btn-sm btn-light"
                                                data-bs-toggle="modal" data-bs-target="#fileModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path
                                                        d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                                    </path>
                                                </svg>
                                                Documentos adjuntos
                                            </button>
                                        @endif

                                        <!-- Modal Files-->
                                        <div class="modal fade" id="fileModal" tabindex="-1"
                                            aria-labelledby="fileModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="fileModalLabel">Documentos
                                                            adjuntos a la licitación
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
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
                                                                                    <a href="{{ $file->file }}"
                                                                                        class="btn btn-sm btn-primary">
                                                                                        Ver archivo
                                                                                    </a>
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-danger"
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
                                            </div>
                                        </div>

                                        <!-- Modal Justificacion-->
                                        <div class="modal fade" id="justificacionModal" tabindex="-1"
                                            aria-labelledby="justificacionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="justificacionModalLabel">
                                                            Justificación
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ $bidding->justification }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Propuestas y
                                    cotizaciones</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                @php
                                    $hasAwardedProposal = $bidding
                                        ->proposals()
                                        ->where('status', 'Adjudicada')
                                        ->exists();
                                @endphp

                                <button class="nav-link {{ !$hasAwardedProposal ? 'disabled' : '' }}"
                                    id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                                    type="button" role="tab" aria-controls="profile-tab-pane"
                                    aria-selected="false"
                                    aria-disabled="{{ !$hasAwardedProposal ? 'true' : 'false' }}"
                                    @disabled(!$hasAwardedProposal)>
                                    Adjudicación
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                @php
                                    $hasDeliverables = $bidding->deliverables()->exists();
                                @endphp

                                <button class="nav-link {{ !$hasDeliverables ? 'disabled' : '' }}" id="contact-tab"
                                    data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button"
                                    role="tab" aria-controls="contact-tab-pane" aria-selected="false"
                                    aria-disabled="{{ !$hasDeliverables ? 'true' : 'false' }}"
                                    @disabled(!$hasDeliverables)>
                                    Entregables
                                </button>

                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active py-4" id="home-tab-pane" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">

                                <livewire:bidding.proposal.table :bidding="$bidding" :mode="$mode" />
                            </div>
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                aria-labelledby="profile-tab" tabindex="0">...</div>
                            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                                aria-labelledby="contact-tab" tabindex="0">...</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
