<div>
    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="modal-body pd-25">
            <div class="row">
                <!-- Información básica -->
                <div class="col-md-12 mb-3">
                    <label for="section" class="form-label">Sección <span class="text-danger tx-12">*</span></label>
                    <input type="text" class="form-control" wire:model="section" name="section" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="order_number" class="form-label">Número/Orden <span
                            class="text-danger tx-12">*</span></label>
                    <input type="text" class="form-control" wire:model="order_number" name="order_number" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="order_number" class="form-label">Tipo <span class="text-danger tx-12">*</span></label>
                    <select class="form-select" aria-label="Default select example" wire:model.change="type" required>
                        <option selected>Seleccionar una opción</option>
                        <option value="Tarifa/Costo" selected>Tarifa/Costo</option>
                        <option value="Informativo">Informativo</option>
                    </select>
                </div>

                @switch($type)
                    @case('Tarifa/Costo')
                        <div class="col-md-6 mb-3">
                            <label for="quote" class="form-label">Concepto</label>
                            <input type="text" class="form-control" wire:model="concept" name="concept" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="quote" class="form-label">Tarifa/Costo</label>
                            <input type="text" class="form-control" wire:model="cost" name="cost" required>
                        </div>
                    @break

                    @case('Informativo')
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" wire:model="description" name="description" rows="3"></textarea>
                        </div>
                    @break
                @endswitch
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
        </div>
    </form>
</div>
