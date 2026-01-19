@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('contraloria/contra-33.jpg') }}" alt="">
                    <div class="overlay"></div>

                    <div class="card-content">
                        <div class="d-flex flex-column mb-2 gap-3">
                            <div
                                class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h2 class="mb-0">Posibles sanciones de los servidores públicos por faltas administrativas no
                                graves</h2>
                        </div>
                        <p class="mb-0">Art. 75 Ley de responsabilidades administrativas para el estado de Guanajuato.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="padding: 30px 20%;">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-image card-alignment-center wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('contraloria/contra-34.jpg') }}" alt="">
                    <div class="overlay"></div>

                    <div class="card-content">
                        <div class="d-flex align-items-center mb-0 gap-3">
                            <div
                                class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                <ion-icon name="warning-outline"></ion-icon>
                            </div>
                            <h2 class="mb-0">01</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                    <div class="card-content mb-0">
                        <h4 class="mb-0">Amonestación pública o privada</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                    <div class="card-content text-end mb-0">
                        <h4 class="mb-0">Suspensión del empleo, cargo o comisión</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-image card-alignment-center wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('contraloria/contra-35.jpg') }}" alt="">
                    <div class="overlay"></div>

                    <div class="card-content">
                        <div class="d-flex align-items-center mb-0 gap-3">
                            <div
                                class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                <ion-icon name="warning-outline"></ion-icon>
                            </div>
                            <h2 class="mb-0">02</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-image card-alignment-center wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('contraloria/contra-36.jpg') }}" alt="">
                    <div class="overlay"></div>

                    <div class="card-content">
                        <div class="d-flex align-items-center mb-0 gap-3">
                            <div
                                class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                <ion-icon name="warning-outline"></ion-icon>
                            </div>
                            <h2 class="mb-0">03</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                    <div class="card-content mb-0">
                        <h4 class="mb-0">Destitución de su empleo, cargo o comisión</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                    <div class="card-content text-end mb-0">
                        <h4 class="mb-0">Inhabilitación temporal</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-image card-alignment-center wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('contraloria/contra-37.jpg') }}" alt="">
                    <div class="overlay"></div>

                    <div class="card-content">
                        <div class="d-flex align-items-center mb-0 gap-3">
                            <div
                                class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                <ion-icon name="warning-outline"></ion-icon>
                            </div>
                            <h2 class="mb-0">04</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
