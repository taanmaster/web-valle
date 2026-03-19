{{--
    Partial: actions-send-recipient
    CTA para enviar el oficio ya firmado a un contacto de la dependencia destino.
    Visible solo cuando status == 'firmado' y aún no se ha enviado (sent_to_user_id vacío).

    Variables heredadas del padre (scope @include):
        $document
--}}
@if($document->status == 'firmado' && !$document->sent_to_user_id)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4 text-center">
        <h5 class="mb-3"><i class="fas fa-paper-plane me-2 text-success"></i> Enviar a Destinatario</h5>
        <p class="text-muted mb-4">El oficio está firmado. Envíalo a un contacto de la dependencia <strong>{{ $document->dependency->name ?? 'destino' }}</strong>.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#sendRecipientModal">
                <i class="fas fa-paper-plane me-2"></i> Enviar a Destinatario
            </button>
            @php
                $downloadUrl = $document->efirma_merged_file
                    ? $document->efirma_merged_file
                    : route('backoffice.documents.pdf', $document->id);
            @endphp
            <a href="{{ $downloadUrl }}" class="btn btn-outline-danger btn-lg" target="_blank">
                <i class="fas fa-file-pdf me-2"></i> Descargar Oficio
            </a>
        </div>
    </div>
</div>
@endif
