<div>
    <div class="modal-header bg-dark">
        @if ($income == null)
            <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Ingreso</h6>
        @else
            <h6 class="modal-title m-0 text-white" id="modalCreate">Editar Ingreso</h6>
        @endif

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div><!--end modal-header-->

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="modal-body pd-25">
            <div class="row">
                <!-- Información básica -->
                <div class="col-md-12 mb-3">
                    <label for="order_number" class="form-label">Tipo <span class="text-danger tx-12">*</span></label>
                    <select class="form-select" aria-label="Default select example" wire:model="type" required>
                        <option selected>Seleccionar una opción</option>
                        <option value="Administración centralizada" selected>Administración centralizada
                        </option>
                        <option value="Entidades paramunicipales">Entidades paramunicipales</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="order_number" class="form-label">Entidad <span
                            class="text-danger tx-12">*</span></label>
                    <select class="form-select" aria-label="Default select example" wire:model="entity" name="entity"
                        required>
                        <option selected>Seleccionar una opción</option>
                        <option value="Secretaría del Ayuntamiento">Secretaría del Ayuntamiento</option>
                        <option value="Fiscalización y control">Fiscalización y control</option>
                        <option value="Protección civíl">Protección civíl</option>
                        <option value="Tesorería">Tesorería</option>
                        <option value="Catrasto e impuesto predial">Catrasto e impuesto predial</option>
                        <option value="Casa de la cultura">Casa de la cultura</option>
                        <option value="Comisión municipal y gimnasio">Comisión municipal y gimnasio</option>
                        <option value="Panteones">Panteones</option>
                        <option value="Mercado municipal">Mercado municipal</option>
                        <option value="Rastro municipal">Rastro municipal</option>
                        <option value="Servicio de limpia">Servicio de limpia</option>
                        <option value="Alumbrado público">Alumbrado público</option>
                        <option value="Parques y Jardines">Parques y Jardines</option>
                        <option value="Movidilidad y transporte">Movidilidad y transporte</option>
                        <option value="Padrones municipales">Padrones municipales</option>
                        <option value="Licitaciones y proveeduría">Licitaciones y proveeduría</option>
                        <option value="DIF municipal">DIF municipal</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="order_number" class="form-label">Ley <span class="text-danger tx-12">*</span></label>
                    <input type="text" class="form-control" wire:model="law" name="law" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="order_number" class="form-label">Total <span class="text-danger tx-12">*</span></label>
                    <input type="text" class="form-control" wire:model="total" name="total" required>
                </div>

            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
        </div>
    </form>
</div>
