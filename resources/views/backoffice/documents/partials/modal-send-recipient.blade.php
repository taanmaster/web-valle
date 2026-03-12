{{--
    Partial: modal-send-recipient
    Modal para seleccionar el contacto de la dependencia destino y enviar el oficio firmado.
    Usa Select2 con AJAX (inicializado en scripts.blade.php) sobre #sent_to_user_id.
    La carga inicial de opciones también se realiza vía AJAX en scripts.blade.php.

    Variables heredadas del padre (scope @include):
        $document
--}}
<div class="modal fade" id="sendRecipientModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-paper-plane me-2"></i> Enviar a Destinatario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backoffice.documents.send-to-recipient', $document->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Selecciona un contacto de la dependencia <strong>{{ $document->dependency->name ?? 'destino' }}</strong> para enviar este oficio firmado.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Destinatario <span class="text-danger">*</span></label>
                        <select name="sent_to_user_id" id="sent_to_user_id" class="form-select" required>
                            <option value="">Buscar contacto de la dependencia...</option>
                        </select>
                        <small class="text-muted">Solo se muestran usuarios de la dependencia destino.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje (opcional)</label>
                        <textarea name="sent_message" class="form-control" rows="3" placeholder="Escriba un mensaje para el destinatario..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-2"></i> Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
