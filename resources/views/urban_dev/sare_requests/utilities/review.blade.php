@php $sareRequest = $review->sareRequest; @endphp
<div>
    {{-- HEADER DE MÓDULO --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-clipboard-check fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $sareRequest->commercial_name }}</h3>
                            <p class="text-muted mb-0">
                                Solicitud #{{ $sareRequest->request_num }} ·
                                Solicitante: <strong>{{ $sareRequest->user->name }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <span class="badge bg-{{ $review->status_color }} fs-6 px-3 py-2">{{ $review->status_label }}</span>
                    <br>
                    <small class="text-muted mt-2 d-block">
                        Enviado: {{ optional($review->sent_at)->format('d/m/Y H:i') ?? '—' }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- ALERTAS FLASH --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">

            {{-- INFORMACIÓN DE LA SOLICITUD (colapsable, colapsada por default) --}}
            <div class="accordion mb-4" id="accordionSolicitud">
                <div class="accordion-item border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSolicitud" aria-expanded="false" aria-controls="collapseSolicitud">
                            <i class="fas fa-file-alt me-2"></i> Información de la Solicitud
                        </button>
                    </h2>
                    <div id="collapseSolicitud" class="accordion-collapse collapse" data-bs-parent="#accordionSolicitud">
                        <div class="accordion-body">
                            {{-- Información General --}}
                            <h6 class="border-bottom pb-2 mb-3">Información General</h6>
                            <div class="row mb-3">
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted">Número de Solicitud:</small>
                                    <p class="mb-0"><strong>{{ $sareRequest->request_num }}</strong></p>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted">Fecha de Solicitud:</small>
                                    <p class="mb-0">{{ $sareRequest->request_date }}</p>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted">Número Catastral:</small>
                                    <p class="mb-0">{{ $sareRequest->catastral_num }}</p>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted">Tipo de Solicitud:</small>
                                    <p class="mb-0">{{ ucfirst($sareRequest->request_type) }}</p>
                                </div>
                                @if ($sareRequest->description)
                                    <div class="col-12 mb-2">
                                        <small class="text-muted">Descripción:</small>
                                        <p class="mb-0">{{ $sareRequest->description }}</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Datos del Solicitante --}}
                            <h6 class="border-bottom pb-2 mb-3">Datos del Solicitante</h6>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Nombre/Razón Social:</small>
                                    <p class="mb-0">{{ $sareRequest->rfc_name }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">RFC:</small>
                                    <p class="mb-0">{{ $sareRequest->rfc_num }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Tipo de Persona:</small>
                                    <p class="mb-0">
                                        {{ $sareRequest->person_type == 'moral' ? 'Persona Moral' : ($sareRequest->person_type == 'fisica' ? 'Persona Física' : '—') }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Propietario:</small>
                                    <p class="mb-0">{{ $sareRequest->property_owner }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Teléfono Oficina:</small>
                                    <p class="mb-0">{{ $sareRequest->office_phone }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Teléfono Móvil:</small>
                                    <p class="mb-0">{{ $sareRequest->mobile_phone }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Email:</small>
                                    <p class="mb-0">{{ $sareRequest->email }}</p>
                                </div>
                            </div>

                            @if ($sareRequest->legal_representative_name)
                                <h6 class="border-bottom pb-2 mb-3">Representante Legal</h6>
                                <div class="row mb-3">
                                    <div class="col-md-4 mb-2">
                                        <small class="text-muted">Nombre:</small>
                                        <p class="mb-0">{{ $sareRequest->legal_representative_name }}
                                            {{ $sareRequest->legal_representative_father_last_name }}
                                            {{ $sareRequest->legal_representative_mother_last_name }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <small class="text-muted">Teléfono Móvil:</small>
                                        <p class="mb-0">{{ $sareRequest->legal_representative_mobile_phone }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <small class="text-muted">Email:</small>
                                        <p class="mb-0">{{ $sareRequest->legal_representative_email }}</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Domicilio del Establecimiento --}}
                            <h6 class="border-bottom pb-2 mb-3">Domicilio del Establecimiento</h6>
                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <small class="text-muted">Dirección Completa:</small>
                                    <p class="mb-0">
                                        {{ $sareRequest->establishment_address_street }}
                                        {{ $sareRequest->establishment_address_number }},
                                        {{ $sareRequest->establishment_address_neighborhood }},
                                        {{ $sareRequest->establishment_address_municipality }},
                                        {{ $sareRequest->establishment_address_state }}
                                        {{ $sareRequest->establishment_address_postal_code }}
                                    </p>
                                </div>
                            </div>

                            {{-- Datos del Negocio --}}
                            <h6 class="border-bottom pb-2 mb-3">Datos del Negocio</h6>
                            <div class="row">
                                @if ($sareRequest->establishment_use)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Uso del Establecimiento:</small>
                                        <p class="mb-0">{{ $sareRequest->establishment_use }}</p>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Nombre Comercial:</small>
                                    <p class="mb-0">{{ $sareRequest->commercial_name }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Inversión Aproximada:</small>
                                    <p class="mb-0">{{ $sareRequest->aprox_investment }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Empleos a Generar:</small>
                                    <p class="mb-0">{{ $sareRequest->jobs_to_generate }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">En Operación:</small>
                                    <p class="mb-0">{{ $sareRequest->is_location_in_operation ? 'Sí' : 'No' }}</p>
                                </div>
                                @if ($sareRequest->business_hours)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Horario de Operación:</small>
                                        <p class="mb-0">{{ $sareRequest->business_hours }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN: INSPECCIÓN --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="text-white mb-0"><i class="fas fa-search-location me-2"></i> Inspección</h5>
                </div>
                <div class="card-body p-4">
                    <form wire:submit="saveInspection">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Inspector <span class="text-danger">*</span></label>
                                <select wire:model="inspector_id" class="form-select @error('inspector_id') is-invalid @enderror">
                                    <option value="">Selecciona un inspector...</option>
                                    @foreach ($inspectors as $inspector)
                                        <option value="{{ $inspector->id }}">{{ $inspector->name }} {{ $inspector->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('inspector_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Superficie medida en sitio</label>
                                <input type="text" wire:model="measured_area" class="form-control" placeholder="Ej. 120 m²">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea wire:model="observations" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fotografías de la inspección</label>
                            <input type="file" wire:model="photos" class="form-control" multiple accept="image/*">
                            <div wire:loading wire:target="photos" class="form-text">Subiendo fotografías...</div>
                        </div>

                        @if ($review->photos->count() > 0)
                            <div class="row mb-3">
                                @foreach ($review->photos as $photo)
                                    <div class="col-3 mb-2">
                                        <a href="javascript:void(0)" onclick="previewImage('{{ $photo->s3_asset_url }}')">
                                            <img src="{{ $photo->s3_asset_url }}" class="img-fluid rounded border" alt="{{ $photo->filename }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading wire:target="saveInspection" class="spinner-border spinner-border-sm me-2"></span>
                                <i wire:loading.remove wire:target="saveInspection" class="fas fa-save me-2"></i>
                                Guardar Inspección
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SECCIÓN: EMISIÓN DEL PERMISO --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="text-white mb-0"><i class="fas fa-file-signature me-2"></i> Emisión del Permiso</h5>
                </div>
                <div class="card-body p-4">
                    <form wire:submit="savePermit">
                        @if ($review->permit_document_s3_url)
                            <div class="alert alert-light border mb-3">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                {{ $review->permit_document_name }}
                                <small class="text-muted">({{ $review->permit_formatted_size }})</small>
                                <a href="{{ $review->permit_document_s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Documento del permiso {{ $review->permit_document_s3_url ? '(reemplazar)' : '' }} <span class="text-danger">*</span></label>
                            <input type="file" wire:model="permit_document" class="form-control @error('permit_document') is-invalid @enderror">
                            @error('permit_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div wire:loading wire:target="permit_document" class="form-text">Subiendo documento...</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading wire:target="savePermit" class="spinner-border spinner-border-sm me-2"></span>
                                <i wire:loading.remove wire:target="savePermit" class="fas fa-save me-2"></i>
                                Guardar Permiso
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SECCIÓN: ENTERO DE PAGO --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="text-white mb-0"><i class="fas fa-money-check-alt me-2"></i> Entero de Pago</h5>
                </div>
                <div class="card-body p-4">
                    <form wire:submit="savePayment">
                        @if ($review->payment_document_s3_url)
                            <div class="alert alert-light border mb-3">
                                <i class="fas fa-file-invoice-dollar text-success me-2"></i>
                                {{ $review->payment_document_name }}
                                <small class="text-muted">({{ $review->payment_formatted_size }})</small>
                                <a href="{{ $review->payment_document_s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Monto (MXN)</label>
                                <input type="number" step="0.01" min="0" wire:model="payment_amount" class="form-control @error('payment_amount') is-invalid @enderror">
                                @error('payment_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Línea de captura</label>
                                <input type="text" wire:model="payment_reference" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comprobante de pago {{ $review->payment_document_s3_url ? '(reemplazar)' : '' }} <span class="text-danger">*</span></label>
                            <input type="file" wire:model="payment_document" class="form-control @error('payment_document') is-invalid @enderror">
                            @error('payment_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div wire:loading wire:target="payment_document" class="form-text">Subiendo comprobante...</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading wire:target="savePayment" class="spinner-border spinner-border-sm me-2"></span>
                                <i wire:loading.remove wire:target="savePayment" class="fas fa-save me-2"></i>
                                Guardar Entero de Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <a href="{{ route('urban_dev.sare_requests.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Volver al Listado
            </a>
        </div>

        {{-- PANEL LATERAL --}}
        <div class="col-lg-4">
            {{-- Resumen de archivos --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0 text-white"><i class="fas fa-folder-open me-2"></i> Resumen de Archivos</h6>
                </div>
                <div class="card-body p-0">
                    @if ($sareRequest->files->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($sareRequest->files as $file)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium">{{ $file->name ?: $file->filename }}</div>
                                        <small class="text-muted">{{ $file->formatted_size }}</small>
                                    </div>
                                    @if ($file->s3_asset_url)
                                        <a href="{{ $file->s3_asset_url }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <small>No hay archivos adjuntos.</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Lista de verificación de documentos --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0 text-white"><i class="fas fa-check-circle me-2"></i> Lista de Verificación de Documentos</h6>
                </div>
                <div class="card-body">
                    @php
                        $requiredDocs = [
                            'documento-propiedad' => 'Documento que acredite propiedad del inmueble',
                            'id-solicitante' => 'Identificación oficial del solicitante',
                            'id-propietario' => 'Identificación oficial del propietario',
                            'comprobante-domicilio' => 'Comprobante de domicilio (no mayor a 2 meses)',
                            'pago-predial' => 'Pago predial del presente año',
                        ];

                        $uploadedFilesByType = [];
                        foreach ($sareRequest->files as $file) {
                            if ($file->slug) {
                                $uploadedFilesByType[$file->slug] = $file;
                            }
                        }
                    @endphp

                    @foreach ($requiredDocs as $slug => $title)
                        @php $isUploaded = isset($uploadedFilesByType[$slug]); @endphp
                        <div class="d-flex align-items-center mb-2 p-2 border rounded {{ $isUploaded ? 'border-success bg-success bg-opacity-10' : 'border-warning bg-warning bg-opacity-10' }}">
                            <i class="fas fa-{{ $isUploaded ? 'check-circle text-success' : 'clock text-warning' }} me-2"></i>
                            <small>{{ $title }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Información del usuario --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0 text-white"><i class="fas fa-user me-2"></i> Información del Usuario</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Nombre:</small>
                        <p class="mb-1">{{ $sareRequest->user->name }}</p>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Email:</small>
                        <p class="mb-1">{{ $sareRequest->user->email }}</p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted">Fecha de Registro:</small>
                        <p class="mb-0">{{ $sareRequest->user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
