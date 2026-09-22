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
                    <h6 class="mb-0 text-uppercase text-muted"><i class="fas fa-file-alt me-1"></i> Oficio recibido · Solo lectura</h6>
                    <span class="badge bg-{{ $review->status_color }}">{{ $review->status_label }}</span>
                </div>
                <div class="card-body p-4">
                    <p class="mb-1"><strong>Folio No.</strong> {{ $req?->folio }}</p>
                    <p class="text-muted small mb-4">
                        <strong>Asunto:</strong> Solicitud de Factibilidad de Protección Civil (Opinión Técnica),
                        respecto del trámite que se señala a continuación.
                    </p>

                    <p class="mb-3">
                        AYUNTAMIENTO DE VALLE DE SANTIAGO, GUANAJUATO<br>
                        DIRECCIÓN GENERAL DE DESARROLLO URBANO Y MEDIO AMBIENTE
                    </p>
                    <p class="mb-3">
                        C. TITULAR DE LA COORDINACIÓN MUNICIPAL DE PROTECCIÓN CIVIL<br>
                        P R E S E N T E.
                    </p>
                    <p class="text-muted small mb-4">
                        Por medio del presente, y con fundamento en las disposiciones aplicables en materia de
                        protección civil y desarrollo urbano, esta Dirección de Desarrollo Urbano y Medio Ambiente
                        solicita atentamente se sirva emitir la Factibilidad de Protección Civil que se detalla a
                        continuación:
                    </p>

                    <div class="border rounded p-3 mb-3">
                        <dl class="row mb-0">
                            <dt class="col-sm-5 text-muted fw-normal">Nombre del ciudadano</dt>
                            <dd class="col-sm-7 fw-bold">{{ $req?->user?->name ?? '—' }}</dd>
                            <dt class="col-sm-5 text-muted fw-normal">Responsable o representante legal</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->responsible_name ?: '—' }}</dd>
                            <dt class="col-sm-5 text-muted fw-normal">Domicilio del inmueble</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->property_address ?: '—' }}</dd>
                            <dt class="col-sm-5 text-muted fw-normal">Tipo de trámite</dt>
                            <dd class="col-sm-7 fw-bold">{{ $req?->getRequestTypeLabelAttribute() }}</dd>
                            <dt class="col-sm-5 text-muted fw-normal">Tipo de construcción / uso de suelo</dt>
                            <dd class="col-sm-7 fw-bold">{{ $review->construction_type ?: '—' }}</dd>
                        </dl>
                    </div>

                    <p class="text-muted small mb-0">
                        Lo anterior, con la finalidad de contar con la opinión técnica correspondiente y, en su
                        caso, determinar las condiciones, medidas preventivas y recomendaciones en materia de
                        protección civil que resulten aplicables al inmueble y/o actividad objeto del trámite.
                    </p>

                    <p class="text-muted small mt-4 mb-0">
                        Valle de Santiago, Gto., a {{ $review->sent_at?->format('d/m/Y') }}.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-dictamen text-white">
                    <h6 class="text-white mb-0">Emitir opinión técnica</h6>
                    <small class="text-white-50">Resolución de Protección Civil</small>
                </div>
                <div class="card-body p-4">
                    <form wire:submit="saveOpinion">
                        <div class="mb-3">
                            <label class="form-label d-block">Resolución <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input type="radio" wire:model="resolution" value="factible" class="form-check-input" id="res_factible">
                                <label class="form-check-label" for="res_factible">Factible</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" wire:model="resolution" value="factible_con_condicionantes" class="form-check-input" id="res_factible_cond">
                                <label class="form-check-label" for="res_factible_cond">Factible con condicionantes</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" wire:model="resolution" value="no_factible" class="form-check-input" id="res_no_factible">
                                <label class="form-check-label" for="res_no_factible">No factible</label>
                            </div>
                            @error('resolution') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. de inspección / visita</label>
                            <input type="text" wire:model="reference_number" class="form-control" placeholder="Ej. INS-2026-0412">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Medidas preventivas y observaciones <span class="text-danger">*</span></label>
                            <textarea wire:model="technical_notes" rows="4" class="form-control @error('technical_notes') is-invalid @enderror"
                                placeholder="Condiciones, medidas preventivas y recomendaciones aplicables al inmueble o actividad..."></textarea>
                            @error('technical_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Requisitos a cargo del interesado</label>
                            <textarea wire:model="conditions_requirements" rows="3" class="form-control"
                                placeholder="Documentos o acciones previas a la continuación del trámite..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Emite (nombre y cargo) <span class="text-danger">*</span></label>
                            <input type="text" wire:model="issued_by" class="form-control @error('issued_by') is-invalid @enderror"
                                placeholder="Titular de Protección Civil">
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
                            <a href="{{ route('proteccion_civil.requests.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-danger">
                                <span wire:loading wire:target="saveOpinion" class="spinner-border spinner-border-sm me-1"></span>
                                Enviar solicitud a Protección Civil
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
