<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Checklist</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('treasury_account_payable_checklists.store') }}">
                {{ csrf_field() }}

                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="status" class="form-label">Estado <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
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