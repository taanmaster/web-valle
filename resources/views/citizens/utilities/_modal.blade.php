<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Ciudadano</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('citizens.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre del Beneficiario <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">Primer Apellido <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Segundo Apellido <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>

                        {{--  
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        --}}

                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Correo Electrónico <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="curp" class="form-label">CURP <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="curp" name="curp" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ine_number" class="form-label">INE Número <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="ine_number" name="ine_number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ine_section" class="form-label">Sección <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="ine_section" name="ine_section" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Calle y número <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Colonia <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="colony" name="colony" required>
                        </div>

                        {{--
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                         --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-de-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
