<div>
@push('stylesheets')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
    integrity="sha384-G0pg86Lj7XwiCQ/NoHwtwRHuXmraYGh2A3fl8nJ/PC+IYnAjhsf0l7sOJr4Qiqj0"
    crossorigin="anonymous" />
<style>
    .bf-upload-box { cursor: pointer; min-height: 70px; border: 1px solid #dee2e6; border-radius: 8px; background: #f8f9fa; transition: border-color .2s, background .2s; }
    .bf-upload-box:hover { border-color: #adb5bd; background: #f1f3f5; }
    .btn-guardar { background: #F5C842; border: none; color: #212529; font-weight: 600; padding: 10px 48px; border-radius: 6px; }
    .btn-guardar:hover { background: #e9bb2f; color: #212529; }
</style>
@endpush

<div class="row layout-spacing">
    <div class="main-content">

        <div class="d-flex align-items-center gap-3 mb-4">
            <h4 class="fw-bold mb-0">
                @if ($mode === 0) Nuevo Beneficio
                @elseif ($mode === 1) Ver Beneficio
                @else Editar Beneficio
                @endif
            </h4>
        </div>

        <form method="POST" wire:submit="save" enctype="multipart/form-data">
            @csrf

            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">

                    {{-- Título --}}
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3"><label class="col-form-label">Título</label></div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    wire:model="title"
                                    @if($mode===1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3"><label class="col-form-label">Descripción</label></div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" class="form-control" wire:model="description"
                                    @if($mode===1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                        </div>
                    </div>

                    {{-- Contenido 1 --}}
                    <div class="row align-items-start mb-3">
                        <div class="col-md-3">
                            <label class="col-form-label">Contenido 1 <small class="text-muted d-block">(Primer parte del artículo)</small></label>
                        </div>
                        <div class="col-md-9" wire:ignore>
                            <input id="bf_content_1" type="hidden" value="{{ $content_1 }}">
                            <trix-editor input="bf_content_1" id="trix-bf-content_1"
                                @if ($mode === 1) disabled @endif></trix-editor>
                        </div>
                    </div>

                    {{-- Contenido 2 --}}
                    <div class="row align-items-start mb-3">
                        <div class="col-md-3">
                            <label class="col-form-label">Contenido 2 <small class="text-muted d-block">(Segunda parte del artículo)</small></label>
                        </div>
                        <div class="col-md-9" wire:ignore>
                            <input id="bf_content_2" type="hidden" value="{{ $content_2 }}">
                            <trix-editor input="bf_content_2" id="trix-bf-content_2"
                                @if ($mode === 1) disabled @endif></trix-editor>
                        </div>
                    </div>

                    {{-- Imagen de portada --}}
                    <div class="row align-items-start mb-3">
                        <div class="col-md-3"><label class="col-form-label">Imagen de portada</label></div>
                        <div class="col-md-9">
                            @if ($mode === 1)
                                @if ($entry?->hero_img)
                                    <img src="{{ $entry->hero_img }}" class="img-fluid rounded" style="max-height: 200px;" alt="Portada">
                                @else
                                    <span class="text-muted small">Sin imagen de portada.</span>
                                @endif
                            @else
                                <label class="bf-upload-box d-flex align-items-center justify-content-center gap-2 w-100 p-3">
                                    <span class="text-muted small">Arrastra o carga imagen</span>
                                    <i class="bx bx-image-add fs-4 text-muted"></i>
                                    <input type="file" class="d-none" wire:model="hero_img" accept="image/*">
                                </label>
                                <div wire:loading wire:target="hero_img" class="text-muted small mt-1">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Cargando imagen...
                                </div>
                                @if ($hero_img instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                    <img src="{{ $hero_img->temporaryUrl() }}" class="img-fluid rounded mt-2" style="max-height: 160px;">
                                @elseif ($entry?->hero_img)
                                    <img src="{{ $entry->hero_img }}" class="img-fluid rounded mt-2" style="max-height: 160px;" alt="Portada actual">
                                @endif
                                @error('hero_img')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            @endif
                        </div>
                    </div>

                    {{-- Imágenes --}}
                    <div class="row align-items-start mb-3">
                        <div class="col-md-3"><label class="col-form-label">Imágenes</label></div>
                        <div class="col-md-9">
                            {{-- Imágenes existentes (show/edit) --}}
                            @if ($existingPhotos->isNotEmpty())
                                <div class="row g-3 mb-3">
                                    @foreach ($existingPhotos as $photo)
                                        <div class="col-md-4 col-6" wire:key="photo-{{ $photo->id }}">
                                            <div class="card border-0 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                                <img src="{{ $photo->image_path }}" class="w-100"
                                                    style="height: 120px; object-fit: cover;" alt="">
                                                @if ($mode === 2)
                                                    <button type="button" wire:click="deletePhoto({{ $photo->id }})"
                                                        wire:confirm="¿Eliminar esta imagen?"
                                                        class="btn btn-sm btn-outline-danger m-2"
                                                        title="Eliminar imagen" aria-label="Eliminar imagen">
                                                        <i class="bx bx-trash"></i> Eliminar
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($mode !== 1)
                                <label class="bf-upload-box d-flex align-items-center justify-content-center gap-2 w-100 p-3">
                                    <span class="text-muted small">Arrastra o carga de imágenes</span>
                                    <i class="bx bx-images fs-4 text-muted"></i>
                                    <input type="file" class="d-none" wire:model="newPhotos" multiple accept="image/*">
                                </label>
                                <div wire:loading wire:target="newPhotos" class="text-muted small mt-1">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Cargando imágenes...
                                </div>
                                @error('newPhotos.*')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

                                @if (!empty($newPhotos))
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @foreach ($newPhotos as $photo)
                                            <img src="{{ $photo->temporaryUrl() }}" class="rounded"
                                                style="height: 80px; width: 110px; object-fit: cover;">
                                        @endforeach
                                    </div>
                                    @if ($mode === 2)
                                        <button type="button" wire:click="uploadPhotos" class="btn btn-info btn-sm mt-2">
                                            <span wire:loading wire:target="uploadPhotos"
                                                class="spinner-border spinner-border-sm me-1"></span>
                                            Subir imágenes
                                        </button>
                                    @endif
                                @endif
                            @elseif ($existingPhotos->isEmpty())
                                <span class="text-muted small">Sin imágenes adicionales.</span>
                            @endif
                        </div>
                    </div>

                    {{-- Fecha de entrada --}}
                    <div class="row justify-content-end align-items-center">
                        <div class="col-auto d-flex align-items-center gap-3">
                            <label class="mb-0">Fecha de entrada</label>
                            <input type="date" class="form-control" style="width: 180px;"
                                wire:model="published_at"
                                @if($mode===1) disabled @endif>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Acciones --}}
            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                <a href="{{ route('benefits.admin.index') }}" class="btn btn-secondary px-4">
                    {{ $mode === 1 ? 'Volver' : 'Cancelar' }}
                </a>
                @if ($mode !== 1)
                    <button type="submit" class="btn btn-guardar">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                        Guardar
                    </button>
                @else
                    <a href="{{ route('benefits.admin.edit', $entry->id) }}" class="btn btn-primary px-4">
                        <i class="bx bx-edit"></i> Editar beneficio
                    </a>
                @endif
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"
    integrity="sha384-sRMuJQ2/bkdEUHWNQG1FK818YOYVLI0ywbZnUh8hJwJ+9MAutlVA5vn5xpfdvUCF"
    crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const e1 = document.querySelector('#trix-bf-content_1');
        const e2 = document.querySelector('#trix-bf-content_2');

        if (e1) {
            e1.addEventListener('trix-change', function () {
                Livewire.dispatch('updateBenefitContent1', {
                    payload: document.querySelector('#bf_content_1').value
                });
            });
        }
        if (e2) {
            e2.addEventListener('trix-change', function () {
                Livewire.dispatch('updateBenefitContent2', {
                    payload: document.querySelector('#bf_content_2').value
                });
            });
        }
    });
</script>
@endpush
</div>
