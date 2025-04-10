<div class="modal fade" id="conceptModal" tabindex="-1" role="dialog" aria-labelledby="conceptModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Artículo</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body pd-25">
                    <div class="row">
                        <!-- Información básica -->
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">CRI <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" wire:model="CRI" name="CRI" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Concepto <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" wire:model="concept" name="concept" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Ingreso estimado <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" wire:model="estimated_income"
                                name="estimated_income" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
