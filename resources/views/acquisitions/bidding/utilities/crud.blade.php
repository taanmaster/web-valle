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
                <div class="row align-items-center justify-content-between mb-4">
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
                    <div class="col-md text-end">
                        <a href="{{ route('acquisitions.biddings.index') }}" class="btn btn-secondary">Regresar a
                            listado</a>
                    </div>
                </div>
            @else
                <a href="{{ route('supplier.bidding.index') }}" class="btn btn-secondary">Regresar a listado</a>
            @endif

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
                                @if ($bidding->status === 'Adjudicación')
                                    <select name="status" id="status" wire:model.live="statusUp"
                                        class="form-control">
                                        <option selected>{{ $bidding->status }}</option>
                                        <option value="Validación jurídica">Validación jurídica</option>
                                    </select>
                                @else
                                    <span class="badge rounded-pill text-bg-secondary">{{ $bidding->status }}</span>
                                @endif
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
                                    @if ($bidding->request_file != null)
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
                                    @endif
                                    @if ($bidding->requirement_file != null)
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
                                    @endif

                                    @if ($bidding->files->count() != null)
                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal"
                                            data-bs-target="#fileModal">
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
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
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
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
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
                                $hasAwardedProposal = $bidding->proposals()->where('status', 'Adjudicada')->exists();
                            @endphp

                            <button class="nav-link {{ !$hasAwardedProposal ? 'disabled' : '' }}" id="profile-tab"
                                data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button"
                                role="tab" aria-controls="profile-tab-pane" aria-selected="false"
                                aria-disabled="{{ !$hasAwardedProposal ? 'true' : 'false' }}"
                                @disabled(!$hasAwardedProposal)>
                                Adjudicación
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            @php
                                $hasDeliverables = $bidding->checklists()->exists();
                            @endphp

                            <button class="nav-link {{ !$hasDeliverables ? 'disabled' : '' }}" id="contact-tab"
                                data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button"
                                role="tab" aria-controls="contact-tab-pane" aria-selected="false"
                                aria-disabled="{{ !$hasDeliverables ? 'true' : 'false' }}"
                                @disabled(!$hasDeliverables) wire:click="$dispatch('refresh-checklist')">
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
                            aria-labelledby="profile-tab" tabindex="0">

                            @if ($hasAwardedProposal != null)
                                <livewire:bidding.award.crud :bidding="$bidding" />
                            @endif
                        </div>
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                            aria-labelledby="contact-tab" tabindex="0">

                            @if ($bidding->contracts->count() != null)
                                <livewire:bidding.checklist.table :bidding="$bidding" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
