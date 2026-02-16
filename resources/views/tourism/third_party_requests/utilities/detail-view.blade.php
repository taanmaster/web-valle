<div>
    @if (session()->has('status_updated'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status_updated') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Cambio de Estatus --}}
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

    {{-- Sección 1: Datos del Solicitante --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class='bx bx-user'></i> 1. Datos del Solicitante</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Nombre Completo</label>
                    <p class="fw-semibold">{{ $request->full_name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Organización</label>
                    <p class="fw-semibold">{{ $request->organization_name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Tipo de Solicitante</label>
                    <p class="fw-semibold">{{ $request->applicant_type === 'persona_fisica' ? 'Persona Física' : 'Persona Moral' }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">{{ $request->applicant_type === 'persona_fisica' ? 'CURP' : 'RFC' }}</label>
                    <p class="fw-semibold">{{ $request->rfc_or_curp }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Domicilio Fiscal</label>
                    <p class="fw-semibold">{{ $request->fiscal_address }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Teléfono</label>
                    <p class="fw-semibold">{{ $request->phone }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Correo Electrónico</label>
                    <p class="fw-semibold">{{ $request->email }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 2: Datos del Evento --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class='bx bx-calendar-event'></i> 2. Datos del Evento</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Nombre del Evento</label>
                    <p class="fw-semibold">{{ $request->event_name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Tipo de Evento</label>
                    <p class="fw-semibold">{{ $request->event_type }}</p>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label text-muted">Objetivo del Evento</label>
                    <p class="fw-semibold">{{ $request->event_objective }}</p>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label text-muted">Descripción del Evento</label>
                    <p class="fw-semibold">{{ $request->event_description }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 3: Fecha y Lugar --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class='bx bx-map'></i> 3. Fecha y Lugar</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label text-muted">Fecha Inicio</label>
                    <p class="fw-semibold">{{ $request->start_date->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label text-muted">Fecha Fin</label>
                    <p class="fw-semibold">{{ $request->end_date->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label text-muted">Hora Inicio</label>
                    <p class="fw-semibold">{{ $request->start_time }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label text-muted">Hora Fin</label>
                    <p class="fw-semibold">{{ $request->end_time }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Sede / Lugar</label>
                    <p class="fw-semibold">{{ $request->venue }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Tipo de Acceso</label>
                    <p class="fw-semibold">{{ $request->event_access_type }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 4: Impacto Turístico --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class='bx bx-trending-up'></i> 4. Impacto Turístico</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Impacto Esperado</label>
                    <p class="fw-semibold">{{ $request->expected_impact }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Asistentes Estimados</label>
                    <p class="fw-semibold">{{ number_format($request->estimated_attendees) }}</p>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label text-muted">Promueve Identidad Cultural</label>
                    <p class="fw-semibold">{{ $request->promotes_identity }}</p>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label text-muted">Genera Impacto Económico</label>
                    <p class="fw-semibold">{{ $request->generates_economic_impact }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 5: Apoyo Solicitado --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class='bx bx-support'></i> 5. Apoyo Solicitado</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Tipo de Apoyo</label>
                    <p class="fw-semibold">{{ $request->support_type }}</p>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label text-muted">Descripción del Apoyo</label>
                    <p class="fw-semibold">{{ $request->support_description }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 6: Firma --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class='bx bx-pen'></i> 6. Declaración y Firma</h6>
        </div>
        <div class="card-body">
            @if ($request->signature_url)
                <div class="text-center">
                    <img src="{{ $request->signature_url }}" alt="Firma del solicitante" class="img-fluid border rounded" style="max-height: 200px;">
                </div>
            @else
                <p class="text-muted text-center">No se adjuntó firma.</p>
            @endif
        </div>
    </div>
</div>
