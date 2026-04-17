{{-- Partial AIR: Formulario de Análisis de Impacto Regulatorio --}}

@if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-circle fa-lg me-3 mt-1"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<input type="hidden" name="type" value="air">

{{-- Folio (readonly) --}}
<div class="mb-4">
    <label class="form-label fw-semibold text-muted small text-uppercase">Folio</label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="fas fa-hashtag text-muted"></i></span>
        <input type="text" class="form-control bg-light fw-bold"
               value="{{ $folio ?? $regulatoryImpact->folio ?? '' }}" readonly>
        <input type="hidden" name="folio" value="{{ $folio ?? $regulatoryImpact->folio ?? '' }}">
    </div>
    <div class="form-text">El folio se genera automáticamente.</div>
</div>

{{-- Sección 1: Datos de la Propuesta --}}
<h6 class="border-bottom pb-2 mb-3 mt-4">
    <i class="fas fa-file-signature me-2 text-warning"></i> Datos de la Propuesta Regulatoria
</h6>

<div class="row g-3 mb-4">
    <div class="col-md-8">
        <label class="form-label fw-semibold">Nombre de la Propuesta Regulatoria <span class="text-danger">*</span></label>
        <input type="text" name="nombre_propuesta"
               class="form-control @error('nombre_propuesta') is-invalid @enderror"
               value="{{ old('nombre_propuesta', $regulatoryImpact->nombre_propuesta ?? '') }}"
               placeholder="Nombre completo de la propuesta" required>
        @error('nombre_propuesta')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Fecha de Vigencia</label>
        <input type="date" name="fecha_vigencia"
               class="form-control @error('fecha_vigencia') is-invalid @enderror"
               value="{{ old('fecha_vigencia', isset($regulatoryImpact) && $regulatoryImpact->fecha_vigencia ? $regulatoryImpact->fecha_vigencia->format('Y-m-d') : '') }}">
        @error('fecha_vigencia')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Autoridad o autoridades que la emiten</label>
        <input type="text" name="autoridad_emisora"
               class="form-control @error('autoridad_emisora') is-invalid @enderror"
               value="{{ old('autoridad_emisora', $regulatoryImpact->autoridad_emisora ?? '') }}"
               placeholder="Ej. H. Ayuntamiento de Valle de Guadalupe">
        @error('autoridad_emisora')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Dependencia que la aplica <span class="text-danger">*</span></label>
        <select name="dependency_id" class="form-select @error('dependency_id') is-invalid @enderror" required>
            <option value="">— Seleccionar dependencia —</option>
            @foreach($dependencies as $dep)
                <option value="{{ $dep->id }}"
                    {{ old('dependency_id', $regulatoryImpact->dependency_id ?? '') == $dep->id ? 'selected' : '' }}>
                    {{ $dep->name }}
                </option>
            @endforeach
        </select>
        @error('dependency_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Sección 2: Detalles de la Regulación --}}
<h6 class="border-bottom pb-2 mb-3 mt-4">
    <i class="fas fa-list-ul me-2 text-warning"></i> Detalles de la Regulación
</h6>

<div class="row g-3 mb-4">
    <div class="col-12">
        <label class="form-label fw-semibold">Objeto del Programa</label>
        <textarea name="objeto_programa" rows="3"
                  class="form-control @error('objeto_programa') is-invalid @enderror"
                  placeholder="Describa el objeto o propósito del programa...">{{ old('objeto_programa', $regulatoryImpact->objeto_programa ?? '') }}</textarea>
        @error('objeto_programa')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Tipo de Ordenamiento</label>
        <input type="text" name="tipo_ordenamiento"
               class="form-control @error('tipo_ordenamiento') is-invalid @enderror"
               value="{{ old('tipo_ordenamiento', $regulatoryImpact->tipo_ordenamiento ?? '') }}"
               placeholder="Ej. Reglamento, Acuerdo, etc.">
        @error('tipo_ordenamiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Materias Reguladas</label>
        <input type="text" name="materias_reguladas"
               class="form-control @error('materias_reguladas') is-invalid @enderror"
               value="{{ old('materias_reguladas', $regulatoryImpact->materias_reguladas ?? '') }}"
               placeholder="Áreas o materias">
        @error('materias_reguladas')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Sectores Regulados</label>
        <input type="text" name="sectores_regulados"
               class="form-control @error('sectores_regulados') is-invalid @enderror"
               value="{{ old('sectores_regulados', $regulatoryImpact->sectores_regulados ?? '') }}"
               placeholder="Sectores económicos o sociales">
        @error('sectores_regulados')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Sujetos Regulados</label>
        <input type="text" name="sujetos_regulados"
               class="form-control @error('sujetos_regulados') is-invalid @enderror"
               value="{{ old('sujetos_regulados', $regulatoryImpact->sujetos_regulados ?? '') }}"
               placeholder="Personas, empresas u organismos sujetos a la regulación">
        @error('sujetos_regulados')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Sección 3: Contenido --}}
<h6 class="border-bottom pb-2 mb-3 mt-4">
    <i class="fas fa-align-left me-2 text-warning"></i> Contenido de la Regulación
</h6>

<div class="row g-3 mb-4">
    <div class="col-12">
        <label class="form-label fw-semibold">Índice de la Regulación (Contenido)</label>
        <textarea name="indice_regulacion" rows="4"
                  class="form-control @error('indice_regulacion') is-invalid @enderror"
                  placeholder="Liste los artículos, capítulos o secciones principales...">{{ old('indice_regulacion', $regulatoryImpact->indice_regulacion ?? '') }}</textarea>
        @error('indice_regulacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Trámites y servicios relacionados con la regulación</label>
        <textarea name="tramites_relacionados" rows="3"
                  class="form-control @error('tramites_relacionados') is-invalid @enderror"
                  placeholder="Describa los trámites o servicios vinculados...">{{ old('tramites_relacionados', $regulatoryImpact->tramites_relacionados ?? '') }}</textarea>
        @error('tramites_relacionados')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Sección 4: Formato de Solicitud --}}
<h6 class="border-bottom pb-2 mb-3 mt-4">
    <i class="fas fa-paperclip me-2 text-warning"></i> Formato de Solicitud
</h6>

<div class="row g-3">
    <div class="col-12">
        @if(isset($regulatoryImpact) && $regulatoryImpact->formato_solicitud_s3_url)
            <div class="alert alert-info border-0 d-flex align-items-center mb-2">
                <i class="fas fa-file-pdf fa-lg me-3"></i>
                <div>
                    <strong>Archivo actual:</strong>
                    <a href="{{ $regulatoryImpact->formato_solicitud_s3_url }}" target="_blank" class="ms-2">
                        Ver documento adjunto <i class="fas fa-external-link-alt ms-1"></i>
                    </a>
                </div>
            </div>
            <label class="form-label fw-semibold">Reemplazar Formato de Solicitud (opcional)</label>
        @else
            <label class="form-label fw-semibold">Adjuntar Formato de Solicitud (PDF o Word)</label>
        @endif
        <input type="file" name="formato_solicitud" accept=".pdf,.doc,.docx"
               class="form-control @error('formato_solicitud') is-invalid @enderror">
        <div class="form-text">Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 10 MB.</div>
        @error('formato_solicitud')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
