@extends('front.layouts.app')

@section('title', 'Solicitud de Desarrollo Urbano #' . $urbanDevRequest->id)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            @include('front.citizen_profile.partials._profile_card')

            <div class="card wow fadeInUp">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <ion-icon name="document-text-outline"></ion-icon>
                            Solicitud #{{ $urbanDevRequest->id }} - {{ $urbanDevRequest->getRequestTypeLabelAttribute() }}
                        </h5>
                        <span class="badge bg-{{ $urbanDevRequest->getStatusColorAttribute() }} fs-6">
                            {{ $urbanDevRequest->getStatusLabelAttribute() }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Tipo de Trámite:</strong><br>
                            <span class="text-muted">{{ $urbanDevRequest->getRequestTypeLabelAttribute() }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Solicitud:</strong><br>
                            <span class="text-muted">{{ $urbanDevRequest->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    @if($urbanDevRequest->description)
                    <div class="row mb-4">
                        <div class="col-12">
                            <strong>Descripción del Proyecto:</strong><br>
                            <span class="text-muted">{{ $urbanDevRequest->description }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <!-- Columna izquierda: Checklist de documentos -->
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                                        Lista de Verificación de Documentos
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="documents-checklist">
                                        <!-- Los documentos se cargarán dinámicamente -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna derecha: Zona de upload -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">
                                        <ion-icon name="cloud-upload-outline"></ion-icon>
                                        Subir Documento
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form id="fileUploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="urban_dev_request_id" value="{{ $urbanDevRequest->id }}">
                                        
                                        <div class="mb-3">
                                            <label for="document_type" class="form-label">Seleccionar tipo de documento</label>
                                            <select class="form-select" id="document_type" name="document_type" required>
                                                <option value="">Seleccione un documento</option>
                                                <!-- Las opciones se cargarán dinámicamente -->
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="file" class="form-label">Archivo</label>
                                            <input type="file" class="form-control" id="file" name="file" 
                                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                            <div class="form-text">
                                                Formatos permitidos: PDF, DOC, DOCX, JPG, PNG. Tamaño máximo: 10MB
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100" disabled>
                                            <ion-icon name="cloud-upload-outline"></ion-icon> Subir Documento
                                        </button>
                                    </form>

                                    <div id="upload-progress" class="mt-3" style="display: none;">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Archivos subidos -->
                            <div class="card border-info mt-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <ion-icon name="folder-open-outline"></ion-icon>
                                        Archivos Subidos
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="uploaded-files">
                                        @if($urbanDevRequest->files->count() > 0)
                                            @foreach($urbanDevRequest->files as $file)
                                                <div class="uploaded-file-item d-flex justify-content-between align-items-center p-2 border rounded mb-2" data-file-id="{{ $file->id }}">
                                                    <div class="file-info">
                                                        <div class="fw-bold">{{ $file->name }}</div>
                                                        <small class="text-muted">{{ $file->filename }}</small>
                                                    </div>
                                                    <div class="file-actions">
                                                        <a href="{{ $file->s3_asset_url ?? Storage::disk('s3')->url('desarrollo_urbano/' . $file->filename) }}" 
                                                           target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                                            <ion-icon name="eye-outline"></ion-icon>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-file" 
                                                                data-file-id="{{ $file->id }}">
                                                            <ion-icon name="trash-outline"></ion-icon>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div id="no-files-message" class="text-center text-muted py-3">
                                                <ion-icon name="document-outline" style="font-size: 36px;"></ion-icon>
                                                <p class="mt-2">No hay archivos subidos</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('citizen.profile.urban_dev_requests') }}" class="btn btn-secondary">
                                    <ion-icon name="arrow-back-outline"></ion-icon> Volver a Mis Trámites
                                </a>
                                
                                {{--  
                                @if($urbanDevRequest->status === 'new')
                                    <div>
                                        <a href="{{ route('citizen.urban_dev.edit', $urbanDevRequest) }}" class="btn btn-warning me-2">
                                            <ion-icon name="create-outline"></ion-icon> Editar
                                        </a>
                                        <button type="button" class="btn btn-danger" onclick="deleteRequest()">
                                            <ion-icon name="trash-outline"></ion-icon> Eliminar
                                        </button>
                                    </div>
                                @endif
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const requestType = '{{ $urbanDevRequest->request_type }}';
    
    // Configuración de documentos por tipo de trámite
    const documentsConfig = {
        'uso-de-suelo': [
            'Formato de solicitud para licencia de Uso de Suelo (FDDUEM-01)',
            'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
            'Contrato de arrendamiento simple.',
            'Copia del último pago del predial.',
            'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
            'Croquis de ubicación del inmueble'
        ],
        'constancia-de-factibilidad': [
            'Formato de solicitud para licencia de Uso de Suelo (FDDUEM-01)',
            'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
            'Contrato de arrendamiento simple',
            'Poder Legal',
            'Copia del último pago del predial.',
            'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
            'Croquis de ubicación del inmueble'
        ],
        'permiso-de-anuncios': [
            'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
            'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
            'Contrato de arrendamiento simple',
            'Poder Legal',
            'Copia del último pago del predial',
            'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
            'Croquis de ubicación del inmueble'
        ],
        'certificacion-numero-oficial': [
            'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
            'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
            'Contrato de arrendamiento simple',
            'Poder Legal',
            'Copia del último pago del predial',
            'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
            'Croquis de ubicación del inmueble'
        ],
        'permiso-de-division': [
            'Solicitud por escrito con proyecto de división',
            'Croquis del predio',
            'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
            'Copia del último pago del predial',
            'Copia de identificación de la persona que acredita la propiedad'
        ],
        'uso-de-via-publica': [
            'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
            'Copia del último pago del predial',
            'Copia de identificación de la persona que acredita la propiedad',
            'Croquis de ubicación del inmueble'
        ],
        'licencia-de-construccion': [
            'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
            'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
            'Copia del último pago del predial',
            'Copia de identificación de la persona que acredita la propiedad',
            'Croquis de ubicación del inmueble',
            'Proyecto arquitectonico, en dos tantos físicos. Con escala 1:100 O 1:50 elaborados, avaldaos y firmados por DRO'
        ],
        'permiso-construccion-panteones': [
            'Formato de solicitud para Licencia de Uso Suelo',
            'Copia de identificación del propietario',
            'Copia del documento de perpetuidad'
        ]
    };

    // Obtener archivos subidos actuales
    const uploadedFiles = @json($urbanDevRequest->files);
    const uploadedFileTypes = uploadedFiles.map(file => file.slug);

    function loadDocumentChecklist() {
        const documents = documentsConfig[requestType] || [];
        const checklistContainer = document.getElementById('documents-checklist');
        const documentTypeSelect = document.getElementById('document_type');
        
        let checklistHtml = '';
        let selectOptions = '<option value="">Seleccione un documento</option>';
        
        documents.forEach((doc, index) => {
            const docSlug = doc.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-');
            const isUploaded = uploadedFileTypes.includes(docSlug);
            
            checklistHtml += `
                <div class="checklist-item d-flex align-items-center mb-3 p-3 border rounded ${isUploaded ? 'border-success bg-light' : 'border-warning'}" data-doc-slug="${docSlug}">
                    <div class="check-icon me-3">
                        ${isUploaded ? 
                            '<ion-icon name="checkmark-circle" style="font-size: 24px; color: #28a745;"></ion-icon>' : 
                            '<ion-icon name="ellipse-outline" style="font-size: 24px; color: #6c757d;"></ion-icon>'
                        }
                    </div>
                    <div class="document-info flex-grow-1">
                        <h6 class="mb-1 ${isUploaded ? 'text-success' : ''}">${doc}</h6>
                        <small class="text-muted">
                            ${isUploaded ? 'Documento subido exitosamente' : 'Pendiente de subir'}
                        </small>
                    </div>
                </div>
            `;
            
            if (!isUploaded) {
                selectOptions += `<option value="${docSlug}">${doc}</option>`;
            }
        });
        
        checklistContainer.innerHTML = checklistHtml;
        documentTypeSelect.innerHTML = selectOptions;
        
        // Habilitar/deshabilitar botón de submit
        updateSubmitButton();
    }

    function updateSubmitButton() {
        const documentTypeSelect = document.getElementById('document_type');
        const fileInput = document.getElementById('file');
        const submitBtn = document.querySelector('#fileUploadForm button[type="submit"]');
        
        const isValid = documentTypeSelect.value && fileInput.files.length > 0;
        submitBtn.disabled = !isValid;
    }

    // Event listeners
    document.getElementById('document_type').addEventListener('change', updateSubmitButton);
    document.getElementById('file').addEventListener('change', updateSubmitButton);

    // Form submission
    document.getElementById('fileUploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const progressContainer = document.getElementById('upload-progress');
        const progressBar = progressContainer.querySelector('.progress-bar');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<ion-icon name="sync-outline" class="spinner"></ion-icon> Subiendo...';
        progressContainer.style.display = 'block';
        
        fetch('{{ route("citizen.urban_dev.file.upload") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar checklist
                const docSlug = document.getElementById('document_type').value;
                updateChecklistItem(docSlug, true);
                
                // Agregar archivo a la lista
                addUploadedFile(data.file);
                
                // Limpiar formulario
                this.reset();
                updateSubmitButton();
                
                // Actualizar select
                const option = document.querySelector(`#document_type option[value="${docSlug}"]`);
                if (option) option.remove();
                
                alert('Archivo subido exitosamente');
            } else {
                throw new Error(data.message || 'Error al subir el archivo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al subir el archivo: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<ion-icon name="cloud-upload-outline"></ion-icon> Subir Documento';
            progressContainer.style.display = 'none';
            progressBar.style.width = '0%';
        });
    });

    function updateChecklistItem(docSlug, isUploaded) {
        const item = document.querySelector(`[data-doc-slug="${docSlug}"]`);
        if (item) {
            const checkIcon = item.querySelector('.check-icon');
            const title = item.querySelector('h6');
            const subtitle = item.querySelector('small');
            
            if (isUploaded) {
                item.className = 'checklist-item d-flex align-items-center mb-3 p-3 border rounded border-success bg-light';
                checkIcon.innerHTML = '<ion-icon name="checkmark-circle" style="font-size: 24px; color: #28a745;"></ion-icon>';
                title.className = 'mb-1 text-success';
                subtitle.textContent = 'Documento subido exitosamente';
            }
        }
    }

    function addUploadedFile(file) {
        const uploadedFilesContainer = document.getElementById('uploaded-files');
        const noFilesMessage = document.getElementById('no-files-message');
        
        if (noFilesMessage) {
            noFilesMessage.remove();
        }
        
        const fileHtml = `
            <div class="uploaded-file-item d-flex justify-content-between align-items-center p-2 border rounded mb-2" data-file-id="${file.id}">
                <div class="file-info">
                    <div class="fw-bold">${file.name}</div>
                    <small class="text-muted">${file.filename}</small>
                </div>
                <div class="file-actions">
                    <a href="${file.url}" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                        <ion-icon name="eye-outline"></ion-icon>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-file" data-file-id="${file.id}">
                        <ion-icon name="trash-outline"></ion-icon>
                    </button>
                </div>
            </div>
        `;
        
        uploadedFilesContainer.insertAdjacentHTML('beforeend', fileHtml);
    }

    // Delete file
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-file')) {
            const fileId = e.target.closest('.delete-file').dataset.fileId;
            
            if (confirm('¿Estás seguro de que quieres eliminar este archivo?')) {
                fetch(`{{ url('ciudadanos/desarrollo-urbano/archivo') }}/${fileId}/eliminar`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const fileItem = document.querySelector(`[data-file-id="${fileId}"]`);
                        if (fileItem) {
                            fileItem.remove();
                        }
                        
                        // Recargar checklist
                        loadDocumentChecklist();
                        
                        alert('Archivo eliminado exitosamente');
                    } else {
                        throw new Error(data.message || 'Error al eliminar el archivo');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el archivo: ' + error.message);
                });
            }
        }
    });

    // Initialize
    loadDocumentChecklist();
});

function deleteRequest() {
    if (confirm('¿Estás seguro de que quieres eliminar esta solicitud? Esta acción no se puede deshacer.')) {
        fetch('{{ route("citizen.urban_dev.destroy", $urbanDevRequest) }}', {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("citizen.profile.urban_dev_requests") }}';
            } else {
                throw new Error(data.message || 'Error al eliminar la solicitud');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar la solicitud: ' + error.message);
        });
    }
}
</script>

<style>
.checklist-item {
    transition: all 0.3s ease;
}

.checklist-item:hover {
    transform: translateX(5px);
}

.uploaded-file-item {
    transition: all 0.3s ease;
}

.uploaded-file-item:hover {
    background-color: #f8f9fa;
}

#upload-progress .progress {
    height: 8px;
}

.spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endsection
