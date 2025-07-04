@extends('front.layouts.app')

@section('content')
    <div class="container">

        @if (!empty($banners))
            <div class="owl-carousel owl-theme main-carousel h-100 mb-4">
                @foreach ($banners as $banner)
                    <div class="item main-banner banner-{{ $banner->id }} h-100">
                        <div class="card card-image card-image-banner wow fadeInUp h-100">
                            <img class="card-img-top desktop-banner" src="{{ asset('front/img/banners/' . $banner->image) }}"
                                alt="">
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
            <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                    <div class="card card-image card-image-banner wow fadeInUp">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                        <div class="overlay"></div>
                        <div class="card-content">
                            <p>Bienvenido al</p>
                            <h2>Sistema de Apertura Rápida de Empresas</h2>
                            <p>del H. Ayuntamiento de Valle de Santiago, Guanajuato.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Identidad</h2>
                        <p>En SMDIF, estamos interesados y comprometidos con involucrarnos activa y positivamente en
                            diversos sectores de la sociedad, principalmente en la familia y la restructuración del tejido
                            social de nuestro municipio</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Misión</h2>
                        <p>Promover la asistencia social y prestación de servicios asistenciales que contribuyan a la
                            protección, atención y superación de la familia y de los grupos más vulnerables, así como de
                            cualquier persona en situación de desamparo y violencia, sensibilizar sobre el respeto de Niños,
                            Niñas, jóvenes, mujeres, adultos mayores y personas con discapacidad.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Visión</h2>
                        <p>Ser un organismo capaz de brindar atención a las familias y a personas en vulnerabilidad, a
                            través de programas que promuevan el bienestar social y fortalecimiento familiar, asegurando la
                            correcta administración de los recursos para que lleguen por fin a los más desfavorecidos, con
                            transparencia, honestidad, desarrollo integral, solución de problemas a corto, mediano y a largo
                            plazo.</p>
                    </div>
                </div>
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
                    <p class="mb-0">Categoría basada en el número de lecturas.</p>
                    <a href="{{ route('blog.list') }}" class="btn btn-link p-0">
                        Ver más artículos
                        <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
            </div>


            <div class="row wow fadeInUp">
                @foreach ($fav_posts->take(3) as $index => $fav_post)
                    @if ($index === 0)
                        <a href="{{ route('blog.detail', $fav_post->slug) }}" class="col-md-12 mb-3">
                            <div class="card card-image card-image-banner wow fadeInUp">
                                <img class="card-img-top" src="{{ asset('images/blog/' . $fav_post->hero_img) }}"
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
                        <a href="{{ route('blog.detail', $fav_post->slug) }}" class="col-md-6 mb-4">
                            <div class="card card-image justify-content-end wow fadeInUp" style="height: 400px">
                                <img class="card-img-top" src="{{ asset('images/blog/' . $fav_post->hero_img) }}"
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

        <div class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-normal wow fadeInUp h-100">
                        <div class="card-content">
                            <h4>Valores</h4>
                            <ol>
                                <li>
                                    Respeto
                                </li>
                                <li>
                                    Igualdad
                                </li>
                                <li>
                                    Empatía
                                </li>
                                <li>
                                    Solidaridad
                                </li>
                                <li>
                                    Honestidad
                                </li>
                                <li>
                                    Compromiso
                                </li>
                                <li>
                                    Generosidad
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-normal wow fadeInUp h-100">
                        <div class="card-content">
                            <h4>Objetivo</h4>

                            <p>
                                Optimizar los recursos, fortalecer y promover la atención de los grupos vulnerables, atender
                                personas que se encuentran en situación de marginación, desamparo o ambiente de violencia,
                                ofrecer asesoría profesional, psicológica, medica, nutricional, dental, visual, legal y en
                                especie a quienes previo estudio socioeconómico lo requiera; también fomentar el sano
                                crecimiento físico y mental de la niñez. Además de sensibilizar a la población en el respeto
                                hacia los Niños, Niñas y Adolescentes, Mujeres, Adultos Mayores y personas con capacidades
                                diferentes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content py-4">
                        <ul style="list-style-type: upper-alpha;">
                            <li>
                                Dirección
                            </li>
                            <li>
                                Centro de Asistencia Infantil Comunitario
                            </li>
                            <li>
                                Cancha de baloncesto
                            </li>
                            <li>
                                Asistencia Alimentaria PREVERP
                            </li>
                            <li>
                                Área Recreativa
                            </li>
                            <li>
                                Rehabilitación
                            </li>
                            <li>
                                Recepción
                            </li>
                            <li>
                                Trabajo Social
                            </li>
                        </ul>

                        <ol class="mt-4">
                            <li>
                                Acceso principal
                            </li>
                            <li>
                                Acceso a CAIC
                            </li>
                            <li>
                                Acceso a cancha
                            </li>
                            <li>
                                Acceso a Recepción
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/croquis.png') }}" alt="Dif Croquis">
                    <div class="overlay"></div>
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
