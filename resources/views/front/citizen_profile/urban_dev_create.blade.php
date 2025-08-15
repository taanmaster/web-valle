@extends('front.layouts.app')

@section('title', 'Nueva Solicitud - Desarrollo Urbano')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            @include('front.citizen_profile.partials._profile_card')

            <div class="card wow fadeInUp">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <ion-icon name="add-circle-outline"></ion-icon>
                        Nueva Solicitud - Desarrollo Urbano
                    </h5>
                </div>
                <div class="card-body">
                    <form id="urbanDevRequestForm" method="POST" action="{{ route('citizen.urban_dev.store') }}">
                        @csrf
                        
                        <div class="row">
                            <!-- Columna izquierda: Información básica -->
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">
                                            <ion-icon name="information-circle-outline"></ion-icon>
                                            Información del Trámite
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="request_type" class="form-label">Tipo de Trámite <span class="text-danger">*</span></label>
                                            <select class="form-select" id="request_type" name="request_type" required>
                                                <option value="">Seleccione un trámite</option>
                                                <option value="uso-de-suelo">Licencia de Uso de Suelo</option>
                                                <option value="constancia-de-factibilidad">Constancia de Factibilidad</option>
                                                <option value="permiso-de-anuncios">Permiso de Anuncios y Toldos</option>
                                                <option value="certificacion-numero-oficial">Certificación de Número Oficial</option>
                                                <option value="permiso-de-division">Permiso de División</option>
                                                <option value="uso-de-via-publica">Uso de Vía Pública</option>
                                                <option value="licencia-de-construccion">Licencia de Construcción</option>
                                                <option value="permiso-construccion-panteones">Permiso de Construcción en Panteones</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Descripción del proyecto <span class="text-info">(Opcional)</span></label>
                                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe brevemente tu proyecto o solicitud..."></textarea>
                                            <small>Esto es un campo util para que puedas clasificar tus diferentes trámites.</small>
                                        </div>

                                        <div class="alert alert-info">
                                            <h6 class="mb-2"><ion-icon name="information-circle-outline"></ion-icon> Información</h6>
                                            <p class="mb-0">Una vez creada la solicitud, podrás subir los documentos requeridos según el tipo de trámite seleccionado.</p>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('citizen.profile.urban_dev_requests') }}" class="btn btn-secondary">
                                                        <ion-icon name="arrow-back-outline"></ion-icon> Cancelar
                                                    </a>
                                                    <button type="submit" class="btn btn-primary">
                                                        <ion-icon name="save-outline"></ion-icon> Crear Solicitud
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna derecha: Preview de documentos requeridos -->
                            <div class="col-md-6">
                                <div class="card border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">
                                            <ion-icon name="document-text-outline"></ion-icon>
                                            Documentos Requeridos
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="documents-preview">
                                            <div class="text-center text-muted py-5">
                                                <ion-icon name="documents-outline" style="font-size: 48px;"></ion-icon>
                                                <p class="mt-3">Selecciona un tipo de trámite para ver los documentos requeridos</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const requestTypeSelect = document.getElementById('request_type');
    const documentsPreview = document.getElementById('documents-preview');

    // Configuración de documentos por tipo de trámite
    const documentsConfig = {
        'uso-de-suelo': [
            'Solicitud por escrito dirigida al Director',
            'Copia de identificación oficial vigente',
            'Escritura pública o documento de propiedad',
            'Último recibo de pago del impuesto predial',
            'Plano de localización del predio (escala 1:1000)',
            'Croquis de ubicación con referencias y medidas'
        ],
        'constancia-de-factibilidad': [
            'Solicitud detallada del proyecto',
            'Proyecto arquitectónico o memoria descriptiva',
            'Escritura pública de propiedad',
            'Plano topográfico actualizado',
            'Estudio de factibilidad de servicios públicos',
            'Dictamen de uso de suelo vigente'
        ],
        'permiso-de-anuncios': [
            'Solicitud especificando tipo y características',
            'Diseño gráfico y especificaciones técnicas',
            'Documento de propiedad o autorización',
            'Memoria de cálculo estructural (si aplica)',
            'Plano de localización y ubicación exacta',
            'Fotografías del lugar de instalación'
        ],
        'certificacion-numero-oficial': [
            'Solicitud dirigida al Director',
            'Escritura pública o documento de propiedad',
            'Constancia de alineamiento vigente',
            'Plano de localización con medidas exactas',
            'Identificación oficial del propietario',
            'Último recibo de impuesto predial'
        ],
        'permiso-de-division': [
            'Solicitud con proyecto de división',
            'Escritura pública de propiedad',
            'Levantamiento topográfico certificado',
            'Proyecto de lotificación completo',
            'Dictamen de factibilidad de servicios',
            'Estudio de impacto urbano y vial'
        ],
        'uso-de-via-publica': [
            'Solicitud especificando uso y tiempo',
            'Croquis del área a ocupar',
            'Programa de actividades y horarios',
            'Medidas de seguridad propuestas',
            'Póliza de seguro de responsabilidad civil',
            'Autorización de vecinos (si aplica)'
        ],
        'licencia-de-construccion': [
            'Solicitud con proyecto arquitectónico',
            'Planos estructurales firmados por DRO',
            'Memoria de cálculo y especificaciones',
            'Dictamen de uso de suelo compatible',
            'Factibilidades de servicios públicos',
            'Estudio de mecánica de suelos (si aplica)'
        ],
        'permiso-construccion-panteones': [
            'Solicitud dirigida a Administración del Panteón',
            'Proyecto de construcción funeraria',
            'Documento de propiedad o concesión del lote',
            'Especificaciones de materiales y acabados',
            'Plano de ubicación dentro del cementerio',
            'Autorización de familiares o herederos'
        ]
    };

    requestTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        if (selectedType && documentsConfig[selectedType]) {
            let html = '<div class="document-checklist">';
            html += '<h6 class="mb-3 text-primary">Documentos requeridos para este trámite:</h6>';
            
            documentsConfig[selectedType].forEach((doc, index) => {
                html += `
                    <div class="document-item d-flex align-items-center mb-2 p-2 border rounded">
                        <div class="document-number me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 14px;">
                            ${index + 1}
                        </div>
                        <div class="document-text flex-grow-1">
                            <small class="text-muted">${doc}</small>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            html += '<div class="alert alert-success mt-3">';
            html += '<small><ion-icon name="checkmark-circle-outline"></ion-icon> Después de crear la solicitud podrás subir estos documentos</small>';
            html += '</div>';
            
            documentsPreview.innerHTML = html;
        } else {
            documentsPreview.innerHTML = `
                <div class="text-center text-muted py-5">
                    <ion-icon name="documents-outline" style="font-size: 48px;"></ion-icon>
                    <p class="mt-3">Selecciona un tipo de trámite para ver los documentos requeridos</p>
                </div>
            `;
        }
    });

    // Handle form submission
    document.getElementById('urbanDevRequestForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<ion-icon name="sync-outline" class="spinner"></ion-icon> Creando...';
        
        fetch(this.action, {
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
                window.location.href = data.redirect;
            } else {
                throw new Error(data.message || 'Error al crear la solicitud');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al crear la solicitud: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});
</script>

<style>
.document-item {
    transition: all 0.3s ease;
}

.document-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.document-number {
    font-weight: bold;
    flex-shrink: 0;
}

.document-checklist {
    max-height: 400px;
    overflow-y: auto;
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
