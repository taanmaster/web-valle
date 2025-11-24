<div>
    @if ($mode != 0)
        <div class="row justify-content-end">
            <div class="col-md-4">

            </div>
        </div>
    @endif
    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Información</h4>
                    </div>
                    <div class="row card-body">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Nombre genérico <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required
                                wire:model="title" @if ($mode == 1) disabled @endif>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                @if ($mode == 1) disabled @endif wire:model="description"></textarea>
                        </div>

                    </div>
                </div>
                @if ($mode != 0)
                    <div class="card">
                        <div class="card-header">
                            <h4>Inventario</h4>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                @if ($mode != 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Estado</h4>
                            <div class="card-body">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" checked>
                                        <label class="form-check-label" for="is_active">Activo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Organización</h4>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-dark btn-sm">Guardar Medicamento</button>
                <a href="{{ route('acquisitions.materials.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
            </div>
        </div>
    </form>
</div>
