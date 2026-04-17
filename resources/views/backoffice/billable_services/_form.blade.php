{{-- Partial compartido entre create y edit --}}

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
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<h6 class="border-bottom pb-2 mb-3">
    <i class="fas fa-tag me-2 text-primary"></i> Información del Servicio
</h6>

<div class="row g-3 mb-4">
    <div class="col-md-8">
        <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
        <input type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $servicio->name ?? '') }}"
               placeholder="Ej. Constancia de Residencia"
               required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Precio Unitario (MXN) <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-light"><i class="fas fa-dollar-sign text-muted"></i></span>
            <input type="number" name="unit_price" step="0.01" min="0"
                   class="form-control @error('unit_price') is-invalid @enderror"
                   value="{{ old('unit_price', $servicio->unit_price ?? '') }}"
                   placeholder="0.00"
                   required>
            @error('unit_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Descripción</label>
        <textarea name="description"
                  class="form-control @error('description') is-invalid @enderror"
                  rows="3"
                  placeholder="Describe brevemente el servicio que se ofrece...">{{ old('description', $servicio->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<h6 class="border-bottom pb-2 mb-3">
    <i class="fas fa-toggle-on me-2 text-primary"></i> Visibilidad
</h6>

<div class="row g-3">
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $servicio->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="is_active">
                Servicio activo <small class="text-muted fw-normal">(visible para ciudadanos en el catálogo)</small>
            </label>
        </div>
    </div>
</div>
