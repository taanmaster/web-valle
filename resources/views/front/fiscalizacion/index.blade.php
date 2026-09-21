@extends('front.layouts.app')

@section('content')
    <div class="container">

        @include('front.fiscalizacion.utilities._nav')

        {{-- Encabezado --}}
        <div class="d-flex align-items-center justify-content-between mb-4 wow fadeInUp">
            <h2 class="text-primary fw-bold mb-0">FISCALIZACIÓN</h2>
        </div>

        {{-- Banner Principal --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-3.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Bienvenidos a la página oficial de</p>
                        <h1 class="display-1 mb-0">Fiscalización</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- Misión / Visión --}}
        <div class="row mb-5 g-3">
            <div class="col-md-6">
                <div class="rounded-4 p-4 h-100 wow fadeInUp" style="background-color: #E0D4F5;">
                    <h3 class="fw-bold mb-3">Misión</h3>
                    <p class="mb-0">Regular y ordenar las actividades comerciales y de servicios que se desarrollan en
                        el municipio de Valle de Santiago, mediante una fiscalización cercana, objetiva y preventiva,
                        que promueva el cumplimiento de las disposiciones municipales, facilite la actividad económica
                        formal y contribuya a una convivencia ordenada en los espacios públicos. La misión coloca a
                        Fiscalización no únicamente como un área sancionadora, sino como una autoridad municipal que
                        orienta, verifica y actúa cuando es necesario. El propósito es que el comerciante conozca sus
                        obligaciones y que la ciudadanía tenga certeza de que las reglas se aplican de manera
                        uniforme.</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="rounded-4 h-100 wow fadeInUp d-flex align-items-center justify-content-center bg-light border"
                    data-wow-delay="0.1s">
                    <ion-icon name="image-outline" style="font-size: 3rem;" class="text-muted"></ion-icon>
                </div>
            </div>

            <div class="col-md-6 order-md-1">
                <div class="rounded-4 h-100 wow fadeInUp d-flex align-items-center justify-content-center bg-light border">
                    <ion-icon name="image-outline" style="font-size: 3rem;" class="text-muted"></ion-icon>
                </div>
            </div>

            <div class="col-md-6 order-md-2">
                <div class="rounded-4 p-4 h-100 wow fadeInUp" data-wow-delay="0.1s" style="background-color: #E0D4F5;">
                    <h3 class="fw-bold mb-3">Visión</h3>
                    <p class="mb-0">Consolidar un área de Fiscalización reconocida en Valle de Santiago por su orden,
                        profesionalismo, imparcialidad y capacidad de respuesta; con procedimientos claros, personal
                        capacitado y presencia efectiva en el municipio, que contribuya al crecimiento ordenado del
                        comercio y al respeto de los espacios públicos. La visión busca que la percepción del área
                        evolucione de una fiscalización principalmente reactiva hacia un modelo de prevención,
                        orientación y seguimiento, sin perder la firmeza necesaria ante incumplimientos.</p>
                </div>
            </div>
        </div>

        {{-- Nuestros Valores --}}
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold mb-0">Nuestros Valores</h3>
            </div>

            <div class="col-12">
                <div class="row row-cols-2 row-cols-md-4 g-3">
                    @php
                        $valores = [
                            [
                                'nombre' => 'Legalidad',
                                'color' => '#dc3545',
                                'tint' => '#FFCCD0',
                                'texto' =>
                                    'Toda actuación deberá realizarse con fundamento en las disposiciones aplicables, respetando las atribuciones y procedimientos establecidos.',
                            ],
                            [
                                'nombre' => 'Imparcialidad',
                                'color' => '#fd7e14',
                                'tint' => '#FDDCB5',
                                'texto' =>
                                    'Aplicar los mismos criterios a comerciantes y establecimientos, evitando favoritismos o diferencias de trato.',
                            ],
                            [
                                'nombre' => 'Respeto',
                                'color' => '#ffc107',
                                'tint' => '#FFF8B0',
                                'texto' =>
                                    'Mantener un trato digno y profesional hacia comerciantes, usuarios, visitantes y compañeros de trabajo.',
                            ],
                            [
                                'nombre' => 'Transparencia',
                                'color' => '#198754',
                                'tint' => '#C8EAC8',
                                'texto' =>
                                    'Explicar de manera clara los requisitos, motivos de las inspecciones, medidas y procedimientos que correspondan.',
                            ],
                            [
                                'nombre' => 'Honestidad',
                                'color' => '#20c997',
                                'tint' => '#C8EDE4',
                                'texto' =>
                                    'Rechazar cualquier práctica que pueda comprometer la integridad del servicio público.',
                            ],
                            [
                                'nombre' => 'Prevención',
                                'color' => '#0d6efd',
                                'tint' => '#DDE8F8',
                                'texto' =>
                                    'Priorizar la orientación y corrección oportuna cuando la naturaleza de la irregularidad permita atenderla de esa manera.',
                            ],
                            [
                                'nombre' => 'Orden',
                                'color' => '#6f42c1',
                                'tint' => '#E0D4F5',
                                'texto' =>
                                    'Mantener registros, recorridos, actas, expedientes y seguimiento de asuntos de forma sistemática.',
                            ],
                            [
                                'nombre' => 'Servicio',
                                'color' => '#d63384',
                                'tint' => '#F9D0EA',
                                'texto' =>
                                    'Entender la fiscalización como una función pública al servicio del municipio y de su comunidad.',
                            ],
                        ];
                    @endphp

                    @foreach ($valores as $index => $valor)
                        <div class="col wow fadeInUp" data-wow-delay="{{ 0.05 * $index }}s">
                            <div class="valor-item">
                                <span class="rounded-pill text-white fw-bold text-center py-2 px-3 w-100 valor-pill"
                                    style="background-color: {{ $valor['color'] }};">
                                    {{ $valor['nombre'] }}
                                </span>
                                <div class="rounded-4 p-3 valor-desc"
                                    style="background-color: {{ $valor['tint'] }};">
                                    <p class="mb-0 small">{{ $valor['texto'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Trámites de Fiscalización --}}
        <div class="row mb-4">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold mb-0">Trámites de Fiscalización</h3>
            </div>
        </div>

        @php
            $tramites = [
                [
                    'titulo' => 'Permiso de Venta en Vía Pública',
                    'vigencia' => '3 meses (renovable)',
                    'visitas' => '3 o más',
                    'pasos' => [
                        [
                            'titulo' => 'Solicita tu permiso.',
                            'texto' => 'Llena el formato de solicitud y anexa fotografías del espacio que deseas ocupar.',
                        ],
                        [
                            'titulo' => 'Visita de verificación.',
                            'texto' => 'Un inspector acudirá al lugar para confirmar si el espacio es adecuado.',
                        ],
                        [
                            'titulo' => 'Recibe tu resultado.',
                            'texto' => 'Te informaremos si tu solicitud fue aprobada.',
                        ],
                        [
                            'titulo' => 'Recoge tu permiso.',
                            'texto' =>
                                'Si fue aprobada, acude a Fiscalización para firmar y recibir tu Permiso Provisional de Ocupación de Vía Pública.',
                        ],
                    ],
                    'tarifa' =>
                        '$5.00 a $50.00 por día, por metro cuadrado (vendedores ambulantes, semifijos y tianguistas). Ver tabla completa de tarifas en la Tabla de Costos y Tarifas Aplicables.',
                    'ruta' => 'citizen.fisc.street_vending.create',
                ],
                [
                    'titulo' => 'Autorización de Eventos en Vía Pública',
                    'vigencia' => 'Un solo evento (la fecha indicada)',
                    'visitas' => '3',
                    'pasos' => [
                        [
                            'titulo' => 'Llena el formato.',
                            'texto' => 'Indica tipo de evento, fecha, horario y nombre del responsable.',
                        ],
                        [
                            'titulo' => 'Obtén el sello de autorización.',
                            'texto' =>
                                'Si tu evento cierra calles, pide primero el sello de Tránsito. Si el evento es en una comunidad, pide el sello del delegado.',
                        ],
                        [
                            'titulo' => 'Sube tu formato en Fiscalización',
                            'texto' => 'para revisión.',
                        ],
                        [
                            'titulo' => 'Recibe tu recibo de pago',
                            'texto' => '(entero de pago) con el costo correspondiente.',
                        ],
                        [
                            'titulo' => 'Paga en Tesorería.',
                            'texto' => '',
                        ],
                        [
                            'titulo' => 'Entrega tu comprobante de pago en Fiscalización.',
                            'texto' => 'Con esto, tu evento queda autorizado.',
                        ],
                    ],
                    'tarifa' => null,
                    'ruta' => 'citizen.fisc.public_event.create',
                ],
                [
                    'titulo' => 'Autorización de Eventos Particulares',
                    'vigencia' => 'Un solo evento (la fecha indicada)',
                    'visitas' => '3',
                    'pasos' => [
                        [
                            'titulo' => 'Llena el formato.',
                            'texto' => 'Indica tipo de evento, fecha, horario y nombre del responsable.',
                        ],
                        [
                            'titulo' => 'Proporciona los datos de tu evento:',
                            'texto' => 'salón, fecha, horario y tipo de evento.',
                        ],
                        [
                            'titulo' => 'Recibe tu recibo de pago',
                            'texto' => '(entero de pago).',
                        ],
                        [
                            'titulo' => 'Paga en Tesorería.',
                            'texto' => '',
                        ],
                        [
                            'titulo' => 'Entrega tu comprobante de pago en Fiscalización.',
                            'texto' => 'Con esto, tu evento queda autorizado.',
                        ],
                    ],
                    'tarifa' => null,
                    'ruta' => 'citizen.fisc.private_event.create',
                ],
                [
                    'titulo' => 'Permiso de Publicidad en Vía Pública',
                    'vigencia' => '1 mes',
                    'visitas' => '3',
                    'pasos' => [
                        [
                            'titulo' => 'Acude a Fiscalización',
                            'texto' => 'y muestra el material publicitario (lona, cartel o volante).',
                        ],
                        [
                            'titulo' => 'Recuerda que debes tener una cuenta de ciudadano.',
                            'texto' => '',
                        ],
                        [
                            'titulo' => 'Indica la cantidad:',
                            'texto' => 'número de piezas (lonas/carteles) o volantes a distribuir.',
                        ],
                        [
                            'titulo' => 'Recibe tu recibo de pago',
                            'texto' => '(entero de pago), válido por un mes.',
                        ],
                        [
                            'titulo' => 'Paga en Tesorería.',
                            'texto' => '',
                        ],
                        [
                            'titulo' => 'Entrega tu comprobante de pago en Fiscalización.',
                            'texto' => 'Con esto, tu permiso queda activo.',
                        ],
                        [
                            'titulo' => 'Verificación posterior.',
                            'texto' => 'Un inspector confirmará que lo instalado coincide con lo autorizado.',
                        ],
                    ],
                    'tarifa' =>
                        'mantas $150.00 por m² (mensual); volanteo $200.00 a $500.00 (mensual); perifoneo $50.00 a $80.00; artistas en vía pública $20.00/$100.00. Ver tabla completa de tarifas en la Tabla de Costos y Tarifas Aplicables.',
                    'ruta' => null,
                ],
            ];
        @endphp

        @foreach ($tramites as $index => $tramite)
            @php $photoFirst = $index % 2 === 0; @endphp
            <div class="row mb-5 align-items-stretch wow fadeInUp">
                <div class="col-md-5 {{ $photoFirst ? 'order-md-1' : 'order-md-2' }} mb-3 mb-md-0">
                    <div class="rounded-4 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center h-100"
                        style="min-height: 260px;">
                        <ion-icon name="image-outline" style="font-size: 3rem; color: #adb5bd;"></ion-icon>
                    </div>
                </div>

                <div class="col-md-7 {{ $photoFirst ? 'order-md-2' : 'order-md-1' }}">
                    <h4 class="text-primary fw-bold mb-3">{{ $tramite['titulo'] }}</h4>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="rounded-3 p-3 h-100" style="background-color: #F0E6D8;">
                                <p class="small-uppercase mb-1 fw-bold">Vigencia</p>
                                <p class="mb-0 small">{{ $tramite['vigencia'] }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rounded-3 p-3 h-100" style="background-color: #F0E6D8;">
                                <p class="small-uppercase mb-1 fw-bold">Visitas necesarias</p>
                                <p class="mb-0 small">{{ $tramite['visitas'] }}</p>
                            </div>
                        </div>
                    </div>

                    <p class="fw-bold mb-2">Pasos a seguir</p>
                    <ol class="mb-3">
                        @foreach ($tramite['pasos'] as $paso)
                            <li class="mb-1">
                                <strong>{{ $paso['titulo'] }}</strong>
                                @if (!empty($paso['texto']))
                                    {{ ' ' . $paso['texto'] }}
                                @endif
                            </li>
                        @endforeach
                    </ol>

                    @if ($tramite['tarifa'])
                        <p class="fst-italic small text-muted mb-3">Tarifa aplicable: {{ $tramite['tarifa'] }}</p>
                    @endif

                    @if ($tramite['ruta'])
                        <a href="{{ route($tramite['ruta']) }}" class="btn btn-primary">Iniciar Solicitud</a>
                    @else
                        <a href="{{ route('citizen.fisc.advertising.index') }}" class="btn btn-link ps-0">Ver mis
                            solicitudes</a>
                    @endif
                </div>
            </div>
        @endforeach

        {{-- Tabla de Costos y Tarifas Aplicables --}}
        <div class="row mb-4">
            <div class="col-12 text-center mb-2">
                <h3 class="fw-bold mb-2">Tabla de Costos y Tarifas Aplicables</h3>
                <p class="fst-italic small text-muted mb-0">Tarifas vigentes conforme al Artículo 5 (Sección Tercera —
                    De los Ingresos en Materia de Fiscalización y Control), publicadas en el Periódico Oficial del
                    Gobierno del Estado de Guanajuato el 16 de febrero de 2026.</p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12 wow fadeInUp">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Fracc.</th>
                                <th>Concepto</th>
                                <th>Tarifa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tarifas = [
                                    ['I', 'Plaza por día, vendedores ambulantes, semifijos y tianguistas (por m²)', '$5.00 a $50.00'],
                                    ['II', 'Plaza por día, vendedores de temporada, ferias y eventos especiales (área de 6 m²)', '$5.00 a $50.00'],
                                    ['III', 'Evento (bailes y espectáculos)', '$500.00 a $8,000.00'],
                                    ['IV', 'Evento particular (por evento, horario no máximo a las 2:00 a.m. del siguiente día)', '$300.00 a $1,000.00'],
                                    ['V', 'Estacionamientos — 1ra categoría / 2da categoría / 3ra categoría', '$500.00 / $450.00 / $500.00'],
                                    ['VI', 'Mantas (mensual, por m²)', '$150.00'],
                                    ['VII', 'Volanteo (mensual)', '$200.00 a $500.00'],
                                    ['VIII', 'Maquinitas por pieza (mensual)', '$50.00'],
                                    ['IX', 'Juegos mecánicos, chico/grande, por pieza', '$100.00 a $300.00'],
                                    ['X', 'Brincolín 1 piso', '$80.00'],
                                    ['XI', 'Brincolín 2 pisos', '$150.00'],
                                    ['XII', 'Brincolín 3 pisos', '$200.00'],
                                    ['XIII', 'Juegos montables de monedas', '$10.00'],
                                    ['XIV', 'Artistas en vía pública', '$20.00 / $100.00'],
                                    ['XV', 'Perifoneo', '$50.00 a $80.00'],
                                    ['XVI', 'Futbolitos y máquinas de videojuegos (mensual)', '$150.00'],
                                    ['XVII', 'Sinfonola (mensual)', '$50.00'],
                                    ['XVIII', 'Supervisión y vigilancia a establecimientos', '$200.00 a $1,000.00'],
                                    ['XIX', 'Establecimiento comercial', '$20.00 a $50.00'],
                                ];
                            @endphp
                            @foreach ($tarifas as $fila)
                                <tr>
                                    <td>{{ $fila[0] }}</td>
                                    <td>{{ $fila[1] }}</td>
                                    <td>{{ $fila[2] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .valor-item {
            cursor: pointer;
        }

        .valor-pill {
            font-size: 0.9rem;
            display: inline-block;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .valor-desc {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height .35s ease, opacity .3s ease, margin-top .35s ease;
        }

        .valor-item:hover .valor-pill,
        .valor-item:focus-within .valor-pill {
            transform: translateY(-3px) scale(1.04);
            box-shadow: 0 8px 16px rgba(0, 0, 0, .15);
        }

        .valor-item:hover .valor-desc,
        .valor-item:focus-within .valor-desc {
            max-height: 150px;
            opacity: 1;
            margin-top: .5rem;
        }

        @media (prefers-reduced-motion: reduce) {
            .valor-pill,
            .valor-desc {
                transition: none;
            }
        }
    </style>
@endpush
