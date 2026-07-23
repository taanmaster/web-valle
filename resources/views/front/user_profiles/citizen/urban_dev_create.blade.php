@extends('front.layouts.app')

@section('title', 'Nueva Solicitud - Desarrollo Urbano')

@section('content')
    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
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
                                                <label for="request_type" class="form-label">Tipo de Trámite <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="request_type" name="request_type" required>
                                                    <option value="">Seleccione un trámite</option>
                                                    <option value="uso-de-suelo">Permiso de Uso de Suelo</option>
                                                    <option value="constancia-de-factibilidad">Constancia de Factibilidad
                                                    </option>
                                                    <option value="permiso-de-anuncios">Permiso de Anuncios y Toldos
                                                    </option>
                                                    <option value="certificacion-numero-oficial">Certificación de Número
                                                        Oficial</option>
                                                    <option value="permiso-de-division">Permiso de División</option>
                                                    <option value="uso-de-via-publica">Uso de Vía Pública</option>
                                                    <option value="licencia-de-construccion">Permiso de Construcción
                                                    </option>
                                                    <option value="permiso-construccion-panteones">Permiso de Construcción
                                                        en Panteones</option>
                                                </select>
                                            </div>

                                            <!-- Modalidad: solo aplica al Permiso de Uso de Suelo -->
                                            <div class="mb-3 d-none" id="modality-wrapper">
                                                <label for="request_modality" class="form-label">Modalidad del trámite
                                                    <span class="text-danger">*</span></label>
                                                <select class="form-select" id="request_modality" name="request_modality">
                                                    <option value="">Seleccione una modalidad</option>
                                                    <option value="bajo-impacto">PUS de Bajo Impacto</option>
                                                    <option value="mediano-alto-impacto">PUS de Mediano y Alto Impacto
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Descripción del proyecto <span
                                                        class="text-info">(Opcional)</span></label>
                                                <textarea class="form-control" id="description" name="description" rows="4"
                                                    placeholder="Describe brevemente tu proyecto o solicitud..."></textarea>
                                                <small>Esto es un campo util para que puedas clasificar tus diferentes
                                                    trámites.</small>
                                            </div>

                                            <div class="alert alert-info">
                                                <h6 class="mb-2"><ion-icon name="information-circle-outline"></ion-icon>
                                                    Información</h6>
                                                <p class="mb-0">Una vez creada la solicitud, podrás subir los documentos
                                                    requeridos según el tipo de trámite seleccionado.</p>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between">
                                                        <a href="{{ route('citizen.profile.urban_dev_requests') }}"
                                                            class="btn btn-secondary">
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
                                                    <p class="mt-3">Selecciona un tipo de trámite para ver los documentos
                                                        requeridos</p>
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

            const modalityWrapper = document.getElementById('modality-wrapper');
            const modalitySelect = document.getElementById('request_modality');

            // El Permiso de Uso de Suelo tiene modalidades con documentos distintos.
            const usoSueloModalities = {
                'bajo-impacto': [
                    'Formato único de solicitud. (FORMATO COMPLETO)',
                    'Identificación oficial.',
                    'Documento que acredite de la Propiedad.',
                    'Carta Poder, si actúa a nombre y representación del propietario.',
                    'Documento que acredite de la Propiedad.',
                    'Croquis ubicación del inmueble.',
                    'Fotografías del predio.',
                    'Número de cuenta predial.',
                    'En caso de arrendar el inmueble, anexar contrato de arrendamiento simple y escritura pública o documento que acredite la propiedad, si el contrato es notariado se omite la escritura pública.',
                    'Personas Morales. Presentar Acta Constitutiva, e instrumento notariado que acredite la personalidad de los representantes (poder legal).',
                    'Copia de identificación oficial del arrendador o representante legal según sea el caso.'
                ],
                'mediano-alto-impacto': [
                    'Formato único de solicitud. (FORMATO COMPLETO)',
                    'Identificación oficial.',
                    'Carta Poder, si actúa a nombre y representación del propietario.',
                    'Documento que acredite de la Propiedad.',
                    'Croquis ubicación del inmueble.',
                    'Fotografías del predio.',
                    'Número de cuenta predial.',
                    'En caso de arrendar el inmueble, anexar contrato de arrendamiento simple y escritura pública o documento que acredite la propiedad, si el contrato es notariado se omite la escritura pública.',
                    'Personas Morales. Presentar Acta Constitutiva, e instrumento notariado que acredite la personalidad de los representantes (poder legal).',
                    'Copia de identificación oficial del arrendador o representante legal según sea el caso.',
                    'Constancia de Medio Ambiente, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo requiera).',
                    'Constancia de Impacto Vial, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo requiera).',
                    'Vo.Bo. de Protección Civil, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo requiera).'
                ]
            };

            // Configuración de documentos por tipo de trámite
            const documentsConfig = {
                'constancia-de-factibilidad': [
                    'Formato de solicitud para licencia de Uso de Suelo (FDDUEM-01)',
                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio.',
                    'Contrato de arrendamiento simple',
                    'Poder Legal',
                    'Copia del último pago del predial.',
                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso.',
                    'Croquis de ubicación del inmueble'
                ],
                'permiso-de-anuncios': [
                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio.',
                    'Contrato de arrendamiento simple',
                    'Poder Legal',
                    'Copia del último pago del predial',
                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso.',
                    'Croquis de ubicación del inmueble'
                ],
                'certificacion-numero-oficial': [
                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio.',
                    'Contrato de arrendamiento simple',
                    'Poder Legal',
                    'Copia del último pago del predial',
                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso.',
                    'Croquis de ubicación del inmueble'
                ],
                'permiso-de-division': [
                    'Solicitud por escrito con proyecto de división',
                    'Croquis del predio',
                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio.',
                    'Copia del último pago del predial.',
                    'Copia de identificación de la persona que acredita la propiedad'
                ],
                'uso-de-via-publica': [
                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                    'Copia del último pago del predial.',
                    'Copia de identificación de la persona que acredita la propiedad.',
                    'Croquis de ubicación del inmueble'
                ],
                'licencia-de-construccion': [
                    'Formato único de solicitud.',
                    'Identificación oficial.',
                    'Carta Poder, si actúa a nombre y representación del propietario.',
                    'Documento que acredite de la Propiedad.',
                    'Croquis ubicación del inmueble.',
                    'Fotografías del predio.',
                    'Número de predial del inmueble.',
                    'En caso de arrendar el inmueble, anexar contrato de arrendamiento simple y escritura pública o documento que acredite la propiedad, si el contrato es notariado se omite la escritura pública.',
                    'Personas Morales. Presentar Acta Constitutiva, e instrumento notariado que acredite la personalidad de los representantes (poder legal).',
                    'Copia de identificación oficial del arrendador o representante legal según sea el caso.',
                    'Planos del Proyecto Ejecutivo. Proyecto Arquitectónico (2 tantos), escala de 1:100 ó 1:50 elaborados, avalados y firmados por el Director Responsable de Obra (DRO).',
                    'Planos de Diseño Estructural. Formato 90 × 60 (2 tantos), firmado y sellado por el Director Responsable de Obra (DRO).',
                    'Memoria de cálculo del Proyecto.',
                    'Constancia de Medio Ambiente, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo quiera).',
                    'Constancia de Impacto Vial, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo quiera).',
                    'Vo.Bo. de Protección Civil, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo quiera).'
                ],
                'permiso-construccion-panteones': [
                    'Formato de solicitud para Licencia de Uso Suelo',
                    'Copia de identificación del propietario.',
                    'Copia del documento de perpetuidad.'
                ]
            };

            // Renderiza el mensaje/placeholder centrado dentro del panel de documentos
            function renderPlaceholder(message) {
                documentsPreview.innerHTML = `
                <div class="text-center text-muted py-5">
                    <ion-icon name="documents-outline" style="font-size: 48px;"></ion-icon>
                    <p class="mt-3">${message}</p>
                </div>
            `;
            }

            // Renderiza el checklist de documentos requeridos
            function renderDocuments(docs) {
                let html = '<div class="document-checklist">';
                html += '<h6 class="mb-3 text-primary">Documentos requeridos para este trámite:</h6>';

                docs.forEach((doc, index) => {
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
                html +=
                    '<small><ion-icon name="checkmark-circle-outline"></ion-icon> Después de crear la solicitud podrás subir estos documentos</small>';
                html += '</div>';

                documentsPreview.innerHTML = html;
            }

            requestTypeSelect.addEventListener('change', function() {
                const selectedType = this.value;

                if (selectedType === 'uso-de-suelo') {
                    // Mostrar el selector de modalidad y esperar a que se elija una
                    modalityWrapper.classList.remove('d-none');
                    modalitySelect.value = '';
                    modalitySelect.setAttribute('required', 'required');
                    renderPlaceholder('Selecciona una modalidad para ver los documentos requeridos');
                    return;
                }

                // Los demás trámites no usan modalidad
                modalityWrapper.classList.add('d-none');
                modalitySelect.removeAttribute('required');
                modalitySelect.value = '';

                if (selectedType && documentsConfig[selectedType]) {
                    renderDocuments(documentsConfig[selectedType]);
                } else {
                    renderPlaceholder('Selecciona un tipo de trámite para ver los documentos requeridos');
                }
            });

            // Al elegir la modalidad del Permiso de Uso de Suelo, mostrar sus documentos
            modalitySelect.addEventListener('change', function() {
                const modality = this.value;

                if (requestTypeSelect.value === 'uso-de-suelo' && usoSueloModalities[modality]) {
                    renderDocuments(usoSueloModalities[modality]);
                } else {
                    renderPlaceholder('Selecciona una modalidad para ver los documentos requeridos');
                }
            });

            // Handle form submission
            document.getElementById('urbanDevRequestForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML =
                '<ion-icon name="sync-outline" class="spinner"></ion-icon> Creando...';

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
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
