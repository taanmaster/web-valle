@extends('front.layouts.app')

@section('title', 'Solicitud - Medio Ambiente')

@section('content')
    @php
        $isDonacion = $environmentRequest->request_type === \App\Models\EnvironmentRequest::TYPE_DONACION;
        $filesByType = $environmentRequest->files->keyBy('document_type');
    @endphp

    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
                <div class="card wow fadeInUp">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <ion-icon name="leaf-outline"></ion-icon>
                            {{ $environmentRequest->request_type_label }}
                        </h5>
                        <span class="badge bg-primary text-uppercase">{{ $environmentRequest->status_label }}</span>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            Folio <strong>{{ $environmentRequest->folio }}</strong> ·
                            Solicitado el {{ $environmentRequest->fecha_solicitud?->format('d/m/Y') }}
                        </p>

                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Datos de la Solicitud</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-0">Nombre</label>
                                        <p class="mb-0">{{ $environmentRequest->nombre }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-0">
                                            {{ $isDonacion ? 'Domicilio' : 'Domicilio Particular' }}
                                        </label>
                                        <p class="mb-0">{{ $environmentRequest->domicilio }}</p>
                                    </div>

                                    @unless ($isDonacion)
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-0">Colonia</label>
                                            <p class="mb-0">{{ $environmentRequest->colonia }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-0">Motivo</label>
                                            <p class="mb-0">{{ $environmentRequest->motivo }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-0">Teléfono Celular</label>
                                            <p class="mb-0">{{ $environmentRequest->telefono_celular }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-0">Teléfono Fijo</label>
                                            <p class="mb-0">{{ $environmentRequest->telefono_fijo }}</p>
                                        </div>
                                    @endunless
                                </div>
                            </div>
                        </div>

                        @if ($isDonacion)
                            <div class="card border-success mb-4" id="documentsCard">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">Documentación de Solicitud</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted small mb-4">
                                        Los tres documentos son obligatorios. Formatos aceptados: PDF, DOC, DOCX, JPG,
                                        PNG (máx. 10MB).
                                    </p>

                                    <div class="row g-3">
                                        @foreach (\App\Models\EnvironmentRequestFile::DONACION_DOCUMENTS as $docType => $docLabel)
                                            @php $existing = $filesByType->get($docType); @endphp
                                            <div class="col-md-4" data-doc-type="{{ $docType }}">
                                                <label class="form-label d-block">
                                                    {{ $docLabel }} <span class="text-danger">*</span>
                                                    @if ($docType === 'solicitud_donacion')
                                                        <ion-icon name="information-circle-outline" tabindex="0"
                                                            data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                            data-bs-placement="top"
                                                            data-bs-content="La solicitud de donación debe de estar dirigida al Presidente Municipal e incluir la cantidad y especie de árboles."></ion-icon>
                                                    @endif
                                                </label>

                                                {{-- Archivo ya subido --}}
                                                <div class="existing-file mb-2 {{ $existing ? '' : 'd-none' }}">
                                                    <div class="d-flex align-items-center justify-content-between border rounded p-2 bg-light">
                                                        <a href="{{ $existing?->url }}" target="_blank"
                                                            class="text-truncate small file-name d-flex align-items-center gap-1">
                                                            <ion-icon name="document-text-outline"></ion-icon>
                                                            <span>{{ $existing?->filename }}</span>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-file"
                                                            data-file-id="{{ $existing?->id }}" title="Eliminar archivo"
                                                            aria-label="Eliminar archivo">
                                                            <ion-icon name="trash-outline"></ion-icon>
                                                        </button>
                                                    </div>
                                                </div>

                                                {{-- Dropzone: sólo se dibuja mientras no haya archivo subido --}}
                                                @unless ($existing)
                                                    <div class="environment-dropzone" tabindex="0" role="button"
                                                        aria-label="Subir {{ $docLabel }}">
                                                        <input type="file" class="environment-dropzone-input d-none"
                                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">

                                                        <div class="environment-dropzone-idle text-center py-4 px-2">
                                                            <ion-icon name="cloud-upload-outline"
                                                                class="text-muted fs-3"></ion-icon>
                                                            <p class="mb-0 mt-2 small">
                                                                Arrastra tu archivo aquí o haz clic para seleccionar
                                                            </p>
                                                            <p class="mb-0 small text-muted">PDF, DOC, DOCX, JPG, PNG
                                                                (máx. 10MB)</p>
                                                        </div>

                                                        <div class="environment-dropzone-uploading text-center py-4 px-2 d-none">
                                                            <div class="spinner-border spinner-border-sm text-primary"
                                                                role="status"></div>
                                                            <p class="mb-0 mt-2 small">Subiendo…</p>
                                                        </div>
                                                    </div>

                                                    <div class="environment-dropzone-error text-danger small mt-2 d-none">
                                                    </div>
                                                @endunless
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('citizen.environment.requests', $environmentRequest->request_type) }}" class="btn btn-secondary">
                                <ion-icon name="arrow-back-outline"></ion-icon> Volver al Listado
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($isDonacion)
    @push('styles')
        <style>
            .environment-dropzone {
                border: 2px dashed #ced4da;
                border-radius: .5rem;
                cursor: pointer;
                transition: border-color .15s ease, background-color .15s ease;
            }

            .environment-dropzone:hover,
            .environment-dropzone:focus-visible,
            .environment-dropzone.is-dragover {
                border-color: var(--bs-primary);
                background-color: rgba(var(--bs-primary-rgb), .06);
                outline: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                var uploadUrl = '{{ route('citizen.environment.file.upload') }}';
                var environmentRequestId = {{ $environmentRequest->id }};
                var allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
                var maxSizeBytes = 10 * 1024 * 1024;

                document.querySelectorAll('#documentsCard [data-doc-type]').forEach(function (container) {
                    var docType = container.dataset.docType;
                    var dropzone = container.querySelector('.environment-dropzone');

                    // Ya hay un archivo subido: no se dibuja dropzone para este documento.
                    if (!dropzone) {
                        return;
                    }

                    var input = dropzone.querySelector('.environment-dropzone-input');
                    var idleState = dropzone.querySelector('.environment-dropzone-idle');
                    var uploadingState = dropzone.querySelector('.environment-dropzone-uploading');
                    var errorBox = container.querySelector('.environment-dropzone-error');

                    function showError(message) {
                        errorBox.textContent = message;
                        errorBox.classList.remove('d-none');
                    }

                    function clearError() {
                        errorBox.classList.add('d-none');
                        errorBox.textContent = '';
                    }

                    function isValidFile(file) {
                        var extension = file.name.split('.').pop().toLowerCase();

                        if (allowedExtensions.indexOf(extension) === -1) {
                            showError('Tipo de archivo no permitido.');
                            return false;
                        }

                        if (file.size > maxSizeBytes) {
                            showError('El archivo es muy grande (máx. 10MB).');
                            return false;
                        }

                        return true;
                    }

                    function resetToIdle() {
                        uploadingState.classList.add('d-none');
                        idleState.classList.remove('d-none');
                    }

                    function uploadFile(file) {
                        clearError();

                        if (!isValidFile(file)) {
                            return;
                        }

                        idleState.classList.add('d-none');
                        uploadingState.classList.remove('d-none');

                        var formData = new FormData();
                        formData.append('file', file);
                        formData.append('environment_request_id', environmentRequestId);
                        formData.append('document_type', docType);

                        fetch(uploadUrl, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                            body: formData,
                        })
                            .then(function (response) { return response.json(); })
                            .then(function (data) {
                                if (data.success) {
                                    window.location.reload();
                                } else {
                                    resetToIdle();
                                    showError(data.message || 'Error al subir el archivo.');
                                }
                            })
                            .catch(function () {
                                resetToIdle();
                                showError('Error al subir el archivo. Inténtalo de nuevo.');
                            });
                    }

                    dropzone.addEventListener('click', function () {
                        input.click();
                    });

                    dropzone.addEventListener('keydown', function (event) {
                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            input.click();
                        }
                    });

                    input.addEventListener('change', function () {
                        if (input.files.length) {
                            uploadFile(input.files[0]);
                        }
                    });

                    ['dragenter', 'dragover'].forEach(function (eventName) {
                        dropzone.addEventListener(eventName, function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            dropzone.classList.add('is-dragover');
                        });
                    });

                    ['dragleave', 'drop'].forEach(function (eventName) {
                        dropzone.addEventListener(eventName, function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            dropzone.classList.remove('is-dragover');
                        });
                    });

                    dropzone.addEventListener('drop', function (event) {
                        var files = event.dataTransfer.files;
                        if (files.length) {
                            uploadFile(files[0]);
                        }
                    });
                });

                document.querySelectorAll('.delete-file').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        if (!confirm('¿Deseas eliminar este archivo?')) {
                            return;
                        }

                        fetch('/ciudadanos/medio-ambiente/archivo/' + btn.dataset.fileId + '/eliminar', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                        }).then(function () {
                            window.location.reload();
                        });
                    });
                });

                var popovers = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
                popovers.forEach(function (el) {
                    new bootstrap.Popover(el);
                });
            });
        </script>
    @endpush
@endif
