@php $req = $review->urbanDevRequest; @endphp
<div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-uppercase text-muted"><i class="fas fa-file-alt me-1"></i> Formato recibido · Solo lectura</h6>
                    <span class="badge bg-{{ $review->status_color }}">{{ $review->status_label }}</span>
                </div>
                <div class="card-body p-4">
                    <p class="mb-1"><strong>Folio:</strong> {{ $req?->folio }}</p>
                    <p class="text-muted small mb-4">
                        <strong>Asunto:</strong> Solicitud de Visto Bueno y Emisión de {{ $review->format_label }}.
                    </p>

                    @if ($review->format === 'licencia_ambiental_funcionamiento')
                        <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3">I. Datos del solicitante y del predio</h6>
                        <dl class="row mb-4">
                            <dt class="col-sm-5 text-muted fw-normal">Ciudadano o responsable legal</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->responsible_name ?: '—' }}</dd>
                            <dt class="col-sm-5 text-muted fw-normal">Denominación del establecimiento</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->establishment_name ?: '—' }}</dd>
                            <dt class="col-sm-5 text-muted fw-normal">Dirección</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->property_address ?: '—' }}</dd>
                        </dl>
                    @elseif ($review->format === 'manejo_de_residuos')
                        <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3">I. Datos del solicitante</h6>
                        <dl class="row mb-4">
                            <dt class="col-sm-5 text-muted fw-normal">Ciudadano que tramita</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->responsible_name ?: '—' }}</dd>
                        </dl>
                    @else
                        <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3">I. Datos del solicitante o responsable</h6>
                        <dl class="row mb-4">
                            <dt class="col-sm-5 text-muted fw-normal">Ciudadano o razón social</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->responsible_name ?: '—' }}</dd>
                            <dt class="col-sm-5 text-muted fw-normal">Responsable técnico o promovente</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->technical_responsible ?: '—' }}</dd>
                        </dl>
                    @endif

                    <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3">
                        {{ $review->format === 'licencia_ambiental_funcionamiento' ? 'II. Ubicación y coordenadas geográficas' : 'II. Ubicación y localización del predio' }}
                    </h6>
                    <dl class="row mb-4">
                        @if ($review->format !== 'licencia_ambiental_funcionamiento')
                            <dt class="col-sm-5 text-muted fw-normal">Domicilio del predio</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->property_address ?: '—' }}</dd>
                        @endif
                        @if ($review->latitude || $review->longitude)
                            <dt class="col-sm-5 text-muted fw-normal">Coordenadas geográficas (WGS84)</dt>
                            <dd class="col-sm-7 fw-bold">Lat {{ $review->latitude ?: '—' }} / Long {{ $review->longitude ?: '—' }}</dd>
                        @endif
                    </dl>

                    <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3">III. Tipo de trámite</h6>
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted fw-normal">Tipo de trámite</dt>
                        <dd class="col-sm-7 fw-bold">{{ $req?->getRequestTypeLabelAttribute() }}</dd>
                    </dl>

                    <p class="text-muted small mt-4 mb-0">
                        Valle de Santiago, Gto., a {{ $review->sent_at?->format('d/m/Y') }}.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-dictamen text-white">
                    <h6 class="text-white mb-0">Emitir visto bueno</h6>
                    <small class="text-white-50">{{ $review->format_label }}</small>
                </div>
                <div class="card-body p-4">
                    <form wire:submit="saveVistoBueno">
                        <div class="mb-3">
                            <label class="form-label d-block">Resolución <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input type="radio" wire:model="resolution" value="procedente" class="form-check-input" id="res_procedente">
                                <label class="form-check-label" for="res_procedente">Procedente</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" wire:model="resolution" value="procedente_con_condicionantes" class="form-check-input" id="res_procedente_cond">
                                <label class="form-check-label" for="res_procedente_cond">Procedente con condicionantes</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" wire:model="resolution" value="no_procedente" class="form-check-input" id="res_no_procedente">
                                <label class="form-check-label" for="res_no_procedente">No procedente</label>
                            </div>
                            @error('resolution') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. de dictamen / inspección</label>
                            <input type="text" wire:model="reference_number" class="form-control" placeholder="Ej. DMA-2026-0198">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Consideraciones técnicas ambientales <span class="text-danger">*</span></label>
                            <textarea wire:model="technical_notes" rows="4" class="form-control @error('technical_notes') is-invalid @enderror"
                                placeholder="Valoración del predio, impactos identificados y criterios aplicados..."></textarea>
                            @error('technical_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Condicionantes y medidas de mitigación</label>
                            <textarea wire:model="conditions_requirements" rows="3" class="form-control"
                                placeholder="Obligaciones ambientales a cargo del promovente..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Emite (nombre y cargo) <span class="text-danger">*</span></label>
                            <input type="text" wire:model="issued_by" class="form-control @error('issued_by') is-invalid @enderror"
                                placeholder="Titular de la Dirección de Medio Ambiente">
                            @error('issued_by') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        @if ($review->resolution_document_s3_url)
                            <div class="alert alert-light border mb-3">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                {{ $review->resolution_document_name }}
                                <a href="{{ $review->resolution_document_s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label">
                                Oficio de resolución firmado {{ $review->resolution_document_s3_url ? '(reemplazar)' : '' }}
                                <span class="text-danger">*</span>
                            </label>
                            <p class="text-muted small mb-1">Adjunta el oficio sellado y firmado. Se envía junto con la resolución a Desarrollo Urbano.</p>
                            <input type="file" wire:model="resolution_document" accept="application/pdf" class="form-control @error('resolution_document') is-invalid @enderror">
                            @error('resolution_document') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div wire:loading wire:target="resolution_document" class="form-text">Subiendo documento...</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('environment.urban_dev_requests.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-danger">
                                <span wire:loading wire:target="saveVistoBueno" class="spinner-border spinner-border-sm me-1"></span>
                                Guardar avance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-dictamen {
        background-color: #6d1b2b;
    }
</style>
