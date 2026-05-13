@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                @if ($banners->count() > 0)
                    <div class="owl-carousel owl-theme main-carousel h-100">
                        @foreach ($banners as $banner)
                            <div class="item main-banner banner-{{ $banner->id }} h-100">
                                <div class="card card-image card-image-banner wow fadeInUp h-100">
                                    <img class="card-img-top desktop-banner"
                                        src="{{ asset('front/img/banners/' . $banner->image) }}" alt="">
                                    <img class="card-img-top responsive-banner"
                                        src="{{ asset('front/img/banners/' . $banner->image_responsive) }}" alt="">

                                    <div class="overlay"></div>
                                    <div class="card-content">
                                        <h2>{{ $banner->title }}</h2>
                                        <p>{{ $banner->subtitle }}</p>

                                        @if ($banner->has_button == true)
                                            <a href="{{ $banner->link }}" class="btn btn-primary"
                                                style="background-color: {{ $banner->hex_button ?? 'black' }} !important; color:{{ $banner->hex_text_button ?? 'white' }} !important; border: {{ $banner->hex_button }} !important;">{{ $banner->text_button }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="card card-image card-image-banner wow fadeInUp h-100 justify-content-center align-items-center">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                        <div class="overlay"></div>
                        <div class="card-content text-center">
                            <h4>Bienvenidos a la página oficial de</h4>
                            <h1>Desarrollo Institucional</h1>
                            <p>Mejora Regulatoria</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bloque de Información de Desarrollo Urbano -->
        <div class="row my-3">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">¿Quiénes Somos?</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <p>
                            La Dirección de Desarrollo Institucional se refiere a una unidad administrativa encargada de
                            fortalecer el funcionamiento interno del aparato gubernamental, especialmente en lo relacionado
                            con la organización, planeación y modernización institucional. Su función principal es impulsar
                            la modernización, la innovación administrativa y la consolidación de estructuras que permitan a
                            la institución responder de manera eficiente y efectiva a las demandas de su entorno. A través
                            del análisis organizacional, la gestión de proyectos de mejora, la actualización normativa y la
                            promoción de buenas prácticas, la Dirección de Desarrollo Institucional contribuye a la
                            construcción de una organización más sólida, transparente y orientada a resultados. En este
                            sentido, su trabajo se vincula directamente con el Eje 5: Gobernanza, eje que busca consolidar
                            un gobierno transparente, eficiente, moderno y participativo, y que plantea como meta lograr
                            instituciones sólidas, procesos administrativos eficaces y una gestión pública innovadora. El
                            presente proyecto busca garantizar que la Dirección de Desarrollo Institucional cuente con el
                            fortalecimiento de la gestión institucional mediante la ejecución de acciones programadas
                            orientadas a la mejora de los procesos administrativos, la planeación estratégica, el
                            seguimiento y evaluación del desempeño, así como la coordinación interinstitucional, con el
                            propósito de consolidar una gobernanza eficiente, transparente y orientada a resultados.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Mejora Regulatoria</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <p>
                            La mejora regulatoria es una política pública que consiste en la generación de normas claras, de
                            trámites y servicios simplificados, así como de instituciones eficaces para su creación y
                            aplicación, que se orienten a obtener el mayor valor posible de los recursos disponibles y de
                            óptimo funcionamiento de las actividades comerciales, industriales, productivas, de servicios y
                            de desarrollo humano de la sociedad en su conjunto. Valle de Santiago busca modernizar la
                            administración pública municipal, hacerla más eficiente y transparente, y generar un entorno
                            favorable para el desarrollo económico y el bienestar de sus habitantes.
                            <br><br>
                            Para lograr estos objetivos, el municipio de Valle de Santiago implementa diversas acciones y
                            herramientas, entre las que se destacan; Programas de Mejora Regulatoria, Simplificación de
                            trámites y servicios, uso de tecnologías de la información, Análisis de Impacto Regulatorio
                            (AIR), Registro Municipal de Trámites y Servicios, Sistema de Apertura Rápida de Empresas
                            (SARE), Participación ciudadana.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-normal wow fadeInUp h-100 p-4">
                    <div class="card-title">
                        <h4>Catálogo</h4>
                    </div>
                    <div class="card-content">
                        <ul>
                            <li>
                                <a href="{{ route('tramites_y_servicios.index') }}" class="btn-link">Trámites y
                                    servicios</a>
                            </li>
                            <li>
                                Expediente único
                            </li>
                            <li>
                                <a href="{{ route('regulaciones_municipales.index') }}" class="btn-link">
                                    Registro municipal de regulaciones
                                </a>
                            </li>
                            <li>
                                Autoridad de Mejora Regulatoria
                            </li>
                            <li>
                                Protesta ciudadana en materia regulatoria
                            </li>
                            <li>
                                <a href="{{ route('inspeccion_municipal.index') }}" class="btn-link">
                                    Registro municipal de Inspecciones, Verificaciones y Visitas Domiciliarias
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('front.regulatory_impact.index') }}" class="btn-link">AIR y Exención</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-normal wow fadeInUp h-100 p-4">
                    <div class="card-title">
                        <h4>Programas</h4>
                    </div>
                    <div class="card-content">
                        <ul>
                            <li>
                                Programas municipal de mejora regulatorias
                            </li>
                            <li>
                                Programas operativos
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-normal wow fadeInUp h-100 p-4">
                    <div class="card-title">
                        <h4>Consejo Municipal</h4>
                    </div>
                    <div class="card-content">
                        <ul>
                            <li>
                                <a href="{{ route('urban_council.index') }}" class="btn-link">
                                    Integrantes
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('council_attributions.index') }}" class="btn-link">
                                    Atribuciones del Consejo
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('actas_consejo.index') }}" class="btn-link">
                                    Actas de Consejo
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-normal wow fadeInUp h-100 p-4">
                    <div class="card-title">
                        <h4>Sitios de Intéres</h4>
                    </div>
                    <div class="card-content">
                        <ul>
                            <li>
                                <a href="{{ route('sare.index') }}" class="btn-link">SARE</a>
                            </li>
                            <li>
                                <a href="https://www.gob.mx/conamer" class="btn-link">CONAMER</a>
                            </li>
                            <li>
                                <a href="https://migtodigitalciudadano.guanajuato.gob.mx/sign-in" class="btn-link">GTO
                                    Digital</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="flag-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Misión</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <p>
                            La misión de la administración municipal para el periodo 2024 – 2027 es proporcionar servicios
                            públicos de calidad, promover el desarrollo sostenible y mejorar la calidad de vida de los
                            ciudadanos. Ser un gobierno que trabaje para impulsar el desarrollo integral de la población con
                            políticas públicas sostenibles, incluyentes e innovadoras que proporcionen servicios públicos
                            eficientes y efectivos que satisfagan las necesidades de los ciudadanos y promuevan el
                            desarrollo
                            del municipio, vamos a fomentar el desarrollo económico, social y ambiental, mediante la
                            planificación estratégica y la colaboración con los sectores público, privado y social, con la
                            finalidad de mejorar la calidad de vida de los ciudadanos, mediante la provisión de servicios
                            públicos de calidad, la seguridad y la salud y la protección del medio ambiente. Considerando
                            los
                            siguientes elementos clave de la misión de la administración municipal: servicio a los
                            ciudadanos,
                            desarrollo sostenible, inclusión y equidad, colaboración y participación y transparencia y
                            rendición de cuentas.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Visión</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <p>
                            La visión de gobierno representa la proyección que nuestro municipio desea alcanzar en tres años
                            para lograr un desarrollo de calidad, que genere progreso, orden, confianza y oportunidades.
                            Valle
                            de Santiago, será un municipio que impulse su economía, bienestar social, seguridad, medio
                            ambiente y gobernanza impulsando políticas públicas de desarrollo económico caracterizado por
                            una
                            economía que fomente la inversión directa en el municipio para crear empleos y con la creación
                            de
                            programas sociales incluyentes, impulsar y fortalecer la economía local que detone el turismo en
                            el municipio y mediante políticas de desarrollo sostenible a largo plazo; así como la creación
                            de
                            políticas y programas que mejoren el bienestar social, poniendo en acción Programas de Empleo
                            Temporal, Programas de Salud, Programas de Vivienda y Urbanismo. Todo esto con una política de
                            gobierno que aplique los principios de transparencia, responsabilidad, participación ciudadana,
                            equidad y eficiencia a través de una planificación estratégica, con una asignación de
                            presupuesto
                            responsable para lograr los objetivos específicos, monitoreando y evaluando todos los proyectos
                            y
                            obras realizadas y con una comunicación y participación efectiva con los ciudadanos.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3 align-items-start">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="heart-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Nuestros Valores</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-normal wow fadeInUp mb-4">
                    <div class="card-content">
                        <p class="mb-0">Los valores para esta administración municipal estarán enfocados en principios y
                            estándares que guían el comportamiento y la toma de decisiones de los funcionarios y empleados
                            municipales, mismos que serán la base para una administración pública efectiva y responsable.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card h-100 bg-warning bg-opacity-50 wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Transparencia</h5>
                        <p class="card-text">Brindar información clara y oportuna sobre las decisiones y acciones del
                            gobierno municipal.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 bg-primary bg-opacity-50 text-white wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Responsabilidad</h5>
                        <p class="card-text">Rendir cuentas por las acciones y decisiones tomadas, y asumir la
                            responsabilidad por los errores.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 bg-success bg-opacity-50 text-white wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Integridad</h5>
                        <p class="card-text">Actuar con honestidad y ética en todas las interacciones, y evitar conflictos
                            de intereses.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 bg-info bg-opacity-50 bg-opacity-50 text-white wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Respeto y cortesía</h5>
                        <p class="card-text">Tratar a los ciudadanos con respeto y cortesía en todas las interacciones.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 bg-danger bg-opacity-50 bg-opacity-50 text-white wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Justicia y equidad</h5>
                        <p class="card-text">Garantizar que todas las decisiones y acciones sean justas y equitativas para
                            todos los ciudadanos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 bg-warning bg-opacity-50 wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Participación ciudadana</h5>
                        <p class="card-text">Fomentar la participación de los ciudadanos en la toma de decisiones y en la
                            gestión municipal.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 bg-success bg-opacity-50 text-white wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Eficiencia y eficacia</h5>
                        <p class="card-text">Utilizar los recursos de manera eficiente y efectiva para lograr los objetivos
                            y metas de la administración municipal.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 bg-info bg-opacity-50 bg-opacity-50 text-white wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Innovación y mejora continua</h5>
                        <p class="card-text">Buscar formas de mejorar e innovar en la gestión municipal para ofrecer
                            mejores servicios a los ciudadanos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 bg-primary bg-opacity-50 text-white wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Sostenibilidad y protección del medio ambiente</h5>
                        <p class="card-text">Proteger el medio ambiente y promover el desarrollo sostenible en la gestión
                            municipal.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 bg-info bg-opacity-50 bg-opacity-50 text-white wow fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Accesibilidad y no discriminación</h5>
                        <p class="card-text">Garantizar que todos los servicios y programas municipales sean accesibles y
                            no discriminatorios para todos los ciudadanos.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Certificaciones</h2>
                        <p>Reconocimientos otorgados por la Autoridad Federal de Mejora Regulatoria para fomentar la
                            aplicación de buenas prácticas nacionales e internacionales en materia de mejora regulatoria.
                        </p>
                        <br><br>
                        <h2>
                            Agenda Regulatoria
                        </h2>
                        <p>
                            Planeación de las regulaciones, que pretendan ser emitidas, modificadas o eliminadas.
                        </p>
                        <a href="{{ route('regulatory-agenda.index') }}"
                            class="btn btn-secondary d-flex align-items-center gap-2 mb-4 mb-md-0"
                            style="width: fit-content">Acceder a directorio de Dependencias <ion-icon
                                name="caret-forward-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>
        </div>
    </div>


    @push('styles')
        <link rel="stylesheet" href="{{ asset('libs/owl-carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('libs/owl-carousel/dist/assets/owl.theme.default.min.css') }}">

        <link rel="stylesheet" href="{{ asset('front/css/calendar.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('libs/owl-carousel/dist/owl.carousel.min.js') }}"></script>

        <script>
            $('.main-carousel').owlCarousel({
                loop: false,
                margin: 0,
                nav: true,
                dots: false,
                items: 1,
            });
        </script>
    @endpush
@endsection
