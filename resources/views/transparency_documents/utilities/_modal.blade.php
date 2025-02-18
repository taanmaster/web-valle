<!-- Modal para crear un nuevo documento -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreateLabel">Nuevo Documento</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('transparency_documents.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="year" class="form-label">Año <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="year" name="year" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            @php
                                $periodOptions = [];
                                $periodLabel = '';

                                switch ($transparency_obligation->update_period) {
                                    case 'Trimestral':
                                        $periodOptions = ['1', '2', '3', '4'];
                                        $periodLabel = 'Periodo Trimestral al que pertenece:';
                                        break;
                                    case 'Anual':
                                        $periodOptions = ['1'];
                                        $periodLabel = 'Periodo Anual al que pertenece:';
                                        break;
                                    case 'Semestral':
                                        $periodOptions = ['1', '2'];
                                        $periodLabel = 'Periodo Semestral al que pertenece:';
                                        break;
                                    default:
                                        $periodOptions = ['1'];
                                        $periodLabel = 'Periodo al que pertenece:';
                                        break;
                                }
                            @endphp
                            <label for="period" class="form-label">{{ $periodLabel }} <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="period" name="period" required>
                                @foreach($periodOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="filename" class="form-label">Archivo <span class="text-danger tx-12">*</span></label>
                            <input type="file" class="form-control" id="filename" name="filename" required>
                        </div>

                        <input type="hidden" name="obligation_id" value="{{ $transparency_obligation->id }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar Documento</button>
                </div>
            </form>
        </div>
    </div>
</div>