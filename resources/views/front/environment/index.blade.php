@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.environment.utilities._nav')

        {{-- HERO --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-8.jpg') }}"
                        alt="Dirección de Medio Ambiente de Valle de Santiago">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <h1 class="display-1 mb-3">Dirección de <br> Medio Ambiente</h1>
                        <p class="p mb-4 ms-auto me-auto" style="width: 70%;">Conoce los programas, servicios y acciones
                            que impulsa la Dirección de Medio Ambiente para promover el cuidado de Valle de Santiago.</p>
                        <a href="#articulos-destacados"
                            class="btn btn-light btn-sm rounded-pill d-inline-flex align-items-center gap-2">
                            Desliza para ver artículos <ion-icon name="arrow-down-outline"></ion-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE RESERVADO --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-normal bg-light wow fadeInUp">
                    <div class="card-content text-center py-5">
                        <p class="text-muted mb-0">Dejar apartado para próxima información</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- TALLERES Y PLÁTICAS --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-6 mb-3">
                <h2 class="mb-3 wow fadeInUp">Nuestros talleres y pláticas</h2>
                <p class="text-muted mb-0 wow fadeInUp">Consulta el calendario de actividades de la Dirección y participa
                    en los talleres y pláticas que se imparten durante el mes.</p>
            </div>
            <div class="col-md-6 mb-3">
                @include('front.utilities._events_calendar', ['events' => $events])
            </div>
        </div>

        {{-- MISIÓN --}}
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content d-flex flex-column justify-content-center h-100 text-center">
                        <h3 class="mb-3">Misión</h3>
                        <p class="text-muted mb-0">Dejar apartado para misión</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <img src="{{ asset('front/img/placeholder-9.jpg') }}" class="img-fluid h-100 w-100"
                        style="object-fit: cover;" alt="Acciones de la Dirección de Medio Ambiente">
                </div>
            </div>
        </div>

        {{-- VISIÓN --}}
        <div class="row mb-4">
            <div class="col-md-6 mb-3 order-md-1 order-2">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <img src="{{ asset('front/img/placeholder-10.jpg') }}" class="img-fluid h-100 w-100"
                        style="object-fit: cover;" alt="Áreas verdes de Valle de Santiago">
                </div>
            </div>
            <div class="col-md-6 mb-3 order-md-2 order-1">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content d-flex flex-column justify-content-center h-100 text-center">
                        <h3 class="mb-3">Visión</h3>
                        <p class="text-muted mb-0">Dejar apartado para visión</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- VALORES --}}
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h4 class="mb-4 wow fadeInUp">Nuestros Valores</h4>

                <div class="d-flex flex-wrap justify-content-center gap-3 wow fadeInUp">
                    <span class="badge rounded-pill bg-danger px-4 py-3">Sostenibilidad</span>
                    <span class="badge rounded-pill bg-warning text-dark px-4 py-3">Identidad y pertenencia</span>
                    <span class="badge rounded-pill bg-success px-4 py-3">Colaboración</span>
                    <span class="badge rounded-pill bg-primary px-4 py-3">Responsabilidad social</span>
                </div>
            </div>
        </div>

        <hr class="border-primary border-3 opacity-100 mb-4">

        {{-- TRÁMITES --}}
        <div class="row mb-4">
            @foreach ($procedures as $slug => $procedure)
                <div class="col-md-4 mb-3">
                    <div class="card card-normal wow fadeInUp h-100">
                        <div class="card-content text-center d-flex flex-column h-100">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="icon bg-primary">
                                    <ion-icon name="{{ $procedure['icon'] }}"></ion-icon>
                                </div>
                            </div>
                            <h4 class="mb-3">{{ $procedure['short_title'] }}</h4>
                            <a href="{{ route('environment.procedure', $slug) }}"
                                class="btn btn-primary mt-auto mx-auto">Consulta aquí</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <a href="{{ route('environment.floristic_list') }}"
                    class="btn btn-primary rounded-pill px-4 wow fadeInUp d-inline-flex align-items-center gap-2">
                    <ion-icon name="download-outline"></ion-icon> Consultar listado florístico
                </a>
            </div>
        </div>

        {{-- ARTÍCULOS DESTACADOS --}}
        <div class="row mb-4" id="articulos-destacados">
            <div class="col-md-12">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="mb-0 wow fadeInUp">Artículos Destacados</h2>
                    <a href="{{ route('environment.list') }}"
                        class="d-flex align-items-center gap-2 text-success fw-medium">Ver más artículos <ion-icon
                            name="arrow-forward-outline"></ion-icon></a>
                </div>
            </div>

            @forelse ($blogs as $index => $blog)
                <div class="{{ $index === 0 ? 'col-md-12' : 'col-md-6' }} mb-3">
                    <a href="{{ route('environment.detail', $blog->slug) }}"
                        class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                        <img src="{{ $blog->hero_img ?: asset('front/img/placeholder.jpg') }}" class="card-img-top"
                            alt="Portada de {{ $blog->title }}">
                        <div class="overlay"></div>

                        <div class="card-content">
                            <h2>{{ $blog->title }}</h2>
                            @if ($blog->description)
                                <p class="mb-0">{{ $blog->description }}</p>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="card card-normal wow fadeInUp">
                        <div class="card-content text-center py-5">
                            <ion-icon name="newspaper-outline" class="text-muted" style="font-size: 3rem"></ion-icon>
                            <p class="text-muted mb-0 mt-3">Aún no hay artículos publicados.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
