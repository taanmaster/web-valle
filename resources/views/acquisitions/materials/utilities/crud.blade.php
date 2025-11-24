<div>

    <div class="row">
        <div class="col-8">
            <div class="card card-body">
                <form method="POST" wire:submit="save" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="generic_name" class="form-label">Nombre genérico <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="generic_name" name="generic_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="commercial_name" class="form-label">Nombre comercial <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <input type="text" class="form-control" id="commercial_name" name="commercial_name">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="formula" class="form-label">Fórmula <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="formula" name="formula" rows="2"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="is_active">Activo</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark btn-sm">Guardar Medicamento</button>
                            <a href="{{ route('acquisitions.materials.index') }}"
                                class="btn btn-secondary btn-sm">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
