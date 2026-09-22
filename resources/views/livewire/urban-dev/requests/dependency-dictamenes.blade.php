<div class="card mb-4">
    <div class="card-header bg-dictamen text-white">
        <h6 class="text-white mb-0">
            <i class="fas fa-stamp"></i>
            Dictámenes de otras dependencias
        </h6>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- PROTECCIÓN CIVIL --}}
        <div class="border rounded p-3 mb-3">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <strong>Protección Civil</strong>
                    <div class="text-muted small">Solicitud de Factibilidad (Opinión Técnica)</div>
                    @if (! $pcReview)
                        <p class="text-muted small mb-0 mt-2">
                            Solicita la opinión técnica en materia de protección civil sobre el inmueble o la
                            actividad objeto del trámite.
                        </p>
                    @else
                        <small class="text-muted d-block mt-2">
                            Enviado: {{ $pcReview->sent_at?->format('d/m/Y H:i') ?? '—' }}
                            — <span class="badge bg-{{ $pcReview->status_color }}">{{ $pcReview->status_label }}</span>
                        </small>
                    @endif
                </div>
                <div>
                    @if (! $pcReview)
                        @if (! $showPcForm)
                            <button type="button" wire:click="openPcForm" class="btn btn-danger">
                                <i class="fas fa-paper-plane"></i> Enviar solicitud a Protección Civil
                            </button>
                        @endif
                    @else
                        <a href="{{ route('proteccion_civil.requests.show', $pcReview) }}" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt"></i> Ver en Protección Civil
                        </a>
                    @endif
                </div>
            </div>

            @if ($showPcForm && ! $pcReview)
                <form wire:submit="sendToProteccionCivil" class="border-top pt-3 mt-3">
                    <p class="text-muted small">
                        Información para el oficio. Los campos se prellenan con lo que ya tiene el expediente.
                        Completa lo que falte antes de enviar.
                    </p>

                    <div class="mb-3">
                        <label class="form-label">Responsable o representante legal <span class="text-danger">*</span></label>
                        <input type="text" wire:model="pc_responsible_name" class="form-control @error('pc_responsible_name') is-invalid @enderror">
                        @error('pc_responsible_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de construcción / uso de suelo <span class="text-danger">*</span></label>
                        <input type="text" wire:model="pc_construction_type" class="form-control @error('pc_construction_type') is-invalid @enderror">
                        @error('pc_construction_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Domicilio del inmueble</label>
                        <input type="text" wire:model="pc_property_address" class="form-control">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" wire:click="cancelPcForm" class="btn btn-outline-secondary">Cancelar</button>
                        <button type="submit" class="btn btn-danger">
                            <span wire:loading wire:target="sendToProteccionCivil" class="spinner-border spinner-border-sm me-1"></span>
                            Enviar solicitud a Protección Civil
                        </button>
                    </div>
                </form>
            @endif

            @if ($pcReview && ($pcReview->resolution || $pcReview->technical_notes))
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-dictamen text-white d-flex justify-content-between align-items-center">
                        <h6 class="text-white mb-0 fw-bold">Factible / Opinión Técnica</h6>
                        @if ($pcReview->resolution)
                            <span class="badge bg-{{ $pcReview->resolution_color }}">{{ $pcReview->resolution_label }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <small class="text-muted text-uppercase fw-semibold d-block mb-2">Capturado por Protección Civil</small>
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center border rounded overflow-hidden">
                                    <span class="bg-warning-subtle px-3 py-2 fw-medium">No. de inspección / visita</span>
                                    <span class="px-3 py-2">{{ $pcReview->reference_number ?: '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center border rounded overflow-hidden">
                                    <span class="bg-warning-subtle px-3 py-2 fw-medium">Emitió</span>
                                    <span class="px-3 py-2">{{ $pcReview->issued_by ?: '—' }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start border rounded overflow-hidden">
                                    <span class="bg-warning-subtle px-3 py-2 fw-medium">Medidas preventivas y observaciones</span>
                                    <span class="px-3 py-2">{{ $pcReview->technical_notes ?: '—' }}</span>
                                </div>
                            </div>
                            @if ($pcReview->conditions_requirements)
                                <div class="col-12">
                                    <div class="d-flex align-items-start border rounded overflow-hidden">
                                        <span class="bg-warning-subtle px-3 py-2 fw-medium">Requisitos a cargo del interesado</span>
                                        <span class="px-3 py-2">{{ $pcReview->conditions_requirements }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($pcReview->resolution_document_s3_url)
                            <div class="d-flex align-items-center justify-content-between border rounded p-2 mt-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <div>
                                        <div class="fw-medium">{{ $pcReview->resolution_document_name }}</div>
                                        <small class="text-muted">{{ $pcReview->resolution_document_formatted_size }}</small>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ $pcReview->resolution_document_s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> Ver</a>
                                    <a href="{{ $pcReview->resolution_document_s3_url }}" download="{{ $pcReview->resolution_document_name }}" class="btn btn-sm btn-outline-success"><i class="fas fa-download"></i> Descargar</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- DIRECCIÓN DE MEDIO AMBIENTE --}}
        <div class="border rounded p-3">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <strong>Dirección de Medio Ambiente</strong>
                    <div class="text-muted small">Solicitud de Visto Bueno Ambiental</div>
                    @if (! $maReview)
                        <p class="text-muted small mb-0 mt-2">
                            Selecciona el formato aplicable según el giro y la magnitud del proyecto.
                        </p>
                    @else
                        <small class="text-muted d-block mt-2">
                            Formato: <strong>{{ $maReview->format_label }}</strong>
                            — Enviado: {{ $maReview->sent_at?->format('d/m/Y H:i') ?? '—' }}
                            — <span class="badge bg-{{ $maReview->status_color }}">{{ $maReview->status_label }}</span>
                        </small>
                    @endif
                </div>
                <div>
                    @if (! $maReview)
                        @if (! $showMaForm)
                            <button type="button" wire:click="openMaForm" class="btn btn-danger">
                                <i class="fas fa-paper-plane"></i> Enviar solicitud a Medio Ambiente
                            </button>
                        @endif
                    @else
                        <a href="{{ route('environment.urban_dev_requests.show', $maReview) }}" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt"></i> Ver en Medio Ambiente
                        </a>
                    @endif
                </div>
            </div>

            @if ($showMaForm && ! $maReview)
                <form wire:submit="sendToMedioAmbiente" class="border-top pt-3 mt-3">
                    <div class="mb-3">
                        <label class="form-label d-block">Formato a enviar <span class="text-danger">*</span></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" id="ma_format_alto" wire:model="ma_format" value="alto_impacto">
                            <label class="btn btn-outline-danger" for="ma_format_alto">Alto Impacto</label>

                            <input type="radio" class="btn-check" id="ma_format_licencia" wire:model="ma_format" value="licencia_ambiental_funcionamiento">
                            <label class="btn btn-outline-danger" for="ma_format_licencia">Licencia Ambiental de Funcionamiento</label>

                            <input type="radio" class="btn-check" id="ma_format_residuos" wire:model="ma_format" value="manejo_de_residuos">
                            <label class="btn btn-outline-danger" for="ma_format_residuos">Manejo de Residuos</label>
                        </div>
                        @error('ma_format') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <p class="text-muted small">
                        Información para el oficio. Los campos se prellenan con lo que ya tiene el expediente.
                        Completa lo que falte antes de enviar.
                    </p>

                    <div class="mb-3">
                        <label class="form-label">Ciudadano o representante legal <span class="text-danger">*</span></label>
                        <input type="text" wire:model="ma_responsible_name" class="form-control @error('ma_responsible_name') is-invalid @enderror">
                        @error('ma_responsible_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsable técnico o promovente</label>
                        <input type="text" wire:model="ma_technical_responsible" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giro o denominación del establecimiento <span class="text-danger">*</span></label>
                        <input type="text" wire:model="ma_establishment_name" class="form-control @error('ma_establishment_name') is-invalid @enderror">
                        @error('ma_establishment_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Domicilio del inmueble</label>
                        <input type="text" wire:model="ma_property_address" class="form-control">
                    </div>

                    @if ($ma_format === 'alto_impacto')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Latitud (WGS84) <span class="text-danger">*</span></label>
                                <input type="text" wire:model="ma_latitude" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Longitud (WGS84) <span class="text-danger">*</span></label>
                                <input type="text" wire:model="ma_longitude" class="form-control">
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" wire:click="cancelMaForm" class="btn btn-outline-secondary">Cancelar</button>
                        <button type="submit" class="btn btn-danger">
                            <span wire:loading wire:target="sendToMedioAmbiente" class="spinner-border spinner-border-sm me-1"></span>
                            Enviar solicitud a Medio Ambiente
                        </button>
                    </div>
                </form>
            @endif

            @if ($maReview && ($maReview->resolution || $maReview->technical_notes))
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-dictamen text-white d-flex justify-content-between align-items-center">
                        <h6 class="text-white mb-0 fw-bold">Visto Bueno Ambiental</h6>
                        @if ($maReview->resolution)
                            <span class="badge bg-{{ $maReview->resolution_color }}">{{ $maReview->resolution_label }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <small class="text-muted text-uppercase fw-semibold d-block mb-2">Capturado por Medio Ambiente</small>
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center border rounded overflow-hidden">
                                    <span class="bg-warning-subtle px-3 py-2 fw-medium">No. de dictamen</span>
                                    <span class="px-3 py-2">{{ $maReview->reference_number ?: '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center border rounded overflow-hidden">
                                    <span class="bg-warning-subtle px-3 py-2 fw-medium">Formato atendido</span>
                                    <span class="px-3 py-2">{{ $maReview->format_label }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start border rounded overflow-hidden">
                                    <span class="bg-warning-subtle px-3 py-2 fw-medium">Consideraciones técnicas ambientales</span>
                                    <span class="px-3 py-2">{{ $maReview->technical_notes ?: '—' }}</span>
                                </div>
                            </div>
                            @if ($maReview->conditions_requirements)
                                <div class="col-12">
                                    <div class="d-flex align-items-start border rounded overflow-hidden">
                                        <span class="bg-warning-subtle px-3 py-2 fw-medium">Condicionantes y medidas de mitigación</span>
                                        <span class="px-3 py-2">{{ $maReview->conditions_requirements }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="d-flex align-items-center border rounded overflow-hidden">
                                    <span class="bg-warning-subtle px-3 py-2 fw-medium">Emitió</span>
                                    <span class="px-3 py-2">{{ $maReview->issued_by ?: '—' }}</span>
                                </div>
                            </div>
                        </div>

                        @if ($maReview->resolution_document_s3_url)
                            <div class="d-flex align-items-center justify-content-between border rounded p-2 mt-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <div>
                                        <div class="fw-medium">{{ $maReview->resolution_document_name }}</div>
                                        <small class="text-muted">{{ $maReview->resolution_document_formatted_size }}</small>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ $maReview->resolution_document_s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> Ver</a>
                                    <a href="{{ $maReview->resolution_document_s3_url }}" download="{{ $maReview->resolution_document_name }}" class="btn btn-sm btn-outline-success"><i class="fas fa-download"></i> Descargar</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-dictamen {
        background-color: #6d1b2b;
    }
</style>
