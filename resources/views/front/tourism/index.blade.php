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
                    <div class="card card-image card-image-banner wow fadeInUp h-100">
                        <img class="card-img-top" src="{{ asset('front/img/turismo/img-1.jpg') }}" alt="">
                        <div class="overlay"></div>
                        <div class="card-content">
                            <h2>Turismo en Valle de Santiago</h2>
                            <p>Descubre los atractivos turísticos, la cultura y las tradiciones de nuestro municipio</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp mb-4">
                    <p class="mb-0">
                        La Subdirección de Turismo de Valle de Santiago es la encargada de planear, coordinar y promover el
                        desarrollo turístico del municipio, fortaleciendo la oferta, la identidad local y la participación
                        de la comunidad, a través de la revalorización de su patrimonio natural, cultural y gastronómico.
                    </p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Misión</h2>
                        <p>
                            Promover el desarrollo turístico sostenible del municipio mediante la revalorización de su
                            patrimonio, el fortalecimiento de los servicios turísticos y la promoción de experiencias
                            auténticas que impulsen la economía local.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/turismo/img-5.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/turismo/img-7.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Visión</h2>
                        <p>
                            Consolidar a Valle de Santiago como un destino turístico reconocido a nivel estatal y nacional
                            por la riqueza de sus paisajes volcánicos, su patrimonio cultural, su identidad gastronómica y
                            su valor arqueológico, bajo un modelo sostenible que preserve su entorno y sus raíces.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE VALORES Y PRINCIPIOS --}}
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-warning">
                        <ion-icon name="star-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Valores y Principios</h3>
                </div>
            </div>

            <div class="col-md-12 mb-0">
                <div class=" wow fadeInUp">
                    <div id="word-cloud" class="text-center py-4">
                        <span class="word-item" data-color="#e74c3c">Sostenibilidad</span>
                        <span class="word-item" data-color="#3498db">Identidad y pertenencia</span>
                        <span class="word-item" data-color="#f39c12">Calidad en el servicio</span>
                        <span class="word-item" data-color="#2ecc71">Colaboración</span>
                        <br>
                        <span class="word-item" data-color="#3498db">Innovación</span>
                        <span class="word-item" data-color="#9b59b6">Responsabilidad social</span>
                        <span class="word-item" data-color="#e74c3c">Profesionalismo</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp flex-row">
                    <img class="card-img-top" src="{{ asset('front/img/turismo/img-6.jpg') }}" alt=""
                        style="object-position: top;">
                    <div class="overlay"></div>
                    <div class="card-content row w-100">
                        <div class="col-md-6">
                            <h2>Datos relevantes del área</h2>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>Promoción y difusión del destino</li>
                                <li>Impulso al desarrollo de productos turísticos</li>
                                <li>Coordinación de eventos y festivales</li>
                                <li>Vinculación con prestadores de servicios, artesanos y productores</li>
                                <li>Impulso al turismo sostenible</li>
                                <li>Atención a visitantes</li>
                                <li>Estrategias de posicionamiento</li>
                                <li>Colaboración con instancias estatales y regionales</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/turismo/img-4.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <h3 class="mb-3">¿Por qué visitar Valle de Santiago?</h3>
                        <p class="p mb-0 ms-auto me-auto" style="width: 70%;">Porque ofrece paisajes volcánicos únicos, una
                            rica herencia cultural y una identidad gastronómica que se viven a
                            través de experiencias auténticas. Es un destino ideal para el turismo de naturaleza y aventura,
                            con actividades como senderismo, ciclismo, rappel, escalada y cabalgatas, que permiten conectar
                            con el entorno y la esencia del municipio.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Descubre Valle de Santiago</h2>
                        <p>Con origen en el antiguo Camémbaro, “lugar de ajenjo y estafiate”, Valle de Santiago resguarda un
                            valioso patrimonio histórico. Su centro invita a recorrer el Jardín Independencia, la parroquia
                            de Santiago Apóstol de gran valor arquitectónico y la Alameda Hidalgo, rodeada de vegetación
                            emblemática. Es un espacio que combina historia, tradición y vida cotidiana.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/turismo/img-2.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp flex-row">
                    <img class="card-img-top" src="{{ asset('front/img/turismo/img-3.jpg') }}" alt=""
                        style="object-position: top;">
                    <div class="overlay"></div>
                    <div class="card-content row w-100">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <h2>El Motivo: Las Siete Luminarias</h2>
                            <p>Uno de los principales atractivos del municipio. Esta zona del eje neo volcánico alberga
                                cráteres
                                únicos como La Alberca, Hoya de Álvarez y Rincón de Parangueo, donde se pueden realizar
                                actividades
                                como campismo, senderismo, cabalgatas y ciclismo de montaña. Además, resguarda vestigios de
                                arte
                                rupestre y espacios propicios para la contemplación y conexión con la naturaleza.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-body text-center pb-4">
                    <h3>Qué comer</h3>
                    <div class="d-flex flex-wrap gap-2 justify-content-center my-3">
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#fcd5ce; color:#333;">Gorditas</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#ffd599; color:#333;">Atole de garbanzo</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#ffe08a; color:#333;">Tamales de cacahuate</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#b5ead7; color:#333;">Cecina</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#b2f5ea; color:#333;">Birria en adobo</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#bee3f8; color:#333;">Camote horneado</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#e9d8fd; color:#333;">Dulces de xoconostle</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-body text-center pb-4">
                    <h3>Qué comprar</h3>
                    <div class="d-flex flex-wrap gap-2 justify-content-center my-3">
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#fcd5ce; color:#333;">Cerería</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#ffd599; color:#333;">Quesos artesanales</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#ffe08a; color:#333;">Pulque</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#b5ead7; color:#333;">Pinturas y artesanías locales.</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#b2f5ea; color:#333;">Sillas tejidas</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#bee3f8; color:#333;">Hidromiel</span>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-normal"
                            style="background-color:#e9d8fd; color:#333;">Cerveza artesanal</span>
                    </div>
                </div>
            </div>
        </div>

        <!--Agenda Regulatoria -->
        <div href="{{ route('urban_dev.index') }}"
            class="card card-image card-alignment-bottom wow fadeInUp h-100 d-block">
            <img src="{{ asset('front/img/turismo/img-1.jpg') }}" class="card-img-top"
                alt="Portada de Desarrollo Urbano">
            <div class="overlay"></div>

            <div class="card-content">
                <h2 style="padding-top: 120px;">Apoyos a terceros</h2>
                <a href="{{ route('login') }}" class="btn btn-secondary d-flex align-items-center gap-2 mb-4 mb-md-0"
                    style="width: fit-content">Realizar solicitud <ion-icon name="caret-forward-outline"></ion-icon></a>
            </div>
        </div>

        @if (count($fav_posts) > 0)
            <div class="row wow fadeInUp">
                <div class="col-md-12">
                    <div class="d-flex align-items-center gap-3">
                        <div
                            class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h3 class="mb-0">Artículos Destacados</h3>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                    <p class="mb-0">Los artículos más relevantes sobre turismo.</p>
                    <a href="{{ route('turismo.front.blog.list') }}" class="btn btn-link p-0">
                        Ver más artículos
                        <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
            </div>

            <div class="row wow fadeInUp">
                @foreach ($fav_posts->take(3) as $index => $fav_post)
                    @if ($index === 0)
                        <a href="{{ route('turismo.front.blog.detail', $fav_post->slug) }}" class="col-md-12 mb-3">
                            <div class="card card-image card-image-banner wow fadeInUp">
                                <img class="card-img-top" src="{{ asset('images/tourism/blog/' . $fav_post->hero_img) }}"
                                    alt="">
                                <div class="overlay"></div>
                                <div class="card-content w-100">
                                    <div class="d-flex aling-items-center justify-content-between w-100">
                                        <h1 class="mb-0">{{ $fav_post->title }}</h1>
                                        <p class="mb-0">{{ $fav_post->writer }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('turismo.front.blog.detail', $fav_post->slug) }}" class="col-md-6 mb-4">
                            <div class="card card-image justify-content-end wow fadeInUp" style="height: 400px">
                                <img class="card-img-top" src="{{ asset('images/tourism/blog/' . $fav_post->hero_img) }}"
                                    alt="">
                                <div class="overlay"></div>
                                <div class="card-content w-100">
                                    <div class="d-flex aling-items-center justify-content-between w-100">
                                        <h3 class="mb-0">{{ $fav_post->title }}</h3>
                                        <p class="mb-0 truncate-text">{{ $fav_post->writer }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="row wow fadeInUp mb-4">
            <div class="d-flex align-items-center justify-content-between w-100">
                <h2>Todas las publicaciones</h2>
                <a href="{{ route('turismo.front.blog.list') }}" class="btn btn-link">
                    Ver más artículos
                    <ion-icon name="arrow-forward"></ion-icon>
                </a>
            </div>
        </div>

        <div class="row wow fadeInUp">
            <livewire:front.tourism.blog.list-blog :mode="0" />
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
