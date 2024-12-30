<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nueva Gaceta</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('gazettes.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="name">Título del Documento  <span class="text-danger tx-12">*</span></label>
                            <input type="text" name="name" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="document_number">Folio <span class="text-danger tx-12">*</span></label>
                            <input type="text" name="document_number" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="meeting_date">Fecha de Publicación  <span class="text-danger tx-12">*</span></label>
                            <input type="date" name="meeting_date" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="type">Tipo de Sesión <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" name="type" required>
                                <option value="solemn">Sesiones Solemnes</option>
                                <option value="ordinary">Sesiones Ordinarias</option>
                                <option value="extraordinary">Sesiones Extraordinarias</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description">Descripción Breve <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="document">Documento <span class="text-danger tx-12">*</span></label>
                            <input type="file" name="document" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <p class="mb-0">El documento debe ser en formato PDF, puedes agregar archivos adicionales más adelante.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-de-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->