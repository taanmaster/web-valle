{{--
    Partial: modal-correction
    Modal para que el revisor devuelva el oficio al creador con comentarios de corrección.
    El oficio pasa de 'revision' a 'borrador' y se registra la versión con activity_type 'correccion_solicitada'.

    Variables heredadas del padre (scope @include):
        $document
--}}
<div class="modal fade" id="correctionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-undo me-2"></i> Solicitar Corrección</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backoffice.documents.request-correction', $document->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        El oficio será devuelto a <strong>{{ $document->user->name ?? 'el creador' }}</strong> para correcciones.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especifique las correcciones requeridas <span class="text-danger">*</span></label>
                        <textarea name="correction_message" class="form-control" rows="5" placeholder="Describa detalladamente las correcciones necesarias..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-undo me-2"></i> Solicitar Corrección
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
