@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.urban_dev.utilities._nav')

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/urbano/img-1.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Bienvenidos a la página oficial de</p>
                        <h1 class="display-1 mb-0">Desarrollo Urbano</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('urban_dev.procedures') }}"
                    class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column gap-3">
                            <div
                                class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="document-text-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Ir a Trámites</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route('urban_dev.services') }}"
                    class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column gap-3">
                            <div
                                class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="grid-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Ir a Servicios</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Bloque de Información de Desarrollo Urbano -->
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">¿Quiénes Somos?</h3>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="{{ asset('front/img/urbano/img-2.jpg') }}" class="img-fluid h-100 w-100"
                                style="object-fit: cover;" alt="">
                        </div>
                        <div class="col-8">
                            <div class="card-content p-5 d-flex align-items-center h-100">
                                <p class="justify-p mb-0">Verifica que las dependencias de la administración pública que
                                    reciben, manejan y administran o ejercen recursos públicos lo hagan conforme a la
                                    normatividad aplicable</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 align-items-stretch">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-2 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-secondary">
                        <ion-icon name="analytics-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Nuestros puntos clave</h3>
                </div>
            </div>

            {{-- Puntos clave: cards + imagen central + collage --}}
            <div class="col-md-4 d-flex wow fadeInUp" data-wow-delay="0.1s">
                <div class="d-flex flex-column gap-3 w-100">
                    <div class="card card-normal text-center flex-fill">
                        <h5 class="fw-bold mb-1">Sostenibilidad</h5>
                        <p class="mb-0 small">Respeto por las áreas naturales (especialmente las Luminarias)</p>
                    </div>
                    <div class="card card-normal text-center flex-fill">
                        <h5 class="fw-bold mb-1">Movilidad</h5>
                        <p class="mb-0 small">Mejora de caminos y conectividad urbana.</p>
                    </div>
                    <div class="card card-normal text-center flex-fill">
                        <h5 class="fw-bold mb-1">Orden</h5>
                        <p class="mb-0 small">Regularización de predios y licencias de construcción.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8 d-flex wow fadeInUp" data-wow-delay="0.2s">
                <img src="{{ asset('front/img/urbano/img-3.jpg') }}" alt="Puntos clave" class="rounded w-100"
                    style="object-fit: cover; min-height: 260px;">
            </div>
        </div>

        <div class="row my-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-secondary">
                        <ion-icon name="analytics-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Misión</h3>
                </div>
            </div>

            {{-- Misión: imagen de fondo con 3 tarjetas semitransparentes --}}
            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="rounded-4 overflow-hidden position-relative"
                    style="background-image: url('{{ asset('front/img/urbano/img-4.jpg') }}'); background-size: cover; background-position: center; min-height: 280px;">
                    {{-- Overlay oscuro --}}
                    <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4"
                        style="background: rgba(0,0,0,0.45);"></div>
                    {{-- Tarjetas --}}
                    <div class="position-relative d-grid gap-3 p-4" style="grid-template-columns: repeat(3, 1fr);">
                        <div class="rounded-4 p-3" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
                            <h6 class="fw-bold mb-2 text-white">Mejorar la calidad de vida:</h6>
                            <p class="mb-0 small text-white">El desarrollo urbano busca atender las necesidades de la
                                población, proporcionando acceso a servicios, infraestructura, vivienda adecuada y espacios
                                públicos de calidad.</p>
                        </div>
                        <div class="rounded-4 p-3" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
                            <h6 class="fw-bold mb-2 text-white">Promover la inclusión social:</h6>
                            <p class="mb-0 small text-white">Se busca reducir desigualdades y segregación socio-espacial,
                                asegurando la participación de todos los ciudadanos en la vida urbana.</p>
                        </div>
                        <div class="rounded-4 p-3"
                            style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
                            <h6 class="fw-bold mb-2 text-white">Fomentar la sostenibilidad:</h6>
                            <p class="mb-0 small text-white">El desarrollo urbano debe integrar criterios ambientales,
                                económicos y sociales para garantizar un futuro sostenible para las ciudades y sus
                                habitantes.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row my-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-secondary">
                        <ion-icon name="analytics-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Visión</h3>
                </div>
            </div>

            {{-- Visión: imagen + 3 tarjetas --}}
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('front/img/urbano/img-5.jpg') }}" alt="Visión urbana"
                    class="img-fluid rounded-4 w-100 h-100" style="object-fit: cover; max-height: 260px;">
            </div>

            <div class="col-md-8 wow fadeInUp" data-wow-delay="0.2s">
                <div class="row g-3 h-100 align-items-stretch">
                    <div class="col-md-4">
                        <div class="rounded-4 p-3 h-100" style="background-color: #DDE8F8;">
                            <h6 class="fw-bold mb-2">Ciudades para la vida:</h6>
                            <p class="mb-0 small">Una visión a futuro que prioriza la creación de ciudades habitables,
                                seguras, productivas y armoniosas con el entorno.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="rounded-4 p-3 h-100" style="background-color: #DDE8F8;">
                            <h6 class="fw-bold mb-2">Desarrollo sostenible:</h6>
                            <p class="mb-0 small">Ciudades que equilibran el crecimiento económico, la protección del medio
                                ambiente y el bienestar social.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="rounded-4 p-3 h-100" style="background-color: #DDE8F8;">
                            <h6 class="fw-bold mb-2">Oportunidades equitativas:</h6>
                            <p class="mb-0 small">Ciudades donde todos los ciudadanos tengan acceso a oportunidades para
                                una vida sana, segura y próspera.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-secondary">
                        <ion-icon name="analytics-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Nuestros valores</h3>
                </div>
            </div>

            {{-- Grid de valores con CSS Grid para alturas iguales por fila --}}
            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="d-grid gap-3" style="grid-template-columns: repeat(4, 1fr);">
                    <div class="rounded-4 p-3" style="background-color: #FDDCB5;">
                        <h6 class="fw-bold mb-2">Honestidad y transparencia</h6>
                        <p class="mb-0 small">Actuar con integridad y ética en la gestión pública y la toma de decisiones.
                        </p>
                    </div>
                    <div class="rounded-4 p-3" style="background-color: #FFF8B0;">
                        <h6 class="fw-bold mb-2">Participación ciudadana</h6>
                        <p class="mb-0 small">Involucrar a los ciudadanos en la planificación y gestión del desarrollo
                            urbano.</p>
                    </div>
                    <div class="rounded-4 p-3" style="background-color: #E0D4F5;">
                        <h6 class="fw-bold mb-2">Equidad e inclusión</h6>
                        <p class="mb-0 small">Garantizar la igualdad de oportunidades para todos los habitantes, sin
                            discriminación.</p>
                    </div>
                    <div class="rounded-4 p-3" style="background-color: #C8EDE4; grid-row: span 2;">
                        <h6 class="fw-bold mb-2">Colaboración</h6>
                        <p class="mb-0 small">Fomentar el trabajo conjunto entre diferentes actores (gobierno, sector
                            privado, sociedad civil).</p>
                    </div>
                    <div class="rounded-4 p-3" style="background-color: #FFCCD0;">
                        <h6 class="fw-bold mb-2">Sostenibilidad</h6>
                        <p class="mb-0 small">Proteger el medio ambiente y los recursos naturales para las generaciones
                            futuras.</p>
                    </div>
                    <div class="rounded-4 p-3" style="background-color: #F9D0EA;">
                        <h6 class="fw-bold mb-2">Innovación y eficiencia</h6>
                        <p class="mb-0 small">Buscar soluciones creativas y eficientes para los desafíos urbanos.</p>
                    </div>
                    <div class="rounded-4 p-3" style="background-color: #C8EAC8;">
                        <h6 class="fw-bold mb-2">Respeto al patrimonio</h6>
                        <p class="mb-0 small">Preservar y valorar el patrimonio cultural y natural de las ciudades.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-secondary">
                        <ion-icon name="analytics-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Directorio</h3>
                </div>
            </div>

            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                <a href="{{ route('urban_dev.contacts', 'inspectors') }}"
                    class="d-flex align-items-center justify-content-center rounded-4 p-4 text-decoration-none"
                    style="background-color: #6ECBBA; min-height: 80px;">
                    <h5 class="fw-bold text-white mb-0">Inspectores</h5>
                </a>
            </div>

            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                <a href="{{ route('urban_dev.contacts', 'experts') }}"
                    class="d-flex align-items-center justify-content-center rounded-4 p-4 text-decoration-none"
                    style="background-color: #6CAEE8; min-height: 80px;">
                    <h5 class="fw-bold text-white mb-0">Peritos</h5>
                </a>
            </div>

            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{ route('urban_dev.contacts', 'auditors') }}"
                    class="d-flex align-items-center justify-content-center rounded-4 p-4 text-decoration-none"
                    style="background-color: #F5C842; min-height: 80px;">
                    <h5 class="fw-bold text-white mb-0">Fiscalización</h5>
                </a>
            </div>

        </div>

        @include('front.urban_dev.utilities._footer')
    </div>
@endsection
