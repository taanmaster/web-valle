<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nueva Convocatoria</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('trn_proposals.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title">Título de la Convocatoria <span class="text-danger tx-12">*</span></label>
                            <input type="text" name="title" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description">Descripción <span class="text-danger tx-12">*</span></label>
                            <textarea name="description" class="form-control" cols="30" rows="5" required=""></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="document">Documento <span class="text-danger tx-12">*</span></label>
                            <input type="file" name="document" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="in_index" id="in_index" checked>
                                <label class="form-check-label" for="in_index">
                                    Visible en el Front Público
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <p class="mb-0">El documento debe ser en formato PDF, DOC, DOCX o ZIP. Tamaño máximo: 50MB.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-de-dark btn-sm">Guardar Convocatoria</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->