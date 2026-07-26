<div>
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">
                <i class="fas fa-map-marked-alt"></i>
                {{ $mode == 1 ? 'Información del predio' : 'Capturar predio' }}
            </h5>
            <span class="badge bg-{{ $castro->status_color }}">{{ $castro->status_label }}</span>
        </div>

        <div class="card-body">
            <form wire:submit.prevent="save">

                {{-- FECHAS Y CUENTA PREDIAL --}}
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h6 class="text-uppercase text-muted mb-0">Fechas y cuenta predial</h6>
                    <div>
                        <small class="text-muted me-2">Folio de solicitud</small>
                        <span
                            class="fw-bold">{{ $castro->urbanDevRequest?->folio ?? '#' . $castro->urban_dev_request_id }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de solicitud <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_solicitud') is-invalid @enderror"
                            wire:model="fecha_solicitud">
                        <small class="text-muted">Se llena con la fecha en que el ciudadano envió la solicitud.</small>
                        @error('fecha_solicitud')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de entrega de documentos <span
                                class="text-danger">*</span></label>
                        <input type="date"
                            class="form-control @error('fecha_entrega_documentos') is-invalid @enderror"
                            wire:model="fecha_entrega_documentos" required>
                        @error('fecha_entrega_documentos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cuenta predial <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cuenta_predial') is-invalid @enderror"
                            placeholder="Ej. 001-0234-005" wire:model="cuenta_predial" required>
                        @error('cuenta_predial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- CONTRIBUYENTE Y PREDIO --}}
                <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3 mt-2">Contribuyente y predio</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nombre del contribuyente <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre_contribuyente') is-invalid @enderror"
                            placeholder="Nombre completo o razón social" wire:model="nombre_contribuyente" required>
                        @error('nombre_contribuyente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo de predio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tipo_predio') is-invalid @enderror"
                            placeholder="Ej. Urbano / Rústico / Ejidal" wire:model="tipo_predio" required>
                        @error('tipo_predio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Domicilio del predio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('domicilio_predio') is-invalid @enderror"
                            placeholder="Calle y número" wire:model="domicilio_predio" required>
                        @error('domicilio_predio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- UBICACIÓN Y DETALLES --}}
                <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3 mt-2">
                    Ubicación y detalles <span class="text-lowercase fw-normal">· opcionales</span>
                </h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Localidad / Colonia / Ejido <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control @error('localidad_colonia_ejido') is-invalid @enderror"
                            wire:model="localidad_colonia_ejido" required>
                        @error('localidad_colonia_ejido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Manzana / Lote <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('manzana_lote') is-invalid @enderror"
                            wire:model="manzana_lote" required>
                        @error('manzana_lote')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Superficie (m²) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0"
                            class="form-control @error('superficie') is-invalid @enderror" placeholder="0.00"
                            wire:model="superficie" required>
                        @error('superficie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Uso / trámite (Desarrollo Urbano) <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('uso_tramite') is-invalid @enderror"
                            placeholder="Ej. Habitacional, subdivisión, licencia..." wire:model="uso_tramite" required>
                        @error('uso_tramite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">URL de expediente <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('url_expediente') is-invalid @enderror"
                            placeholder="https://" wire:model="url_expediente" required>
                        @error('url_expediente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('urban_dev.catastro.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="button" class="btn btn-outline-primary" wire:click="saveDraft"
                        wire:loading.attr="disabled">
                        <i class="far fa-save"></i> Guardar borrador
                    </button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <i class="fas fa-check"></i>
                        {{ $mode == 1 ? 'Guardar cambios' : 'Finalizar captura' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
