<div class="modal fade" id="fractionModal" tabindex="-1" role="dialog" aria-labelledby="fractionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nueva Fracción</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Fracción<span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" wire:model="fraction" name="fraction" required>
                        </div>

                        <!-- Información básica -->
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" wire:model="name" name="name" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" wire:model="description" name="description" rows="3"></textarea>
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
