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
                                    <input type="text" name="searchFolio" wire:model.live="searchCitizen"
                                        class="form-control" @if ($mode == 1) disabled @endif
                                        placeholder="Buscar por nombre">
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
                                    <input type="text" name="searchFolio" wire:model.live="searchWorker"
                                        class="form-control" @if ($mode == 1) disabled @endif
                                        placeholder="Buscar por nombre">
                                </div>

                                <div class="position-absolute drop-search p-3 pt-1 @if ($searchWorker == null) d-none @endif"
                                    style="height: 400px; overflow:scroll;">
                                    <!-- Cities dependent select menu... -->

                                    <label for="provisional_integer_id" class="col-form-label mb-1">Inpector</label>

                                    @php
                                        $workers = \App\Models\UrbanDevWorker::where(
                                            'name',
                                            'like',
                                            '%' . $searchWorker . '%',
                                        )->get();
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
                        <input type="text" name="exterior_number" wire:model="exterior_number" class="form-control"
                            @if ($mode == 1) disabled @endif placeholder="Número Exterior">
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
                        <textarea name="details" id="details" cols="20" rows="5" wire:model="details" class="form-control"></textarea>
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
</div>
