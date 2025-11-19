<div class="my-3">
    <div class="row h-100">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3>Información del Proveedor Adjudicado</h3>
                </div>
                <div class="card-body p-3">
                    <div class="mb-2">
                        <label class="col-form-label">No. de Proveedor:</label>
                        <p>{{ $proposal->supplier->registration_number }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="col-form-label">Nombre del Proveedor:</label>
                        <p>{{ $proposal->supplier->owner_name }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="col-form-label">Tipo de Proveedor:</label>
                        <p>{{ $proposal->supplier->person_type }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3>Estructura financiera / presupuesto</h3>
                </div>
                <div class="card-body p-3">
                    <form method="POST" wire:submit="save" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                wire:model.live="description"></textarea>
                            <label for="floatingTextarea2">Espacio para escribir descripción o resumen de estructura
                                financiera o presupuesto</label>
                        </div>
                        <div class="mt-3">

                            @if ($file == null)
                                <label for="exampleFormControlInput1" class="form-label">Subir documento</label>
                                <small>Tipo: PDF, Word o Excel</small>
                                <input type="file" wire:model.live="file" class="form-control"
                                    id="exampleFormControlInput1">
                            @else
                                <a href="{{ $file }}" class="btn btn-sm btn-light"
                                    style="max-width: fit-content; max-height:fit-content" target="_blanck">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                        </path>
                                    </svg>
                                    Documento
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <livewire:bidding.contract.table :bidding="$bidding" />
        </div>
    </div>

</div>
