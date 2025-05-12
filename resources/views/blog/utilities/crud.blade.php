<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                @if ($blog != null)
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
                @else
                    <h2>Nueva entrada</h2>
                @endif
            </div>
        </div>


        <form method="POST" wire:submit="save" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row align-items-center m-3">
                <div class="col-md-1">
                    <label for="title" class="col-form-label">Title</label>
                </div>
                <div class="col-md">
                    <input type="text" name="title" wire:model="title" class="form-control"
                        @if ($mode == 1) disabled @endif>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-1">
                    <label for="description" class="col-form-label">Descripción</label>
                </div>
                <div class="col-md">
                    <textarea class="form-control" wire:model="description" name="description" rows="3"
                        @if ($mode == 1) disabled @endif></textarea>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-1">
                    <label for="content_1" class="col-form-label">Contenido 1 (Primer parte del artículo)</label>
                </div>
                <div class="col-md">
                    <textarea class="form-control" wire:model="content_1" name="content_1" rows="3"
                        @if ($mode == 1) disabled @endif></textarea>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-1">
                    <label for="content_2" class="col-form-label">Contenido 2 (Segunda parte del artículo)</label>
                </div>
                <div class="col-md">
                    <textarea class="form-control" wire:model="content_2" name="content_2" rows="3"
                        @if ($mode == 1) disabled @endif></textarea>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-1">
                    <label for="cover" class="col-form-label">Imagen de portada</label>
                </div>
                <div class="col-md">
                    <div class="form-check">
                        <input type="file" class="form-control" id="hero_img" name="hero_img" wire:model="hero_img"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <label for="images" class="col-form-label">Imagenes</label>
                </div>
                <div class="col-md">
                    <livewire:dropzone wire:model="photos" :rules="['image', 'mimes:png,jpeg', 'max:10420']" :multiple="true" />
                </div>
            </div>

            <div class="row m-3">
                <div class="col-md-6">
                    <label for="writer" class="form-label">Escrito por la
                        dirección de...</label>
                    <select class="form-select" name="writer" wire:model.change="writer"
                        @if ($mode == 1) disabled @endif>
                        <option selected>Seleccionar tipo</option>
                        @foreach ($categories as $categoryTransparency)
                            <option value="{{ $categoryTransparency->name }}">{{ $categoryTransparency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="published_at" class="form-label">Fecha de entrada o modificación</label>
                    <input type="date" class="form-control" id="published_at" name="published_at"
                        wire:model="published_at" @if ($mode == 1) disabled @endif>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <label for="category" class="form-label">Escrito por la
                        dirección de...</label>
                    <select class="form-select" name="category" wire:model.change="category"
                        @if ($mode == 1) disabled @endif>
                        <option selected>Seleccionar tipo</option>
                        <option value="General">General</option>
                        <option value="Turismo">Turismo</option>
                        <option value="Eventos">Eventos</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="is_fav" class="form-label">Añadir a destacados</label>
                    <select class="form-select" name="is_fav" wire:model="is_fav">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>
            </div>

            @if ($mode != 1)
                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('blog.admin.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>
                    <button type="submit" style="max-width: 110px" class="btn btn-dark btn-sm">Guardar
                        datos</button>
                </div>
            @endif
        </form>
    </div>
</div>
