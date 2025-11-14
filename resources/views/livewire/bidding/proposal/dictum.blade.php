<div>

    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Dictamen</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="clearModal"></button>
    </div>

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <h3>Información del Proveedor</h3>

                    <div class="row my-4">
                        <div class="col-md-6">
                            <label class="col-form-label">No. Proveedor</label>
                            <p>{{ $proposal->supplier->registration_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-form-label">Tipo de Proveedor</label>
                            @switch($proposal->supplier->person_type)
                                @case('fisica')
                                    <p>Persona física</p>
                                @break

                                @case('moral')
                                    <p>Persona moral</p>
                                @break
                            @endswitch
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Nombre de Proveedor</label>
                            <p>{{ $proposal->supplier->owner_name }}</p>
                        </div>
                    </div>

                    <h3>Cotización y/p Propuesta</h3>

                    <div class="row mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">{{ $proposal->file_name }}</p>
                            <a href="{{ $proposal->file }}" class="btn btn-sm btn-primary" target="_blank"
                                style="max-width: fit-content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 h-100">
                    <h3>Dictame</h3>
                    <div class="row my-4">
                        <div class="col-md-4">
                            <label class="col-form-label">Resultado</label>
                        </div>
                        <div class="col-md">
                            <select name="status" id="status" wire:model="status" class="form-control" required>
                                <option>Seleccione una opción</option>
                                <option value="Fallo">Fallo</option>
                                <option value="Adjudicada">Adjudicada</option>
                            </select>
                        </div>
                    </div>
                    <h5>Acta de dictamen</h5>
                    <div class="row mt-4">
                        <div class="col-md-12 mb-4">
                            <input type="text" name="dictum_file_name" id="dictum_file_name"
                                wire:model="dictum_file_name" required class="form-control">
                        </div>
                        <div class="col-md-12">
                            <input type="file" name="dictum_file" id="dictum_file" wire:model="dictum_file"
                                class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                wire:click="clearModal">Cancelar</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Guardar</button>
        </div>
    </form>
</div>
