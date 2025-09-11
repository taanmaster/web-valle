@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.implan.utilities.nav')

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
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <a href="{{ route('implan.front.achievements') }}"
                    class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                    <img src="{{ asset('images/implan/logros.png') }}" class="card-img-top"
                        alt="Portada de Desarrollo Urbano">
                    <div class="overlay"></div>

                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <h2>Logros</h2>
                    </div>
                </a>
            </div>
            <div class="col-md-6">

                <a href="javascript:void(0)" class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                    <img src="{{ asset('images/implan/convocatoria.png') }}" class="card-img-top"
                        alt="Portada de Desarrollo Urbano">
                    <div class="overlay"></div>

                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <h2>Convocatoria</h2>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h3>Visores INEGI</h3>
                                <br>
                                <p>Los visores del INEGI son herramientas interactivas en línea que permiten explorar,
                                    consultar y descargar información geoespacial, estadística y sociodemográfica de todo
                                    México. Están diseñados para facilitar el acceso a datos públicos de manera visual y
                                    sencilla, usando mapas temáticos, filtros y capas de información.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <a href="http://201.116.233.69/ovie-client/#"
                                            class="card card-body d-flex flex-column align-items-center">
                                            <img src="{{ asset('images/implan/coordinates.svg') }}" alt=""
                                                style="height: 200px">
                                            <h4>Visor OVIE</h4>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="http://implan.ddns.net/mxsig/?v=bGF0OjIwLjg4MTA0LGxvbjotMTAwLjg4MzkyLHo6NSxsOmMxMDB8YzEwMQ=="
                                            class="card card-body d-flex flex-column align-items-center">
                                            <img src="{{ asset('images/implan/globe.svg') }}" alt=""
                                                style="height: 200px">
                                            <h4>Visor OVIE</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('front.implan.utilities.footer')
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
