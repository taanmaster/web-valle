<div>
    {{-- Indicador de progreso --}}
    <div class="d-flex justify-content-center mb-5">
        <div class="d-flex align-items-center gap-2">
            @for ($i = 1; $i <= $totalSteps; $i++)
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center {{ $i <= $currentStep ? 'bg-primary text-white' : 'bg-light text-muted border' }}"
                        style="width: 36px; height: 36px; font-size: 14px; font-weight: 600;">
                        {{ $i }}
                    </div>
                    @if ($i < $totalSteps)
                        <div class="mx-1 {{ $i < $currentStep ? 'bg-primary' : 'bg-light' }}" style="width: 40px; height: 3px;"></div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Paso 1: Datos del Solicitante --}}
    @if ($currentStep == 1)
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><ion-icon name="person-outline"></ion-icon> Paso 1: Datos del Solicitante</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" wire:model="full_name" id="full_name">
                        @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="organization_name" class="form-label">Nombre de la Organización <span class="text-info">(Opcional)</span></label>
                        <input type="text" class="form-control" wire:model="organization_name" id="organization_name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="applicant_type" class="form-label">Tipo de Solicitante <span class="text-danger">*</span></label>
                        <select class="form-select @error('applicant_type') is-invalid @enderror" wire:model.live="applicant_type" id="applicant_type">
                            <option value="persona_fisica">Persona Física</option>
                            <option value="persona_moral">Persona Moral</option>
                        </select>
                        @error('applicant_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rfc_or_curp" class="form-label">
                            {{ $applicant_type === 'persona_fisica' ? 'CURP' : 'RFC' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('rfc_or_curp') is-invalid @enderror"
                            wire:model="rfc_or_curp" id="rfc_or_curp"
                            maxlength="{{ $applicant_type === 'persona_fisica' ? '18' : '13' }}">
                        @error('rfc_or_curp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="fiscal_address" class="form-label">Domicilio Fiscal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('fiscal_address') is-invalid @enderror" wire:model="fiscal_address" id="fiscal_address">
                        @error('fiscal_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" wire:model="phone" id="phone">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" id="email">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Paso 2: Datos del Evento --}}
    @if ($currentStep == 2)
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><ion-icon name="calendar-outline"></ion-icon> Paso 2: Datos del Evento</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="event_name" class="form-label">Nombre del Evento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('event_name') is-invalid @enderror" wire:model="event_name" id="event_name">
                        @error('event_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="event_type" class="form-label">Tipo de Evento <span class="text-danger">*</span></label>
                        <select class="form-select @error('event_type') is-invalid @enderror" wire:model="event_type" id="event_type">
                            <option value="">Seleccione un tipo</option>
                            <option value="Festival">Festival</option>
                            <option value="Exposición">Exposición</option>
                            <option value="Cultural">Cultural</option>
                            <option value="Deportivo">Deportivo</option>
                            <option value="Gastronómico">Gastronómico</option>
                            <option value="Musical">Musical</option>
                            <option value="Religioso">Religioso</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('event_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="event_objective" class="form-label">Objetivo del Evento <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('event_objective') is-invalid @enderror" wire:model="event_objective" id="event_objective" rows="3"
                            placeholder="Describe el objetivo principal del evento..."></textarea>
                        @error('event_objective') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="event_description" class="form-label">Descripción del Evento <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('event_description') is-invalid @enderror" wire:model="event_description" id="event_description" rows="4"
                            placeholder="Describe las actividades, programación y detalles del evento..."></textarea>
                        @error('event_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Paso 3: Fecha y Lugar --}}
    @if ($currentStep == 3)
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><ion-icon name="location-outline"></ion-icon> Paso 3: Fecha y Lugar</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" wire:model="start_date" id="start_date">
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">Fecha de Fin <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" wire:model="end_date" id="end_date">
                        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">Hora de Inicio <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" wire:model="start_time" id="start_time">
                        @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_time" class="form-label">Hora de Fin <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" wire:model="end_time" id="end_time">
                        @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="venue" class="form-label">Sede / Lugar <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('venue') is-invalid @enderror" wire:model="venue" id="venue"
                            placeholder="Nombre del lugar donde se realizará el evento">
                        @error('venue') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo de Acceso <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model="event_access_type" id="access_open" value="Abierto">
                                <label class="form-check-label" for="access_open">Abierto</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model="event_access_type" id="access_closed" value="Cerrado">
                                <label class="form-check-label" for="access_closed">Cerrado</label>
                            </div>
                        </div>
                        @error('event_access_type') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Paso 4: Impacto Turístico --}}
    @if ($currentStep == 4)
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><ion-icon name="trending-up-outline"></ion-icon> Paso 4: Impacto Turístico</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="expected_impact" class="form-label">Impacto Esperado <span class="text-danger">*</span></label>
                        <select class="form-select @error('expected_impact') is-invalid @enderror" wire:model="expected_impact" id="expected_impact">
                            <option value="">Seleccione el alcance</option>
                            <option value="Local">Local</option>
                            <option value="Regional">Regional</option>
                            <option value="Estatal">Estatal</option>
                            <option value="Nacional">Nacional</option>
                            <option value="Internacional">Internacional</option>
                        </select>
                        @error('expected_impact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="estimated_attendees" class="form-label">Asistentes Estimados <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('estimated_attendees') is-invalid @enderror" wire:model="estimated_attendees" id="estimated_attendees" min="1">
                        @error('estimated_attendees') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="promotes_identity" class="form-label">¿Cómo promueve la identidad cultural del municipio? <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('promotes_identity') is-invalid @enderror" wire:model="promotes_identity" id="promotes_identity" rows="3"
                            placeholder="Describe cómo el evento promueve la identidad cultural..."></textarea>
                        @error('promotes_identity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="generates_economic_impact" class="form-label">¿Qué impacto económico genera? <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('generates_economic_impact') is-invalid @enderror" wire:model="generates_economic_impact" id="generates_economic_impact" rows="3"
                            placeholder="Describe la derrama económica esperada y los sectores beneficiados..."></textarea>
                        @error('generates_economic_impact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Paso 5: Apoyo Solicitado --}}
    @if ($currentStep == 5)
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><ion-icon name="hand-left-outline"></ion-icon> Paso 5: Apoyo Solicitado</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="support_type" class="form-label">Tipo de Apoyo <span class="text-danger">*</span></label>
                        <select class="form-select @error('support_type') is-invalid @enderror" wire:model="support_type" id="support_type">
                            <option value="">Seleccione el tipo de apoyo</option>
                            <option value="Logístico">Logístico (tarimas, sonido, sillas, etc.)</option>
                            <option value="Económico">Económico</option>
                            <option value="Difusión">Difusión y Publicidad</option>
                            <option value="Mixto">Mixto (Logístico + Económico)</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('support_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="support_description" class="form-label">Descripción Detallada del Apoyo <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('support_description') is-invalid @enderror" wire:model="support_description" id="support_description" rows="5"
                            placeholder="Describe detalladamente el apoyo que requieres: cantidades, especificaciones, montos, etc."></textarea>
                        @error('support_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Paso 6: Declaración y Firma --}}
    @if ($currentStep == 6)
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><ion-icon name="create-outline"></ion-icon> Paso 6: Declaración y Firma</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Declaración:</strong> Bajo protesta de decir verdad, manifiesto que los datos proporcionados
                    en esta solicitud son verídicos y que el evento descrito tiene como objetivo promover el turismo
                    y la cultura del municipio. Me comprometo a dar el uso adecuado al apoyo otorgado y a presentar
                    un informe de resultados posterior al evento.
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="signature" class="form-label">Firma del Solicitante <span class="text-info">(Opcional - Imagen)</span></label>
                        <input type="file" class="form-control @error('signature') is-invalid @enderror" wire:model="signature" id="signature" accept="image/*">
                        @error('signature') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Sube una imagen de tu firma (JPG, PNG). Máximo 2MB.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        @if ($signature)
                            <label class="form-label">Vista previa</label>
                            <div class="border rounded p-2 text-center">
                                <img src="{{ $signature->temporaryUrl() }}" alt="Vista previa de firma" class="img-fluid" style="max-height: 150px;">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Resumen --}}
                <div class="card bg-light mt-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Resumen de tu Solicitud</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Solicitante:</strong> {{ $full_name }}</p>
                                <p class="mb-1"><strong>Evento:</strong> {{ $event_name }}</p>
                                <p class="mb-1"><strong>Tipo:</strong> {{ $event_type }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Fecha:</strong> {{ $start_date }} al {{ $end_date }}</p>
                                <p class="mb-1"><strong>Sede:</strong> {{ $venue }}</p>
                                <p class="mb-1"><strong>Tipo de Apoyo:</strong> {{ $support_type }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Botones de navegación --}}
    <div class="d-flex justify-content-between mt-4">
        <div>
            @if ($currentStep > 1)
                <button wire:click="previousStep" class="btn btn-outline-secondary">
                    <ion-icon name="arrow-back-outline"></ion-icon> Anterior
                </button>
            @endif
        </div>
        <div>
            @if ($currentStep < $totalSteps)
                <button wire:click="nextStep" class="btn btn-primary">
                    Siguiente <ion-icon name="arrow-forward-outline"></ion-icon>
                </button>
            @else
                <button wire:click="save" class="btn btn-success btn-lg">
                    <ion-icon name="send-outline"></ion-icon> Enviar Solicitud
                </button>
            @endif
        </div>
    </div>
</div>
