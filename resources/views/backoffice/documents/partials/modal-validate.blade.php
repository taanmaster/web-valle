{{--
    Partial: modal-validate
    Modal para que el revisor registre su validación y pase el oficio al siguiente colaborador.
    Usa Select2 (inicializado en scripts.blade.php) sobre #next_assigned_to.

    Variables heredadas del padre (scope @include):
        $document, $availableUsers
--}}
<div class="modal fade" id="validateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i> Validar Oficio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backoffice.documents.validate', $document->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check me-2"></i>
                        Esta será la validación #{{ $document->validations_count + 1 }} de 3 requeridas.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Enviar al siguiente colaborador <span class="text-danger">*</span></label>
                        <select name="next_assigned_to" id="next_assigned_to" class="form-select" required>
                            <option value="">Seleccionar colaborador...</option>
                            @foreach($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje (opcional)</label>
                        <textarea name="validation_message" class="form-control" rows="3" placeholder="Mensaje para el siguiente colaborador..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle me-2"></i> Validar y Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
