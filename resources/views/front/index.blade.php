@extends('front.layouts.app')

@section('content')
    <div class="container">
        @if (!empty($headerbands))
            <div class="row justify-content-center mt-4">
                <div class="col-md-12">
                    <div class="d-flex gap-4">
                        @foreach ($headerbands as $hb)
                            <style type="text/css">
                                .headerband-{{ Str::slug($hb->title) }} {
                                    background-color: {{ $hb->hex_background }} !important;
                                    color: {{ $hb->hex_text }} !important;
                                }

                                .headerband {
                                    padding: 10px 0;
                                    width: 100%;
                                }

                                .headerband h6 {
                                    letter-spacing: -1px;
                                }
                            </style>

                            <div class="col card headerband headerband-{{ Str::slug($hb->title) }}">
                                <div class=" d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0 me-3">{{ $hb->title }}</h6>
                                    {!! $hb->text !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (!empty($banners))
                    <div class="owl-carousel owl-theme main-carousel">
                        @foreach ($banners as $banner)
                            <div class="item main-banner banner-{{ $banner->id }}">
                                <div class="card card-image card-image-banner wow fadeInUp">
                                    <img class="card-img-top" src="{{ asset('front/img/banners/' . $banner->image) }}"
                                        alt="">
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
                    <div class="card card-image card-image-banner wow fadeInUp">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                        <div class="overlay"></div>
                        <div class="card-content">
                            <h2>Un gobierno de ciudadanos <br> para ciudadanos</h2>
                            <p>¡Un valle para todos! se construye mejorando la transparencia y facilitando el acceso de los
                                ciudadanos a su gestión con el gobierno y la información pública</p>
                        </div>
                    </div>
                @endif

                <div class="card card-normal wow fadeInUp">
                    <div class="card-title">
                        <div class="d-flex gap-3">
                            <div class="card-icon bg-primary text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="documents-outline"></ion-icon>
                            </div>
                            <h3>Gaceta Municipal</h3>
                        </div>
                        <p class="card-title-description mb-0">Entérate aquí de las decisiones tomadas por las y los
                            integrantes del H. Ayuntamiento</p>
                    </div>

                    <div class="row w-100">
                        <div class="col-md-4">
                            <a href="{{ route('gazette.list', 'ordinary') }}" class="folder-card folder-green">
                                <div class="folder-head"></div>
                                <div class="folder-body">
                                    <div class="folder-document"></div>
                                    <div class="folder-document"></div>
                                </div>
                                <div class="folder-overlay"></div>
                                <div class="folder-text">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h6>Sesiones Ordinarias <br> H. Ayuntamiento 2024-2027</h6>
                                        <div
                                            class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                            <ion-icon name="arrow-forward-outline"></ion-icon>
                                        </div>
                                    </div>
                                    <p class="mb-0"><strong>{{ $ordinary_gazette_sessions }}</strong></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('gazette.list', 'solemn') }}" class="folder-card folder-yellow">
                                <div class="folder-head"></div>
                                <div class="folder-body">
                                    <div class="folder-document"></div>
                                    <div class="folder-document"></div>
                                </div>
                                <div class="folder-overlay"></div>
                                <div class="folder-text">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h6>Sesiones Solemnes <br> H. Ayuntamiento 2024-2027</h6>
                                        <div
                                            class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                            <ion-icon name="arrow-forward-outline"></ion-icon>
                                        </div>
                                    </div>
                                    <p class="mb-0"><strong>{{ $solemn_gazette_sessions }}</strong></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('gazette.list', 'extraordinary') }}" class="folder-card folder-blue">
                                <div class="folder-head"></div>
                                <div class="folder-body">
                                    <div class="folder-document"></div>
                                </div>
                                <div class="folder-overlay"></div>
                                <div class="folder-text">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h6>Sesiones Extraordinarias <br> H. Ayuntamiento 2024-2027</h6>
                                        <div
                                            class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                            <ion-icon name="arrow-forward-outline"></ion-icon>
                                        </div>
                                    </div>
                                    <p class="mb-0"><strong>{{ $extraordinary_gazette_sessions }}</strong></p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('gazette.list', 'all') }}"
                        class="btn btn-secondary d-flex align-items-center gap-2">Acceder a todo el archivo <ion-icon
                            name="caret-forward-outline"></ion-icon></a>
                </div>
            </div>
        </div>

        <!-- Dependencias -->
        <div class="row">
            @foreach ($dependencies as $dependency)
                <div class="col-md-6">
                    @if ($dependency->image_cover != null)
                        <a href="{{ route('dependency.detail', $dependency->slug) }}"
                            class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                            <img src="{{ asset('images/dependencies/' . $dependency->image_cover) }}" class="card-img-top"
                                alt="Portada de {{ $dependency->name }}">
                            <div class="overlay"></div>

                            <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                            </div>

                            <div class="card-content">
                                <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3"
                                    alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                                <h4>{{ $dependency->name }}</h4>
                                <p class="mb-0">{{ $dependency->description }}</p>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('dependency.detail', $dependency->slug) }}"
                            class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                            <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                            </div>

                            <div class="card-content">
                                <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3"
                                    alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">

                                <h4>{{ $dependency->name }}</h4>
                                <p class="mb-0">{{ $dependency->description }}</p>
                            </div>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <!--Agenda Regulatoria -->
        @if ($regulation_dependencies->count() >= 1)
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="pe-4">
                        <h2>Agenda Regulatoria</h2>
                        <p>Son las propuestas de regulaciones que los sujetos obligados pretenden expedir.</p>
                        <a href="{{ route('regulatory-agenda.index') }}"
                            class="btn btn-secondary d-flex align-items-center gap-2" style="width: fit-content">Acceder a
                            directorio
                            de
                            Dependencias
                            <ion-icon name="caret-forward-outline"></ion-icon></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-image card-image-banner wow fadeInUp">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                        <div class="overlay"></div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    @if (!empty($popup))
        <div class="modal fade valle-popup-modal" id="vallePopupModal" tabindex="-1"
            aria-labelledby="vallePopupModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    <div class="modal-body">
                        @if ($popup->image == null)
                        @else
                            <div class="valle-modal-image">
                                <img class="img-fluid" src="{{ asset('front/img/popups/' . $popup->image) }}"
                                    alt="">
                            </div>
                        @endif

                        <div class="valle-info-wrap">
                            <h3>{{ $popup->title }}</h3>
                            @if ($popup->subtitle != null)
                                <h5>{{ $popup->subtitle }}</h5>
                            @endif

                            <p>{{ $popup->text }}</p>

                            @if ($popup->has_button == true)
                                <a href="{{ $popup->link }}" class="btn btn-primary mt-4">{{ $popup->text_button }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            @if ($popup->show_on_enter == true)
                <script type="text/javascript">
                    if (document.cookie.indexOf('modal=modal_shown') >= 0) {

                    } else {
                        var vallePopupModal = new bootstrap.Modal(document.getElementById('vallePopupModal'), {
                            keyboard: false
                        });

                        vallePopupModal.show();
                        document.cookie = ('modal=modal_shown');
                    }
                </script>
            @endif

            @if ($popup->show_on_exit == true)
                <script type="text/javascript">
                    if (document.cookie.indexOf('modal=modal_shown') >= 0) {

                    } else {
                        $("html").bind("mouseleave", function() {
                            var vallePopupModal = new bootstrap.Modal(document.getElementById('vallePopupModal'), {
                                keyboard: false
                            });

                            vallePopupModal.show();
                            $("html").unbind("mouseleave");
                        });

                        document.cookie = ('modal=modal_shown');
                    }
                </script>
            @endif
        @endpush
    @endif

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
