<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Proveedor</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('treasury_account_payable_suppliers.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="rfc" class="form-label">RFC <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="rfc" name="rfc">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Correo Electrónico <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="phone" class="form-label">Teléfono <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="account_name" class="form-label">Nombre de la Cuenta <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="account_name" name="account_name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="account_number" class="form-label">Número de Cuenta <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="account_number" name="account_number">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="bank_name" class="form-label">Banco <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="dependency_name" class="form-label">Dependencia <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="dependency_name" name="dependency_name">
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