<div>
    {{-- Alertas --}}
    @foreach (['status_updated' => 'success', 'obs_saved' => 'success', 'evidence_saved' => 'success'] as $key => $type)
        @if (session()->has($key))
            <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                {{ session($key) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endforeach

    {{-- Tabs controlados por Livewire --}}
    @php
        $showObservations = $mode === 'admin';
    @endphp

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item" wire:key="tab-nav-detail">
            <button wire:click="$set('activeTab','detail')"
                class="nav-link {{ $activeTab === 'detail' ? 'active' : '' }}" type="button">
                Detalles de la Solicitud
            </button>
        </li>

        <li class="nav-item" wire:key="tab-nav-evidence">
            <button wire:click="$set('activeTab','evidence')"
                class="nav-link {{ $activeTab === 'evidence' ? 'active' : '' }}" type="button">
                Evidencia
                @if ($evidences->count() > 0)
                    <span class="badge bg-secondary ms-1">{{ $evidences->count() }}</span>
                @endif
            </button>
        </li>
        @if ($showObservations)
            <li class="nav-item" wire:key="tab-nav-observations">
                <button wire:click="$set('activeTab','observations')"
                    class="nav-link {{ $activeTab === 'observations' ? 'active' : '' }}" type="button">
                    Observaciones
                    @if ($observations->count() > 0)
                        <span class="badge bg-primary ms-1">{{ $observations->count() }}</span>
                    @endif
                </button>
            </li>
        @endif
    </ul>

    <div>

        {{-- ===== TAB: DETALLE ===== --}}
        <div @class(['d-none' => $activeTab !== 'detail'])>

            {{-- Cambio de estatus (solo admin) --}}
            @if ($mode === 'admin')
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-0">Cambiar Estatus de la Solicitud</h6>
                            </div>
                            <div class="col-md-3">
                                <select wire:model="status" class="form-select">
                                    <option value="Enviada">Enviada</option>
                                    <option value="En Revisión">En Revisión</option>
                                    <option value="Aprobada">Aprobada</option>
                                    <option value="Concluido">Concluido</option>
                                    <option value="Rechazada">Rechazada</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button wire:click="updateStatus" class="btn btn-primary btn-sm">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Sección 1: Datos del Solicitante --}}
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><ion-icon name="person-outline"></ion-icon> 1. Datos del Solicitante</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Nombre Completo</small>
                            <p class="mb-0 fw-semibold">{{ $request->full_name }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Organización</small>
                            <p class="mb-0 fw-semibold">{{ $request->organization_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <small class="text-muted">Tipo</small>
                            <p class="mb-0 fw-semibold">
                                {{ $request->applicant_type === 'persona_fisica' ? 'Persona Física' : 'Persona Moral' }}
                            </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <small
                                class="text-muted">{{ $request->applicant_type === 'persona_fisica' ? 'CURP' : 'RFC' }}</small>
                            <p class="mb-0 fw-semibold">{{ $request->rfc_or_curp }}</p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <small class="text-muted">Domicilio Fiscal</small>
                            <p class="mb-0 fw-semibold">{{ $request->fiscal_address }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Teléfono</small>
                            <p class="mb-0 fw-semibold">{{ $request->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Correo Electrónico</small>
                            <p class="mb-0 fw-semibold">{{ $request->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 2: Datos del Evento --}}
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><ion-icon name="calendar-outline"></ion-icon> 2. Datos del Evento</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Nombre del Evento</small>
                            <p class="mb-0 fw-semibold">{{ $request->event_name }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Tipo de Evento</small>
                            <p class="mb-0 fw-semibold">{{ $request->event_type }}</p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <small class="text-muted">Objetivo</small>
                            <p class="mb-0">{{ $request->event_objective }}</p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <small class="text-muted">Descripción</small>
                            <p class="mb-0">{{ $request->event_description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 3: Fecha y Lugar --}}
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><ion-icon name="location-outline"></ion-icon> 3. Fecha y Lugar</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <small class="text-muted">Fecha Inicio</small>
                            <p class="mb-0 fw-semibold">{{ $request->start_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-3 mb-2">
                            <small class="text-muted">Fecha Fin</small>
                            <p class="mb-0 fw-semibold">{{ $request->end_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-3 mb-2">
                            <small class="text-muted">Hora Inicio</small>
                            <p class="mb-0 fw-semibold">{{ $request->start_time }}</p>
                        </div>
                        <div class="col-md-3 mb-2">
                            <small class="text-muted">Hora Fin</small>
                            <p class="mb-0 fw-semibold">{{ $request->end_time }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Sede</small>
                            <p class="mb-0 fw-semibold">{{ $request->venue }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Tipo de Acceso</small>
                            <p class="mb-0 fw-semibold">{{ $request->event_access_type }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 4: Impacto Turístico --}}
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><ion-icon name="trending-up-outline"></ion-icon> 4. Impacto Turístico</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Impacto Esperado</small>
                            <p class="mb-0 fw-semibold">{{ $request->expected_impact }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Asistentes Estimados</small>
                            <p class="mb-0 fw-semibold">{{ number_format($request->estimated_attendees) }}</p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <small class="text-muted">Promueve Identidad Cultural</small>
                            <p class="mb-0">{{ $request->promotes_identity }}</p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <small class="text-muted">Genera Impacto Económico</small>
                            <p class="mb-0">{{ $request->generates_economic_impact }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 5: Apoyo Solicitado --}}
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><ion-icon name="hand-left-outline"></ion-icon> 5. Apoyo Solicitado</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <small class="text-muted">Tipo de Apoyo</small>
                            <p class="mb-0 fw-semibold">{{ $request->support_type }}</p>
                        </div>
                        <div class="col-md-8 mb-2">
                            <small class="text-muted">Descripción del Apoyo</small>
                            <p class="mb-0">{{ $request->support_description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 6: Firma --}}
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><ion-icon name="create-outline"></ion-icon> 6. Declaración y Firma</h6>
                </div>
                <div class="card-body">
                    @if ($request->signature_url)
                        <div class="text-center">
                            <img src="{{ $request->signature_url }}" alt="Firma" class="img-fluid border rounded"
                                style="max-height: 200px;">
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">No se adjuntó firma.</p>
                    @endif
                </div>
            </div>
        </div>
        {{-- /TAB DETALLE --}}

        {{-- ===== TAB: EVIDENCIA ===== --}}
        <div @class(['d-none' => $activeTab !== 'evidence'])>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Evidencias del Evento</h6>
                @if ($mode === 'citizen')
                    <button wire:click="$set('showEvidenceForm', true)" type="button"
                        class="btn btn-primary btn-sm">
                        Agregar Evidencia
                    </button>
                @endif
            </div>

            {{-- Form inline --}}
            @if ($showEvidenceForm)
                <div class="card mb-4 border-primary">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><ion-icon name="cloud-upload-outline"></ion-icon> Nueva Evidencia</span>
                        <button wire:click="$set('showEvidenceForm', false)" type="button"
                            class="btn-close btn-close-white"></button>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" wire:model="evidenceName"
                                    class="form-control @error('evidenceName') is-invalid @enderror"
                                    placeholder="Ej: Fotografías del evento">
                                @error('evidenceName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Archivo <span class="text-danger">*</span></label>
                                <input type="file" wire:model="evidenceFile"
                                    class="form-control @error('evidenceFile') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx">
                                <div class="form-text">Imágenes, PDF, Word o Excel. Máx. 20 MB.</div>
                                @error('evidenceFile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button wire:click="saveEvidence" wire:loading.attr="disabled"
                                    class="btn btn-success w-100">
                                    <span wire:loading wire:target="saveEvidence"
                                        class="spinner-border spinner-border-sm me-1"></span>
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tabla de evidencias --}}
            @if ($evidences->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Subido por</th>
                                <th>Fecha</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evidences as $evidence)
                                <tr>
                                    <td>
                                        @php
                                            $icon = match (true) {
                                                in_array($evidence->file_extension, [
                                                    'jpg',
                                                    'jpeg',
                                                    'png',
                                                    'gif',
                                                    'webp',
                                                ])
                                                    => 'image-outline',
                                                $evidence->file_extension === 'pdf' => 'document-outline',
                                                in_array($evidence->file_extension, ['doc', 'docx'])
                                                    => 'document-text-outline',
                                                in_array($evidence->file_extension, ['xls', 'xlsx']) => 'grid-outline',
                                                default => 'attach-outline',
                                            };
                                        @endphp
                                        <a href="{{ $evidence->file_download_url }}" target="_blank"
                                            class="text-decoration-none text-body">
                                            <ion-icon name="{{ $icon }}" class="me-1 text-muted"></ion-icon>
                                            {{ $evidence->name }}
                                        </a>
                                    </td>
                                    <td><span
                                            class="badge bg-light text-dark text-uppercase">{{ $evidence->file_extension }}</span>
                                    </td>
                                    <td>{{ $evidence->uploader->name ?? 'N/A' }}</td>
                                    <td>{{ $evidence->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ $evidence->file_url }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <ion-icon name="eye-outline"></ion-icon> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <ion-icon name="folder-open-outline" class="display-4 d-block mx-auto mb-2"></ion-icon>
                    <p class="mb-0">No hay evidencias registradas aún.</p>
                </div>
            @endif
        </div>
        {{-- /TAB EVIDENCIA --}}

        {{-- ===== TAB: OBSERVACIONES (solo admin) ===== --}}
        @if ($showObservations)
            <div @class(['d-none' => $activeTab !== 'observations'])>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Observaciones Internas</h6>
                    <button wire:click="$toggle('showObsForm')" class="btn btn-outline-primary btn-sm"
                        style="max-width: fit-content">
                        {{ $showObsForm ? 'Cancelar' : 'Nueva Observación' }}
                    </button>
                </div>

                @if ($showObsForm)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Observación <span class="text-danger">*</span></label>
                                <textarea wire:model="observation" rows="3" class="form-control @error('observation') is-invalid @enderror"
                                    placeholder="Escribe una observación..."></textarea>
                                @error('observation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button wire:click="saveObservation" class="btn btn-primary btn-sm">Guardar
                                Observación</button>
                        </div>
                    </div>
                @endif

                @if ($observations->count() > 0)
                    @foreach ($observations as $obs)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong>{{ $obs->user->name ?? 'Sistema' }}</strong>
                                    <small class="text-muted">{{ $obs->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <p class="mb-0">{{ $obs->observation }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5 text-muted">
                        <ion-icon name="chatbubbles-outline" class="display-4 d-block mx-auto mb-2"></ion-icon>
                        <p class="mb-0">No hay observaciones registradas.</p>
                    </div>
                @endif
            </div>
        @endif
        {{-- /TAB OBSERVACIONES --}}

    </div>

</div>
