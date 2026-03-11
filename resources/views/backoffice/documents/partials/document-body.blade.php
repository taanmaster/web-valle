{{--
    Partial: document-body
    Muestra la card principal con toda la información del oficio:
    folio, fechas, tipo, prioridad, dependencia, remitente, creador,
    solicitante, asunto, cuerpo y (si existe) la firma/sello.

    Variables heredadas del padre (scope @include):
        $document
--}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-white"><i class="fas fa-file-alt me-2"></i> Oficio {{ $document->folio }}</h5>
        <div>
            {!! $document->status_badge !!}
            {!! $document->priority_badge !!}
        </div>
    </div>
    <div class="card-body p-4">

        <!-- Información General -->
        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2 text-primary"></i> Información General</h6>
        <div class="row mb-4">
            <div class="col-md-3">
                <small class="text-muted d-block">Folio</small>
                <strong class="text-primary">{{ $document->folio }}</strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Fecha de Expedición</small>
                <strong>{{ $document->issue_date->format('d/m/Y') }}</strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Tipo</small>
                {!! $document->type_badge !!}
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Prioridad</small>
                {!! $document->priority_badge !!}
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <small class="text-muted d-block">Dependencia Destino</small>
                <strong>{{ $document->dependency->name ?? '-' }}</strong>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Remitente (Director Destino)</small>
                <strong>{{ $document->sender }}</strong>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <small class="text-muted d-block">Creado por</small>
                <strong>{{ $document->user->name ?? '-' }}</strong>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Solicitante (Director Origen)</small>
                <strong>{{ $document->requester }}</strong>
            </div>
        </div>

        <!-- Asunto -->
        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-tag me-2 text-primary"></i> Asunto</h6>
        <p class="mb-4">{{ $document->subject }}</p>

        <!-- Cuerpo del Oficio -->
        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-file-alt me-2 text-primary"></i> Cuerpo del Oficio</h6>
        <div class="bg-light p-4 rounded mb-4" style="white-space: pre-wrap;">{{ $document->body }}</div>

        <!-- Firma y Sello (si existe) -->
        @if($document->signature_s3_url)
            <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-signature me-2 text-primary"></i> Firma y Sello</h6>
            <div class="row mb-4">
                <div class="col-md-6">
                    <small class="text-muted d-block mb-2">Firma</small>
                    <img src="{{ $document->signature_s3_url }}" alt="Firma" class="img-fluid border rounded" style="max-height: 150px;">
                </div>
                @if($document->stamp_s3_url)
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-2">Sello</small>
                        <img src="{{ $document->stamp_s3_url }}" alt="Sello" class="img-fluid border rounded" style="max-height: 150px;">
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
