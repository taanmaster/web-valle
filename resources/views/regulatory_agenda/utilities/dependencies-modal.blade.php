<div>
    <div class="modal-header bg-dark">
        @if ($dependency == null)
            <h6 class="modal-title m-0 text-white" id="modalCreate">Nueva Dependencia</h6>
        @else
            <h6 class="modal-title m-0 text-white" id="modalCreate">Editar Dependencia</h6>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div><!--end modal-header-->

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="modal-body pd-25">
            <div class="row">
                <!-- Información básica -->
                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                    <input type="text" class="form-control" wire:model="name" name="name" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">Descripción <span
                            class="text-info tx-12">(Opcional)</span></label>
                    <textarea class="form-control" wire:model="description" name="description" rows="3"></textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.boolean="in_index" name="in_index" id="in_index" value="1">
                        <label class="form-check-label" for="in_index">
                            Mostrar en el índice público (front)
                        </label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre de Enlace de Mejora Regulatoria</label>
                        <input type="text" class="form-control" wire:model="fullname_connection"
                            name="fullname_connection">
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label">Cargo de Enlace de Mejora Regulatoria</label>
                        <input type="text" class="form-control" wire:model="title_connection"
                            name="title_connection">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre de Títular de la dependencía</label>
                        <input type="text" class="form-control" wire:model="fullname_lider" name="fullname_lider">
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label">Cargo de Títular de la dependencía</label>
                        <input type="text" class="form-control" wire:model="title_lider" name="title_lider">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
        </div>
    </form>
</div>
