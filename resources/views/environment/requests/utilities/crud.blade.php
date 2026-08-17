<div>
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Encabezado --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <span class="badge bg-secondary text-uppercase fs-6">{{ $environmentRequest->request_type }}</span>
    </div>

    <div class="bg-light rounded px-3 py-2 mb-3">
        <span class="fw-semibold">Solicitud #{{ $environmentRequest->id }}</span>
    </div>

    <h4 class="fw-bold mb-1">{{ $environmentRequest->request_type_label }}</h4>
    <p class="text-muted mb-4">Solicitud #{{ $environmentRequest->id }} · Solicitado por: <strong>{{ $environmentRequest->nombre }}</strong></p>

    <div class="row">
        {{-- Columna izquierda --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-primary mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Datos de la Solicitud</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-0">Nombre</label>
                            <p class="mb-0">{{ $environmentRequest->nombre }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-0">
                                {{ $this->isDonacion() ? 'Domicilio' : 'Domicilio Particular' }}
                            </label>
                            <p class="mb-0">{{ $environmentRequest->domicilio }}</p>
                        </div>

                        @unless ($this->isDonacion())
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-0">Colonia</label>
                                <p class="mb-0">{{ $environmentRequest->colonia }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-0">Motivo</label>
                                <p class="mb-0">{{ $environmentRequest->motivo }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-0">Teléfono Celular</label>
                                <p class="mb-0">{{ $environmentRequest->telefono_celular }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-0">Teléfono Fijo</label>
                                <p class="mb-0">{{ $environmentRequest->telefono_fijo }}</p>
                            </div>
                        @endunless
                    </div>
                </div>
            </div>

            @unless ($this->isDonacion())
                <div class="card border-danger mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0">Supervisión de la Solicitud</h6>
                    </div>
                    <div class="card-body">
                        <form wire:submit="saveSupervision">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha en que se atendió</label>
                                    <input type="date" class="form-control" wire:model="fecha_atencion">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Inspector que atendió</label>
                                    <input type="text" class="form-control" wire:model="inspector">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Observaciones de la inspección</label>
                                    <textarea class="form-control" rows="2" wire:model="observaciones_inspeccion"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Persona que atendió</label>
                                    <input type="text" class="form-control" wire:model="persona_atendio">
                                </div>

                                <div class="col-md-{{ $this->isPoda() || $this->isTala() ? '8' : '6' }}">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Especie</label>
                                            <input type="text" class="form-control" wire:model="especie">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Cantidad</label>
                                            <input type="text" class="form-control" wire:model="cantidad">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Altura del árbol</label>
                                            <input type="text" class="form-control" wire:model="altura_arbol">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Coordenadas</label>
                                            <input type="text" class="form-control" wire:model="coordenadas">
                                        </div>
                                    </div>
                                </div>

                                @if ($this->isPoda() || $this->isTala())
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('images/three.webp') }}" alt="Árbol" class="img-fluid">
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Guardar Supervisión</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endunless

            @if ($this->isDonacion())
                <div class="card border-warning mb-4">
                    <div class="card-header bg-warning">
                        <h6 class="mb-0">Documentación de Solicitud</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach (\App\Models\EnvironmentRequestFile::DONACION_DOCUMENTS as $docType => $docLabel)
                                @php $file = $environmentRequest->files->firstWhere('document_type', $docType); @endphp
                                <div class="col-md-4">
                                    <label class="form-label small text-uppercase text-muted">{{ $docLabel }}</label>
                                    @if ($file)
                                        <a href="{{ $file->url }}" target="_blank" class="d-block small">
                                            <i class="fas fa-file-alt"></i> {{ $file->filename }}
                                        </a>
                                    @else
                                        <p class="small text-muted mb-0">Pendiente de subir</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Columna derecha --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-warning mb-4">
                <div class="card-header bg-warning">
                    <h6 class="mb-0">Gestión de Estatus</h6>
                </div>
                <div class="card-body">
                    <form wire:submit="updateStatus">
                        <label class="form-label small text-muted">Cambiar Estatus</label>
                        <select class="form-select mb-3" wire:model="status">
                            @foreach ($environmentRequest->availableStatuses() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-warning w-100">Actualizar Estatus</button>
                    </form>
                </div>
            </div>

            <div class="card border-info mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">Detalles de la Solicitud</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2 small text-muted">ID de Solicitud:</p>
                    <p class="mb-3 fw-bold">#{{ $environmentRequest->id }}</p>
                    <p class="mb-2 small text-muted">Tipo de Trámite:</p>
                    <p class="mb-3 fw-bold">{{ $environmentRequest->request_type_label }}</p>
                    <p class="mb-2 small text-muted">Fecha de creación:</p>
                    <p class="mb-3">{{ $environmentRequest->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-2 small text-muted">Última Actualización:</p>
                    <p class="mb-0">{{ $environmentRequest->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="card border-dark mb-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0">Acciones Administrativas</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('environment.requests.index') }}" class="btn btn-secondary">
                        Volver al Listado
                    </a>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#contactSolicitanteModal">
                        Contactar al Solicitante
                    </button>
                </div>
            </div>

            @if ($this->isTala())
                <div class="card border-secondary mb-4">
                    <div class="card-header text-white bg-secondary">
                        <h6 class="mb-0">Costo</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-center fw-bold small mb-3">DONACIÓN DE 20 ÁRBOLES ENDÉMICOS</p>
                        @if ($environmentRequest->status === \App\Models\EnvironmentRequest::STATUS_PAGADA)
                            <button type="button" class="btn btn-success w-100" disabled>
                                <i class="fas fa-check"></i> Compensación confirmada
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-success w-100" wire:click="confirmCompensation"
                                wire:confirm="¿Confirmas que el solicitante cumplió la donación de 20 árboles endémicos?">
                                Confirmar Pago
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Evidencia fotográfica --}}
    @unless ($this->isDonacion())
        <div class="card border-success mb-4">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">Evidencia Fotográfica</h6>
            </div>
            <div class="card-body">
                @if ($environmentRequest->files->where('document_type', 'evidencia')->count())
                    <div class="row g-2 mb-3">
                        @foreach ($environmentRequest->files->where('document_type', 'evidencia') as $file)
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-between border rounded p-2">
                                    <a href="{{ $file->url }}" target="_blank" class="text-truncate small">
                                        <i class="fas fa-file-alt"></i> {{ $file->filename }}
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" wire:click="deleteEvidence({{ $file->id }})"
                                        wire:confirm="¿Deseas eliminar este archivo?">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form wire:submit="uploadEvidence">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-8">
                            <input type="file" class="form-control" wire:model="newEvidence" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <div class="form-text">PDF, DOC, DOCX, JPG, PNG (máx. 10MB)</div>
                            @error('newEvidence') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100" wire:loading.attr="disabled" wire:target="newEvidence">
                                <span wire:loading wire:target="newEvidence"><i class="fas fa-spinner fa-spin"></i></span>
                                Subir evidencia
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endunless

    {{-- Vale de entrega de planta (Donación) --}}
    @if ($this->isDonacion())
        <div class="card border-dark mb-4">
            <div class="card-header text-white bg-dark">
                <h6 class="mb-0">Vale de Entrega de Planta</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Registro interno de la Dirección: no genera PDF ni se muestra al ciudadano.</p>

                <form wire:submit="saveVoucher">
                    <div class="row g-2 mb-3">
                        @for ($i = 0; $i < \App\Models\EnvironmentDeliveryVoucher::ITEM_ROWS; $i++)
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-0">Especie</label>
                                <input type="text" class="form-control form-control-sm" wire:model="voucherEspecies.{{ $i }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-0">Cantidad</label>
                                <input type="text" class="form-control form-control-sm" wire:model="voucherCantidades.{{ $i }}">
                            </div>
                        @endfor
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Lugar donde se plantará</label>
                            <input type="text" class="form-control" wire:model="voucher_lugar_plantacion">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de entrega</label>
                            <input type="date" class="form-control" wire:model="voucher_fecha_entrega">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-dark">Guardar Vale</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal: Contactar al Solicitante --}}
    <div class="modal fade" id="contactSolicitanteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.citizen_messages.store') }}" class="modal-content">
                @csrf
                <input type="hidden" name="user_id" value="{{ $environmentRequest->user_id }}">
                <input type="hidden" name="related_model_type" value="{{ \App\Models\EnvironmentRequest::class }}">
                <input type="hidden" name="related_model_id" value="{{ $environmentRequest->id }}">

                <div class="modal-header">
                    <h5 class="modal-title">Contactar al Solicitante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Asunto</label>
                        <input type="text" name="subject" class="form-control"
                            value="Sobre tu solicitud {{ $environmentRequest->folio }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje</label>
                        <textarea name="body" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                </div>
            </form>
        </div>
    </div>
</div>
