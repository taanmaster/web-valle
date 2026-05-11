<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title m-0" id="modalCreateLabel">Nuevo Apoyo Económico</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('financial_supports.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="int_num" class="form-label fw-semibold">Folio</label>
                            <input type="text" class="form-control" id="int_num" name="int_num"
                                value="{{ $nextFolio }}" readonly>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="citizen_id" class="form-label fw-semibold">Beneficiario <span class="text-danger">*</span></label>
                            <select class="form-select" id="citizen_id" name="citizen_id" required>
                                <option value="">Selecciona una opción</option>
                                @foreach ($citizens as $citizen)
                                    <option value="{{ $citizen->id }}">{{ $citizen->name }} {{ $citizen->first_name }}
                                        {{ $citizen->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="receipt_num" class="form-label fw-semibold">Número de Recibo</label>
                            <input type="text" class="form-control" id="receipt_num" name="receipt_num">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="type_id" class="form-label fw-semibold">Tipo de Apoyo <span class="text-danger">*</span></label>
                            <select class="form-select" id="type_id" name="type_id" required>
                                <option value="">Selecciona una opción</option>
                                @foreach ($support_types as $support_type)
                                    <option value="{{ $support_type->id }}">{{ $support_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
