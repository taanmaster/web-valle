@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp mb-4">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="mb-1">
                                    <ion-icon name="create-outline"></ion-icon> Alta de Proveedor
                                </h5>
                                <p class="text-muted mb-0">
                                    <strong>Folio:</strong> {{ $supplier->registration_number }} | 
                                    <strong>Tipo:</strong> {{ $supplier->person_type_formatted }} | 
                                    {!! $supplier->status_badge !!}
                                </p>
                            </div>
                            <a href="{{ route('supplier.alta.index') }}" class="btn btn-outline-secondary">
                                <ion-icon name="arrow-back-outline"></ion-icon> Volver
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <ion-icon name="checkmark-circle-outline"></ion-icon> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Por favor corrige los siguientes errores:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Formulario -->
                        <form id="supplierForm" action="{{ route('supplier.alta.store', $supplier->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if($supplier->person_type === 'fisica')
                                @include('front.user_profiles.supplier.forms._persona_fisica')
                            @else
                                @include('front.user_profiles.supplier.forms._persona_moral')
                            @endif

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('supplier.alta.index') }}" class="btn btn-secondary">
                                    Cancelar
                                </a>
                                <button type="button" id="submitBtn" class="btn btn-primary">
                                    <ion-icon name="save-outline"></ion-icon> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @php
                    $userInfo = Auth::user()->userInfo;
                    $padronStatus = $userInfo && isset($userInfo->additional_data['padron_status']) 
                        ? $userInfo->additional_data['padron_status'] 
                        : null;
                @endphp

                @if($padronStatus === 'con_padron')
                    <!-- Checklist de Entregables -->
                    <div class="card wow fadeInUp">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <ion-icon name="document-text-outline"></ion-icon> Documentos Requeridos
                            </h5>
                            <p class="mb-0 small">Recuerda que estos se entregan en físico al finalizar su subida en este apartado para proceder al alta completa</p>
                        </div>
                    <div class="card-body">
                        <!-- Progreso general -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Progreso Total:</strong>
                                <span class="badge {{ $supplier->progress_percentage == 100 ? 'bg-success' : 'bg-primary' }}">
                                    {{ $supplier->progress_percentage }}%
                                </span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar {{ $supplier->progress_percentage == 100 ? 'bg-success' : 'bg-primary' }}" 
                                     role="progressbar" 
                                     style="width: {{ $supplier->progress_percentage }}%"
                                     aria-valuenow="{{ $supplier->progress_percentage }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ $supplier->progress_percentage }}%
                                </div>
                            </div>
                        </div>

                        <div id="documents-checklist">
                            @foreach($requiredDocuments as $index => $doc)
                                @php
                                    $docFiles = $supplier->files->where('file_type', $doc['slug']);
                                    $hasFiles = $docFiles->count() > 0;
                                @endphp
                                
                                <div class="document-item mb-4 pb-4 border-bottom" data-document-slug="{{ $doc['slug'] }}">
                                    <div class="d-flex align-items-start gap-3">
                                        <!-- Icono de estado -->
                                        <div class="flex-shrink-0">
                                            @if($hasFiles)
                                                <div class="status-icon status-completed">
                                                    <ion-icon name="checkmark-circle" style="font-size: 32px; color: #198754;"></ion-icon>
                                                </div>
                                            @else
                                                <div class="status-icon status-pending">
                                                    <ion-icon name="ellipse-outline" style="font-size: 32px; color: #ffc107;"></ion-icon>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Contenido -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="mb-1 {{ $hasFiles ? 'text-success' : '' }}">
                                                        {{ $doc['name'] }}
                                                    </h6>
                                                    <small class="text-muted">
                                                        @if($hasFiles)
                                                            <span class="text-success">
                                                                <ion-icon name="checkmark-outline"></ion-icon> Documento subido exitosamente
                                                            </span>
                                                        @else
                                                            <span class="text-warning">
                                                                <ion-icon name="time-outline"></ion-icon> Pendiente de subir
                                                            </span>
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    @if(isset($doc['has_resource']) && $doc['has_resource'])
                                                        <a href="{{ asset('front/formats/' . $doc['resource_file']) }}" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           download
                                                           title="Descargar formato para llenar">
                                                            <ion-icon name="download-outline"></ion-icon> Descargar Recurso (Word)
                                                        </a>
                                                    @endif
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-primary upload-btn" 
                                                            data-document-name="{{ $doc['name'] }}"
                                                            data-document-slug="{{ $doc['slug'] }}"
                                                            onclick="document.getElementById('file-{{ $doc['slug'] }}').click()">
                                                        <ion-icon name="cloud-upload-outline"></ion-icon> Subir Archivo
                                                    </button>
                                                </div>
                                                <input type="file" 
                                                       id="file-{{ $doc['slug'] }}" 
                                                       class="d-none file-input" 
                                                       data-document-name="{{ $doc['name'] }}"
                                                       data-document-slug="{{ $doc['slug'] }}"
                                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            </div>

                                            <!-- Lista de archivos subidos -->
                                            <div class="uploaded-files-list" id="files-{{ $doc['slug'] }}">
                                                @foreach($docFiles as $file)
                                                    <div class="file-card-item mb-2" data-file-id="{{ $file->id }}">
                                                        <div class="file-card">
                                                            <div class="file-card-icon">
                                                                @php
                                                                    $extension = pathinfo($file->filename, PATHINFO_EXTENSION);
                                                                    $iconName = 'document-outline';
                                                                    $iconColor = '#6c757d';
                                                                    if($extension === 'pdf') {
                                                                        $iconName = 'document-text';
                                                                        $iconColor = '#dc3545';
                                                                    } elseif(in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                                                        $iconName = 'image';
                                                                        $iconColor = '#198754';
                                                                    }
                                                                @endphp
                                                                <ion-icon name="{{ $iconName }}" style="font-size: 24px; color: {{ $iconColor }};"></ion-icon>
                                                            </div>
                                                            <div class="file-card-content">
                                                                <div class="file-name">{{ $doc['name'] }}</div>
                                                                <div class="file-details">
                                                                    <small class="text-muted">{{ $file->filename }}</small>
                                                                    <small class="file-date">Subido: {{ $file->created_at->format('d/m/Y H:i') }}</small>
                                                                    @if($file->status)
                                                                        <small class="ms-2">{!! $file->status_badge !!}</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="file-card-actions">
                                                                <a href="{{ $file->s3_url }}" target="_blank" 
                                                                   class="btn btn-sm btn-outline-primary file-action-btn" 
                                                                   title="Ver archivo">
                                                                    <ion-icon name="eye-outline"></ion-icon>
                                                                </a>
                                                                <button type="button" 
                                                                        class="btn btn-sm btn-outline-danger file-action-btn delete-file-btn" 
                                                                        data-file-id="{{ $file->id }}"
                                                                        title="Eliminar archivo">
                                                                    <ion-icon name="trash-outline"></ion-icon>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                    <!-- Mensaje informativo para sin padrón -->
                    <div class="card wow fadeInUp">
                        <div class="card-body text-center py-5">
                            <ion-icon name="information-circle-outline" style="font-size: 64px; color: #0d6efd;"></ion-icon>
                            <h5 class="mt-3 mb-2">Registro sin Padrón</h5>
                            <p class="text-muted mb-0">
                                Tu registro es de tipo <strong>Sin Padrón</strong>, por lo que no es necesario subir documentos adicionales en este momento.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="confirmationModalLabel">
                        <ion-icon name="alert-circle-outline"></ion-icon> Confirmación Importante
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <ion-icon name="documents-outline" style="font-size: 64px; color: #ffc107;"></ion-icon>
                    <h5 class="mt-3 mb-3">¡Importante!</h5>
                    <p class="mb-0" style="font-size: 16px;">
                        Recuerda que para que tu proceso sea exitoso también tienes que <strong>entregar esta documentación de manera física</strong>.
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon> Cancelar
                    </button>
                    <button type="button" id="confirmSubmitBtn" class="btn btn-primary">
                        <ion-icon name="checkmark-circle-outline"></ion-icon> Aceptar y Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .file-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .file-card:hover {
            background: #e9ecef;
            border-color: #adb5bd;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .file-card-icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-card-content {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            color: #212529;
            margin-bottom: 4px;
        }

        .file-details {
            display: flex;
            gap: 15px;
            font-size: 0.875rem;
        }

        .file-card-actions {
            display: flex;
            gap: 8px;
        }

        .file-action-btn {
            padding: 4px 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-icon {
            transition: transform 0.3s ease;
        }

        .status-completed .status-icon:hover {
            transform: scale(1.1);
        }

        .document-item:last-child {
            border-bottom: none !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const supplierId = {{ $supplier->id }};
            const uploadUrl = '{{ route("supplier.alta.uploadFile", $supplier->id) }}';
            const deleteUrl = '{{ route("supplier.alta.deleteFile", [$supplier->id, ":fileId"]) }}';
            const csrfToken = '{{ csrf_token() }}';

            // Manejar modal de confirmación
            const submitBtn = document.getElementById('submitBtn');
            const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
            const supplierForm = document.getElementById('supplierForm');
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

            // Mostrar modal al hacer click en Guardar
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                confirmationModal.show();
            });

            // Enviar formulario al confirmar
            confirmSubmitBtn.addEventListener('click', function() {
                confirmationModal.hide();
                supplierForm.submit();
            });

            // Manejar subida de archivos
            document.querySelectorAll('.file-input').forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const documentName = this.dataset.documentName;
                    const documentSlug = this.dataset.documentSlug;

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('document_name', documentName);
                    formData.append('document_slug', documentSlug);
                    formData.append('_token', csrfToken);

                    // Mostrar loading
                    const filesList = document.getElementById('files-' + documentSlug);
                    const loadingHtml = `
                        <div class="alert alert-info loading-upload">
                            <ion-icon name="hourglass-outline" class="spinning"></ion-icon> Subiendo archivo...
                        </div>
                    `;
                    filesList.insertAdjacentHTML('beforeend', loadingHtml);

                    fetch(uploadUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Recargar la página para mostrar el archivo
                            location.reload();
                        } else {
                            alert('Error al subir el archivo: ' + data.message);
                            document.querySelector('.loading-upload').remove();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al subir el archivo');
                        document.querySelector('.loading-upload').remove();
                    });

                    // Limpiar input
                    this.value = '';
                });
            });

            // Manejar eliminación de archivos
            document.querySelectorAll('.delete-file-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (!confirm('¿Estás seguro de eliminar este archivo?')) return;

                    const fileId = this.dataset.fileId;
                    const fileCard = this.closest('.file-card-item');

                    fetch(deleteUrl.replace(':fileId', fileId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fileCard.remove();
                            location.reload();
                        } else {
                            alert('Error al eliminar el archivo');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al eliminar el archivo');
                    });
                });
            });
        });
    </script>
    @endpush
@endsection
