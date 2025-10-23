@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Transparencia
        @endslot
        @slot('title')
            Dependencias
        @endslot
    @endcomponent

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
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>#{{ $transparency_dependency->id }} - {{ $transparency_dependency->name }}</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ $transparency_dependency->description }}</p>
                        </div>

                        <div class="card-footer text-muted">
                            <div class="row">
                                <div class="col-md-12">
                                    <small>Creado: {{ $transparency_dependency->created_at }}</small><br>
                                    <small>Actualizado: {{ $transparency_dependency->updated_at }}</small>
                                </div>
                                <div class="col-md-12">
                                    {{--
                                    <div class="btn-group mt-4" role="group" aria-label="Basic example">
                                        <form method="POST"
                                            action="{{ route('transparency_dependencies.destroy', $transparency_dependency->id) }}"
                                            style="display: inline-block;">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class='bx bx-trash-alt'></i> Eliminar
                                            </button>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </div>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-body">
                        <h4>Usuarios de esta Dependencia</h4>
                        <hr>

                        @foreach ($transparency_dependency->users as $user)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->user->email ?? 'N/A'))) . '?d=retro&s=150' }}"
                                    alt="profile-user" class="rounded-circle me-2 thumb-sm" />
                                <div>
                                    <h6 class="mb-0">{{ $user->user->name }}</h6>
                                    <p class="mb-0">{{ $user->user->email }}</p>
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#associateUserModal">Asociar un usuario</a>
                    </div>
                </div>

                <div class="col-8">
                    <div class="card card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>Obligaciones</h4>

                            <div class="text-end">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate"
                                    class="btn btn-primary">Nueva Obligación</a>
                            </div>
                        </div>

                        <hr>

                        @include('transparency_obligations.utilities._table', [
                            'transparency_obligations' => $transparency_dependency->obligations,
                        ])
                    </div>

                    <div class="card card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>Repositorio de Archivos</h4>
                        </div>

                        @if ($transparency_dependency->files->count() == 0)
                            <div class="alert alert-warning mb-0">Actualmente no has configurado documentos para esta
                                dependencia.</div>
                        @endif


                        <div id="uploaded_image">

                        </div>

                        <hr>

                        <div class="col-md-12">
                            <!-- Contenedor para barra de progreso de archivos grandes -->
                            <div class="col-md-12 mb-3" id="large_file_upload_progress_container" style="display: none;">
                                <div class="alert alert-info">
                                    <strong>Subiendo archivo grande...</strong>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        role="progressbar" id="large_file_upload_progress" style="width: 0%;"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <span class="progress-text">0%</span>
                                    </div>
                                </div>
                                <small class="text-muted mt-2 d-block" id="large_file_upload_status">Iniciando
                                    subida...</small>
                            </div>

                            <div id="dropzoneForm" class="dropzone">
                                <div class="dz-message" data-dz-message>
                                    <span>
                                        <img src="{{ asset('assets/images/illustrations/upload.svg') }}"
                                            class="me-auto ms-auto d-block" width="40%" alt="">
                                        <br>
                                        Arrastra y suelta aquí tus archivos o da click para buscar
                                        <br>
                                        <small class="text-muted">Archivos grandes (>8MB) se subirán automáticamente por
                                            fragmentos</small>
                                    </span>
                                </div>
                            </div>

                            <div align="center">
                                <button type="button" class="btn btn-info" id="submit-all">Subir Documentos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('transparency_obligations.utilities._modal')

    <!-- Modal para asociar un usuario -->
    <div class="modal fade" id="associateUserModal" tabindex="-1" role="dialog" aria-labelledby="associateUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h6 class="modal-title m-0 text-white" id="associateUserModalLabel">Asociar Usuario a Dependencia</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->

                <form method="POST" action="{{ route('transparency_dependency_users.store') }}">
                    {{ csrf_field() }}

                    <div class="modal-body pd-25">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="user_id" class="form-label">Usuario <span
                                        class="text-danger tx-12">*</span></label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="dependency_id" value="{{ $transparency_dependency->id }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark btn-sm">Asociar Usuario</button>
                    </div>
                </form>
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

        <script>
            // Límite de tamaño para decidir si usar subida por chunks (8MB)
            const LARGE_FILE_THRESHOLD = 8 * 1024 * 1024;
            const CHUNK_SIZE = 2 * 1024 * 1024; // 2MB chunks

            var myDropzone = new Dropzone("#dropzoneForm", {
                url: "{{ route('dropzone.upload', $transparency_dependency->id) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                autoProcessQueue: false,
                parallelUploads: 20,
                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar",
                autoDiscover: false,
                maxFilesize: 100, // Aumentamos el límite para permitir archivos grandes
                addRemoveLinks: true,
                init: function() {
                    var submitButton = document.querySelector("#submit-all");
                    myDropzone = this;

                    // Interceptar archivos grandes antes de que Dropzone los procese
                    this.on("addedfile", function(file) {
                        if (file.size > LARGE_FILE_THRESHOLD) {
                            // Remover el archivo de Dropzone ya que lo manejaremos por chunks
                            this.removeFile(file);
                            // Procesar archivo grande inmediatamente
                            handleLargeFileUpload(file);
                        }
                    });

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

            // Función para manejar archivos grandes por chunks
            async function handleLargeFileUpload(file) {
                try {
                    const progressContainer = document.getElementById('large_file_upload_progress_container');
                    const progressBar = document.getElementById('large_file_upload_progress');
                    const uploadStatus = document.getElementById('large_file_upload_status');

                    progressContainer.style.display = 'block';
                    updateLargeFileProgress(0, 'Preparando subida de archivo grande...');

                    // Paso 1: Inicializar subida por chunks
                    updateLargeFileProgress(10, 'Inicializando subida...');
                    const initResponse = await initChunkUpload(file);
                    if (!initResponse.success) {
                        throw new Error('Error al inicializar subida');
                    }

                    // Paso 2: Subir chunks
                    updateLargeFileProgress(15, 'Iniciando subida por fragmentos...');
                    await uploadChunks(file, initResponse.upload_id, initResponse.total_chunks);

                    // Paso 3: Finalizar subida
                    updateLargeFileProgress(90, 'Finalizando subida...');
                    const finalizeResponse = await finalizeUpload(initResponse.upload_id);
                    if (!finalizeResponse.success) {
                        throw new Error(finalizeResponse.error || 'Error al finalizar subida');
                    }

                    updateLargeFileProgress(100, 'Completado exitosamente');

                    // Recargar lista de archivos
                    setTimeout(() => {
                        progressContainer.style.display = 'none';
                        load_images();
                    }, 1000);

                } catch (error) {
                    console.error('Error:', error);
                    updateLargeFileProgress(0, 'Error: ' + error.message);

                    setTimeout(() => {
                        document.getElementById('large_file_upload_progress_container').style.display = 'none';
                    }, 3000);
                }
            }

            async function initChunkUpload(file) {
                const formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('filename', file.name);
                formData.append('filesize', file.size);
                formData.append('chunk_size', CHUNK_SIZE);
                formData.append('dependency_id', '{{ $transparency_dependency->id }}');

                const response = await fetch('{{ route('transparency_files.init-chunk-upload') }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.error || 'Error al inicializar subida');
                }

                return await response.json();
            }

            async function uploadChunks(file, uploadId, totalChunks) {
                for (let i = 0; i < totalChunks; i++) {
                    const start = i * CHUNK_SIZE;
                    const end = Math.min(start + CHUNK_SIZE, file.size);
                    const chunk = file.slice(start, end);

                    const formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('upload_id', uploadId);
                    formData.append('chunk_number', i);
                    formData.append('chunk', chunk, `chunk_${i}`);

                    const response = await fetch('{{ route('transparency_files.upload-chunk') }}', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        throw new Error(`Error en fragmento ${i + 1}: ${errorData.error || 'Error desconocido'}`);
                    }

                    const result = await response.json();
                    if (!result.success) {
                        throw new Error(`Error en fragmento ${i + 1}: ${result.error}`);
                    }

                    // Calcular progreso entre 15% y 85%
                    const chunkProgress = 15 + (70 * (i + 1) / totalChunks);
                    updateLargeFileProgress(chunkProgress,
                        `Subiendo fragmento ${i + 1} de ${totalChunks} (${result.progress.toFixed(1)}%)`);
                }
            }

            async function finalizeUpload(uploadId) {
                const formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('upload_id', uploadId);

                const response = await fetch('{{ route('transparency_files.finalize-chunk-upload') }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.error || 'Error al finalizar subida');
                }

                return await response.json();
            }

            function updateLargeFileProgress(percent, message) {
                const progressBar = document.getElementById('large_file_upload_progress');
                const uploadStatus = document.getElementById('large_file_upload_status');

                progressBar.style.width = percent + '%';
                progressBar.setAttribute('aria-valuenow', percent);
                progressBar.querySelector('.progress-text').textContent = Math.round(percent) + '%';
                uploadStatus.textContent = message;

                if (percent === 100) {
                    progressBar.classList.remove('progress-bar-animated');
                    progressBar.classList.remove('bg-primary');
                    progressBar.classList.add('bg-success');
                }
            }

            load_images();

            function load_images() {
                $.ajax({
                    url: "{{ route('dropzone.fetch', $transparency_dependency->id) }}",
                    success: function(data) {
                        $('#uploaded_image').html(data);
                    }
                })
            }

            $(document).on('click', '.remove_file', function() {
                var name = $(this).attr('id');
                $.ajax({
                    url: "{{ route('dropzone.delete', $transparency_dependency->id) }}",
                    data: {
                        name: name
                    },
                    success: function(data) {
                        load_images();
                    }
                })
            });

            async function copyToClipboard(elementId) {
                try {
                    const copyText = document.getElementById(elementId);
                    const textToCopy = copyText.value;
                    
                    // Usar la API moderna del portapapeles
                    await navigator.clipboard.writeText(textToCopy);
                    
                    // Mostrar toast de éxito
                    showToast('Ruta copiada exitosamente', 'success');
                } catch (err) {
                    // Fallback para navegadores antiguos
                    try {
                        const copyText = document.getElementById(elementId);
                        copyText.select();
                        copyText.setSelectionRange(0, 99999);
                        document.execCommand("copy");
                        showToast('Ruta copiada exitosamente', 'success');
                    } catch (e) {
                        showToast('Error al copiar la ruta', 'error');
                    }
                }
            }

            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                const bgColor = type === 'success' ? 'bg-success' : 'bg-danger';
                const icon = type === 'success' ? '<i class="fas fa-check-circle me-2"></i>' : '<i class="fas fa-exclamation-circle me-2"></i>';
                
                toast.className = `alert ${bgColor} text-white alert-dismissible fade show position-fixed`;
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
                toast.innerHTML = `
                    ${icon}
                    <span>${message}</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                document.body.appendChild(toast);
                
                // Auto-remover después de 3 segundos
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.remove();
                        }
                    }, 150);
                }, 3000);
            }
        </script>
    @endpush
@endsection
