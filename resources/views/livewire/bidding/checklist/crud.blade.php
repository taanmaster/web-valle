<div>
    <div class="modal-header">
        @if ($checklist != null)
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Entregable</h1>
        @else
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo Entregable</h1>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            wire:click="clearModalCheck"></button>
    </div>

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="row">
                <div class="mb-3">
                    <label for="file_name" class="form-label">Nombre del documento *</label>
                    <input type="text" class="form-control" id="file_name" wire:model="file_name" required>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Fecha de Entrega *</label>
                    <input type="date" class="form-control" id="due_date" wire:model="due_date" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                wire:click="clearModalCheck">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
