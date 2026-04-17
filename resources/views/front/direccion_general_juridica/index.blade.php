@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.direccion_general_juridica.utilities._nav')

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/juridico/img-5.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content d-flex flex-column align-items-center text-center w-100">
                        <h1 class="display-1 mb-3">Dirección General <br> Jurídica</h1>
                        <hr style="width: 40%">
                        <a href="{{ route('appointments.search') }}" class="btn btn-primary">Agendar asesoría jurídica</a>
                    </div>
                </div>
            </div>
        </div>


        {{-- BLOQUE ¿QUÉ HACE? --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content p-5 d-flex align-items-center h-100">
                        <p class="justify-p mb-0">La Dirección General Jurídica tiene como objetivo, la asesoría, revisión,
                            análisis y la coordinación de estrategias jurídicas para el despacho de sus funciones o para el
                            auxilio del Ayuntamiento y de las dependencias que integran la Administración Pública Municipal
                            de
                            Valle de Santiago, Guanajuato. Su actuación comprende la emisión de opiniones jurídicas, la
                            elaboración y revisión de instrumentos legales, así como la defensa y seguimiento de los
                            procedimientos administrativos y judiciales en los que el municipio sea parte, con el fin de
                            garantizar la legalidad y certeza jurídica en el ejercicio de la función pública municipal.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-8">
                            <div class="card-content p-5 h-100">
                                <h4>Misión</h4>
                                <p class="justify-p mb-0">
                                    Brindar asesoría y despacho de actos jurídicos y administrativos, del Ayuntamiento y de
                                    las dependencias de la Administración Pública Municipal de Valle de Santiago,
                                    Guanajuato, garantizando que los actos de autoridad se apeguen al marco legal vigente,
                                    protegiendo los intereses del municipio y promoviendo una gestión pública eficiente,
                                    transparente y orientada al servicio de la ciudadanía.
                                </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <img src="{{ asset('front/img/juridico/img-3.jpg') }}" class="img-fluid h-100 w-100"
                                style="object-fit: cover;" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12 mb-3">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="{{ asset('front/img/juridico/img-4.jpg') }}" class="img-fluid h-100 w-100"
                                style="object-fit: cover;" alt="">
                        </div>
                        <div class="col-8">
                            <div class="card-content p-5 h-100">
                                <h4>Visión</h4>
                                <p class="justify-p mb-0">
                                    Ser una Dirección General Jurídica reconocida por su profesionalismo, ética y eficiencia
                                    en la defensa de los intereses del municipio, consolidándose como un órgano jurídico
                                    confiable que fortalezca la legalidad, la certeza jurídica y el buen gobierno en Valle
                                    de Santiago, Guanajuato.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE VALORES Y PRINCIPIOS --}}
        <div class="row mb-3">
            <div class="col-12 text-center wow fadeInUp">
                <h3 class="mb-0">Nuestros valores</h3>
            </div>
        </div>

        <div class="row g-3 mb-4 wow fadeInUp">
            {{-- Fila superior: 4 tarjetas + imagen derecha --}}
            <div class="col-12 col-md-7">
                <div class="row g-3 h-100">
                    <div class="col-6">
                        <div class="rounded-3 p-3 h-100 bg-danger-subtle">
                            <h6 class="fw-bold mb-2">Legalidad</h6>
                            <p class="mb-0 small">Actuar siempre con estricto apego a la Constitución, las leyes y
                                reglamentos aplicables.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-3 p-3 h-100 bg-warning-subtle">
                            <h6 class="fw-bold mb-2">Ética</h6>
                            <p class="mb-0 small">Desempeñar las funciones con honestidad, integridad y responsabilidad en
                                el servicio público.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-3 p-3 h-100 bg-secondary-subtle">
                            <h6 class="fw-bold mb-2">Transparencia</h6>
                            <p class="mb-0 small">Garantizar que las actuaciones jurídicas del municipio se realicen con
                                claridad y rendición de cuentas.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-3 p-3 h-100 bg-info-subtle">
                            <h6 class="fw-bold mb-2">Profesionalismo</h6>
                            <p class="mb-0 small">Ejercer la función jurídica con preparación técnica, calidad y compromiso
                                institucional.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <img src="{{ asset('front/img/juridico/img-7.jpg') }}"
                    class="img-fluid w-100 h-100 rounded-3 object-fit-cover" style="min-height: 220px;" alt="Justicia">
            </div>

            {{-- Fila inferior: imagen izquierda + 3 tarjetas --}}
            <div class="col-12 col-md-5">
                <img src="{{ asset('front/img/juridico/img-6.jpg') }}"
                    class="img-fluid w-100 h-100 rounded-3 object-fit-cover" style="min-height: 220px;" alt="Derecho">
            </div>
            <div class="col-12 col-md-7">
                <div class="row g-3 h-100">
                    <div class="col-6">
                        <div class="rounded-3 p-3 h-100 bg-primary">
                            <h6 class="fw-bold mb-2 text-white">Imparcialidad</h6>
                            <p class="mb-0 small text-white">Tomar decisiones y emitir opiniones jurídicas objetivas, sin
                                intereses personales o externos.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-3 p-3 h-100 bg-primary">
                            <h6 class="fw-bold mb-2 text-white">Responsabilidad</h6>
                            <p class="mb-0 small text-white">Asumir las consecuencias de las decisiones jurídicas y actuar
                                con diligencia en la defensa del municipio.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rounded-3 p-3 bg-primary">
                            <h6 class="fw-bold mb-2 text-white">Servicio público</h6>
                            <p class="mb-0 small text-white">Trabajar con vocación para contribuir al bienestar de la
                                ciudadanía y al desarrollo del municipio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
