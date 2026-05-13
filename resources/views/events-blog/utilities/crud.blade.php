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
                    @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
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
                    <input id="eb_content_1" type="hidden" wire:model.defer="content_1"
                        @if ($mode == 1) disabled @endif value="{{ $content_1 }}">
                    <trix-editor wire:ignore input="eb_content_1" id="trix-eb-content_1"
                        @if ($mode == 1) disabled @endif></trix-editor>
                </div>
            </div>

            <div class="row align-items-center m-3">
                <div class="col-md-2">
                    <label class="col-form-label">Contenido 2 (Segunda parte del artículo)</label>
                </div>
                <div class="col-md" wire:ignore>
                    <input id="eb_content_2" type="hidden" wire:model.defer="content_2"
                        @if ($mode == 1) disabled @endif value="{{ $content_2 }}">
                    <trix-editor wire:ignore input="eb_content_2" id="trix-eb-content_2"
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
                        <img src="{{ asset('images/events-blog/' . $entry->hero_img) }}"
                            class="img-thumbnail mt-2" style="max-height:120px;" alt="Portada actual">
                    @endif
                </div>
            </div>

            @if ($mode == 0)
                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label class="col-form-label">Imágenes</label>
                    </div>
                    <div class="col-md-10">
                        <input type="file" class="form-control" wire:model="photos" multiple>
                        <small class="text-muted">Puedes seleccionar varias imágenes a la vez.</small>
                    </div>
                </div>
            @endif

            <div class="row m-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de entrada</label>
                    <input type="date" class="form-control" wire:model="published_at"
                        @if ($mode == 1) disabled @endif>
                </div>
            </div>

            @if ($mode != 1)
                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('events_blog.admin.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>
                    <button type="submit" style="max-width: 110px"
                        class="btn btn-primary btn-sm">Guardar datos</button>
                </div>
            @endif
        </form>

        @if ($mode == 2)
            <div class="col-md-2">
                <label class="col-form-label">Imágenes adicionales</label>
            </div>

            <div id="eb_uploaded_image"></div>
            <hr>

            <div class="col-md-12">
                <form action="{{ route('dropzone.events_blog.upload', $entry->id) }}" method="POST"
                    enctype="multipart/form-data" class="dropzone" id="ebDropzoneForm">
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
                    <button type="button" class="btn btn-info" id="eb-submit-all">Subir Imágenes</button>
                </div>
            </div>
        @endif

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editor1 = document.querySelector('#trix-eb-content_1');
            const editor2 = document.querySelector('#trix-eb-content_2');

            if (editor1) {
                editor1.addEventListener('trix-change', function() {
                    const value = document.querySelector('#eb_content_1').value;
                    Livewire.dispatch('updateEventsContent1', { 'payload': value });
                });
            }

            if (editor2) {
                editor2.addEventListener('trix-change', function() {
                    const value = document.querySelector('#eb_content_2').value;
                    Livewire.dispatch('updateEventsContent2', { 'payload': value });
                });
            }

            document.addEventListener('livewire:load', function() {
                setTimeout(() => {
                    const c1 = document.querySelector('#eb_content_1');
                    const c2 = document.querySelector('#eb_content_2');
                    const e1 = document.querySelector('#trix-eb-content_1');
                    const e2 = document.querySelector('#trix-eb-content_2');

                    if (c1 && e1) e1.editor.loadHTML(c1.value);
                    if (c2 && e2) e2.editor.loadHTML(c2.value);
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

            const ebDropzone = new Dropzone("#ebDropzoneForm", {
                url: "{{ route('dropzone.events_blog.upload', $entry->id) }}",
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                paramName: 'file',
                autoProcessQueue: false,
                parallelUploads: 10,
                uploadMultiple: true,
                acceptedFiles: ".png,.jpg,.jpeg,.gif,.bmp",
                maxFilesize: 15,
                addRemoveLinks: true,
                dictDefaultMessage: "Arrastra y suelta tus imágenes aquí o da click para subir.",
                init: function() {
                    let dz = this;

                    document.getElementById("eb-submit-all").addEventListener("click", function() {
                        if (dz.getQueuedFiles().length > 0) {
                            dz.processQueue();
                        } else {
                            alert("No hay imágenes para subir.");
                        }
                    });

                    dz.on("queuecomplete", function() {
                        dz.removeAllFiles();
                        loadEbImages();
                    });
                }
            });

            loadEbImages();

            function loadEbImages() {
                $.ajax({
                    url: "{{ route('dropzone.events_blog.fetch', $entry->id) }}",
                    success: function(data) {
                        $('#eb_uploaded_image').html(data);
                    }
                });
            }

            $(document).on('click', '.remove_file', function() {
                var imagePath = $(this).attr('id');
                if (!imagePath) return;

                $.ajax({
                    url: "{{ route('dropzone.events_blog.delete') }}",
                    type: 'POST',
                    data: { image_path: imagePath, _token: '{{ csrf_token() }}' },
                    success: function() { loadEbImages(); }
                });
            });
        </script>
    @endpush
@endif
