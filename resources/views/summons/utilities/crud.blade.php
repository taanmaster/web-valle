<div>

    @push('stylesheets')
        <style>
            .drop-search {
                top: 120%;
                border-radius: 12px;
                background-color: white;
                box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
                z-index: 5;
                width: 99%;
                display: flex;
                flex-direction: column;
            }

            .concept-search {
                min-height: 200px;
                max-height: 640px;
                height: fit-content;
            }

            .drop-search .btn {
                text-align: left;
            }

            .drop-search .btn:hover {
                background-color: #F2F4FF;
            }

            .accordion-button::after {
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    @endpush

    <div class="row layout-spacing">
        <div class="main-content">

            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($summon != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver citatorio</h2>
                            @break

                            @case(2)
                                <h2>Editar citatorio</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nuevo citatorio</h2>
                    @endif

                    <div class="d-flex">

                    </div>
                </div>
            </div>

            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <div class="row my-3">
                            <div class="col-md-4">
                                <label for="expiration_date" class="col-form-label" required>Fecha Expedición
                                    Citatorio</label>
                            </div>
                            <div class="col-md">
                                <input type="date" name="expiration_date" wire:model="expiration_date"
                                    class="form-control" @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-4">
                                <label for="folio" class="col-form-label" required>Folio</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="folio" wire:model="folio" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-4">
                                <label for="number" class="col-form-label" required>No. Citatorio</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="number" wire:model="number" class="form-control"
                                    @if ($mode == 1) disabled @endif>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="full_name" class="col-form-label" required>Nombre (s)</label>
                            </div>
                            <div class="col-md">
                                <div class="input-group">

                                    @if ($selectedCitizen != null)
                                        <div class="d-flex w-100">
                                            <input type="text" name="full_name" wire:model="full_name"
                                                class="form-control" @if ($mode == 1) disabled @endif
                                                placeholder="Nombre completo" disabled>
                                            <button type="button" wire:click="clearCitizen"
                                                class="btn btn-link btn-sm @if ($mode == 1) d-none @endif">Limpiar</button>
                                        </div>
                                    @else
                                        <input type="text" name="searchFolio" wire:model.live="searchCitizen"
                                            class="form-control" @if ($mode == 1) disabled @endif
                                            placeholder="Buscar por nombre">
                                    @endif
                                </div>

                                <div class="position-absolute drop-search p-3 pt-1 @if ($searchCitizen == null) d-none @endif"
                                    style="height: 400px; overflow:scroll;">
                                    <!-- Cities dependent select menu... -->

                                    <label for="provisional_integer_id" class="col-form-label mb-1">Ciudadano</label>

                                    @php
                                        $citizens = \App\Models\Citizen::where(
                                            'name',
                                            'like',
                                            '%' . $searchCitizen . '%',
                                        )->get();
                                    @endphp

                                    @if ($citizens->count() > 0)
                                        @foreach ($citizens as $citizen)
                                            <button type="button" wire:click="selectCitizen({{ $citizen->id }})"
                                                class="btn">
                                                {{ $citizen->name }} {{ $citizen->first_name }}
                                                {{ $citizen->last_name }}
                                            </button>
                                        @endforeach
                                    @else
                                        <p>No existe</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="worker_id" class="col-form-label" required>Inspector</label>
                            </div>
                            <div class="col-md">
                                <div class="input-group">

                                    @if ($selectedWorker != null)
                                        <div class="d-flex w-100">
                                            <input type="text" name="worker_name" wire:model="worker_name"
                                                class="form-control" @if ($mode == 1) disabled @endif
                                                placeholder="Nombre completo" disabled>
                                            <button type="button" wire:click="clearWorker"
                                                class="btn btn-link btn-sm @if ($mode == 1) d-none @endif">Limpiar</button>
                                        </div>
                                    @else
                                        <input type="text" name="searchFolio" wire:model.live="searchWorker"
                                            class="form-control" @if ($mode == 1) disabled @endif
                                            placeholder="Buscar por nombre">
                                    @endif
                                </div>

                                <div class="position-absolute drop-search p-3 pt-1 @if ($searchWorker == null) d-none @endif"
                                    style="height: 400px; overflow:scroll;">
                                    <!-- Cities dependent select menu... -->

                                    <label for="provisional_integer_id" class="col-form-label mb-1">Inspector</label>

                                    @php
                                        $workers = \App\Models\UrbanDevWorker::where(
                                            'dependency_subcategory',
                                            'Inspector',
                                        )
                                            ->where('name', 'like', '%' . $searchWorker . '%')
                                            ->get();
                                    @endphp

                                    @if ($workers->count() > 0)
                                        @foreach ($workers as $worker)
                                            <button type="button" wire:click="selectWorker({{ $worker->id }})"
                                                class="btn">
                                                {{ $worker->name }} {{ $worker->last_name }}
                                            </button>
                                        @endforeach
                                    @else
                                        <p>No existe</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="publication_date" class="col-form-label">Domicilio</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="street" wire:model="street" class="form-control"
                            @if ($mode == 1) disabled @endif placeholder="Calle">
                    </div>
                    <div class="col-md">
                        <input type="text" name="external_number" wire:model="external_number"
                            class="form-control" @if ($mode == 1) disabled @endif
                            placeholder="Número Exterior">
                    </div>
                    <div class="col-md">
                        <input type="text" name="suburb" wire:model="suburb" class="form-control"
                            @if ($mode == 1) disabled @endif placeholder="Colonia">
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="file" class="col-form-label">Observaciones</label>
                    </div>
                    <div class="col-md">
                        <textarea name="details" id="details" cols="20" rows="5" wire:model="details" class="form-control"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="file" class="col-form-label">Evidencias</label>
                    </div>
                    <div class="col-md">
                        <input type="file" name="file" wire:model="file" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end m-3" style="gap: 12px">

                    <a href="{{ route('summons.index') }}" class="btn btn-sm btn-secondary"
                        style="max-width: 100px">Regresar</a>


                    @if ($mode != 1)
                        <button class="btn btn-sm btn-primary" type="submit"
                            style="max-width: 100px">Guardar</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if ($mode != 0)
        <div class="main-content mt-4 mx-3">
            <div class="row layout-spacing mb-4">

                <div class="col-md">
                    <h5>Seguimiento</h5>
                </div>

                @if ($mode != 1)
                    <div class="col-md-3 text-end">
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Crear seguimiento
                        </button>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Comentario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($summon->followups as $log)
                                    <tr>
                                        <td>{{ $log->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $log->followup_type ?? 'N/A' }}</td>
                                        <td>{{ $log->notes }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Crear seguimiento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="type" class="col-form-label">Tipo</label>
                                <select name="followup_type" id="followup_type" class="form-select"
                                    wire:model="followup_type">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    <option value="Documentación">Documentación</option>
                                    <option value="Citatorio">Citatorio</option>
                                    <option value="Trámite realizado">Trámite realizado</option>
                                    <option value="Trámite cerrado">Trámite cerrado</option>
                                    <option value="Suspensión Obra">Suspensión Obra</option>
                                    <option value="Cierre">Cierre</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="followup_comment" class="col-form-label">Comentario</label>
                                <textarea name="followup_comment" id="followup_comment" cols="30" rows="5" class="form-control"
                                    wire:model="followup_comment"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:click="saveFollowup"
                            data-bs-dismiss="modal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
