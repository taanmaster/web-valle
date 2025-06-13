<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nueva Obligación</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('transparency_obligations.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body pd-25">
                    <div class="row">
                        @if(isset($transparency_dependency))
                        <input type="hidden" name="dependency_id" value="{{ $transparency_dependency->id }}">
                        @else
                        <div class="col-md-12 mb-3">
                            <label for="dependency_id" class="form-label">Dependencia <span class="text-danger tx-12">*</span></label>
                            <select name="dependency_id" id="dependency_id" class="form-control" required>
                                <option value="">Seleccione una dependencia</option>
                                @foreach($transparency_dependencies as $dependency)
                                <option value="{{ $dependency->id }}">{{ $dependency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipo <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="Especifica">Especifica</option>
                                <option value="Común">Común</option>
                                <option value="Aplicabilidad">Tabla de Aplicabilidad</option>
                                <option value="Clasificados">Índice de expedientes clasificados</option>
                                <option value="Graficas">Gráficas Informativas</option>
                                <option value="Proactiva">Transparencia Proactiva</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="update_period" class="form-label">Periodo de Actualización <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="update_period" name="update_period" required>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Anual">Anual</option>
                                <option value="Semestral">Semestral</option>
                                <option value="Trianual">Trianual</option>
                                <option value="Mensual">Mensual</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div>
    </div>
</div>