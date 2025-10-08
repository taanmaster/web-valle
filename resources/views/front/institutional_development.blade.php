@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                @if (!empty($banners))
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
                    <div class="card card-image card-image-banner wow fadeInUp h-100">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                        <div class="overlay"></div>
                        <div class="card-content">
                            <h2>Un gobierno de ciudadanos <br> para ciudadanos</h2>
                            <p>¡Un valle para todos! se construye mejorando la transparencia y facilitando el acceso de los
                                ciudadanos a su gestión con el gobierno y la información pública</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4 mb-4">
                <div id="calendar" class="wow fadeInUp"></div>
            </div>
        </div>

        <div class="row mb-4">
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
                            favorable para el desarrollo económico y el bienestar de sus habitantes. <br> <br>
                            Para lograr estos objetivos, el municipio de Valle de Santiago implementa diversas acciones y
                            herramientas, entre las que se destacan;
                            Programas de Mejora Regulatoria, Simplificación de trámites y servicios, Uso de tecnologías de
                            la información, Análisis de Impacto Regulatorio (AIR), Registro Municipal de Trámites y
                            Servicios, Sistema de Apertura Rápida de Empresas (SARE), Participación ciudadana.
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
                                <a href="" class="btn-link">
                                    Integrantes
                                </a>
                            </li>
                            <li>
                                <a href="" class="btn-link">
                                    Atribuciones del Consejo
                                </a>
                            </li>
                            <li>
                                <a href="" class="btn-link">
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
