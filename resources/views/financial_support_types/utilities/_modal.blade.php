<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title m-0" id="modalCreateLabel">Nuevo Tipo de Apoyo</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('financial_support_types.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-semibold">Descripción <span class="text-muted fw-normal">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="monthly_cap" class="form-label fw-semibold">Monto <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="monthly_cap" name="monthly_cap" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Documentación Necesaria</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_birth_certificate" name="documents[]" value="Acta de nacimiento">
                                        <label class="form-check-label" for="doc_birth_certificate">Acta de nacimiento</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_ine" name="documents[]" value="INE">
                                        <label class="form-check-label" for="doc_ine">INE</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_address_proof" name="documents[]" value="Comprobante de domicilio">
                                        <label class="form-check-label" for="doc_address_proof">Comprobante de domicilio</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_rfc" name="documents[]" value="RFC">
                                        <label class="form-check-label" for="doc_rfc">RFC</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_death_certificate" name="documents[]" value="Acta de defunción">
                                        <label class="form-check-label" for="doc_death_certificate">Acta de defunción</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_funeral_payment" name="documents[]" value="Hoja de paga funeraria">
                                        <label class="form-check-label" for="doc_funeral_payment">Hoja de paga funeraria</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_cemetery_docs" name="documents[]" value="Documentos del panteón">
                                        <label class="form-check-label" for="doc_cemetery_docs">Documentos del panteón</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_study_certificate" name="documents[]" value="Constancia de estudios">
                                        <label class="form-check-label" for="doc_study_certificate">Constancia de estudios</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_medical_prescriptions" name="documents[]" value="Recetas médicas">
                                        <label class="form-check-label" for="doc_medical_prescriptions">Recetas médicas</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_medical_certificate" name="documents[]" value="Constancia médica">
                                        <label class="form-check-label" for="doc_medical_certificate">Constancia médica</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc_hospital_visit_card" name="documents[]" value="Tarjetón de visita al hospital">
                                        <label class="form-check-label" for="doc_hospital_visit_card">Tarjetón de visita al hospital</label>
                                    </div>
                                </div>
                            </div>
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