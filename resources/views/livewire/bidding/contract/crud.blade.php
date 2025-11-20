<div>
    <div class="modal-header">
        @if ($contract != null)
            @switch($mode)
                @case(1)
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ver Contrato/Modificatorio</h1>
                @break

                @case(2)
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Contrato/Modificatorio</h1>
                @break
            @endswitch
        @else
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo Contrato/Modificatorio</h1>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            wire:click="clearModal"></button>
    </div>

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="type" class="form-label">Tipo de documento *</label>
                    <select name="type" id="type" wire:model="type" class="form-control" required>
                        <option selected>Selecciona una opción</option>

                        @php
                            $hasContract = $bidding->contracts()->where('type', 'Contrato')->exists();
                        @endphp

                        @if ($hasContract == null)
                            <option value="Contrato">Contrato</option>
                        @endif
                        <option value="Modificatorio">Modificatorio</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Fecha de Inicio *</label>
                    <input type="date" class="form-control" id="start_date" wire:model="start_date" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Fecha de Fin *</label>
                    <input type="date" class="form-control" id="end_date" wire:model="end_date" required>
                </div>
            </div>
            <div class="row">
                <h5>Documento</h5>
                <div class="mb-3">
                    <label for="file_name" class="form-label">Nombre del documento *</label>
                    <input type="text" class="form-control" id="file_name" wire:model="file_name" required>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Documento *</label>
                    <input type="file" class="form-control" id="file" wire:model="file" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                wire:click="clearModal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
