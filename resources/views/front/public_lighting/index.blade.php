@extends('front.layouts.app')

@section('content')
    <div class="container">

        {{-- Encabezado --}}
        <div class="d-flex align-items-center justify-content-between mb-4 wow fadeInUp">
            <h2 class="text-primary fw-bold mb-0">ALUMBRADO PÚBLICO</h2>
        </div>

        {{-- Banner Principal --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-3.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Bienvenidos a la página oficial de</p>
                        <h1 class="display-1 mb-0">Alumbrado Público</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- Misión / Visión --}}
        <div class="row mb-5 g-3">
            <div class="col-12">
                <div class="rounded-4 p-4 wow fadeInUp" style="background-color: #E0D4F5;">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-md-center mb-2 mb-md-0">
                            <h3 class="fw-bold mb-0">Misión</h3>
                        </div>
                        <div class="col-md-9">
                            <p class="mb-0">Garantizar el bienestar y la calidad de vida de la ciudadanía a través de la
                                prestación eficiente, oportuna y transparente de los servicios públicos municipales,
                                fomentando el cuidado del entorno urbano, el mantenimiento de espacios comunes y la
                                gestión responsable de los recursos, con un enfoque de cercanía, inclusión y compromiso
                                social.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="rounded-4 p-4 wow fadeInUp" data-wow-delay="0.1s" style="background-color: #E0D4F5;">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-md-center mb-2 mb-md-0">
                            <h3 class="fw-bold mb-0">Visión</h3>
                        </div>
                        <div class="col-md-9">
                            <p class="mb-0">Ser una dependencia municipal reconocida por su eficiencia, innovación y
                                vocación de servicio, que brinde servicios públicos de calidad y promueva comunidades
                                limpias, ordenadas, seguras y sustentables, consolidándose como un área fundamental para
                                el desarrollo integral y armónico del municipio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nuestros Valores --}}
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold mb-0">Nuestros Valores</h3>
            </div>

            <div class="col-12">
                @php
                    $valores = [
                        ['nombre' => 'Compromiso', 'color' => '#dc3545'],
                        ['nombre' => 'Honestidad', 'color' => '#fd7e14'],
                        ['nombre' => 'Respeto', 'color' => '#ffc107'],
                        ['nombre' => 'Eficiencia', 'color' => '#198754'],
                        ['nombre' => 'Innovación', 'color' => '#20c997'],
                        ['nombre' => 'Vocación de servicio', 'color' => '#0d6efd'],
                        ['nombre' => 'Sustentabilidad', 'color' => '#6f42c1'],
                    ];
                @endphp

                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach ($valores as $index => $valor)
                        <span class="rounded-pill text-white fw-bold text-center py-2 px-4 valor-pill wow fadeInUp"
                            data-wow-delay="{{ 0.05 * $index }}s" style="background-color: {{ $valor['color'] }};">
                            {{ $valor['nombre'] }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Peticiones ciudadanas --}}
        <div class="row mb-4">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold mb-0">Peticiones ciudadanas del servicio de alumbrado público</h3>
            </div>
        </div>

        <div class="row mb-5 align-items-stretch wow fadeInUp">
            <div class="col-md-5 mb-3 mb-md-0">
                <div class="rounded-4 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center h-100"
                    style="min-height: 260px;">
                    <ion-icon name="image-outline" style="font-size: 3rem; color: #adb5bd;"></ion-icon>
                </div>
            </div>

            <div class="col-md-7">
                <div class="rounded-3 p-3 mb-3" style="background-color: #F0E6D8;">
                    <p class="small-uppercase mb-1 fw-bold">Requisitos necesarios</p>
                    <p class="mb-0 small">Tener una cuenta de ciudadano activa en el portal.</p>
                </div>

                <p class="fw-bold mb-2">Pasos a seguir</p>
                <ol class="mb-3">
                    <li class="mb-1"><strong>Inicia sesión.</strong> Si tienes una sesión activa de ciudadano inicia
                        sesión, de no ser así, crea una cuenta.</li>
                    <li class="mb-1"><strong>Llena el formulario de tu petición.</strong> Indica la ubicación de la
                        luminaria y anexa fotografías del problema.</li>
                    <li class="mb-1"><strong>Atención a tu petición.</strong> Te informaremos si tu petición fue
                        realizada.</li>
                </ol>

                <a href="{{ route('citizen.profile.index') }}" class="btn btn-primary">Iniciar Petición</a>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .valor-pill {
            font-size: 0.9rem;
            min-width: 150px;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .valor-pill:hover {
            transform: translateY(-3px) scale(1.04);
            box-shadow: 0 8px 16px rgba(0, 0, 0, .15);
        }

        @media (prefers-reduced-motion: reduce) {
            .valor-pill {
                transition: none;
            }
        }
    </style>
@endpush
