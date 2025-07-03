<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Doctor</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('dif.doctors.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre Completo <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="specialty_id" class="form-label">Especialidad <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="specialty_id" name="specialty_id" required>
                                <option value="">Seleccionar especialidad...</option>
                                @foreach(\App\Models\DIFSpecialty::all() as $specialty)
                                    <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="full_address" class="form-label">Dirección Completa <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="full_address" name="full_address" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electrónico <span class="text-danger tx-12">*</span></label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>

                        <hr>
                        
                        <div class="col-md-12 mb-3">
                            <label for="employee_num" class="form-label">Número de Empleado <span class="text-info tx-12">(Generado automáticamente)</span></label>
                            <input type="text" class="form-control" id="employee_num" name="employee_num" value="{{ Str::random(8) }}" readonly>
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
