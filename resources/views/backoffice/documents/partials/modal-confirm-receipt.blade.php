{{--
    Partial: modal-confirm-receipt
    Modal de confirmación de lectura al recibir un oficio asignado.
    Solo se renderiza cuando $showConfirmModal es true.
    El backend marca la fecha de primera lectura al confirmar.

    Variables heredadas del padre (scope @include):
        $document, $showConfirmModal
--}}
@if($showConfirmModal)
<div class="modal fade" id="confirmReceiptModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-envelope-open me-2"></i> Confirmar Recibo</h5>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-envelope-open-text fa-4x text-info mb-3"></i>
                <h5>Nuevo Oficio Asignado</h5>
                <p class="text-muted">Has recibido el oficio <strong>{{ $document->folio }}</strong> para su revisión.</p>
                <p class="mb-0">Por favor confirma que has recibido y leído este documento.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form action="{{ route('backoffice.documents.confirm-receipt', $document->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-info btn-lg">
                        <i class="fas fa-check me-2"></i> Confirmar Recibo y Leído
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
