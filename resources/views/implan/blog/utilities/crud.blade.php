<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($post != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver publicación</h2>
                            @break

                            @case(2)
                                <h2>Editar publicación</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva publicación</h2>
                    @endif
                </div>
            </div>
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row align-items-center justify-content-end m-3">
                    <div class="col-md-2">
                        <label for="published_at" class="col-form-label">Fecha de Ingreso</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="published_at" wire:model="published_at" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center justify-content-end m-3">
                    <div class="col-md-2">
                        <label for="type" class="col-form-label">Tipo</label>
                    </div>
                    <div class="col-md-4">
                        <select name="type" wire:model="type" id="type" class="form-control"
                            @if ($mode == 1) disabled @endif>
                            <option>Seleccionar opción</option>
                            <option value="Plano">Plano Temático</option>
                            <option value="Capa">Capa</option>
                        </select>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="title" class="col-form-label">Título</label>
                    </div>
                    <div class="col-md">
                        <input type="text" class="form-control" wire:model="title" name="title"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-2">
                        <label for="image" class="col-form-label">Imagen</label>
                    </div>
                    <div class="col-md">
                        @if ($mode == 1)
                            @if ($image)
                                @php
                                    $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                                @endphp

                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'tiff']))
                                    <img src="{{ $image }}" alt="Vista previa"
                                        style="max-width: 400px; height: auto;">
                                @elseif ($extension === 'pdf')
                                    <iframe src="{{ $image }}" style="width: 100%; height: 500px;"
                                        frameborder="0"></iframe>
                                @else
                                    <a href="{{ $image }}" target="_blank" class="btn btn-outline-primary">
                                        Ver archivo
                                    </a>
                                @endif
                            @else
                                <p>No hay archivo disponible.</p>
                            @endif
                        @else
                            <input type="file" wire:model="image" name="image" class="form-control">
                        @endif
                    </div>
                </div>

                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('implan.blog.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>
                    @if ($mode != 1)
                        <button type="submit" style="max-width: 110px" class="btn btn-dark btn-sm">Guardar
                            datos</button>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>
