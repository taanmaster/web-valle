{{--
    Partial: actions-send-review
    CTA para que el creador envíe su borrador a revisión.
    Visible solo cuando el usuario actual es el creador y el oficio está en borrador.

    Variables heredadas del padre (scope @include):
        $document
--}}
@if($document->user_id == Auth::id() && $document->status == 'borrador')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4 text-center">
        <h5 class="mb-3"><i class="fas fa-paper-plane me-2"></i> Enviar para Revisión</h5>
        <p class="text-muted mb-4">Tu oficio está listo. Envíalo a un colaborador para su revisión.</p>
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#sendReviewModal">
            <i class="fas fa-paper-plane me-2"></i> Enviar para su Revisión
        </button>
    </div>
</div>
@endif
