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
                    <label for="file_name" class="form-label">Nombre del entregable *</label>
                    <input type="text" class="form-control" id="file_name" wire:model="file_name" required>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Fecha de Entrega *</label>
                    <input type="date" class="form-control" id="due_date" wire:model="due_date" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="quantity" wire:model="quantity">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unidad</label>
                        <input type="text" class="form-control" id="unit" wire:model="unit">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="description" wire:model="description">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" wire:model="name">
                    </div>
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
