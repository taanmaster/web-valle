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

                                                <div class="existing-file mb-2 {{ $existing ? '' : 'd-none' }}">
                                                    <div class="d-flex align-items-center justify-content-between border rounded p-2">
                                                        <a href="{{ $existing?->url }}" target="_blank" class="text-truncate small file-name">
                                                            <ion-icon name="document-outline"></ion-icon>
                                                            {{ $existing?->filename }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-file"
                                                            data-file-id="{{ $existing?->id }}">
                                                            <ion-icon name="trash-outline"></ion-icon>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div id="dropzone-{{ $docType }}" class="dropzone-area border rounded p-3 text-center text-muted small {{ $existing ? 'd-none' : '' }}">
                                                </div>
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
    @push('scripts')
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css">

        <script>
            Dropzone.autoDiscover = false;

            document.addEventListener('DOMContentLoaded', function () {
                var environmentRequestId = {{ $environmentRequest->id }};
                var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                document.querySelectorAll('#documentsCard [data-doc-type]').forEach(function (container) {
                    var docType = container.dataset.docType;
                    var dropzoneEl = container.querySelector('.dropzone-area');

                    if (dropzoneEl.classList.contains('d-none')) {
                        return;
                    }

                    new Dropzone(dropzoneEl, {
                        url: '{{ route('citizen.environment.file.upload') }}',
                        maxFilesize: 10,
                        acceptedFiles: '.pdf,.doc,.docx,.jpg,.jpeg,.png',
                        addRemoveLinks: false,
                        maxFiles: 1,
                        uploadMultiple: false,
                        parallelUploads: 1,
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        dictDefaultMessage: 'Arrastra archivos aquí o haz clic para seleccionar<br><small>PDF, DOC, DOCX, JPG, PNG (máx. 10MB)</small>',
                        dictFileTooBig: 'El archivo es muy grande (máx. 10MB)',
                        dictInvalidFileType: 'Tipo de archivo no permitido',
                        sending: function (file, xhr, formData) {
                            formData.append('environment_request_id', environmentRequestId);
                            formData.append('document_type', docType);
                        },
                        success: function (file, response) {
                            if (response.success) {
                                window.location.reload();
                            } else {
                                alert('Error al subir el archivo: ' + (response.message || 'Error desconocido'));
                                this.removeFile(file);
                            }
                        },
                        error: function (file, message) {
                            alert('Error al subir el archivo: ' + message);
                            this.removeFile(file);
                        },
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
