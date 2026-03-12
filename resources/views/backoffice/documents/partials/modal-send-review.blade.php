{{--
    Partial: modal-send-review
    Modal para que el creador envíe el borrador al colaborador elegido.
    Usa Select2 (inicializado en scripts.blade.php) sobre #assigned_to_review.

    Variables heredadas del padre (scope @include):
        $document, $availableUsers
--}}
<div class="modal fade" id="sendReviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-paper-plane me-2"></i> Enviar para Revisión</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backoffice.documents.send-review', $document->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Colaborador <span class="text-danger">*</span></label>
                        <select name="assigned_to" id="assigned_to_review" class="form-select" required>
                            <option value="">Buscar colaborador...</option>
                            @foreach($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje (opcional)</label>
                        <textarea name="assignment_message" class="form-control" rows="3" placeholder="Escriba un mensaje para el colaborador..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i> Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
