@php
    $readonly = $mode == 1;
    $statusColors = [
        \App\Models\ServiceRequest::STATUS_DRAFT => 'secondary',
        \App\Models\ServiceRequest::STATUS_REVIEW => 'warning text-dark',
        \App\Models\ServiceRequest::STATUS_PUBLISHED => 'success',
    ];
    $statusSteps = [
        \App\Models\ServiceRequest::STATUS_DRAFT => '1 · Borrador',
        \App\Models\ServiceRequest::STATUS_REVIEW => '2 · En revisión',
        \App\Models\ServiceRequest::STATUS_PUBLISHED => '3 · Publicado en el portal',
    ];
@endphp

<div>
    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">
                                @if ($request == null)
                                    Nuevo trámite
                                @elseif ($mode == 1)
                                    {{ $request->name }}
                                @else
                                    Editar trámite
                                @endif
                                <span class="badge bg-{{ $statusColors[$status] ?? 'secondary' }} ms-2 align-middle">
                                    {{ \App\Models\ServiceRequest::STATUS_LABELS[$status] ?? 'Borrador' }}
                                </span>
                            </h4>
                            <p class="text-muted mb-0">
                                <i class="fas fa-landmark me-1"></i>
                                Cédula del catálogo municipal del Portal Ciudadano Único.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('institucional_development.requests.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ALERTAS --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                <div>
                    Revisa los siguientes campos:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- A. DATOS GENERALES DE CONTROL ADMINISTRATIVO --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-a">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">A</span>
                    Datos generales de control administrativo
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Dependencia o entidad municipal</label>
                    <select wire:model.live="dependency_name" class="form-select" @disabled($readonly)>
                        <option value="">Seleccione una dependencia</option>
                        @foreach ($dependencies as $dependency)
                            <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Unidad administrativa responsable</label>
                    <input type="text" wire:model.blur="admin_unit" class="form-control"
                        placeholder="Ej. Subdirección de Licencias" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Área responsable de recibir el trámite</label>
                    <input type="text" wire:model.blur="receiving_area" class="form-control"
                        placeholder="Ej. Ventanilla Única" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Área responsable de resolver</label>
                    <input type="text" wire:model.blur="resolving_area" class="form-control"
                        placeholder="Ej. Dirección de Desarrollo Urbano" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Autoridad que emite la regulación</label>
                    <input type="text" wire:model.blur="issuing_authority" class="form-control"
                        placeholder="Ej. H. Ayuntamiento" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Autoridad que aplica el trámite</label>
                    <input type="text" wire:model.blur="applying_authority" class="form-control"
                        placeholder="Ej. Dirección de Desarrollo Urbano" @disabled($readonly)>
                </div>
                <div class="col-md-12">
                    <label class="form-label">
                        Nombre del Enlace de Simplificación y Digitalización
                        <i class="fas fa-question-circle text-muted ms-1"
                            title="Persona designada por la dependencia"></i>
                    </label>
                    <input type="text" wire:model.blur="liaison_name" class="form-control"
                        placeholder="Nombre completo del enlace designado" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cargo del Enlace</label>
                    <input type="text" wire:model.blur="liaison_position" class="form-control"
                        placeholder="Ej. Jefe de Departamento" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Correo institucional del Enlace</label>
                    <input type="email" wire:model.blur="liaison_email" class="form-control"
                        placeholder="nombre@vallesantiago.gob.mx" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono institucional</label>
                    <input type="text" wire:model.blur="liaison_phone" class="form-control"
                        placeholder="(456) 000 0000 ext." @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha de elaboración / actualización</label>
                    <input type="date" wire:model.live="elaboration_date" class="form-control"
                        @disabled($readonly)>
                </div>
            </div>
        </div>
    </div>

    {{-- B. IDENTIFICACIÓN DEL TRÁMITE O SERVICIO --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-b">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">B</span>
                    Identificación del trámite o servicio
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Nombre oficial del trámite o servicio <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model.blur="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Debe coincidir con la denominación oficial vigente" @disabled($readonly)>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        Clave de identificación / Homoclave
                        <i class="fas fa-question-circle text-muted ms-1"
                            title="Clave única del catálogo municipal"></i>
                    </label>
                    <input type="text" wire:model.blur="homoclave" class="form-control"
                        placeholder="Ej. VS-DDU-014" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label d-block">Tipo</label>
                    @include('service_requests.utilities.partials.chip-radios', [
                        'field' => 'type',
                        'options' => ['Trámite', 'Servicio', 'Otro'],
                        'mode' => $mode,
                    ])
                    @error('type')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label">Sujeto Obligado responsable</label>
                    <input type="text" wire:model.blur="responsible_subject" class="form-control"
                        placeholder="Dependencia, entidad o unidad administrativa municipal"
                        @disabled($readonly)>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Descripción del trámite o servicio</label>
                    <textarea wire:model.blur="description" class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        placeholder="Redacta en lenguaje ciudadano: ¿para qué sirve?, ¿quién puede solicitarlo?, ¿en qué casos debe realizarse?"
                        @disabled($readonly)></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="fas fa-lightbulb me-1"></i>
                        Escribe como lo explicarías a un vecino, no como en el reglamento. Frases cortas, sin
                        tecnicismos.
                    </small>
                </div>
                <div class="col-md-12">
                    <label class="form-label d-block">Modalidad</label>
                    @include('service_requests.utilities.partials.chip-radios', [
                        'field' => 'modality',
                        'options' => ['Primera vez', 'Renovación', 'Reposición', 'Modificación', 'Otra'],
                        'mode' => $mode,
                    ])
                </div>
            </div>
        </div>
    </div>

    {{-- C. CANAL DE ATENCIÓN Y DISPONIBILIDAD --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-c">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">C</span>
                    Canal de atención y disponibilidad
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label d-block">Canales disponibles</label>
                    @include('service_requests.utilities.partials.chip-checks', [
                        'field' => 'channels',
                        'options' => ['Presencial', 'En línea', 'Ventanilla digital', 'Correo institucional'],
                        'mode' => $mode,
                    ])
                </div>
                <div class="col-md-6">
                    <label class="form-label d-block">¿Permite iniciar el trámite en línea?</label>
                    @include('service_requests.utilities.partials.bool-group', [
                        'field' => 'can_start_online',
                        'mode' => $mode,
                    ])
                </div>
                <div class="col-md-6">
                    <label class="form-label d-block">¿Permite concluir el trámite en línea?</label>
                    @include('service_requests.utilities.partials.bool-group', [
                        'field' => 'can_finish_online',
                        'mode' => $mode,
                    ])
                </div>
                <div class="col-md-12">
                    <label class="form-label">Liga electrónica (si aplica)</label>
                    <input type="url" wire:model.blur="online_url" class="form-control" placeholder="https://"
                        @disabled($readonly)>
                </div>
            </div>
        </div>
    </div>

    {{-- D. REQUISITOS DEL TRÁMITE O SERVICIO --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-d">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">D</span>
                    Requisitos del trámite o servicio
                </h6>
                <div class="d-flex align-items-center gap-3">
                    @if (count($requirementRows) > 0)
                        <span class="badge bg-secondary">{{ count($requirementRows) }} agregados</span>
                    @endif
                    <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </div>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <p class="text-muted small">
                Agrega cada requisito por separado. Cada uno debe tener su fundamento jurídico específico.
            </p>

            @foreach ($requirementRows as $index => $row)
                <div class="card bg-light border mb-3" wire:key="requirement-{{ $index }}">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Requisito {{ $index + 1 }}</h6>
                            @if (!$readonly)
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    style="max-width: fit-content"
                                    wire:click="removeRow('requirementRows', {{ $index }})"
                                    wire:confirm="¿Eliminar este requisito?" title="Eliminar requisito"
                                    aria-label="Eliminar requisito">
                                    <i class="fas fa-trash me-1"></i> Eliminar
                                </button>
                            @endif
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Requisito</label>
                                <input type="text" wire:model.blur="requirementRows.{{ $index }}.name"
                                    class="form-control" placeholder="Ej. Identificación oficial vigente"
                                    @disabled($readonly)>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">Presentación</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (['Original', 'Copia', 'Digital'] as $option)
                                        <input type="checkbox" class="btn-check"
                                            id="req_{{ $index }}_presentation_{{ Str::slug($option, '_') }}"
                                            value="{{ $option }}"
                                            wire:model.live="requirementRows.{{ $index }}.presentation"
                                            @disabled($readonly)>
                                        <label class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                            for="req_{{ $index }}_presentation_{{ Str::slug($option, '_') }}">{{ $option }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">¿Lo emite un tercero?</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <input type="radio" class="btn-check" id="req_{{ $index }}_third_yes"
                                        value="1"
                                        wire:model.live="requirementRows.{{ $index }}.third_party_issued"
                                        @disabled($readonly)>
                                    <label class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                        for="req_{{ $index }}_third_yes">Sí</label>
                                    <input type="radio" class="btn-check" id="req_{{ $index }}_third_no"
                                        value="0"
                                        wire:model.live="requirementRows.{{ $index }}.third_party_issued"
                                        @disabled($readonly)>
                                    <label class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                        for="req_{{ $index }}_third_no">No</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Observaciones (opcional)</label>
                                <input type="text"
                                    wire:model.blur="requirementRows.{{ $index }}.observations"
                                    class="form-control" placeholder="Notas para el ciudadano"
                                    @disabled($readonly)>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if (!$readonly)
                <button type="button" class="btn btn-outline-primary w-100" wire:click="addRow('requirementRows')">
                    <i class="fas fa-plus me-2"></i> Agregar requisito
                </button>
            @elseif (count($requirementRows) === 0)
                <p class="text-muted mb-0">Sin requisitos registrados.</p>
            @endif
        </div>
    </div>

    {{-- E. FUNDAMENTO JURÍDICO Y REGULACIÓN --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-e">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">E</span>
                    Fundamento jurídico y regulación
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <div class="alert alert-warning border-0" role="alert">
                <i class="fas fa-balance-scale me-2"></i>
                El trámite o servicio debe estar previsto en regulación vigente. Cita siempre:
                ordenamiento · artículo · fracción · inciso · fecha de publicación.
            </div>

            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Fundamento jurídico de la existencia del trámite</label>
                    <textarea wire:model.blur="legal_basis" class="form-control" rows="3"
                        placeholder="Ej. Ley de Ingresos del Municipio 2025, art. 21 — POE 28/12/2024" @disabled($readonly)></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Regulación correspondiente</label>
                    <input type="text" wire:model.blur="regulation_name" class="form-control"
                        placeholder="Nombre de la regulación" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Medio de Difusión Oficial</label>
                    <input type="text" wire:model.blur="regulation_media" class="form-control"
                        placeholder="Ej. Periódico Oficial del Estado" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha de publicación</label>
                    <input type="date" wire:model.live="regulation_publication_date" class="form-control"
                        @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Artículo(s) aplicable(s)</label>
                    <input type="text" wire:model.blur="regulation_articles" class="form-control"
                        placeholder="Ej. arts. 21, 22 y 24" @disabled($readonly)>
                </div>
            </div>
        </div>
    </div>

    {{-- F. TRÁMITES O SERVICIOS RELACIONADOS --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-f">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">F</span>
                    Trámites o servicios relacionados
                </h6>
                <div class="d-flex align-items-center gap-3">
                    @if (count($relatedRows) > 0)
                        <span class="badge bg-secondary">{{ count($relatedRows) }} agregados</span>
                    @endif
                    <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </div>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <p class="text-muted small">
                Indica si este trámite es requisito de otro, o si requiere realizar otro previamente.
            </p>

            @foreach ($relatedRows as $index => $row)
                <div class="card bg-light border mb-3" wire:key="related-{{ $index }}">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Trámite relacionado {{ $index + 1 }}</h6>
                            @if (!$readonly)
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    style="max-width: fit-content"
                                    wire:click="removeRow('relatedRows', {{ $index }})"
                                    wire:confirm="¿Eliminar este trámite relacionado?" title="Eliminar"
                                    aria-label="Eliminar trámite relacionado">
                                    <i class="fas fa-trash me-1"></i> Eliminar
                                </button>
                            @endif
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Nombre del trámite o servicio relacionado</label>
                                <input type="text" wire:model.blur="relatedRows.{{ $index }}.name"
                                    class="form-control" placeholder="Ej. Dictamen de uso de suelo"
                                    @disabled($readonly)>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Homoclave</label>
                                <input type="text" wire:model.blur="relatedRows.{{ $index }}.homoclave"
                                    class="form-control" placeholder="Ej. VS-DDU-007" @disabled($readonly)>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">Sujeto Obligado responsable</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (['Municipal', 'Estatal', 'Federal'] as $option)
                                        <input type="radio" class="btn-check"
                                            id="rel_{{ $index }}_subject_{{ Str::slug($option, '_') }}"
                                            value="{{ $option }}"
                                            wire:model.live="relatedRows.{{ $index }}.subject_level"
                                            @disabled($readonly)>
                                        <label class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                            for="rel_{{ $index }}_subject_{{ Str::slug($option, '_') }}">{{ $option }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">Tipo de relación</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (['Requisito previo', 'Trámite posterior', 'Dependencia funcional'] as $option)
                                        <input type="radio" class="btn-check"
                                            id="rel_{{ $index }}_relation_{{ Str::slug($option, '_') }}"
                                            value="{{ $option }}"
                                            wire:model.live="relatedRows.{{ $index }}.relation_type"
                                            @disabled($readonly)>
                                        <label class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                            for="rel_{{ $index }}_relation_{{ Str::slug($option, '_') }}">{{ $option }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if (!$readonly)
                <button type="button" class="btn btn-outline-primary w-100" wire:click="addRow('relatedRows')">
                    <i class="fas fa-plus me-2"></i> Agregar otro trámite relacionado
                </button>
            @elseif (count($relatedRows) === 0)
                <p class="text-muted mb-0">Sin trámites relacionados.</p>
            @endif
        </div>
    </div>

    {{-- G. PRESENTACIÓN Y FORMATO DE LA SOLICITUD --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-g">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">G</span>
                    Presentación y formato de la solicitud
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label d-block">Forma de presentación de la solicitud</label>
                    @include('service_requests.utilities.partials.chip-checks', [
                        'field' => 'submission_forms',
                        'options' => [
                            'Formulario electrónico',
                            'Formato oficial',
                            'Escrito libre',
                            'Comparecencia',
                            'Correo institucional',
                        ],
                        'mode' => $mode,
                    ])
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nombre del formato vigente</label>
                    <input type="text" wire:model.blur="format_name" class="form-control"
                        placeholder="Ej. Solicitud única de licencia" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Medio de Difusión Oficial</label>
                    <input type="text" wire:model.blur="format_media" class="form-control"
                        placeholder="Ej. Periódico Oficial del Estado" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Última fecha de publicación</label>
                    <input type="date" wire:model.live="format_publication_date" class="form-control"
                        @disabled($readonly)>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Formato vigente (PDF)</label>
                    @if ($request != null && $request->format_filename)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <a href="{{ $request->format_filename }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf me-1"></i> Ver formato vigente
                            </a>
                            @if (!$readonly)
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    wire:click="removeFile('format_filename')" wire:confirm="¿Quitar este archivo?"
                                    title="Quitar archivo" aria-label="Quitar archivo">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    @endif
                    @if (!$readonly)
                        <input type="file" wire:model="format_upload"
                            class="form-control @error('format_upload') is-invalid @enderror" accept=".pdf">
                        @error('format_upload')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div wire:loading wire:target="format_upload">
                            <small class="text-muted"><i class="fas fa-circle-notch fa-spin me-1"></i> Subiendo
                                archivo…</small>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pasos para realizar el trámite en línea (documento)</label>
                    @if ($request != null && $request->steps_filename)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <a href="{{ $request->steps_filename }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-alt me-1"></i> Ver documento
                            </a>
                            @if (!$readonly)
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    wire:click="removeFile('steps_filename')" wire:confirm="¿Quitar este archivo?"
                                    title="Quitar archivo" aria-label="Quitar archivo">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    @endif
                    @if (!$readonly)
                        <input type="file" wire:model="steps_upload"
                            class="form-control @error('steps_upload') is-invalid @enderror">
                        @error('steps_upload')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div wire:loading wire:target="steps_upload">
                            <small class="text-muted"><i class="fas fa-circle-notch fa-spin me-1"></i> Subiendo
                                archivo…</small>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class="form-label">Ficha del trámite (documento)</label>
                    @if ($request != null && $request->procedure_filename)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <a href="{{ $request->procedure_filename }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf me-1"></i> Ver ficha
                            </a>
                            @if (!$readonly)
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    wire:click="removeFile('procedure_filename')" wire:confirm="¿Quitar este archivo?"
                                    title="Quitar archivo" aria-label="Quitar archivo">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    @endif
                    @if (!$readonly)
                        <input type="file" wire:model="procedure_upload"
                            class="form-control @error('procedure_upload') is-invalid @enderror">
                        @error('procedure_upload')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div wire:loading wire:target="procedure_upload">
                            <small class="text-muted"><i class="fas fa-circle-notch fa-spin me-1"></i> Subiendo
                                archivo…</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- H. INSPECCIÓN O VERIFICACIÓN --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-h">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">H</span>
                    Inspección o verificación
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label d-block">¿Requiere inspección o verificación?</label>
                    @include('service_requests.utilities.partials.bool-group', [
                        'field' => 'requires_inspection',
                        'mode' => $mode,
                    ])
                </div>

                @if ($requires_inspection === '1')
                    <div class="col-md-12">
                        <label class="form-label">Objetivo de la inspección o verificación</label>
                        <input type="text" wire:model.blur="inspection_objective" class="form-control"
                            placeholder="Ej. Verificar condiciones de seguridad del local"
                            @disabled($readonly)>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Autoridad responsable</label>
                        <input type="text" wire:model.blur="inspection_authority" class="form-control"
                            placeholder="Ej. Protección Civil Municipal" @disabled($readonly)>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Momento en que se realiza</label>
                        <input type="text" wire:model.blur="inspection_moment" class="form-control"
                            placeholder="Ej. Antes de emitir la resolución" @disabled($readonly)>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fundamento jurídico</label>
                        <input type="text" wire:model.blur="inspection_legal_basis" class="form-control"
                            placeholder="Ej. Reglamento de P. Civil, art. 30" @disabled($readonly)>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Criterios aplicables</label>
                        <input type="text" wire:model.blur="inspection_criteria" class="form-control"
                            placeholder="Ej. Salidas de emergencia, extintores…" @disabled($readonly)>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- I. CONTACTO, OFICINAS Y HORARIOS DE ATENCIÓN --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-i">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">I</span>
                    Contacto, oficinas y horarios de atención
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-address-card me-2"></i>Contacto oficial</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nombre del área responsable</label>
                    <input type="text" wire:model.blur="contact_area" class="form-control"
                        placeholder="Ej. Ventanilla Única" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Servidor público de orientación</label>
                    <input type="text" wire:model.blur="contact_advisor" class="form-control"
                        placeholder="Nombre y cargo" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono</label>
                    <input type="text" wire:model.blur="contact_phone" class="form-control"
                        placeholder="(456) 000 0000 ext." @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" wire:model.blur="contact_email" class="form-control"
                        placeholder="area@vallesantiago.gob.mx" @disabled($readonly)>
                </div>
                <div class="col-md-6 offset-md-6">
                    <label class="form-label">Medio para consultas, seguimiento y quejas</label>
                    <input type="text" wire:model.blur="contact_media" class="form-control"
                        placeholder="Ej. Portal, teléfono, correo" @disabled($readonly)>
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-building me-2"></i>Oficinas de recepción</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <label class="form-label">Unidad administrativa de recepción y domicilio completo</label>
                    <input type="text" wire:model.blur="reception_address" class="form-control"
                        placeholder="Ej. Presidencia Municipal, Portal Guerrero #1, Centro"
                        @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label d-block">¿Existe ventanilla alterna o módulo móvil?</label>
                    @include('service_requests.utilities.partials.bool-group', [
                        'field' => 'has_alternate_office',
                        'mode' => $mode,
                    ])
                </div>
                @if ($has_alternate_office === '1')
                    <div class="col-md-6">
                        <label class="form-label">URL para ubicación</label>
                        <input type="url" wire:model.blur="alternate_office_url" class="form-control"
                            placeholder="https://" @disabled($readonly)>
                    </div>
                @endif
            </div>

            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-clock me-2"></i>Horarios de atención</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Días y horarios</label>
                    <input type="text" wire:model.blur="schedule_days" class="form-control"
                        placeholder="L–V 8:00–15:00" @disabled($readonly)>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Recepción de documentos</label>
                    <input type="text" wire:model.blur="schedule_reception" class="form-control"
                        placeholder="8:00–14:00" @disabled($readonly)>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Entrega de resolución</label>
                    <input type="text" wire:model.blur="schedule_resolution" class="form-control"
                        placeholder="9:00–15:00" @disabled($readonly)>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Días inhábiles aplicables</label>
                    <input type="text" wire:model.blur="non_working_days" class="form-control"
                        placeholder="Ej. Días festivos oficiales y periodo vacacional" @disabled($readonly)>
                </div>
            </div>
        </div>
    </div>

    {{-- J. PLAZOS DE RESOLUCIÓN Y PREVENCIÓN --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-j">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">J</span>
                    Plazos de resolución y prevención
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-hourglass-half me-2"></i>Resolución</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Plazo máximo</label>
                    <input type="text" wire:model.blur="resolution_time" class="form-control"
                        placeholder="Ej. 10" @disabled($readonly)>
                </div>
                <div class="col-md-5">
                    <label class="form-label d-block">Unidad de tiempo</label>
                    @include('service_requests.utilities.partials.chip-radios', [
                        'field' => 'resolution_time_unit',
                        'options' => ['Días hábiles', 'Naturales', 'Meses', 'Inmediato'],
                        'mode' => $mode,
                    ])
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fundamento jurídico del plazo</label>
                    <input type="text" wire:model.blur="resolution_legal_basis" class="form-control"
                        placeholder="Ordenamiento y artículo" @disabled($readonly)>
                </div>
                <div class="col-md-4">
                    <label class="form-label d-block">
                        Afirmativa ficta
                        <i class="fas fa-question-circle text-muted ms-1"
                            title="Si la autoridad no responde en el plazo, la solicitud se considera aprobada"></i>
                    </label>
                    @include('service_requests.utilities.partials.bool-group', [
                        'field' => 'afirmativa_ficta',
                        'mode' => $mode,
                    ])
                </div>
                <div class="col-md-4">
                    <label class="form-label d-block">Negativa ficta</label>
                    @include('service_requests.utilities.partials.bool-group', [
                        'field' => 'negativa_ficta',
                        'mode' => $mode,
                    ])
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fundamento jurídico de la ficta</label>
                    <input type="text" wire:model.blur="ficta_legal_basis" class="form-control"
                        placeholder="Ordenamiento y artículo" @disabled($readonly)>
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Prevención al
                solicitante</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Plazo para prevenir al solicitante</label>
                    <input type="text" wire:model.blur="prevention_time" class="form-control"
                        placeholder="Ej. 5 días hábiles" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Plazo del solicitante para cumplir</label>
                    <input type="text" wire:model.blur="compliance_time" class="form-control"
                        placeholder="Ej. 10 días hábiles" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Medio de notificación de la prevención</label>
                    <input type="text" wire:model.blur="prevention_media" class="form-control"
                        placeholder="Ej. Correo institucional / estrados" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fundamento jurídico</label>
                    <input type="text" wire:model.blur="prevention_legal_basis" class="form-control"
                        placeholder="Ordenamiento y artículo" @disabled($readonly)>
                </div>
            </div>
        </div>
    </div>

    {{-- K. COSTOS, DERECHOS Y FORMAS DE PAGO --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-k">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">K</span>
                    Costos, derechos y formas de pago
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Monto aplicable</label>
                    <input type="text" wire:model.blur="applicable_amount" class="form-control"
                        placeholder="Ej. Variable / $0.00" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        Fundamento jurídico del cobro
                        <i class="fas fa-question-circle text-muted ms-1"
                            title="Todo cobro debe estar previsto en la Ley de Ingresos vigente"></i>
                    </label>
                    <input type="text" wire:model.blur="fee_legal_basis" class="form-control"
                        placeholder="Ej. Ley de Ingresos 2025, art. 21" @disabled($readonly)>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Forma de determinar el monto (si es variable)</label>
                    <input type="text" wire:model.blur="variable_fee_method" class="form-control"
                        placeholder="Ej. Según giro y m² del establecimiento" @disabled($readonly)>
                </div>
                <div class="col-md-12">
                    <label class="form-label d-block">Alternativas de pago</label>
                    @include('service_requests.utilities.partials.chip-checks', [
                        'field' => 'payment_options',
                        'options' => ['Caja', 'Banco', 'Transferencia', 'Pago en línea', 'Otro'],
                        'mode' => $mode,
                    ])
                </div>
            </div>

            {{--
            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-dollar-sign me-2"></i>Desglose de costos (se
                muestra al ciudadano)</h6>

            @foreach ($costRows as $index => $row)
                <div class="row g-3 align-items-end mb-2" wire:key="cost-{{ $index }}">
                    <div class="col-md-3">
                        <label class="form-label">Valor</label>
                        <input type="number" step="0.01" wire:model.blur="costRows.{{ $index }}.ammount"
                            class="form-control" placeholder="0.00" @disabled($readonly)>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label">Descripción del valor</label>
                        <input type="text" wire:model.blur="costRows.{{ $index }}.description"
                            class="form-control" placeholder="Descripción del costo" @disabled($readonly)>
                    </div>
                    <div class="col-md-2">
                        @if (!$readonly)
                            <button type="button" class="btn btn-outline-danger w-100"
                                wire:click="removeRow('costRows', {{ $index }})"
                                wire:confirm="¿Eliminar este costo?" title="Eliminar costo"
                                aria-label="Eliminar costo">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
             --}}

            {{--
            @if (!$readonly)
                <button type="button" class="btn btn-outline-primary w-100 mt-2" wire:click="addRow('costRows')">
                    <i class="fas fa-plus me-2"></i> Agregar costo
                </button>
            @elseif (count($costRows) === 0)
                <p class="text-muted mb-0">Sin costos registrados.</p>
            @endif
             --}}
        </div>
    </div>

    {{-- L. VIGENCIA, CRITERIOS DE RESOLUCIÓN Y FRECUENCIA --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-l">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">L</span>
                    Vigencia, criterios de resolución y frecuencia
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-calendar-check me-2"></i>Vigencia de la resolución
            </h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Vigencia</label>
                    <input type="text" wire:model.blur="validity" class="form-control"
                        placeholder="Ej. 1 año fiscal" @disabled($readonly)>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fundamento jurídico</label>
                    <input type="text" wire:model.blur="validity_legal_basis" class="form-control"
                        placeholder="Ordenamiento y art." @disabled($readonly)>
                </div>
                <div class="col-md-4">
                    <label class="form-label d-block">¿Procede renovación?</label>
                    @include('service_requests.utilities.partials.bool-group', [
                        'field' => 'allows_renewal',
                        'mode' => $mode,
                    ])
                </div>
                <div class="col-md-12">
                    <label class="form-label">Criterios de resolución</label>
                    <textarea wire:model.blur="resolution_criteria" class="form-control" rows="3"
                        placeholder="Criterios objetivos para aprobar, negar, prevenir o desechar la solicitud."
                        @disabled($readonly)></textarea>
                    <small class="text-muted">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Evita criterios discrecionales — deben ser verificables.
                    </small>
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-chart-line me-2"></i>Frecuencia del trámite o
                servicio</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Solicitudes recibidas en el último año</label>
                    <input type="text" wire:model.blur="annual_requests" class="form-control"
                        placeholder="Ej. 1,240" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Periodo reportado</label>
                    <input type="text" wire:model.blur="reported_period" class="form-control"
                        placeholder="Ej. Ene–Dic 2025" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fuente de información</label>
                    <input type="text" wire:model.blur="information_source" class="form-control"
                        placeholder="Ej. Sistema de Ventanilla" @disabled($readonly)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Observaciones</label>
                    <input type="text" wire:model.blur="frequency_observations" class="form-control"
                        placeholder="Opcional" @disabled($readonly)>
                </div>
            </div>
        </div>
    </div>

    {{-- M. INFORMACIÓN AL SOLICITANTE, SANCIONES Y PRIVACIDAD --}}
    <div class="card border-0 shadow-sm mb-4" x-data="{ open: true }" wire:key="section-m">
        <div class="card-header bg-white py-3" role="button" @click="open = !open">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">M</span>
                    Información al solicitante, sanciones y privacidad
                </h6>
                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>
        <div class="card-body p-4" x-show="open">
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <label class="form-label">Información que debe conservar el solicitante</label>
                    <textarea wire:model.blur="applicant_records" class="form-control" rows="3"
                        placeholder="Documentos, constancias, acuses o comprobantes que la persona debe conservar para acreditación o seguimiento."
                        @disabled($readonly)></textarea>
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3">
                <i class="fas fa-gavel me-2"></i>Sanciones
                <small class="text-muted fw-normal ms-1">(solo si existen en norma vigente)</small>
            </h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Conducta sancionable</label>
                    <input type="text" wire:model.blur="sanction_conduct" class="form-control"
                        placeholder="Ej. Operar sin licencia" @disabled($readonly)>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sanción aplicable</label>
                    <input type="text" wire:model.blur="sanction_applicable" class="form-control"
                        placeholder="Ej. Multa y clausura" @disabled($readonly)>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fundamento jurídico</label>
                    <input type="text" wire:model.blur="sanction_legal_basis" class="form-control"
                        placeholder="Ordenamiento y art." @disabled($readonly)>
                </div>
            </div>

            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user-shield me-2"></i>Datos personales</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label d-block">¿Recaba datos personales?</label>
                    @include('service_requests.utilities.partials.bool-group', [
                        'field' => 'collects_personal_data',
                        'mode' => $mode,
                    ])
                </div>
                @if ($collects_personal_data === '1')
                    <div class="col-md-6">
                        <label class="form-label">Tipo de datos recabados</label>
                        <input type="text" wire:model.blur="personal_data_types" class="form-control"
                            placeholder="Ej. Nombre, domicilio, RFC, teléfono" @disabled($readonly)>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Aviso de privacidad aplicable</label>
                        <input type="text" wire:model.blur="privacy_notice_name" class="form-control"
                            placeholder="Nombre del aviso" @disabled($readonly)>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Liga del aviso de privacidad</label>
                        <input type="url" wire:model.blur="privacy_notice_url" class="form-control"
                            placeholder="https://" @disabled($readonly)>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- BARRA DE ACCIONES --}}
    <div class="card border-0 shadow sticky-bottom mb-4">
        <div class="card-body py-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                {{-- Stepper de estado --}}
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @foreach ($statusSteps as $value => $label)
                        <span
                            class="badge rounded-pill {{ $status === $value ? 'bg-' . $statusColors[$value] : 'bg-light text-muted border' }}">
                            {{ $label }}
                        </span>
                        @if (!$loop->last)
                            <i class="fas fa-chevron-right text-muted"></i>
                        @endif
                    @endforeach
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    {{-- Indicador de autoguardado --}}
                    @if ($request != null && !$readonly)
                        <small class="text-muted">
                            <span wire:loading>
                                <i class="fas fa-circle-notch fa-spin me-1"></i> Guardando…
                            </span>
                            <span wire:loading.remove>
                                <i class="fas fa-check-circle text-success me-1"></i>
                                Guardado automático{{ $lastSavedAt ? ' · ' . $lastSavedAt : '' }}
                            </span>
                        </small>
                    @elseif ($request == null)
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Guarda el borrador para activar el guardado automático.
                        </small>
                    @endif

                    {{-- Acciones --}}
                    @if ($readonly)
                        <a href="{{ route('institucional_development.requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Volver
                        </a>
                    @else
                        @if ($status === \App\Models\ServiceRequest::STATUS_DRAFT)
                            <button type="button" class="btn btn-outline-primary" wire:click="saveDraft"
                                wire:loading.attr="disabled">
                                <i class="fas fa-save me-2"></i> Guardar borrador
                            </button>

                            @if ($request != null)
                                <button type="button" class="btn btn-outline-warning" wire:click="sendToReview"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-paper-plane me-2"></i> Enviar a revisión
                                </button>
                            @endif
                        @endif

                        @if ($status !== \App\Models\ServiceRequest::STATUS_DRAFT && $request != null)
                            <button type="button" class="btn btn-outline-secondary" wire:click="backToDraft"
                                wire:confirm="{{ $status === \App\Models\ServiceRequest::STATUS_PUBLISHED ? 'El trámite dejará de mostrarse en el portal ciudadano. ¿Regresar a borrador?' : '¿Regresar el trámite a borrador?' }}"
                                wire:loading.attr="disabled">
                                <i class="fas fa-undo me-2"></i> Regresar a borrador
                            </button>
                        @endif

                        @if ($status !== \App\Models\ServiceRequest::STATUS_PUBLISHED)
                            <button type="button" class="btn btn-success" wire:click="publish"
                                wire:confirm="El trámite será visible para la ciudadanía en el portal. ¿Publicar ahora?"
                                wire:loading.attr="disabled">
                                <i class="fas fa-check me-2"></i> Publicar en el portal
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
