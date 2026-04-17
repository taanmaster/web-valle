@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.secretary_of_assistance.utilities._nav')

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-8.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <h1 class="display-1 mb-3">Secretaría de Ayuntamiento</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE ¿QUÉ HACE? --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-8">
                            <div class="card-content p-5 h-100">
                                <p class="justify-p mb-0">
                                    La Secretaría del Ayuntamiento es la dependencia municipal encargada de la política
                                    interna, gobernabilidad y atención ciudadana. Funciona como enlace administrativo, da fe
                                    de los actos del Presidente Municipal, gestiona el archivo y publica los acuerdos de
                                    cabildo.
                                </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <img src="{{ asset('front/img/ayuntamiento/img-1.jpg') }}" class="img-fluid h-100 w-100"
                                style="object-fit: cover;" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE MISIÓN, VISIÓN Y VALORES CLAVE --}}
        <div class="row g-0 mb-4 wow fadeInUp overflow-hidden rounded-3 shadow-sm">

            {{-- Columna imagen --}}
            <div class="col-12 col-md-5">
                <img src="{{ asset('front/img/ayuntamiento/img-2.jpg') }}" class="img-fluid w-100 h-100 object-fit-cover"
                    style="min-height: 300px;" alt="Secretaría de Ayuntamiento">
            </div>

            {{-- Columna de tarjetas --}}
            <div class="col-12 col-md-7 d-flex flex-column gap-3 p-3 p-md-4" style="background-color: #f0f0ee;">

                {{-- Misión --}}
                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body px-4 py-3 text-center">
                        <h5 class="fw-bold mb-2">Misión</h5>
                        <p class="text-muted mb-0 small">
                            Proporcionar servicios institucionales de alta calidad a través de la asesoría, el
                            seguimiento de los acuerdos del Ayuntamiento, la administración pública municipal y la
                            atención a la sociedad, fundamentados en el respeto, la legalidad y la mejora continua
                            para facilitar la gobernabilidad.
                        </p>
                    </div>
                </div>

                {{-- Visión --}}
                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body px-4 py-3 text-center">
                        <h5 class="fw-bold mb-2">Visión</h5>
                        <p class="text-muted mb-0 small">
                            Ser una dependencia accesible para el ciudadano, moderna, eficiente y confiable, que
                            contribuya a la consolidación de un gobierno transparente y de resultados.
                        </p>
                    </div>
                </div>

                {{-- Valores Clave --}}
                <div class="card border-0 rounded-3 shadow-sm">
                    <div class="card-body px-4 py-3">
                        <h5 class="fw-bold text-center mb-3">Valores Clave</h5>
                        <div class="d-flex flex-column gap-2">
                            <div class="rounded-3 px-3 py-2 small" style="background-color: #f8d8a8;">
                                <strong>Respeto</strong> hacia los demás y las instituciones.
                            </div>
                            <div class="rounded-3 px-3 py-2 small" style="background-color: #f8d8a8;">
                                <strong>Lealtad</strong> y compromiso social.
                            </div>
                            <div class="rounded-3 px-3 py-2 small" style="background-color: #a8d8b8;">
                                <strong>Transparencia</strong> y rendición de cuentas.
                            </div>
                            <div class="rounded-3 px-3 py-2 small" style="background-color: #72c295;">
                                <strong>Confianza</strong> y certeza jurídica en las decisiones.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/ayuntamiento/img-3.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <h1 class="display-1 mb-3">Servicios a la Ciudadanía</h1>
                        <p>
                            Expedición de constancias de identidad y de residencia
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
