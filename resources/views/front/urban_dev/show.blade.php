@extends('front.layouts.app')

@section('content')
<div class="container">
    @php
        // Configuración de trámites con sus pasos específicos
        $tramites_config = [
            'uso-de-suelo' => [
                'title' => 'Licencia de Uso de Suelo',
                'description' => 'Solicitud para determinar el uso de suelo permitido en un predio específico según la zonificación municipal.',
                'icon' => 'map-outline',
                'color' => 'info',
                'legal_base' => 'Artículos 256, 257, 258, 259, 261, 262 y 264 del Código Territorial para el Estado y los Municipios de Guanajuato',
                'costs' => [
                    ['description' => 'Uso habitacional, por vivienda', 'price' => '$771.00'],
                    ['description' => 'Uso comercial, por local comercial', 'price' => '$900.00'],
                    ['description' => 'Uso industrial, por predio', 'price' => '$2,100.00']
                ],
                'steps' => [
                    'Presentar solicitud por escrito dirigida al Director de Desarrollo Urbano',
                    'Anexar copia de identificación oficial vigente del propietario o representante legal',
                    'Presentar escritura pública o documento que acredite la propiedad del inmueble',
                    'Entregar copia del último recibo de pago del impuesto predial',
                    'Proporcionar plano de localización del predio (escala 1:1000)',
                    'Incluir croquis de ubicación con referencias y medidas del terreno',
                    'Realizar pago de derechos correspondientes en Tesorería Municipal',
                    'Programar inspección técnica del predio por parte del personal municipal',
                    'Esperar resolución y entrega de la licencia (15 días hábiles)'
                ]
            ],
            'constancia-de-factibilidad' => [
                'title' => 'Constancia de Factibilidad',
                'description' => 'Documento que certifica la viabilidad técnica y legal para desarrollar un proyecto específico en el predio.',
                'icon' => 'checkmark-circle-outline',
                'color' => 'warning',
                'legal_base' => 'Artículos 253, 254 y 255 del Código Territorial para el Estado y los Municipios de Guanajuato',
                'costs' => [
                    ['description' => 'Por metro cuadrado de construcción proyectada', 'price' => '$12.50'],
                    ['description' => 'Revisión de proyecto arquitectónico', 'price' => '$1,250.00'],
                    ['description' => 'Inspección técnica especializada', 'price' => '$850.00']
                ],
                'steps' => [
                    'Presentar solicitud detallada del proyecto a desarrollar',
                    'Adjuntar proyecto arquitectónico o memoria descriptiva de la obra',
                    'Entregar escritura pública que acredite la propiedad del inmueble',
                    'Incluir plano topográfico actualizado del terreno',
                    'Presentar estudio de factibilidad de servicios públicos',
                    'Anexar dictamen de uso de suelo vigente',
                    'Realizar pago de derechos en Tesorería Municipal',
                    'Someterse a revisión técnica por parte de la Dirección de Obras Públicas',
                    'Obtener resolución favorable y entrega del documento (20 días hábiles)'
                ]
            ],
            'permiso-de-anuncios' => [
                'title' => 'Permiso de Anuncios y Toldos',
                'description' => 'Autorización para la instalación y operación de elementos publicitarios y toldos en el municipio.',
                'icon' => 'megaphone-outline',
                'color' => 'primary',
                'legal_base' => 'Artículos 168-183 del Reglamento de Construcción de Valle de Santiago, Gto.',
                'costs' => [
                    ['description' => 'Anuncio menor a 4 m² (por año)', 'price' => '$450.00'],
                    ['description' => 'Anuncio de 4 a 20 m² (por año)', 'price' => '$890.00'],
                    ['description' => 'Anuncio mayor a 20 m² (por año)', 'price' => '$1,780.00']
                ],
                'steps' => [
                    'Presentar solicitud especificando tipo y características del anuncio',
                    'Adjuntar diseño gráfico y especificaciones técnicas del anuncio',
                    'Entregar documento que acredite la propiedad o autorización del inmueble',
                    'Incluir memoria de cálculo estructural (anuncios mayores a 4 m²)',
                    'Presentar plano de localización y ubicación exacta del anuncio',
                    'Anexar fotografías del lugar donde se instalará',
                    'Realizar pago de derechos correspondientes',
                    'Programar inspección para verificar cumplimiento de normativas',
                    'Recibir permiso y cumplir con renovación anual'
                ]
            ],
            'certificacion-numero-oficial' => [
                'title' => 'Certificación de Número Oficial',
                'description' => 'Asignación oficial del número que corresponde a un predio según su ubicación y normativa municipal.',
                'icon' => 'home-outline',
                'color' => 'dark',
                'legal_base' => 'Artículos 68 y 72 del Reglamento de Construcción y Fisionomía para el Municipio de Valle de Santiago',
                'costs' => [
                    ['description' => 'Certificación de número oficial', 'price' => '$385.00']
                ],
                'steps' => [
                    'Presentar solicitud dirigida al Director de Desarrollo Urbano',
                    'Entregar escritura pública o documento de propiedad del inmueble',
                    'Adjuntar constancia de alineamiento y número oficial vigente',
                    'Incluir plano de localización del predio con medidas exactas',
                    'Presentar identificación oficial del propietario o representante',
                    'Anexar último recibo de pago del impuesto predial',
                    'Realizar pago de derechos en Tesorería Municipal',
                    'Permitir inspección técnica para verificación de ubicación',
                    'Recibir certificación oficial (10 días hábiles)'
                ]
            ],
            'permiso-de-division' => [
                'title' => 'Permiso de División',
                'description' => 'Autorización para dividir un predio en fracciones menores conforme a la normativa territorial vigente.',
                'icon' => 'resize-outline',
                'color' => 'success',
                'legal_base' => 'Artículos 395, 397 y 398 del Código Territorial para el Estado y sus Municipios de Guanajuato',
                'costs' => [
                    ['description' => 'División simple (hasta 5 lotes)', 'price' => '$2,850.00'],
                    ['description' => 'División compleja (más de 5 lotes)', 'price' => '$4,200.00']
                ],
                'steps' => [
                    'Presentar solicitud con proyecto de división del predio',
                    'Entregar escritura pública que acredite la propiedad del terreno',
                    'Adjuntar levantamiento topográfico certificado por perito autorizado',
                    'Incluir proyecto de lotificación con vialidades y servicios',
                    'Presentar dictamen de factibilidad de servicios públicos',
                    'Anexar estudio de impacto urbano y vial',
                    'Realizar pago de derechos y contribuciones correspondientes',
                    'Cumplir con obras de urbanización requeridas',
                    'Obtener autorización final e inscripción en Registro Público'
                ]
            ],
            'uso-de-via-publica' => [
                'title' => 'Uso de Vía Pública',
                'description' => 'Permiso temporal o permanente para ocupar espacios de vía pública con fines específicos.',
                'icon' => 'car-outline',
                'color' => 'info',
                'legal_base' => 'Artículos 53, 54, 55 y 56 del Reglamento de Construcción de Valle de Santiago',
                'costs' => [
                    ['description' => 'Por metro cuadrado por día', 'price' => '$15.50'],
                    ['description' => 'Permiso mensual (hasta 50 m²)', 'price' => '$650.00'],
                    ['description' => 'Por metro cuadrado excedente a 50 m²', 'price' => '$8.36']
                ],
                'steps' => [
                    'Presentar solicitud especificando el uso y tiempo requerido',
                    'Adjuntar croquis del área a ocupar con medidas exactas',
                    'Entregar programa de actividades y horarios de ocupación',
                    'Incluir medidas de seguridad y señalización propuestas',
                    'Presentar póliza de seguro de responsabilidad civil',
                    'Anexar autorización de vecinos afectados (si aplica)',
                    'Realizar pago de derechos por ocupación de vía pública',
                    'Cumplir con supervisión continua durante el período autorizado',
                    'Restituir las condiciones originales al término del permiso'
                ]
            ],
            'licencia-de-construccion' => [
                'title' => 'Licencia de Construcción',
                'description' => 'Autorización oficial para realizar obras de construcción, modificación o ampliación de inmuebles.',
                'icon' => 'construct-outline',
                'color' => 'danger',
                'legal_base' => 'Artículo 24 fracciones I inc. a2a y a2b del Reglamento de Construcción de Valle de Santiago',
                'costs' => [
                    ['description' => 'Construcción habitacional (por m²)', 'price' => '$18.75'],
                    ['description' => 'Construcción comercial (por m²)', 'price' => '$24.50'],
                    ['description' => 'Construcción industrial (por m²)', 'price' => '$32.80']
                ],
                'steps' => [
                    'Presentar solicitud con proyecto arquitectónico completo',
                    'Entregar planos estructurales firmados por Director Responsable de Obra',
                    'Adjuntar memoria de cálculo y especificaciones técnicas',
                    'Incluir dictamen de uso de suelo compatible con el proyecto',
                    'Presentar factibilidades de servicios (agua, drenaje, electricidad)',
                    'Anexar estudio de mecánica de suelos (construcciones mayores)',
                    'Realizar pago de licencia y derechos de supervisión',
                    'Programar inspecciones durante el proceso constructivo',
                    'Obtener visto bueno final y recepción de obra'
                ]
            ],
            'permiso-construccion-panteones' => [
                'title' => 'Permiso de Construcción en Panteones',
                'description' => 'Autorización especial para realizar construcciones funerarias dentro de cementerios municipales.',
                'icon' => 'flower-outline',
                'color' => 'primary',
                'legal_base' => 'Artículos 13, 46, 50, 56 y 57 del Reglamento de Panteones y Cementerios del Municipio',
                'costs' => [
                    ['description' => 'Por metro cuadrado excedente a 40 m²', 'price' => '$8.36']
                ],
                'steps' => [
                    'Presentar solicitud dirigida a la Administración del Panteón',
                    'Adjuntar proyecto de la construcción funeraria propuesta',
                    'Entregar documento que acredite la propiedad o concesión del lote',
                    'Incluir especificaciones de materiales y acabados a utilizar',
                    'Presentar plano de ubicación dentro del cementerio',
                    'Anexar autorización de familiares o herederos legales',
                    'Realizar pago de derechos de construcción en panteón',
                    'Cumplir con horarios y normativas especiales del cementerio',
                    'Recibir inspección final y autorización de uso'
                ]
            ]
        ];

        $tramite_actual = $tramites_config[$tramite] ?? null;
    @endphp

    @if($tramite_actual)
        <!-- Header del trámite -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-5.jpg') }}" alt="">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <div class="d-flex align-items-center mb-3">
                            <div class="card-icon card-icon-static bg-{{ $tramite_actual['color'] }} text-white d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <ion-icon name="{{ $tramite_actual['icon'] }}" style="font-size: 30px;"></ion-icon>
                            </div>
                            <div>
                                <h2 class="mb-0">{{ $tramite_actual['title'] }}</h2>
                                <p class="mb-0">Desarrollo Urbano - Valle de Santiago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción del trámite -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card wow fadeInUp">
                    <div class="card-body">
                        <h4 class="mb-3">Descripción del Trámite</h4>
                        <p class="mb-4">{{ $tramite_actual['description'] }}</p>
                        
                        <div class="alert alert-info">
                            <h6 class="mb-2"><i class="fas fa-gavel"></i> Fundamento Legal</h6>
                            <p class="mb-0">{{ $tramite_actual['legal_base'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pasos del trámite -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card wow fadeInUp">
                    <div class="card-body">
                        <h4 class="mb-4">Pasos para Completar el Trámite</h4>
                        
                        <div class="process-timeline">
                            @foreach($tramite_actual['steps'] as $index => $step)
                                <div class="timeline-item wow fadeInLeft" data-wow-delay="{{ $index * 0.1 }}s">
                                    <div class="timeline-marker bg-{{ $tramite_actual['color'] }}">
                                        <span class="step-number">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="card border-left-{{ $tramite_actual['color'] }}">
                                            <div class="card-body">
                                                <h6 class="mb-2">Paso {{ $index + 1 }}</h6>
                                                <p class="mb-0">{{ $step }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información importante -->
        {{--  
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-warning wow fadeInUp">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Documentos Importantes</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Identificación oficial vigente</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Documentos de propiedad</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Comprobante de pago predial</li>
                            <li class="mb-0"><i class="fas fa-check text-success"></i> Planos y proyectos técnicos</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-info wow fadeInUp">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-clock"></i> Tiempos de Respuesta</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Revisión inicial:</strong> 3-5 días hábiles
                        </div>
                        <div class="mb-3">
                            <strong>Inspección técnica:</strong> 5-7 días hábiles
                        </div>
                        <div class="mb-0">
                            <strong>Resolución final:</strong> 10-20 días hábiles
                        </div>
                    </div>
                </div>
            </div>
        </div>
        --}}

        <!-- Costos del trámite -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-success wow fadeInUp">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-money-bill"></i> Costos del Trámite</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            @foreach($tramite_actual['costs'] as $index => $cost)
                                <div class="col-md-{{ count($tramite_actual['costs']) == 1 ? '12' : (count($tramite_actual['costs']) == 2 ? '6' : '4') }} mb-3">
                                    <div class="cost-item text-center p-3 border rounded">
                                        <div class="cost-letter text-{{ $tramite_actual['color'] }} fw-bold mb-2">
                                            {{ chr(97 + $index) }})
                                        </div>
                                        <h6 class="cost-description mb-2">{{ $cost['description'] }}</h6>
                                        <div class="cost-price h4 text-success mb-0">{{ $cost['price'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <div class="display-6 text-info mb-2"><i class="fas fa-clock"></i></div>
                                    <h6>Tiempo Promedio</h6>
                                    <p class="text-muted">15-20 días hábiles</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <div class="display-6 text-warning mb-2"><i class="fas fa-file-alt"></i></div>
                                    <h6>Documentos</h6>
                                    <p class="text-muted">{{ count($tramite_actual['steps']) }} requisitos</p>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <h6 class="mb-2"><i class="fas fa-info-circle"></i> Información Importante</h6>
                            <p class="mb-0">Los costos están basados en la Ley de Ingresos vigente del Municipio de Valle de Santiago. Los precios pueden variar según actualizaciones periódicas. Para información actualizada, consulte en Tesorería Municipal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de acción -->
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <div class="card wow fadeInUp">
                    <div class="card-body py-5">
                        <h4 class="mb-3">¿Listo para iniciar tu trámite?</h4>
                        <p class="mb-4">Una vez que tengas todos los documentos listos, puedes iniciar el proceso en línea.</p>

                        <a href="{{ route('citizen.urban_dev.create') }}" class="btn btn-{{ $tramite_actual['color'] }} btn-lg px-5 py-3">
                            <ion-icon name="documents-outline" class="me-2"></ion-icon>
                            Iniciar Trámite
                        </a>

                        <p class="mt-2"><small>Para los trámites debes Iniciar Sesión y tener una cuenta en nuestro sistema. Registrate <a href="{{ route('register') }}">aquí</a></small></p>

                        <div class="mt-3">
                            <a href="{{ route('urban_dev.index') }}" class="btn btn-outline-secondary">
                                <ion-icon name="arrow-back-outline" class="me-2"></ion-icon>
                                Volver a Trámites
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Error: Trámite no encontrado -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body py-5">
                        <div class="display-1 text-muted mb-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4>Trámite no encontrado</h4>
                        <p class="text-muted mb-4">El trámite solicitado no existe o no está disponible.</p>
                        <a href="{{ route('urban_dev.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Volver a Trámites
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.process-timeline {
    position: relative;
    padding-left: 30px;
}

.process-timeline::before {
    content: '';
    position: absolute;
    left: 25px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #007bff, #28a745);
    border-radius: 2px;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 10px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    z-index: 10;
}

.step-number {
    color: white;
    font-weight: bold;
    font-size: 18px;
}

.timeline-content {
    margin-left: 40px;
}

.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}

.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}

.border-left-primary {
    border-left: 4px solid #007bff !important;
}

.border-left-danger {
    border-left: 4px solid #dc3545 !important;
}

.border-left-success {
    border-left: 4px solid #28a745 !important;
}

.border-left-dark {
    border-left: 4px solid #343a40 !important;
}

.cost-item {
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.cost-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.cost-letter {
    font-size: 1.2rem;
    font-weight: 700;
}

.cost-description {
    color: #495057;
    font-size: 0.95rem;
    line-height: 1.3;
}

.cost-price {
    font-weight: 700;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.card-image-banner {
    position: relative;
    min-height: 250px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.4);
    border-radius: inherit;
}

.card-content {
    position: absolute;
    bottom: 30px;
    left: 30px;
    right: 30px;
    color: white;
    z-index: 10;
}

.card-icon-static {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .process-timeline {
        padding-left: 20px;
    }
    
    .timeline-marker {
        left: -25px;
        width: 40px;
        height: 40px;
    }
    
    .step-number {
        font-size: 16px;
    }
    
    .timeline-content {
        margin-left: 30px;
    }
}
</style>
@endsection