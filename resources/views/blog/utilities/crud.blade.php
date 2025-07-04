@push('stylesheets')
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />

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
                <div class="col-md" wire:ignore>
                    <input id="content_1" type="hidden" wire:model.defer="content_1"
                        @if ($mode == 1) disabled @endif value="{{ $content_1 }}">
                    <trix-editor wire:ignore input="content_1" id="trix-content_1"
                        @if ($mode == 1) disabled @endif></trix-editor>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-1">
                    <label for="content_2" class="col-form-label">Contenido 2 (Segunda parte del artículo)</label>
                </div>
                <div class="col-md" wire:ignore>

                    <input id="content_2" type="hidden" wire:model.defer="content_2"
                        @if ($mode == 1) disabled @endif value="{{ $content_2 }}">
                    <trix-editor wire:ignore input="content_2" id="trix-content_2"
                        @if ($mode == 1) disabled @endif></trix-editor>

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
                        <option value="Dif">DIF</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="is_fav" class="form-label">Añadir a destacados *</label>
                    <select class="form-select" name="is_fav" wire:model.live="is_fav" required>
                        <option value="">Seleccionar opción</option>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>
            </div>

            @if ($mode != 1)
                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('blog.admin.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>

                    <button type="submit" style="max-width: 110px" class="btn btn-primary btn-sm"
                        @if ($is_fav == '') disabled @endif>Guardar
                        datos</button>
                </div>
            @endif
        </form>

        @if ($mode == 2)
            <div class="col-md-1">
                <label for="photos" class="col-form-label">Imágenes adicionales</label>
            </div>

            <div id="uploaded_image">

            </div>
            <hr>

            <div class="col-md-12">
                <form action="{{ route('dropzone.blog.upload', $blog->id) }}" method="POST"
                    enctype="multipart/form-data" class="dropzone" id="dropzoneForm">
                    @csrf
                    <div class="dz-message" data-dz-message>
                        <span>
                            <img src="{{ asset('assets/images/illustrations/upload.svg') }}"
                                class="me-auto ms-auto d-block" width="40%" alt="">
                            <br>
                            Arrastra y suelta aquí tus archivos o da click para buscar
                        </span>
                    </div>
                </form>

                <p class="text-bold"><small>Peso máximo por archivo: 10MB</small></p>

                <div align="center">
                    <button type="button" class="btn btn-info" id="submit-all">Subir Imagenes</button>
                </div>
            </div>
        @endif

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editor1 = document.querySelector('#trix-content_1');
            const editor2 = document.querySelector('#trix-content_2');

            editor1.addEventListener('trix-change', function() {
                const value = document.querySelector('#content_1').value;

                Livewire.dispatch('updateContent1', {
                    'payload': value
                });
            });

            editor2.addEventListener('trix-change', function() {
                const value = document.querySelector('input#content_2').value;
                Livewire.dispatch('updateContent2', {
                    'payload': value
                });
            });

            document.addEventListener('livewire:load', function() {
                setTimeout(() => {
                    const content1 = document.querySelector('#content_1');
                    const content2 = document.querySelector('#content_2');

                    const editor1 = document.querySelector('#trix-content_1');
                    const editor2 = document.querySelector('#trix-content_2');

                    if (content1 && editor1) {
                        editor1.editor.loadHTML(content1.value);
                    }

                    if (content2 && editor2) {
                        editor2.editor.loadHTML(content2.value);
                    }
                }, 300); // espera breve para asegurar que Livewire haya montado los datos
            });
        });
    </script>

</div>
@if ($mode == 2)
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

        <script>
            Dropzone.autoDiscover = false; // Siempre antes de cualquier inicialización

            const myDropzone = new Dropzone("#dropzoneForm", {
                url: "{{ route('dropzone.blog.upload', $blog->id) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                paramName: 'file',
                autoProcessQueue: false,
                parallelUploads: 10,
                uploadMultiple: true,
                acceptedFiles: ".png,.jpg,.jpeg,.gif,.bmp",
                maxFilesize: 15, // MB
                addRemoveLinks: true,
                dictDefaultMessage: "Arrastra y suelta tus imágenes aquí o da click para subir.",
                init: function() {
                    let dz = this;

                    document.getElementById("submit-all").addEventListener("click", function() {
                        if (dz.getQueuedFiles().length > 0) {
                            dz.processQueue();
                        } else {
                            alert("No hay imágenes para subir.");
                        }
                    });

                    dz.on("queuecomplete", function() {
                        dz.removeAllFiles();
                        load_images(); // opcional, si quieres recargar galería
                    });

                    dz.on("error", function(file, errorMessage) {
                        console.error("Error subiendo archivo:", errorMessage);
                    });
                }
            });

            load_images();

            function load_images() {
                $.ajax({
                    url: "{{ route('dropzone.blog.fetch', $blog->id) }}",
                    success: function(data) {
                        $('#uploaded_image').html(data);
                    }
                });
            }

            $(document).on('click', '.remove_file', function() {
                var imagePath = $(this).attr('id'); // Aquí estamos obteniendo el nombre del archivo
                if (!imagePath) {
                    console.log('No se encontró el archivo');
                    return;
                }

                $.ajax({
                    url: "{{ route('dropzone.blog.delete') }}",
                    type: 'POST',
                    data: {
                        image_path: imagePath, // Aquí pasamos el nombre del archivo
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        load_images(); // Recargar las imágenes
                    },
                });
            });
        </script>
    @endpush
@endif
