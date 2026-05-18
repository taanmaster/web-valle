@extends('front.layouts.app')

@section('content')
    <div class="container">

        {{-- Hero Banner --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp h-100 justify-content-center align-items-center">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                    <div class="card-content text-center">
                        <h4>Bienvenidos a la página oficial de</h4>
                        <h1>Dirección de Salud</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- Misión --}}
        <div class="row mb-4 align-items-stretch">
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <div class="d-flex align-items-center mb-3" style="gap: 12px">
                            <div class="icon bg-primary">
                                <ion-icon name="flag-outline"></ion-icon>
                            </div>
                            <h3 class="mb-0">Misión</h3>
                        </div>
                        <p>Promover y salvaguardar la salud de la población mediante acciones de prevención,
                            concientización y atención integrando y colaborando con instituciones públicas y del sector
                            salud; fomentando hábitos saludables y la correcta aplicación de la normatividad vigente para
                            favorecer el bienestar colectivo y una mejor calidad de vida en el municipio.</p>
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

        {{-- Visión --}}
        <div class="row mb-4 align-items-stretch">
            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <div class="d-flex align-items-center mb-3" style="gap: 12px">
                            <div class="icon bg-primary">
                                <ion-icon name="eye-outline"></ion-icon>
                            </div>
                            <h3 class="mb-0">Visión</h3>
                        </div>
                        <p>Ser una dirección influyente en salud municipal reconocida por su compromiso con la
                            prevención, la educación en salud y la coordinación efectiva con instituciones públicas y del
                            sector salud; impulsando el bienestar de las personas como centro de los servicios
                            municipales, con personal preparado, empoderado y con orientación más saludable.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nuestros Valores --}}
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-warning">
                        <ion-icon name="star-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Nuestros Valores</h3>
                </div>
            </div>

            <div class="col-md-12 mb-0">
                <div class=" wow fadeInUp">
                    <div id="word-cloud" class="text-center py-4">
                        <span class="word-item" data-color="#e74c3c">Honestidad</span>
                        <span class="word-item" data-color="#3498db">Ética</span>
                        <span class="word-item" data-color="#f39c12">Empatía</span>
                        <span class="word-item" data-color="#2ecc71">Responsabilidad</span>
                        <br>
                        <span class="word-item" data-color="#3498db">Transparencia</span>
                        <span class="word-item" data-color="#9b59b6">Igualdad</span>
                        <span class="word-item" data-color="#e74c3c">Bienestar integral</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Talleres --}}
        <div class="row wow fadeInUp mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="mb-0">Talleres</h3>
                    <a href="{{ route('health_direction.list', 'Taller') }}" class="btn btn-link p-0 d-flex align-items-center gap-1">
                        Ver más talleres <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            @if (isset($talleres) && $talleres->count() > 0)
                @foreach ($talleres->take(2) as $blog)
                    <div class="col-md-6 mb-3">
                        <div class="card card-image wow fadeInUp" style="height: 220px">
                            <img class="card-img-top" src="{{ asset('images/health_direction/blog/' . $blog->hero_img) }}"
                                alt="{{ $blog->title }}">
                            <div class="overlay"></div>
                            <div class="card-content">
                                <h5 class="mb-0">{{ $blog->title }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card card-normal wow fadeInUp text-center py-5">
                        <div class="card-body w-100 d-flex flex-column align-items-center justify-content-center">
                            <ion-icon name="construct-outline" style="font-size: 2.5rem; color: #cbd5e1;"></ion-icon>
                            <p class="text-muted mt-2 mb-0">Próximamente talleres disponibles</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Campañas --}}
        <div class="row wow fadeInUp mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="mb-0">Campañas</h3>
                    <a href="{{ route('health_direction.list', 'Campaña') }}" class="btn btn-link p-0 d-flex align-items-center gap-1">
                        Ver más campañas <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            @if (isset($campanas) && $campanas->count() > 0)
                @foreach ($campanas->take(2) as $blog)
                    <div class="col-md-6 mb-3">
                        <div class="card card-image wow fadeInUp" style="height: 220px">
                            <img class="card-img-top" src="{{ asset('images/health_direction/blog/' . $blog->hero_img) }}"
                                alt="{{ $blog->title }}">
                            <div class="overlay"></div>
                            <div class="card-content">
                                <h5 class="mb-0">{{ $blog->title }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card card-normal wow fadeInUp text-center py-5">
                        <div class="card-body w-100 d-flex flex-column align-items-center justify-content-center">
                            <ion-icon name="megaphone-outline" style="font-size: 2.5rem; color: #cbd5e1;"></ion-icon>
                            <p class="text-muted mt-2 mb-0">Próximamente campañas disponibles</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Eventos y Pláticas --}}
        <div class="row mb-4">
            {{-- Eventos --}}
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-between mb-3 wow fadeInUp">
                    <h3 class="mb-0">Eventos</h3>
                    <a href="{{ route('health_direction.list', 'Evento') }}" class="btn btn-link p-0 d-flex align-items-center gap-1">
                        Ver más eventos <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
                @if (isset($eventos) && $eventos->count() > 0)
                    @foreach ($eventos->take(2) as $blog)
                        <div class="mb-3">
                            <div class="card card-image wow fadeInUp" style="height: 190px">
                                <img class="card-img-top"
                                    src="{{ asset('images/health_direction/blog/' . $blog->hero_img) }}"
                                    alt="{{ $blog->title }}">
                                <div class="overlay"></div>
                                <div class="card-content">
                                    <h5 class="mb-0">{{ $blog->title }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card card-normal wow fadeInUp text-center py-5">
                        <div class="card-body w-100 d-flex flex-column align-items-center justify-content-center">
                            <ion-icon name="calendar-outline" style="font-size: 2.5rem; color: #cbd5e1;"></ion-icon>
                            <p class="text-muted mt-2 mb-0">Próximamente eventos disponibles</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Pláticas --}}
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-between mb-3 wow fadeInUp">
                    <h3 class="mb-0">Pláticas</h3>
                    <a href="{{ route('health_direction.list', 'Platica') }}" class="btn btn-link p-0 d-flex align-items-center gap-1">
                        Ver más pláticas <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
                @if (isset($platicas) && $platicas->count() > 0)
                    @foreach ($platicas->take(2) as $blog)
                        <div class="mb-3">
                            <div class="card card-image wow fadeInUp" style="height: 190px">
                                <img class="card-img-top"
                                    src="{{ asset('images/health_direction/blog/' . $blog->hero_img) }}"
                                    alt="{{ $blog->title }}">
                                <div class="overlay"></div>
                                <div class="card-content">
                                    <h5 class="mb-0">{{ $blog->title }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card card-normal wow fadeInUp text-center py-5">
                        <div class="card-body w-100 d-flex flex-column align-items-center justify-content-center">
                            <ion-icon name="mic-outline" style="font-size: 2.5rem; color: #cbd5e1;"></ion-icon>
                            <p class="text-muted mt-2 mb-0">Próximamente pláticas disponibles</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Dispensario de medicamentos --}}
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-3 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="medical-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Dispensario de medicamentos</h3>
                </div>
            </div>
        </div>
        <div class="row mb-4 wow fadeInUp">
            <div class="col-md-8">
                <div class="card h-100" style="background-color: #eff6ff; border: 1px solid #bfdbfe;">
                    <div class="card-body">
                        <p>El servicio válido médico-medicamento, puedes acudir a la dirección correspondiente con la
                            siguiente documentación.</p>
                        <div class="d-flex flex-column gap-2 mt-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-info text-white py-2 px-3">Copia de la misma cédula</span>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <span class="badge bg-info text-white py-2 px-3"
                                    style="white-space: normal; text-align: left">
                                    Copia de tu identificación oficial con foto y tu fin a fin en la semana, con una
                                    antigüedad no mayor a 6 meses
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card h-100 d-flex align-items-center justify-content-center">
                    <div class="card-body text-center d-flex align-items-center justify-content-center">
                        <span class="badge bg-success px-4 py-3"
                            style="font-size: 0.9rem; white-space: normal; line-height: 1.6">
                            Carmelo Vargas #26 Colonia Miraballe,<br>Valle de Santiago, Gto.
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Casa Ciudadana para gestión de apoyos en salud --}}
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-3 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="home-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Casa Ciudadana para gestión de apoyos en salud</h3>
                </div>
            </div>
        </div>
        <div class="row mb-5 wow fadeInUp">
            <div class="col-md-8">
                <div class="card h-100" style="background-color: #f0f0f0; border: none; border-radius: 16px;">
                    <div class="card-body px-4 py-4 text-center">
                        <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">Información y requisitos para tu solicitud
                        </h5>
                        <p class="text-muted mb-3" style="font-size: 0.88rem;">Acércate a la Dirección de Salud, donde te
                            orientaremos de manera<br>personalizada sobre los requisitos según el trámite que necesites
                            realizar.</p>
                        <p class="mb-3" style="font-size: 0.9rem;">Para avanzar con tu solicitud, te pediremos reunir y
                            presentar algunos<br>documentos básicos, como:</p>
                        <ul class="list-unstyled mb-4 mx-auto" style="max-width: 420px;">
                            <li class="mb-2">
                                <div class="py-2 px-3 text-center"
                                    style="background-color: #cef0fb; border: 1.5px solid #7dd3f0; border-radius: 50px; font-size: 0.9rem;">
                                    Copia de identificación oficial
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="py-2 px-3 text-center"
                                    style="background-color: #cef0fb; border: 1.5px solid #7dd3f0; border-radius: 50px; font-size: 0.9rem;">
                                    CURP
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="py-2 px-3 text-center"
                                    style="background-color: #cef0fb; border: 1.5px solid #7dd3f0; border-radius: 50px; font-size: 0.9rem;">
                                    Comprobante de domicilio
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="py-2 px-3 text-center"
                                    style="background-color: #cef0fb; border: 1.5px solid #7dd3f0; border-radius: 50px; font-size: 0.9rem;">
                                    Carta de no derechohabiencia (IMSS o ISSSTE)
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="py-2 px-3 text-center"
                                    style="background-color: #cef0fb; border: 1.5px solid #7dd3f0; border-radius: 50px; font-size: 0.9rem;">
                                    Acta de nacimiento del solicitante y/o de un tercero
                                </div>
                            </li>
                        </ul>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Nuestro equipo te acompañará en todo el
                            proceso para que<br>puedas completar tu trámite de forma clara y sencilla.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card h-100 d-flex align-items-center justify-content-center">
                    <div class="card-body text-center w-100 d-flex flex-column align-items-center justify-content-center">
                        <ion-icon name="location-outline" style="font-size: 2.5rem; color: #0d6efd;"></ion-icon>
                        <p class="mt-2 mb-0">Paseo al parque #198 en Guanajuato capital</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('libs/owl-carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/owl-carousel/dist/assets/owl.theme.default.min.css') }}">
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

@push('styles')
    <style>
        /* Estilos para la nube de palabras */
        #word-cloud {
            line-height: 3;
            min-height: 150px;
        }

        .word-item {
            display: inline-block;
            margin: 5px 15px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.4s ease;
            cursor: pointer;
            opacity: 0.7;
        }

        .word-item:nth-child(odd) {
            font-size: 1.4rem;
        }

        .word-item:nth-child(3n) {
            font-size: 1.6rem;
        }

        .word-item.active {
            font-size: 2rem !important;
            opacity: 1;
            transform: scale(1.2);
        }

        .word-item:hover {
            transform: scale(1.15);
            opacity: 1;
        }

        /* Estilos para botones de descarga */
        .download-btn {
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .download-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.4s ease;
        }

        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .download-btn:hover::before {
            left: 100%;
        }

        .download-btn .download-icon {
            transition: transform 0.3s ease;
        }

        .download-btn:hover .download-icon {
            transform: translateY(3px);
            animation: bounce-download 0.6s ease infinite;
        }

        @keyframes bounce-download {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(5px);
            }
        }

        .download-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de nube de palabras
            const wordItems = document.querySelectorAll('.word-item');
            let currentIndex = 0;

            function highlightNextWord() {
                // Remover active de todas las palabras
                wordItems.forEach(item => item.classList.remove('active'));

                // Aplicar color y active a la palabra actual
                const currentWord = wordItems[currentIndex];
                currentWord.classList.add('active');
                currentWord.style.color = currentWord.getAttribute('data-color');

                currentIndex = (currentIndex + 1) % wordItems.length;
            }

            // Iniciar la animación
            highlightNextWord();
            setInterval(highlightNextWord, 1500);

            // Hover manual en las palabras
            wordItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.color = this.getAttribute('data-color');
                });

                item.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.color = '#6c757d';
                    }
                });
            });
        });
    </script>
@endpush
