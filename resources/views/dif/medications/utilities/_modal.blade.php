<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Medicamento</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('dif.medications.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="generic_name" class="form-label">Nombre genérico <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="generic_name" name="generic_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="commercial_name" class="form-label">Nombre comercial <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="commercial_name" name="commercial_name">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="formula" class="form-label">Fórmula <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="formula" name="formula" rows="2"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Presentación</label>
                            <input type="text" class="form-control" id="type" name="type">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="type_num" class="form-label">Cantidad</label>
                            <input type="text" class="form-control" id="type_num" name="type_num">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="type_dosage" class="form-label">Unidad</label>
                            <input type="text" class="form-control" id="type_dosage" name="type_dosage">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="use_type" class="form-label">Vía de administración</label>
                            <input type="text" class="form-control" id="use_type" name="use_type">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="expiration_date" class="form-label">Fecha de expiración <span class="text-danger tx-12">*</span></label>
                            <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Activo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar Medicamento</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
