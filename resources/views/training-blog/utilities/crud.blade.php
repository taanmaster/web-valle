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
                @if ($entry != null)
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
                    <label class="col-form-label">Contenido 1 (Primer parte del artículo)</label>
                </div>
                <div class="col-md" wire:ignore>
                    <input id="tb_content_1" type="hidden" wire:model.defer="content_1"
                        @if ($mode == 1) disabled @endif value="{{ $content_1 }}">
                    <trix-editor wire:ignore input="tb_content_1" id="trix-tb-content_1"
                        @if ($mode == 1) disabled @endif></trix-editor>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-2">
                    <label class="col-form-label">Contenido 2 (Segunda parte del artículo)</label>
                </div>
                <div class="col-md" wire:ignore>
                    <input id="tb_content_2" type="hidden" wire:model.defer="content_2"
                        @if ($mode == 1) disabled @endif value="{{ $content_2 }}">
                    <trix-editor wire:ignore input="tb_content_2" id="trix-tb-content_2"
                        @if ($mode == 1) disabled @endif></trix-editor>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-2">
                    <label class="col-form-label">Imagen de portada</label>
                </div>
                <div class="col-md-10">
                    <input type="file" class="form-control" wire:model="hero_img"
                        @if ($mode == 1) disabled @endif>
                    @if ($mode != 0 && $entry && $entry->hero_img && $entry->hero_img !== 'empty-image.jpg')
                        <img src="{{ asset('images/training-blog/' . $entry->hero_img) }}" class="img-thumbnail mt-2"
                            style="max-height:120px;" alt="Portada actual">
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
                    <a href="{{ route('training_blog.admin.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>
                    <button type="submit" style="max-width: 110px" class="btn btn-primary btn-sm">Guardar
                        datos</button>
                </div>
            @endif
        </form>

        @if ($mode == 2)
            <div class="col-md-2">
                <label class="col-form-label">Imágenes adicionales</label>
            </div>

            <div id="tb_uploaded_image"></div>
            <hr>

            <div class="col-md-12">
                <form action="{{ route('dropzone.training_blog.upload', $entry->id) }}" method="POST"
                    enctype="multipart/form-data" class="dropzone" id="tbDropzoneForm">
                    @csrf
                    <div class="dz-message" data-dz-message>
                        <span>
                            <img src="{{ asset('assets/images/illustrations/upload.svg') }}"
                                class="me-auto ms-auto d-block" width="40%" alt="">
                            <br>Arrastra y suelta aquí tus imagenes o da click para buscar
                        </span>
                    </div>
                </form>
                <p class="text-bold"><small>Peso máximo por archivo: 10MB</small></p>
                <div align="center">
                    <button type="button" class="btn btn-info" id="tb-submit-all">Subir Imágenes</button>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const e1 = document.querySelector('#trix-tb-content_1');
            const e2 = document.querySelector('#trix-tb-content_2');

            if (e1) {
                e1.addEventListener('trix-change', function() {
                    Livewire.dispatch('updateTrainingContent1', {
                        payload: document.querySelector('#tb_content_1').value
                    });
                });
            }
            if (e2) {
                e2.addEventListener('trix-change', function() {
                    Livewire.dispatch('updateTrainingContent2', {
                        payload: document.querySelector('#tb_content_2').value
                    });
                });
            }

            document.addEventListener('livewire:load', function() {
                setTimeout(() => {
                    const c1 = document.querySelector('#tb_content_1');
                    const c2 = document.querySelector('#tb_content_2');
                    const ed1 = document.querySelector('#trix-tb-content_1');
                    const ed2 = document.querySelector('#trix-tb-content_2');
                    if (c1 && ed1) ed1.editor.loadHTML(c1.value);
                    if (c2 && ed2) ed2.editor.loadHTML(c2.value);
                }, 300);
            });
        });
    </script>
</div>

@if ($mode == 2)
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
        <script>
            Dropzone.autoDiscover = false;

            const tbDropzone = new Dropzone("#tbDropzoneForm", {
                url: "{{ route('dropzone.training_blog.upload', $entry->id) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                paramName: 'file',
                autoProcessQueue: false,
                parallelUploads: 10,
                uploadMultiple: true,
                acceptedFiles: ".png,.jpg,.jpeg,.gif,.bmp",
                maxFilesize: 15,
                addRemoveLinks: true,
                init: function() {
                    let dz = this;
                    document.getElementById("tb-submit-all").addEventListener("click", function() {
                        dz.getQueuedFiles().length > 0 ? dz.processQueue() : alert(
                            "No hay imágenes para subir.");
                    });
                    dz.on("queuecomplete", function() {
                        dz.removeAllFiles();
                        loadTbImages();
                    });
                }
            });

            loadTbImages();

            function loadTbImages() {
                $.ajax({
                    url: "{{ route('dropzone.training_blog.fetch', $entry->id) }}",
                    success: function(data) {
                        $('#tb_uploaded_image').html(data);
                    }
                });
            }

            $(document).on('click', '.remove_file', function() {
                var path = $(this).attr('id');
                if (!path) return;
                $.ajax({
                    url: "{{ route('dropzone.training_blog.delete') }}",
                    type: 'POST',
                    data: {
                        image_path: path,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        loadTbImages();
                    }
                });
            });
        </script>
    @endpush
@endif
