@push('stylesheets')
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css" />

    <style>
        .dropzone {
            min-height: 10rem;
            border: 3px dotted #d9d9d9;
            position: relative;
            border-radius: 15px;
            margin-bottom: 20px;
        }
    </style>
@endpush

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
                <div class="col-md-11">
                    <div class="form-check">
                        <input type="file" class="form-control" id="hero_img" name="hero_img" wire:model="hero_img"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>
            </div>

            <div class="row m-3">
                <div class="col-md-6 mb-3">
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
                <div class="col-md-6 mb-3">
                    <label for="published_at" class="form-label">Fecha de entrada o modificación</label>
                    <input type="date" class="form-control" id="published_at" name="published_at"
                        wire:model="published_at" @if ($mode == 1) disabled @endif>
                </div>

                <div class="col-md-6">
                    <label for="category" class="form-label">Categorías</label>
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

        @if ($mode == 2)
            <div class="col-md-1">
                <label for="photos" class="col-form-label">Imágenes adicionales</label>
            </div>

            <div class="col-md-12">
                <div id="dropzoneForm" class="dropzone">
                    <div class="dz-message" data-dz-message>
                        <span>
                            <img src="{{ asset('assets/images/illustrations/upload.svg') }}"
                                class="me-auto ms-auto d-block" width="40%" alt="">
                            <br>
                            Arrastra y suelta aquí tus archivos o da click para buscar
                        </span>
                    </div>
                </div>

                <p class="text-bold"><small>Peso máximo por archivo: 10MB</small></p>

                <div align="center">
                    <button type="button" class="btn btn-info" id="submit-all">Subir Imagenes</button>
                </div>
            </div>
        @endif

    </div>
</div>
@if ($mode == 2)
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

        <script>
            var myDropzone = new Dropzone("#dropzoneForm", {
                url: "{{ route('dropzone.blog.upload', $blog->id) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                autoProcessQueue: false,
                parallelUploads: 20,
                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
                autoDiscover: false,
                maxFilesize: 15,
                addRemoveLinks: true,
                init: function() {
                    var submitButton = document.querySelector("#submit-all");
                    myDropzone = this;

                    submitButton.addEventListener('click', function() {
                        myDropzone.processQueue();
                    });

                    this.on("complete", function() {
                        if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                            var _this = this;
                            _this.removeAllFiles();
                        }
                        load_images();
                    });

                },
            });

            load_images();

            function load_images() {
                $.ajax({
                    url: "{{ route('dropzone.blog.fetch', $blog->id) }}",
                    success: function(data) {
                        $('#uploaded_image').html(data);
                    }
                })
            }

            $(document).on('click', '.remove_file', function() {
                var name = $(this).attr('id');
                $.ajax({
                    url: "{{ route('dropzone.blog.delete', $blog->id) }}",
                    data: {
                        name: name
                    },
                    success: function(data) {
                        load_images();
                    }
                })
            });

            function copyToClipboard(elementId) {
                var copyText = document.getElementById(elementId);
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand("copy");
                alert("Ruta copiada: " + copyText.value);
            }
        </script>
    @endpush
@endif
