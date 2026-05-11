<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title m-0" id="modalCreateLabel">Nuevo Particular</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('citizens.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre del Beneficiario <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label fw-semibold">Primer Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label fw-semibold">Segundo Apellido <span class="text-danger">*</span></label>
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
                            <label for="email" class="form-label fw-semibold">Correo Electrónico <span class="text-muted fw-normal">(Opcional)</span></label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="curp" class="form-label fw-semibold">CURP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="curp" name="curp" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ine_number" class="form-label fw-semibold">INE Número <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ine_number" name="ine_number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ine_section" class="form-label fw-semibold">Sección <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ine_section" name="ine_section" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label fw-semibold">Calle y número <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="colony" class="form-label fw-semibold">Colonia <span class="text-danger">*</span></label>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Guardar
                    </button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
