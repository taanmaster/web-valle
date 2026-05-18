@push('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
@endpush

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                @switch($mode)
                    @case(0)
                        <h2>Nueva entrada</h2>
                    @break

                    @case(1)
                        <h2>Ver entrada</h2>
                    @break

                    @case(2)
                        <h2>Editar entrada</h2>
                    @break
                @endswitch
            </div>
        </div>

        <form method="POST" wire:submit="save" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row align-items-center m-3">
                <div class="col-md-2">
                    <label class="col-form-label">Título</label>
                </div>
                <div class="col-md">
                    <input type="text" wire:model="title" class="form-control"
                        @if ($mode == 1) disabled @endif>
                    @error('title')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-2">
                    <label class="col-form-label">Descripción</label>
                </div>
                <div class="col-md">
                    <textarea class="form-control" wire:model="description" rows="3"
                        @if ($mode == 1) disabled @endif></textarea>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-2">
                    <label class="col-form-label">Contenido 1</label>
                </div>
                <div class="col-md" wire:ignore>
                    <input id="gb_content_1" type="hidden" wire:model.defer="content_1"
                        @if ($mode == 1) disabled @endif value="{{ $content_1 }}">
                    <trix-editor wire:ignore input="gb_content_1" id="trix-gb-content_1"
                        @if ($mode == 1) disabled @endif></trix-editor>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-2">
                    <label class="col-form-label">Contenido 2</label>
                </div>
                <div class="col-md" wire:ignore>
                    <input id="gb_content_2" type="hidden" wire:model.defer="content_2"
                        @if ($mode == 1) disabled @endif value="{{ $content_2 }}">
                    <trix-editor wire:ignore input="gb_content_2" id="trix-gb-content_2"
                        @if ($mode == 1) disabled @endif></trix-editor>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-2">
                    <label class="col-form-label">Imagen de portada</label>
                </div>
                <div class="col-md-10">
                    <input type="file" class="form-control" wire:model="hero_img" accept="image/*"
                        @if ($mode == 1) disabled @endif>
                    @if ($entry && $entry->hero_img)
                        <img src="{{ $entry->hero_img }}" class="img-thumbnail mt-2" style="max-height:120px;"
                            alt="Portada actual">
                    @endif
                </div>
            </div>

            <div class="row m-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de entrada</label>
                    <input type="date" class="form-control" wire:model="published_at"
                        @if ($mode == 1) disabled @endif>
                </div>
            </div>

            @if ($mode != 1)
                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route($routePrefix . '.admin.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">
                        @if ($mode == 0)
                            Cancelar
                        @else
                            Volver
                        @endif
                    </a>
                    <button type="submit" style="max-width: 110px" class="btn btn-primary btn-sm">
                        Guardar datos
                    </button>
                </div>
            @endif
        </form>

        {{-- Fotos adicionales — sólo en modo edición --}}
        @if ($mode == 2)
            <hr class="mt-4">
            <h5 class="mb-3">Imágenes adicionales</h5>

            @if ($existingPhotos->isNotEmpty())
                <div class="row mb-4">
                    @foreach ($existingPhotos as $photo)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="{{ $photo->image_path }}" class="card-img-top"
                                    style="height:150px; object-fit:cover;" alt="">
                                <div class="card-body text-center p-2">
                                    <button wire:click="deletePhoto({{ $photo->id }})"
                                        wire:confirm="¿Eliminar esta imagen?" type="button"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class='bx bx-trash'></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Agregar imágenes</label>
                <input type="file" class="form-control" wire:model="newPhotos" multiple accept="image/*">
                @error('newPhotos.*')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <button wire:click="uploadPhotos" type="button" class="btn btn-info btn-sm">
                    <div wire:loading wire:target="uploadPhotos" class="spinner-border spinner-border-sm me-1"
                        role="status"></div>
                    Subir imágenes
                </button>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const e1 = document.querySelector('#trix-gb-content_1');
            const e2 = document.querySelector('#trix-gb-content_2');

            if (e1) {
                e1.addEventListener('trix-change', function() {
                    Livewire.dispatch('updateGeneralBlogContent1', {
                        payload: document.querySelector('#gb_content_1').value
                    });
                });
            }
            if (e2) {
                e2.addEventListener('trix-change', function() {
                    Livewire.dispatch('updateGeneralBlogContent2', {
                        payload: document.querySelector('#gb_content_2').value
                    });
                });
            }

            document.addEventListener('livewire:load', function() {
                setTimeout(() => {
                    const c1 = document.querySelector('#gb_content_1');
                    const c2 = document.querySelector('#gb_content_2');
                    const ed1 = document.querySelector('#trix-gb-content_1');
                    const ed2 = document.querySelector('#trix-gb-content_2');
                    if (c1 && ed1) ed1.editor.loadHTML(c1.value);
                    if (c2 && ed2) ed2.editor.loadHTML(c2.value);
                }, 300);
            });
        });
    </script>
</div>
