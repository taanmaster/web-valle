
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Texto Legal</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('legals.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label>Titulo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" />
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Prioridad <span class="text-info">(Opcional)</span></label>
                            <select class="form-control" name="priority">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Texto</label>
                    
                        <textarea class="form-control" name="description" required="" rows="20"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-de-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div>
    </div>
</div>