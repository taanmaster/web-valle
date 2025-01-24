@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-image wow fadeInUp">
                <img src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                <div class="overlay"></div>
                <div class="card-content">
                    <h2>Un gobierno de ciudadanos <br> para ciudadanos</h2>
                    <p>¡Un valle para todos! se construye mejorando la transparencia y facilitando el acceso de los ciudadanos a su gestión con el gobierno y la información pública</p>
                </div>
            </div>

            <div class="card card-normal wow fadeInUp">
                <div class="card-title">
                    <div class="d-flex gap-3">
                        <div class="card-icon bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h3>Gaceta Municipal</h3>
                    </div>
                    <p class="card-title-description mb-0">Entérate aquí de las decisiones tomadas por las y los integrantes del H. Ayuntamiento</p>
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
                                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center"><ion-icon name="arrow-forward-outline"></ion-icon></div>
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
                                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center"><ion-icon name="arrow-forward-outline"></ion-icon></div>
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
                                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center"><ion-icon name="arrow-forward-outline"></ion-icon></div>
                                </div>
                                <p class="mb-0"><strong>{{ $extraordinary_gazette_sessions }}</strong></p>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('gazette.list', 'all') }}" class="btn btn-secondary d-flex align-items-center gap-2">Acceder a todo el archivo <ion-icon name="caret-forward-outline"></ion-icon></a>
            </div>
        </div>
    </div>
</div>
@endsection