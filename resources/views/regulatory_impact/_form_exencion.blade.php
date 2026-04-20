{{-- Partial Exención: Formulario de Solicitud de Exención de AIR --}}

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

<input type="hidden" name="type" value="exencion">

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

{{-- Sección 1: Datos de la Solicitud --}}
<h6 class="border-bottom pb-2 mb-3 mt-4">
    <i class="fas fa-file-signature me-2 text-secondary"></i> Datos de la Solicitud de Exención
</h6>

<div class="row g-3 mb-4">
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

    <div class="col-md-6">
        <label class="form-label fw-semibold">Fecha de Envío</label>
        <input type="date" name="fecha_envio"
               class="form-control @error('fecha_envio') is-invalid @enderror"
               value="{{ old('fecha_envio', isset($regulatoryImpact) && $regulatoryImpact->fecha_envio ? $regulatoryImpact->fecha_envio->format('Y-m-d') : '') }}">
        @error('fecha_envio')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Título de la Regulación <span class="text-danger">*</span></label>
        <input type="text" name="titulo_regulacion"
               class="form-control @error('titulo_regulacion') is-invalid @enderror"
               value="{{ old('titulo_regulacion', $regulatoryImpact->titulo_regulacion ?? '') }}"
               placeholder="Título completo de la regulación" required>
        @error('titulo_regulacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Nombre y Cargo</label>
        <input type="text" name="nombre_cargo"
               class="form-control @error('nombre_cargo') is-invalid @enderror"
               value="{{ old('nombre_cargo', $regulatoryImpact->nombre_cargo ?? '') }}"
               placeholder="Nombre completo y cargo del solicitante">
        @error('nombre_cargo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Formato de Solicitud --}}
<h6 class="border-bottom pb-2 mb-3 mt-4">
    <i class="fas fa-paperclip me-2 text-secondary"></i> Formato de Solicitud
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
