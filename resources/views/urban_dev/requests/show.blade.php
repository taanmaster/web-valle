@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('li_3') <a href="{{ route('urban_dev.requests.index') }}">Solicitudes</a> @endslot
@slot('title') Solicitud #{{ $urbanDevRequest->id }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        
        <!-- Header con información básica -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-1">
                                    <i class="fas fa-file-alt"></i>
                                    {{ $urbanDevRequest->getRequestTypeLabelAttribute() }}
                                </h4>
                                <p class="text-muted mb-0">
                                    Solicitud #{{ $urbanDevRequest->id }} • 
                                    Solicitado por: <strong>{{ $urbanDevRequest->user->name }}</strong>
                                </p>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt"></i> Creado: {{ $urbanDevRequest->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-{{ $urbanDevRequest->getStatusColorAttribute() }} fs-6 px-3 py-2">
                                    {{ $urbanDevRequest->getStatusLabelAttribute() }}
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">
                                    <i class="far fa-clock"></i> Actualizado: {{ $urbanDevRequest->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Información Principal y Documentos -->
            <div class="col-md-7">
                <!-- Información del Solicitante -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="text-white">
                            <i class="fas fa-user"></i>
                            Información del Solicitante
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Nombre Completo:</small>
                                <p class="mb-0 fw-bold">{{ $urbanDevRequest->user->name }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Correo Electrónico:</small>
                                <p class="mb-0">
                                    <a href="mailto:{{ $urbanDevRequest->user->email }}">{{ $urbanDevRequest->user->email }}</a>
                                </p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Registro:</small>
                                <p class="mb-0">{{ $urbanDevRequest->user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        @if($urbanDevRequest->description)
                        <div class="row">
                            <div class="col-12">
                                <small class="text-muted">Descripción del Proyecto:</small>
                                <div class="alert alert-light mt-1">
                                    {{ $urbanDevRequest->description }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Formato Único de Solicitud -->
                @if (in_array($urbanDevRequest->request_type, ['uso-de-suelo', 'licencia-de-construccion']))
                    @php
                        $format = $urbanDevRequest->format;
                        $fmt = $format?->data ?? [];
                        $fval = fn($k) => trim((string) ($fmt[$k] ?? ''));

                        $personaLabel = ['fisica' => 'Persona Física', 'moral' => 'Persona Moral'];
                        $condicionLabel = ['solicitante' => 'Solicitante', 'tercero' => 'Tercero interesado'];
                        $tramiteLabel = [
                            'uso-suelo' => 'Permiso de Uso de Suelo',
                            'num-oficial' => 'Certificación de Número Oficial',
                            'alineamiento' => 'Constancia de Alineamiento',
                        ];

                        // Secciones: título => [ [label, value], ... ] (solo se muestran valores no vacíos)
                        $fmtSections = [];

                        if ($urbanDevRequest->request_type === 'uso-de-suelo') {
                            $fmtSections['Tipo de trámite'] = [
                                ['Tipo de trámite', $tramiteLabel[$fval('tipo_tramite')] ?? $fval('tipo_tramite')],
                            ];
                        }

                        $fmtSections['1. Datos generales del solicitante'] = [
                            ['Tipo de Persona', $personaLabel[$fval('tipo_persona')] ?? ''],
                            ['En su condición de', $condicionLabel[$fval('condicion')] ?? ''],
                            ['Primer Apellido (P. Física)', $fval('pf_primer_apellido')],
                            ['Segundo Apellido (P. Física)', $fval('pf_segundo_apellido')],
                            ['Nombres (P. Física)', $fval('pf_nombres')],
                            ['CURP', $fval('pf_curp')],
                            ['Correo (P. Física)', $fval('pf_correo')],
                            ['Teléfono (P. Física)', $fval('pf_telefono')],
                            ['Razón Social (P. Moral)', $fval('pm_razon_social')],
                            ['RFC (P. Moral)', $fval('pm_rfc')],
                            ['Rep. Legal - Primer Apellido', $fval('rl_primer_apellido')],
                            ['Rep. Legal - Segundo Apellido', $fval('rl_segundo_apellido')],
                            ['Rep. Legal - Nombres', $fval('rl_nombres')],
                            ['Rep. Legal - RFC', $fval('rl_rfc')],
                            ['Rep. Legal - Correo', $fval('rl_correo')],
                            ['Rep. Legal - Teléfono', $fval('rl_telefono')],
                        ];

                        $fmtSections['2. Domicilio para recibir notificaciones'] = [
                            ['Calle', $fval('dom_calle')],
                            ['Número Ext', $fval('dom_num_ext')],
                            ['Número Int', $fval('dom_num_int')],
                            ['Colonia', $fval('dom_colonia')],
                            ['CP', $fval('dom_cp')],
                            ['Ciudad', $fval('dom_ciudad')],
                            ['Estado', $fval('dom_estado')],
                        ];

                        $fmtSections['3. Datos del propietario del predio'] = [
                            ['Tipo de propietario', $personaLabel[$fval('prop_tipo')] ?? ''],
                            ['Primer Apellido', $fval('prop_pf_primer_apellido')],
                            ['Segundo Apellido', $fval('prop_pf_segundo_apellido')],
                            ['Nombres', $fval('prop_pf_nombres')],
                            ['Razón Social', $fval('prop_pm_razon_social')],
                        ];

                        $fmtSections['4. Datos del predio'] = [
                            ['Número de cuenta predial', $fval('predio_cuenta_predial')],
                            ['Calle', $fval('predio_calle')],
                            ['Número Ext', $fval('predio_num_ext')],
                            ['Número Int', $fval('predio_num_int')],
                            ['Colonia', $fval('predio_colonia')],
                            ['CP', $fval('predio_cp')],
                            ['Superficie del predio', $fval('predio_superficie')],
                        ];

                        if ($urbanDevRequest->request_type === 'uso-de-suelo') {
                            $fmtSections['5. Datos del giro solicitado'] = [
                                ['Giro Solicitado', $fval('giro_solicitado')],
                                ['Superficie a ocupar del predio', $fval('giro_superficie_ocupar')],
                                ['Denominación Comercial', $fval('giro_denominacion_comercial')],
                            ];
                        } else {
                            $fmtSections['5. Datos de la construcción'] = [
                                ['Tipo de construcción a realizar', $fval('construccion_tipo')],
                                ['Metros cuadrados de construcción', $fval('construccion_m2')],
                                ['Metros lineales de construcción', $fval('construccion_ml')],
                                ['Perito - Primer Apellido', $fval('perito_primer_apellido')],
                                ['Perito - Segundo Apellido', $fval('perito_segundo_apellido')],
                                ['Perito - Nombres', $fval('perito_nombres')],
                                ['Perito - No. Registro Padrón Municipal', $fval('perito_registro_padron')],
                                ['Perito - Correo', $fval('perito_correo')],
                                ['Perito - Teléfono', $fval('perito_telefono')],
                            ];
                        }
                    @endphp

                    <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #4d8f8b;">
                            <h6 class="text-white mb-0">
                                <i class="fas fa-file-signature"></i>
                                Formato Único de Solicitud
                            </h6>
                        </div>
                        <div class="card-body">
                            @if (!$format)
                                {{-- Empty state: el ciudadano aún no ha llenado el formato --}}
                                <div class="text-center text-muted py-4">
                                    <i class="far fa-file-alt" style="font-size: 48px;"></i>
                                    <h6 class="mt-3 mb-1">El formato aún no ha sido llenado</h6>
                                    <p class="mb-0">El ciudadano todavía no ha completado el Formato Único de Solicitud
                                        de este trámite.</p>
                                </div>
                            @else
                                <div class="accordion formato-accordion" id="formatoAccordion">
                                    @foreach ($fmtSections as $secTitle => $rows)
                                        @php
                                            $visibleRows = array_filter($rows, fn($r) => $r[1] !== '');
                                        @endphp
                                        @if (count($visibleRows) > 0)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#fmt-sec-{{ $loop->index }}"
                                                        aria-expanded="false"
                                                        aria-controls="fmt-sec-{{ $loop->index }}">
                                                        {{ $secTitle }}
                                                    </button>
                                                </h2>
                                                <div id="fmt-sec-{{ $loop->index }}"
                                                    class="accordion-collapse collapse"
                                                    data-bs-parent="#formatoAccordion">
                                                    <div class="accordion-body">
                                                        <dl class="row mb-0">
                                                            @foreach ($visibleRows as $r)
                                                                <dt class="col-sm-5 text-muted fw-normal">{{ $r[0] }}
                                                                </dt>
                                                                <dd class="col-sm-7 fw-bold">{{ $r[1] }}</dd>
                                                            @endforeach
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    {{-- Croquis y firmas --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#fmt-sec-files"
                                                aria-expanded="false" aria-controls="fmt-sec-files">
                                                Croquis y firmas
                                            </button>
                                        </h2>
                                        <div id="fmt-sec-files" class="accordion-collapse collapse"
                                            data-bs-parent="#formatoAccordion">
                                            <div class="accordion-body">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <small class="text-muted d-block mb-1">Croquis</small>
                                                        @if ($format->croquis_url)
                                                            <a href="{{ $format->croquis_url }}" target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i> Ver croquis
                                                            </a>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small class="text-muted d-block mb-1">Firma del
                                                            solicitante</small>
                                                        @if ($format->signature_applicant_url)
                                                            <img src="{{ $format->signature_applicant_url }}"
                                                                alt="Firma solicitante"
                                                                style="max-height: 70px; border: 1px solid #dee2e6; border-radius: 6px; background: #fff;">
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </div>
                                                    @if ($urbanDevRequest->request_type === 'licencia-de-construccion')
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block mb-1">Firma del
                                                                perito</small>
                                                            @if ($format->signature_perito_url)
                                                                <img src="{{ $format->signature_perito_url }}"
                                                                    alt="Firma perito"
                                                                    style="max-height: 70px; border: 1px solid #dee2e6; border-radius: 6px; background: #fff;">
                                                            @else
                                                                <span class="text-muted">—</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Información del Predio (Catastro) -->
                @if (in_array($urbanDevRequest->request_type, \App\Models\UrbanDevRequest::CASTRO_REQUEST_TYPES))
                    @php $castro = $urbanDevRequest->castro; @endphp
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h6 class="text-white mb-0">
                                <i class="fas fa-map-marked-alt"></i>
                                Información del Predio
                            </h6>
                            @if ($castro)
                                <span class="badge bg-{{ $castro->status_color }}">{{ $castro->status_label }}</span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if (!$castro || $castro->status !== 'completado')
                                <div class="text-center text-muted py-4">
                                    <i class="far fa-clock" style="font-size: 48px;"></i>
                                    <h6 class="mt-3 mb-1">Catastro aún no ha capturado la información</h6>
                                    <p class="mb-0">Esta sección se completará cuando Catastro registre los datos del
                                        predio.</p>
                                </div>
                            @else
                                <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3">Fechas y cuenta predial</h6>
                                <dl class="row mb-2">
                                    <dt class="col-sm-4 text-muted fw-normal">Fecha de solicitud</dt>
                                    <dd class="col-sm-8 fw-bold">{{ optional($castro->fecha_solicitud)->format('d/m/Y') ?? '—' }}</dd>
                                    <dt class="col-sm-4 text-muted fw-normal">Fecha de entrega de documentos</dt>
                                    <dd class="col-sm-8 fw-bold">{{ optional($castro->fecha_entrega_documentos)->format('d/m/Y') ?? '—' }}</dd>
                                    <dt class="col-sm-4 text-muted fw-normal">Cuenta predial</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $castro->cuenta_predial ?: '—' }}</dd>
                                </dl>

                                <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3 mt-3">Contribuyente y predio</h6>
                                <dl class="row mb-2">
                                    <dt class="col-sm-4 text-muted fw-normal">Nombre del contribuyente</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $castro->nombre_contribuyente ?: '—' }}</dd>
                                    <dt class="col-sm-4 text-muted fw-normal">Tipo de predio</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $castro->tipo_predio ?: '—' }}</dd>
                                    <dt class="col-sm-4 text-muted fw-normal">Domicilio del predio</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $castro->domicilio_predio ?: '—' }}</dd>
                                </dl>

                                <h6 class="text-uppercase text-muted border-bottom pb-2 mb-3 mt-3">Ubicación y detalles</h6>
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 text-muted fw-normal">Localidad / Colonia / Ejido</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $castro->localidad_colonia_ejido ?: '—' }}</dd>
                                    <dt class="col-sm-4 text-muted fw-normal">Manzana / Lote</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $castro->manzana_lote ?: '—' }}</dd>
                                    <dt class="col-sm-4 text-muted fw-normal">Superficie (m²)</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $castro->superficie !== null ? number_format($castro->superficie, 2) : '—' }}</dd>
                                    <dt class="col-sm-4 text-muted fw-normal">Uso / trámite (Desarrollo Urbano)</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $castro->uso_tramite ?: '—' }}</dd>
                                    <dt class="col-sm-4 text-muted fw-normal">URL de expediente</dt>
                                    <dd class="col-sm-8 fw-bold">
                                        @if ($castro->url_expediente && preg_match('#^https?://#i', $castro->url_expediente))
                                            <a href="{{ $castro->url_expediente }}" target="_blank" rel="noopener noreferrer">
                                                <i class="fas fa-external-link-alt"></i> Ver expediente
                                            </a>
                                        @else
                                            —
                                        @endif
                                    </dd>
                                </dl>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Lista de Verificación de Documentos -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="text-white">
                            <i class="fas fa-check-circle"></i>
                            Lista de Verificación de Documentos
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="documents-checklist">
                            <!-- Los documentos se cargarán dinámicamente -->
                        </div>
                        
                        @php
                            // El "Formato único de solicitud" y el "Número de cuenta predial" ya
                            // no son documentos a subir en uso-de-suelo / licencia-de-construccion:
                            // se capturan en el formato y en los detalles de la solicitud.
                            // Uso de Suelo tiene dos modalidades (mode) con documentos distintos.
                            $usoSueloByMode = [
                                'bajo-impacto' => [
                                    'Identificación oficial.',
                                    'Documento que acredite de la Propiedad.',
                                    'Carta Poder, si actúa a nombre y representación del propietario.',
                                    'Croquis ubicación del inmueble.',
                                    'Fotografías del predio.',
                                    'En caso de arrendar el inmueble, anexar contrato de arrendamiento simple y escritura pública o documento que acredite la propiedad, si el contrato es notariado se omite la escritura pública.',
                                    'Personas Morales. Presentar Acta Constitutiva, e instrumento notariado que acredite la personalidad de los representantes (poder legal).',
                                    'Copia de identificación oficial del arrendador o representante legal según sea el caso.',
                                ],
                                'mediano-alto-impacto' => [
                                    'Identificación oficial.',
                                    'Carta Poder, si actúa a nombre y representación del propietario.',
                                    'Documento que acredite de la Propiedad.',
                                    'Croquis ubicación del inmueble.',
                                    'Fotografías del predio.',
                                    'En caso de arrendar el inmueble, anexar contrato de arrendamiento simple y escritura pública o documento que acredite la propiedad, si el contrato es notariado se omite la escritura pública.',
                                    'Personas Morales. Presentar Acta Constitutiva, e instrumento notariado que acredite la personalidad de los representantes (poder legal).',
                                    'Copia de identificación oficial del arrendador o representante legal según sea el caso.',
                                    'Constancia de Medio Ambiente, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo quiera).',
                                    'Constancia de Impacto Vial, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo quiera).',
                                    'Vo.Bo. de Protección Civil, (será solicitado por la Autoridad Administrativa responsable del trámite cuando este así lo quiera).',
                                ],
                            ];

                            $documentsConfig = [
                                'constancia-de-factibilidad' => [
                                    'Formato de solicitud para licencia de Uso de Suelo (FDDUEM-01)',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Contrato de arrendamiento simple',
                                    'Poder Legal',
                                    'Copia del último pago del predial.',
                                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'permiso-de-anuncios' => [
                                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Contrato de arrendamiento simple',
                                    'Poder Legal',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'certificacion-numero-oficial' => [
                                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Contrato de arrendamiento simple',
                                    'Poder Legal',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'permiso-de-division' => [
                                    'Solicitud por escrito con proyecto de división',
                                    'Croquis del predio',
                                    'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad'
                                ],
                                'uso-de-via-publica' => [
                                    'Formato de solicitud para Licencia de Uso Suelo (FDDUEM-01)',
                                    'Copia del último pago del predial',
                                    'Copia de identificación de la persona que acredita la propiedad',
                                    'Croquis de ubicación del inmueble'
                                ],
                                'licencia-de-construccion' => [
                                    'Identificación oficial.',
                                    'Carta Poder, si actúa a nombre y representación del propietario.',
                                    'Documento que acredite de la Propiedad.',
                                    'Croquis ubicación del inmueble.',
                                    'Fotografías del predio.',
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
                                'permiso-construccion-panteones' => [
                                    'Formato de solicitud para Licencia de Uso Suelo',
                                    'Copia de identificación del propietario',
                                    'Copia del documento de perpetuidad'
                                ]
                            ];
                            
                            if ($urbanDevRequest->request_type === 'uso-de-suelo') {
                                $requiredDocuments = $usoSueloByMode[$urbanDevRequest->mode] ?? $usoSueloByMode['bajo-impacto'];
                            } else {
                                $requiredDocuments = $documentsConfig[$urbanDevRequest->request_type] ?? [];
                            }
                            $uploadedFiles = $urbanDevRequest->files;
                            $uploadedFileTypes = $uploadedFiles->pluck('slug')->toArray();
                        @endphp

                        @if(count($requiredDocuments) > 0)
                            @foreach($requiredDocuments as $index => $document)
                                @php
                                    $docSlug = Str::slug($document);
                                    $documentFiles = $uploadedFiles->where('slug', $docSlug);
                                    $hasFiles = $documentFiles->count() > 0;
                                @endphp
                                
                                <div class="mb-4 p-3 border rounded {{ $hasFiles ? 'border-success bg-light' : 'border-warning' }}">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="me-3">
                                            @if($hasFiles)
                                                <i class="fas fa-check-circle text-success" style="font-size: 24px;"></i>
                                            @else
                                                <i class="far fa-circle text-muted" style="font-size: 24px;"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 {{ $hasFiles ? 'text-success' : '' }}">{{ $document }}</h6>
                                            <small class="text-muted">
                                                @if($hasFiles)
                                                    <i class="far fa-folder"></i> {{ $documentFiles->count() }} archivo(s) subido(s)
                                                @else
                                                    <i class="fas fa-exclamation-circle"></i> Pendiente de subir
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    
                                    @if($hasFiles)
                                        <div class="uploaded-files ms-5">
                                            @foreach($documentFiles as $file)
                                                <div class="file-card mb-2 p-3 bg-white border rounded shadow-sm">
                                                    <div class="d-flex align-items-center">
                                                        <div class="file-icon me-3">
                                                            @php
                                                                $extension = strtolower($file->file_extension ?? '');
                                                                $iconColor = '#6c757d';
                                                                $iconClass = 'far fa-file';
                                                                
                                                                if (in_array($extension, ['pdf'])) {
                                                                    $iconColor = '#dc3545';
                                                                    $iconClass = 'fas fa-file-pdf';
                                                                } elseif (in_array($extension, ['doc', 'docx'])) {
                                                                    $iconColor = '#0d6efd';
                                                                    $iconClass = 'fas fa-file-word';
                                                                } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                                    $iconColor = '#198754';
                                                                    $iconClass = 'fas fa-file-image';
                                                                } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                                                    $iconColor = '#198754';
                                                                    $iconClass = 'fas fa-file-excel';
                                                                }
                                                            @endphp
                                                            <i class="{{ $iconClass }}" style="font-size: 32px; color: {{ $iconColor }};"></i>
                                                        </div>
                                                        <div class="file-info flex-grow-1">
                                                            <div class="file-name fw-bold">{{ $file->filename }}</div>
                                                            <div class="file-details small text-muted">
                                                                <span><i class="far fa-calendar-alt"></i> {{ $file->created_at->format('d/m/Y H:i') }}</span>
                                                                @if($file->filesize)
                                                                    <span class="ms-3"><i class="fas fa-weight-hanging"></i> {{ $file->getFormattedSizeAttribute() }}</span>
                                                                @endif
                                                                @if($file->file_extension)
                                                                    <span class="ms-3"><i class="fas fa-code"></i> {{ strtoupper($file->file_extension) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="file-actions">
                                                            <a href="{{ $file->getUrlAttribute() }}" 
                                                               target="_blank" 
                                                               class="btn btn-sm btn-outline-primary me-2"
                                                               title="Descargar archivo">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            <a href="{{ $file->getUrlAttribute() }}" 
                                                               target="_blank" 
                                                               class="btn btn-sm btn-outline-secondary"
                                                               title="Ver archivo">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <!-- Resumen de progreso -->
                            @php
                                $totalDocuments = count($requiredDocuments);
                                $uploadedCount = $uploadedFiles->count();
                                $progressPercentage = $totalDocuments > 0 ? round(($uploadedCount / $totalDocuments) * 100) : 0;
                                
                                $progressColor = 'danger';
                                if ($progressPercentage >= 80) {
                                    $progressColor = 'success';
                                } elseif ($progressPercentage >= 50) {
                                    $progressColor = 'warning';
                                } elseif ($progressPercentage >= 25) {
                                    $progressColor = 'info';
                                }
                            @endphp

                            <div class="bg-{{ $progressColor == 'danger' ? 'light' : $progressColor }}-subtle border border-{{ $progressColor }} rounded p-3 mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-chart-bar"></i>
                                        Progreso de Documentación
                                    </h6>
                                    <span class="badge bg-{{ $progressColor }}">{{ $uploadedCount }}/{{ $totalDocuments }}</span>
                                </div>
                                
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-{{ $progressColor }}" 
                                         role="progressbar" 
                                         style="width: {{ $progressPercentage }}%"
                                         aria-valuenow="{{ $progressPercentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-{{ $progressColor }}">
                                        <i class="fas fa-check"></i> {{ $uploadedCount }} documentos subidos
                                    </small>
                                    @if($totalDocuments - $uploadedCount > 0)
                                        <small class="text-muted">
                                            <i class="far fa-clock"></i> {{ $totalDocuments - $uploadedCount }} pendientes
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="far fa-file" style="font-size: 48px;"></i>
                                <p class="mt-3">No hay documentos requeridos configurados para este tipo de trámite.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Panel de Control -->
            <div class="col-md-5">
                <!-- Cambio de Estatus -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h6>
                            <i class="fas fa-cogs"></i>
                            Gestión de Estatus
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('urban_dev.requests.update', $urbanDevRequest) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Cambiar Estatus:</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="new" {{ $urbanDevRequest->status == 'new' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="entry" {{ $urbanDevRequest->status == 'entry' ? 'selected' : '' }}>Ingreso</option>
                                    <option value="validation" {{ $urbanDevRequest->status == 'validation' ? 'selected' : '' }}>Validación</option>
                                    <option value="requires_correction" {{ $urbanDevRequest->status == 'requires_correction' ? 'selected' : '' }}>Requiere Corrección</option>
                                    <option value="inspection" {{ $urbanDevRequest->status == 'inspection' ? 'selected' : '' }}>Inspección</option>
                                    <option value="resolved" {{ $urbanDevRequest->status == 'resolved' ? 'selected' : '' }}>Resolución</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Actualizar Estatus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Información de la Solicitud -->
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h6>
                            <i class="fas fa-info-circle"></i>
                            Detalles de la Solicitud
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Folio de Solicitud:</small>
                            <p class="mb-1 fw-bold">{{ $urbanDevRequest->folio ?? '#' . $urbanDevRequest->id }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Tipo de Trámite:</small>
                            <p class="mb-1">{{ $urbanDevRequest->getRequestTypeLabelAttribute() }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Estado Técnico:</small>
                            <code class="small">{{ $urbanDevRequest->status }}</code>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Fecha de Creación:</small>
                            <p class="mb-1">{{ $urbanDevRequest->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted">Última Actualización:</small>
                            <p class="mb-0">{{ $urbanDevRequest->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>

                        <!-- Información Adicional -->
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="fas fa-plus-circle"></i>
                                Información Adicional
                            </h6>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-primary mb-0" data-bs-toggle="modal" data-bs-target="#editDetailsModal">
                                    <i class="fas fa-edit"></i> Configurar
                                </button>
                            </div>
                        </div>

                        @if($urbanDevRequest->inspector_id)
                        <div class="mb-2">
                            <small class="text-muted">Inspector Asignado:</small>
                            <p class="mb-1">{{ $urbanDevRequest->inspector->name ?? 'No asignado' }}</p>
                            @if($urbanDevRequest->inspector_license_number)
                                <small class="text-muted">Licencia: {{ $urbanDevRequest->inspector_license_number }}</small>
                            @endif
                        </div>
                        @endif

                        @if($urbanDevRequest->inspection_start_date)
                        <div class="mb-2">
                            <small class="text-muted">Fecha de entrega a Inspector:</small>
                            <p class="mb-1">{{ $urbanDevRequest->inspection_start_date->format('d/m/Y') }}</p>
                        </div>
                        @endif

                        @if($urbanDevRequest->building_type)
                        <div class="mb-2">
                            <small class="text-muted">Tipo de Edificación:</small>
                            <p class="mb-1">{{ $urbanDevRequest->getBuildingTypeLabelAttribute() }}</p>
                        </div>
                        @endif

                        @if($urbanDevRequest->payment_date)
                        <div class="mb-2">
                            <small class="text-muted">Información de Pago:</small>
                            <p class="mb-1">
                                <strong>Fecha:</strong> {{ $urbanDevRequest->payment_date->format('d/m/Y') }}
                                @if($urbanDevRequest->payment_amount)
                                    <br><strong>Monto:</strong> ${{ number_format($urbanDevRequest->payment_amount, 2) }}
                                @endif
                            </p>
                            @if($urbanDevRequest->payment_ref_number_1 || $urbanDevRequest->payment_ref_number_2)
                                <small class="text-muted">
                                    @if($urbanDevRequest->payment_ref_number_1)
                                        Folio de Entero por Desarrollo: {{ $urbanDevRequest->payment_ref_number_1 }}
                                    @endif
                                    @if($urbanDevRequest->payment_ref_number_2)
                                        <br>Folio de Entero por Pagado: {{ $urbanDevRequest->payment_ref_number_2 }}
                                    @endif
                                </small>
                            @endif
                        </div>
                        @endif

                        @if($urbanDevRequest->inspection_validity_start && $urbanDevRequest->inspection_validity_end)
                        <div class="mb-2">
                            <small class="text-muted">Vigencia de Inspección:</small>
                            <p class="mb-1">
                                {{ $urbanDevRequest->inspection_validity_start->format('d/m/Y') }} - 
                                {{ $urbanDevRequest->inspection_validity_end->format('d/m/Y') }}
                            </p>
                            @php
                                $now = now();
                                $isValid = $now->between($urbanDevRequest->inspection_validity_start, $urbanDevRequest->inspection_validity_end);
                            @endphp
                            <span class="badge bg-{{ $isValid ? 'success' : 'danger' }}">
                                {{ $isValid ? 'Vigente' : 'Vencida' }}
                            </span>
                        </div>
                        @endif

                        @if(!$urbanDevRequest->inspector_id && !$urbanDevRequest->building_type && !$urbanDevRequest->payment_date)
                        <div class="text-center text-muted py-2">
                            <i class="fas fa-info-circle"></i>
                            <small>Haz clic en "Editar" para agregar información adicional</small>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Resumen de Archivos -->
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="text-white">
                            <i class="far fa-folder"></i>
                            Resumen de Archivos
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($urbanDevRequest->files->count() > 0)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Total de archivos:</span>
                                    <span class="badge bg-primary">{{ $urbanDevRequest->files->count() }}</span>
                                </div>
                            </div>
                            
                            @php
                                $totalSize = $urbanDevRequest->files->sum('filesize');
                                $formattedSize = 'N/A';
                                if ($totalSize) {
                                    if ($totalSize >= 1073741824) {
                                        $formattedSize = number_format($totalSize / 1073741824, 2) . ' GB';
                                    } elseif ($totalSize >= 1048576) {
                                        $formattedSize = number_format($totalSize / 1048576, 2) . ' MB';
                                    } elseif ($totalSize >= 1024) {
                                        $formattedSize = number_format($totalSize / 1024, 2) . ' KB';
                                    } else {
                                        $formattedSize = $totalSize . ' bytes';
                                    }
                                }
                            @endphp
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Tamaño total:</span>
                                    <span class="text-muted">{{ $formattedSize }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="small fw-bold">Archivos por tipo:</h6>
                                @php
                                    $fileTypes = $urbanDevRequest->files->groupBy('file_extension');
                                @endphp
                                @foreach($fileTypes as $extension => $files)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">{{ strtoupper($extension) }}</span>
                                        <span class="badge text-bg-secondary">{{ $files->count() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="far fa-file" style="font-size: 36px;"></i>
                                <p class="mt-2 mb-0">No hay archivos adjuntos</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Administrativas -->
                <div class="card mt-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="text-white">
                            <i class="fas fa-cog"></i>
                            Acciones Administrativas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('urban_dev.requests.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver al Listado
                            </a>

                            <a href="mailto:{{ $urbanDevRequest->user->email }}?subject=Solicitud de Desarrollo Urbano #{{ $urbanDevRequest->id }}" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-envelope"></i> Contactar Solicitante
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Detalles Adicionales -->
<div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDetailsModalLabel">
                    <i class="fas fa-edit"></i>
                    Editar Información Adicional
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('urban_dev.requests.update-details', $urbanDevRequest) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Inspector -->
                        <div class="col-md-6 mb-3">
                            <label for="inspector_id" class="form-label">Inspector Asignado</label>
                            <select name="inspector_id" id="inspector_id" class="form-select">
                                <option value="">Seleccionar Inspector</option>
                                @php
                                    // Obtener usuarios con rol de inspector o usuarios que pueden ser inspectores
                                    // Si no tienes roles específicos, puedes usar una consulta simple
                                    try {
                                        $inspectors = \App\Models\User::whereHas('roles', function($q) {
                                            $q->where('name', 'inspector');
                                        })->get();
                                    } catch (\Exception $e) {
                                        // Fallback: obtener algunos usuarios para testing
                                        $inspectors = \App\Models\User::limit(10)->get();
                                    }
                                @endphp
                                @foreach($inspectors as $inspector)
                                    <option value="{{ $inspector->id }}" {{ $urbanDevRequest->inspector_id == $inspector->id ? 'selected' : '' }}>
                                        {{ $inspector->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Número de Licencia del Inspector -->
                        <div class="col-md-6 mb-3">
                            <label for="inspector_license_number" class="form-label">Número de Licencia</label>
                            <input type="text" name="inspector_license_number" id="inspector_license_number" 
                                   class="form-control" value="{{ $urbanDevRequest->inspector_license_number }}"
                                   placeholder="Número de licencia del inspector">
                        </div>

                        <!-- Fecha de entrega a Inspector -->
                        <div class="col-md-6 mb-3">
                            <label for="inspection_start_date" class="form-label">Fecha de entrega a Inspector</label>
                            <input type="date" name="inspection_start_date" id="inspection_start_date" 
                                   class="form-control" value="{{ $urbanDevRequest->inspection_start_date?->format('Y-m-d') }}">
                        </div>

                        <!-- Tipo de Edificación -->
                        <div class="col-md-6 mb-3">
                            <label for="building_type" class="form-label">Tipo de Edificación</label>
                            <select name="building_type" id="building_type" class="form-select">
                                <option value="">Seleccionar tipo</option>
                                <option value="casa_habitacion" {{ $urbanDevRequest->building_type == 'casa_habitacion' ? 'selected' : '' }}>Casa Habitación</option>
                                <option value="bodega" {{ $urbanDevRequest->building_type == 'bodega' ? 'selected' : '' }}>Bodega</option>
                                <option value="local_comercial" {{ $urbanDevRequest->building_type == 'local_comercial' ? 'selected' : '' }}>Local Comercial</option>
                                <option value="otro" {{ $urbanDevRequest->building_type == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>

                        <!-- Información de Pago -->
                        <div class="col-12 mb-3">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-money-bill"></i>
                                Información de Pago
                            </h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="payment_date" class="form-label">Fecha de Pago</label>
                            <input type="date" name="payment_date" id="payment_date" 
                                   class="form-control" value="{{ $urbanDevRequest->payment_date?->format('Y-m-d') }}">
                        </div>

                        @if(isset($costOptions) && $costOptions->isNotEmpty())
                            <div class="col-md-8 mb-3">
                                <label for="urban_dev_cost_id" class="form-label">
                                    Concepto de costo <small class="text-muted">(define el monto del pago en línea)</small>
                                </label>
                                <select name="urban_dev_cost_id" id="urban_dev_cost_id" class="form-select">
                                    <option value="">Sin concepto asignado</option>
                                    @foreach($costOptions as $opt)
                                        <option value="{{ $opt->id }}" data-amount="{{ $opt->amount }}"
                                            {{ $urbanDevRequest->urban_dev_cost_id == $opt->id ? 'selected' : '' }}>
                                            {{ $opt->description }} — {{ $opt->formatted_price }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label for="payment_amount" class="form-label">Monto</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="payment_amount" id="payment_amount"
                                       class="form-control" step="0.01" value="{{ $urbanDevRequest->payment_amount }}"
                                       placeholder="0.00">
                            </div>
                        </div>

                        @if(isset($costOptions) && $costOptions->isNotEmpty())
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const sel = document.getElementById('urban_dev_cost_id');
                                    const amt = document.getElementById('payment_amount');
                                    if (sel && amt) {
                                        sel.addEventListener('change', function () {
                                            const a = this.options[this.selectedIndex].getAttribute('data-amount');
                                            if (a) amt.value = a;
                                        });
                                    }
                                });
                            </script>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label for="payment_ref_number_1" class="form-label">Folio de Entero por Desarrollo</label>
                            <input type="text" name="payment_ref_number_1" id="payment_ref_number_1" 
                                   class="form-control" value="{{ $urbanDevRequest->payment_ref_number_1 }}"
                                   placeholder="Número de referencia">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="payment_ref_number_2" class="form-label">Folio de Entero Pagado</label>
                            <input type="text" name="payment_ref_number_2" id="payment_ref_number_2" 
                                   class="form-control" value="{{ $urbanDevRequest->payment_ref_number_2 }}"
                                   placeholder="Número de referencia adicional">
                        </div>

                        <!-- Vigencia de Inspección -->
                        @php
                            $isInspector = false;
                            try {
                                $isInspector = auth()->user()->hasRole('inspector');
                            } catch (\Exception $e) {
                                // Fallback: verificar si el usuario tiene 'inspector' en alguna relación
                                $isInspector = false;
                            }
                        @endphp
                        
                        @if(!$isInspector)
                        <div class="col-12 mb-3">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-calendar-check"></i>
                                Vigencia de Inspección
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="inspection_validity_start" class="form-label">Fecha de Inicio</label>
                            <input type="date" name="inspection_validity_start" id="inspection_validity_start" 
                                   class="form-control" value="{{ $urbanDevRequest->inspection_validity_start?->format('Y-m-d') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="inspection_validity_end" class="form-label">Fecha de Vencimiento</label>
                            <input type="date" name="inspection_validity_end" id="inspection_validity_end" 
                                   class="form-control" value="{{ $urbanDevRequest->inspection_validity_end?->format('Y-m-d') }}">
                        </div>
                        @else
                        @if($urbanDevRequest->inspection_validity_start && $urbanDevRequest->inspection_validity_end)
                        <div class="col-12 mb-3">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-calendar-check"></i>
                                Vigencia de Inspección
                            </h6>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="alert alert-light border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Fecha de Inicio:</small>
                                        <p class="mb-0 fw-bold">{{ $urbanDevRequest->inspection_validity_start->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Fecha de Vencimiento:</small>
                                        <p class="mb-0 fw-bold">{{ $urbanDevRequest->inspection_validity_end->format('d/m/Y') }}</p>
                                        @php
                                            $now = now();
                                            $isValid = $now->between($urbanDevRequest->inspection_validity_start, $urbanDevRequest->inspection_validity_end);
                                        @endphp
                                        <span class="badge bg-{{ $isValid ? 'success' : 'danger' }} mt-1">
                                            {{ $isValid ? 'Vigente' : 'Vencida' }}
                                        </span>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle"></i>
                                    Solo administradores pueden modificar la vigencia de inspección.
                                </small>
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<style>
.file-card {
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.file-card:hover {
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.file-icon {
    transition: transform 0.3s ease;
}

.file-card:hover .file-icon {
    transform: scale(1.1);
}

.file-actions .btn {
    min-width: 90px;
}

.file-info h6 {
    color: #333;
    font-weight: 600;
}

.file-card .badge {
    font-size: 0.75em;
}

/* Animación para botones */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Mejoras para iconos FontAwesome */
.fas, .far {
    margin-right: 0.25rem;
}

.card-header .fas,
.card-header .far {
    margin-right: 0.5rem;
}

/* Responsive para tarjetas de archivos */
@media (max-width: 576px) {
    .file-card .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .file-actions {
        width: 100%;
        margin-top: 15px;
    }
    
    .file-actions .btn-group-vertical {
        width: 100%;
        flex-direction: row !important;
    }
    
    .file-actions .btn {
        flex: 1;
    }
}

/* Estilos para modal de previsualización */
.modal-dialog {
    margin: 1rem auto;
}

.modal-xl {
    max-width: 90vw;
}

.modal-lg {
    max-width: 80vw;
}

/* Mejoras para el preview de imágenes */
.modal-body img {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.modal-body img:hover {
    transform: scale(1.02);
}

/* Estilos para iframe de PDF */
.modal-body iframe {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Loading state para imágenes */
.modal-body img {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-body img.loaded {
    opacity: 1;
}

/* Mejoras para badges en Bootstrap 5 */
.badge {
    --bs-badge-font-size: 0.75em;
}

/* Acordeón del Formato Único de Solicitud (estilo teal) */
.formato-accordion .accordion-button {
    background-color: #4d8f8b;
    color: #fff;
    font-weight: 600;
}

.formato-accordion .accordion-button:not(.collapsed) {
    background-color: #3f7773;
    color: #fff;
    box-shadow: none;
}

.formato-accordion .accordion-button:focus {
    box-shadow: none;
    border-color: transparent;
}

.formato-accordion .accordion-button::after {
    filter: brightness(0) invert(1);
}

.formato-accordion .accordion-item {
    border: none;
    margin-bottom: 8px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Funcionalidad de previsualización de archivos
    window.previewFile = function(url, filename, extension) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'filePreviewModal';
        modal.setAttribute('tabindex', '-1');
        
        let modalContent = '';
        
        if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(extension.toLowerCase())) {
            // Preview para imágenes
            modalContent = `
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-image"></i> ${filename}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="${url}" class="img-fluid" alt="${filename}" style="max-height: 70vh;">
                        </div>
                        <div class="modal-footer">
                            <a href="${url}" download="${filename}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            `;
        } else if (extension.toLowerCase() === 'pdf') {
            // Preview para PDFs
            modalContent = `
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-file-pdf"></i> ${filename}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe src="${url}" style="width: 100%; height: 70vh;" frameborder="0"></iframe>
                        </div>
                        <div class="modal-footer">
                            <a href="${url}" download="${filename}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <a href="${url}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Para otros tipos de archivo, solo mostrar información
            modalContent = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="far fa-file"></i> ${filename}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <i class="far fa-file" style="font-size: 64px; color: #6c757d;"></i>
                            <h6 class="mt-3">${filename}</h6>
                            <p class="text-muted">Tipo de archivo: ${extension.toUpperCase()}</p>
                            <p class="small text-muted">Este tipo de archivo no puede ser previsualizado en el navegador.</p>
                        </div>
                        <div class="modal-footer">
                            <a href="${url}" download="${filename}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <a href="${url}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        modal.innerHTML = modalContent;
        document.body.appendChild(modal);
        
        // Mostrar el modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        // Limpiar el DOM cuando se cierre el modal
        modal.addEventListener('hidden.bs.modal', function() {
            document.body.removeChild(modal);
        });
    };
    
    // Funcionalidad de descarga masiva
    window.downloadAllFiles = function() {
        const files = @json($urbanDevRequest->files->map(function($file) {
            return [
                'name' => $file->name,
                'url' => $file->getUrlAttribute()
            ];
        })->filter(function($file) {
            return !empty($file['url']);
        })->values());
        
        if (files.length === 0) {
            alert('No hay archivos disponibles para descargar');
            return;
        }
        
        // Mostrar confirmación
        if (!confirm(`¿Deseas descargar ${files.length} archivo(s)?`)) {
            return;
        }
        
        // Crear un indicador de progreso
        const progressDiv = document.createElement('div');
        progressDiv.innerHTML = `
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Descargando archivos...</strong> 
                <span id="downloadProgress">0/${files.length}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.querySelector('.card-body').prepend(progressDiv);
        
        // Descargar archivos uno por uno
        files.forEach(function(file, index) {
            setTimeout(function() {
                const link = document.createElement('a');
                link.href = file.url;
                link.download = file.name;
                link.target = '_blank';
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // Actualizar progreso
                const progressSpan = document.getElementById('downloadProgress');
                if (progressSpan) {
                    progressSpan.textContent = `${index + 1}/${files.length}`;
                    
                    // Remover el indicador cuando termine
                    if (index === files.length - 1) {
                        setTimeout(() => {
                            progressDiv.remove();
                        }, 2000);
                    }
                }
            }, index * 500); // Retrasar 500ms entre descargas
        });
    };
    
    // Funcionalidad de exportar PDF (placeholder)
    window.exportToPDF = function() {
        // Esta función se puede implementar con una librería como jsPDF
        alert('Funcionalidad de exportar PDF en desarrollo');
    };
});

// Script para el modal de edición de detalles
document.addEventListener('DOMContentLoaded', function() {
    // Validación de fechas de vigencia (solo si los campos existen y son editables)
    const validityStart = document.getElementById('inspection_validity_start');
    const validityEnd = document.getElementById('inspection_validity_end');
    
    // Solo aplicar validaciones si ambos campos existen (es decir, el usuario puede editarlos)
    if (validityStart && validityEnd) {
        validityStart.addEventListener('change', function() {
            validityEnd.min = this.value;
            if (validityEnd.value && validityEnd.value < this.value) {
                validityEnd.value = '';
            }
        });
        
        // Validar que la fecha de fin sea mayor que la de inicio
        const modal = document.getElementById('editDetailsModal');
        if (modal) {
            modal.addEventListener('submit', function(e) {
                const startDate = validityStart?.value;
                const endDate = validityEnd?.value;
                
                if (startDate && endDate && new Date(endDate) <= new Date(startDate)) {
                    e.preventDefault();
                    alert('La fecha de vencimiento debe ser posterior a la fecha de inicio.');
                    return false;
                }
            });
        }
    }
    
    // Auto-completar algunos campos según el tipo de edificación
    const buildingType = document.getElementById('building_type');
    if (buildingType) {
        buildingType.addEventListener('change', function() {
            // Aquí se pueden agregar sugerencias automáticas
            // Por ejemplo, duración típica de inspección según el tipo
        });
    }
});
</script>
@endsection
@endsection
