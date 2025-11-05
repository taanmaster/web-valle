@extends('front.layouts.app')

@section('title', 'Solicitud de Desarrollo Urbano #' . $urbanDevRequest->id)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            @include('front.user_profiles.partials._profile_card')

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
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                                        Lista de Documentos con Zona de Subida
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="documents-checklist">
                                        <!-- Los documentos se cargarán dinámicamente -->
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Dropzone.js -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<script>
// Configurar Dropzone para que no auto-descubra elementos
Dropzone.autoDiscover = false;

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
    
    // Agrupar archivos por slug de documento
    const filesByDocumentType = {};
    uploadedFiles.forEach(file => {
        if (!filesByDocumentType[file.slug]) {
            filesByDocumentType[file.slug] = [];
        }
        filesByDocumentType[file.slug].push(file);
    });
    
    console.log('Archivos agrupados por slug:', filesByDocumentType); // Debug

    // Array para almacenar las instancias de Dropzone
    const dropzoneInstances = {};

    // Función para generar slugs consistentes
    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[áäàâã]/g, 'a')
            .replace(/[éëèê]/g, 'e')
            .replace(/[íïìî]/g, 'i')
            .replace(/[óöòôõ]/g, 'o')
            .replace(/[úüùû]/g, 'u')
            .replace(/[ñ]/g, 'n')
            .replace(/[ç]/g, 'c')
            .replace(/[^a-z0-9\s]/g, ' ') // Reemplazar caracteres especiales por espacios
            .replace(/\s+/g, '-') // Reemplazar espacios múltiples por guión
            .replace(/^-+|-+$/g, '') // Eliminar guiones al inicio y final
            .replace(/-+/g, '-'); // Reemplazar múltiples guiones por uno solo
    }

    // Mapeo especial para documentos conocidos que pueden tener problemas de slug
    const documentSlugMapping = {
        'Formato de solicitud para licencia de Uso de Suelo (FDDUEM-01)': 'formato-de-solicitud-para-licencia-de-uso-de-suelo-fdduem-01',
        'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio': 'copia-de-la-escritura-de-la-propiedad-o-documento-notariado-que-compruebe-la-posesion-del-predio',
        'Contrato de arrendamiento simple.': 'contrato-de-arrendamiento-simple',
        'Copia del último pago del predial.': 'copia-del-ultimo-pago-del-predial',
        'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso': 'copia-de-identificacion-de-la-persona-que-acredita-la-propiedad-asi-como-la-del-arrendatario-o-representante-legal-segun-sea-el-caso',
        'Croquis de ubicación del inmueble': 'croquis-de-ubicacion-del-inmueble',
        'Poder Legal': 'poder-legal',
        'Solicitud por escrito con proyecto de división': 'solicitud-por-escrito-con-proyecto-de-division',
        'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio': 'copia-de-la-escritura-de-la-propiedad-o-documento-notariado-que-compruebe-la-posesion-del-predio',
        'Copia de identificación de la persona que acredita la propiedad': 'copia-de-identificacion-de-la-persona-que-acredita-la-propiedad',
        'Proyecto arquitectonico, en dos tantos físicos. Con escala 1:100 O 1:50 elaborados, avaldaos y firmados por DRO': 'proyecto-arquitectonico-en-dos-tantos-fisicos-con-escala-1-100-o-1-50-elaborados-avaldaos-y-firmados-por-dro',
        'Copia de identificación del propietario': 'copia-de-identificacion-del-propietario',
        'Copia del documento de perpetuidad': 'copia-del-documento-de-perpetuidad'
    };

    function getDocumentSlug(documentName) {
        // Primero verificar si hay un mapeo específico
        if (documentSlugMapping[documentName]) {
            return documentSlugMapping[documentName];
        }
        // Si no, generar usando la función
        return generateSlug(documentName);
    }

    function createFileListItem(file) {
        // Manejar la fecha del archivo - si no tiene created_at, usar la fecha actual
        let uploadDate;
        if (file.created_at) {
            uploadDate = new Date(file.created_at).toLocaleString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } else {
            // Si es un archivo recién subido sin created_at, usar la fecha actual
            uploadDate = new Date().toLocaleString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Determinar el icono basado en la extensión del archivo
        const extension = file.filename ? file.filename.split('.').pop().toLowerCase() : 'file';
        let fileIcon = 'document-outline';
        let iconColor = '#6c757d';
        
        switch(extension) {
            case 'pdf':
                fileIcon = 'document-text';
                iconColor = '#dc3545';
                break;
            case 'doc':
            case 'docx':
                fileIcon = 'document';
                iconColor = '#0d6efd';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
                fileIcon = 'image';
                iconColor = '#198754';
                break;
            default:
                fileIcon = 'document-outline';
                iconColor = '#6c757d';
        }
        
        return `
            <div class="file-card-item mb-3" data-file-id="${file.id}">
                <div class="file-card">
                    <div class="file-card-icon">
                        <ion-icon name="${fileIcon}" style="font-size: 28px; color: ${iconColor};"></ion-icon>
                    </div>
                    <div class="file-card-content">
                        <div class="file-name">${file.name}</div>
                        <div class="file-details">
                            <small class="text-muted">${file.filename}</small>
                            <small class="file-date">Subido: ${uploadDate}</small>
                        </div>
                    </div>
                    <div class="file-card-actions">
                        <a href="${file.s3_asset_url || ''}" target="_blank" 
                           class="btn btn-sm btn-outline-primary file-action-btn" 
                           title="Ver archivo">
                            <ion-icon name="eye-outline"></ion-icon>
                        </a>
                    </div>
                </div>
            </div>
        `;
    }

    function loadDocumentChecklist() {
        console.log('Cargando lista de documentos...'); // Debug
        console.log('Tipo de solicitud:', requestType); // Debug
        
        const documents = documentsConfig[requestType] || [];
        console.log('Documentos encontrados:', documents); // Debug
        
        const checklistContainer = document.getElementById('documents-checklist');
        
        if (!checklistContainer) {
            console.error('No se encontró el contenedor documents-checklist');
            return;
        }
        
        let checklistHtml = '';
        
        documents.forEach((doc, index) => {
            const docSlug = getDocumentSlug(doc);
            const documentFiles = filesByDocumentType[docSlug] || [];
            const hasFiles = documentFiles.length > 0;
            
            console.log(`Documento: "${doc}" -> Slug: "${docSlug}" -> Archivos: ${documentFiles.length}`); // Debug
            
            checklistHtml += `
                <div class="document-item mb-4 p-3 border rounded ${hasFiles ? 'border-success bg-light' : 'border-warning'}" data-doc-slug="${docSlug}">
                    <div class="row">
                        <!-- Información del documento -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="check-icon me-3">
                                    ${hasFiles ? 
                                        '<ion-icon name="checkmark-circle" style="font-size: 24px; color: #28a745;"></ion-icon>' : 
                                        '<ion-icon name="ellipse-outline" style="font-size: 24px; color: #6c757d;"></ion-icon>'
                                    }
                                </div>
                                <div class="document-info">
                                    <h6 class="mb-1 ${hasFiles ? 'text-success' : ''}">${doc}</h6>
                                    <small class="text-muted">
                                        ${hasFiles ? `${documentFiles.length} archivo(s) subido(s)` : 'Pendiente de subir'}
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- DropZone -->
                        <div class="col-md-6">
                            <div class="dropzone-container">
                                <!-- Archivos subidos encima del dropzone -->
                                <div class="uploaded-files-overlay" id="files-${docSlug}">
                                    ${documentFiles.map(file => createFileListItem(file)).join('')}
                                </div>
                                
                                <!-- DropZone -->
                                <div id="dropzone-${docSlug}" class="dropzone-area ${hasFiles ? 'has-files' : ''}" data-doc-slug="${docSlug}">
                                    <div class="dz-message">
                                        <ion-icon name="cloud-upload-outline" style="font-size: 32px; color: #6c757d;"></ion-icon>
                                        <p class="mt-2 mb-0">${hasFiles ? 'Arrastra más archivos aquí' : 'Arrastra archivos aquí o haz clic para seleccionar'}</p>
                                        <small class="text-muted">PDF, DOC, DOCX, JPG, PNG (máx. 10MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        //console.log('HTML generado:', checklistHtml); // Debug
        checklistContainer.innerHTML = checklistHtml;
        
        // Inicializar Dropzones después de crear el HTML
        initializeDropzones();
    }

    function initializeDropzones() {
        const documents = documentsConfig[requestType] || [];
        
        documents.forEach((doc, index) => {
            const docSlug = getDocumentSlug(doc);
            const dropzoneElement = document.getElementById(`dropzone-${docSlug}`);
            
            if (dropzoneElement && !dropzoneInstances[docSlug]) {
                const dropzone = new Dropzone(dropzoneElement, {
                    url: '{{ route("citizen.urban_dev.file.upload") }}',
                    maxFilesize: 10, // MB
                    acceptedFiles: '.pdf,.doc,.docx,.jpg,.jpeg,.png',
                    addRemoveLinks: false,
                    maxFiles: 1,
                    uploadMultiple: false,
                    parallelUploads: 1,
                    autoProcessQueue: true,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    sending: function(file, xhr, formData) {
                        formData.append('urban_dev_request_id', '{{ $urbanDevRequest->id }}');
                        formData.append('document_type', docSlug);
                    },
                    success: function(file, response) {
                        if (response.success) {
                            // Usar el slug que viene del servidor para asegurar consistencia
                            const serverSlug = response.file.slug;
                            
                            // Actualizar la UI
                            updateDocumentStatus(serverSlug, true);
                            addFileToDocumentList(serverSlug, response.file);
                            
                            // Remover el archivo del dropzone
                            this.removeFile(file);
                            
                            // Mostrar mensaje de éxito
                            showNotification('Archivo subido exitosamente', 'success');
                        } else {
                            showNotification('Error al subir el archivo: ' + (response.message || 'Error desconocido'), 'error');
                            this.removeFile(file);
                        }
                    },
                    error: function(file, errorMessage) {
                        console.error('Error uploading file:', errorMessage);
                        showNotification('Error al subir el archivo: ' + errorMessage, 'error');
                        this.removeFile(file);
                    },
                    dictDefaultMessage: '',
                    dictFileTooBig: 'El archivo es muy grande (máx. 10MB)',
                    dictInvalidFileType: 'Tipo de archivo no permitido',
                    dictMaxFilesExceeded: 'Solo se puede subir un archivo a la vez'
                });
                
                dropzoneInstances[docSlug] = dropzone;
            }
        });
    }

    function updateDocumentStatus(fileSlug, hasFiles) {
        const documentItem = document.querySelector(`[data-doc-slug="${fileSlug}"]`);
        if (documentItem) {
            const checkIcon = documentItem.querySelector('.check-icon');
            const title = documentItem.querySelector('h6');
            const subtitle = documentItem.querySelector('small');
            const dropzoneArea = documentItem.querySelector('.dropzone-area');
            const dropzoneMessage = documentItem.querySelector('.dz-message p');
            const currentFiles = filesByDocumentType[fileSlug] || [];
            
            if (hasFiles) {
                documentItem.className = 'document-item mb-4 p-3 border rounded border-success bg-light';
                checkIcon.innerHTML = '<ion-icon name="checkmark-circle" style="font-size: 24px; color: #28a745;"></ion-icon>';
                title.className = 'mb-1 text-success';
                subtitle.textContent = `${currentFiles.length} archivo(s) subido(s)`;
                
                // Actualizar el estado visual del dropzone
                if (dropzoneArea) {
                    dropzoneArea.classList.add('has-files');
                }
                if (dropzoneMessage) {
                    dropzoneMessage.textContent = 'Arrastra más archivos aquí';
                }
            } else {
                documentItem.className = 'document-item mb-4 p-3 border rounded border-warning';
                checkIcon.innerHTML = '<ion-icon name="ellipse-outline" style="font-size: 24px; color: #6c757d;"></ion-icon>';
                title.className = 'mb-1';
                subtitle.textContent = 'Pendiente de subir';
                
                // Resetear el estado visual del dropzone
                if (dropzoneArea) {
                    dropzoneArea.classList.remove('has-files');
                }
                if (dropzoneMessage) {
                    dropzoneMessage.textContent = 'Arrastra archivos aquí o haz clic para seleccionar';
                }
            }
        }
    }

    function addFileToDocumentList(fileSlug, file) {
        // Agregar archivo al objeto de seguimiento usando el slug del archivo
        if (!filesByDocumentType[fileSlug]) {
            filesByDocumentType[fileSlug] = [];
        }
        filesByDocumentType[fileSlug].push(file);
        
        // Actualizar la lista visual
        const filesContainer = document.getElementById(`files-${fileSlug}`);
        if (filesContainer) {
            filesContainer.insertAdjacentHTML('beforeend', createFileListItem(file));
        }
        
        // Actualizar estado del documento
        updateDocumentStatus(fileSlug, true);
    }

    function showNotification(message, type = 'info') {
        // Crear notificación temporal
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Remover automáticamente después de 5 segundos
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

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
.document-item {
    transition: all 0.3s ease;
}

.document-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Contenedor de DropZone con archivos superpuestos */
.dropzone-container {
    position: relative;
}

.uploaded-files-overlay {
    position: relative;
    z-index: 10;
    margin-bottom: 10px;
}

/* Estilos para las tarjetas de archivo */
.file-card-item {
    animation: slideInFromTop 0.3s ease-out;
}

.file-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
}

.file-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #007bff;
}

.file-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #0056b3);
    border-radius: 12px 12px 0 0;
}

.file-card-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: rgba(0,123,255,0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.file-card-content {
    flex-grow: 1;
    min-width: 0;
}

.file-name {
    font-weight: 600;
    color: #212529;
    font-size: 14px;
    line-height: 1.3;
    margin-bottom: 4px;
    word-break: break-word;
}

.file-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.file-details small {
    font-size: 11px;
    color: #6c757d;
    line-height: 1.2;
}

.file-date {
    color: #198754 !important;
    font-weight: 500;
}

.file-card-actions {
    flex-shrink: 0;
}

.file-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.file-action-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0,123,255,0.3);
}

/* Estilos personalizados para Dropzone */
.dropzone-area {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    background: #f8f9fa;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.dropzone-area.has-files {
    min-height: 80px;
    padding: 15px;
    border-style: solid;
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
}

.dropzone-area:hover {
    border-color: #007bff;
    background: #e3f2fd;
}

.dropzone-area.dz-drag-hover {
    border-color: #28a745;
    background: #d4edda;
    transform: scale(1.02);
}

.dropzone-area .dz-message {
    margin: 0;
}

.dropzone-area .dz-message p {
    margin: 0;
    color: #6c757d;
    font-weight: 500;
}

.dropzone-area .dz-message small {
    color: #adb5bd;
}

/* Ocultar elementos de Dropzone que no necesitamos */
.dropzone-area .dz-preview {
    display: none !important;
}

/* Animaciones */
@keyframes slideInFromTop {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsivo */
@media (max-width: 768px) {
    .document-item .row > div {
        margin-bottom: 15px;
    }
    
    .dropzone-area {
        min-height: 80px;
        padding: 15px;
    }
    
    .dropzone-area.has-files {
        min-height: 60px;
        padding: 10px;
    }
    
    .dropzone-area .dz-message p {
        font-size: 14px;
    }
    
    .dropzone-area .dz-message small {
        font-size: 12px;
    }
    
    .file-card {
        padding: 10px;
        gap: 10px;
    }
    
    .file-card-icon {
        width: 35px;
        height: 35px;
    }
    
    .file-name {
        font-size: 13px;
    }
}

.spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Animación para notificaciones */
.alert.position-fixed {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
@endsection
