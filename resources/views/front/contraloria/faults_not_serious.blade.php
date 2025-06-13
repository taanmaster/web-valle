@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card card-image card-image-banner wow fadeInUp">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-3.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex flex-column mb-2 gap-3">
                        <div class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">Faltas administrativas no graves de los servidores públicos</h2>
                    </div>
                    <p class="mb-0">Art. 49 Ley de responsabilidades administrativas para el estado de Guanajuato</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 30px 20%;">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-4.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
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
                    <h4 class="mb-0">Incumplir sus funciones otorgadas</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                <div class="card-content text-end mb-0">
                    <h4 class="mb-0">No denunciar</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
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
                <img class="card-img-top" src="{{ asset('front/img/placeholder-2.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
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
                    <h4 class="mb-0">No atender instrucciones de sus superiores</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                <div class="card-content text-end mb-0">
                    <h4 class="mb-0">No presentar en tiempo las declaraciones patrimoniales y de intereses</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-4.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                            <ion-icon name="warning-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">04</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-3.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                            <ion-icon name="warning-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">05</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                <div class="card-content mb-0">
                    <h4 class="mb-0">No impedir el mal uso de la información.</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                <div class="card-content text-end mb-0">
                    <h4 class="mb-0">No supervisar que los servidores públicos cumplan con la ley.</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-2.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                            <ion-icon name="warning-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">06</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                            <ion-icon name="warning-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">07</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                <div class="card-content mb-0">
                    <h4 class="mb-0">No rendir cuentas.</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                <div class="card-content text-end mb-0">
                    <h4 class="mb-0">No colaborar en procedimientos administrativos</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-3.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                            <ion-icon name="warning-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">08</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-4.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                            <ion-icon name="warning-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">09</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                <div class="card-content mb-0">
                    <h4 class="mb-0">Cuando existe un conflicto de interés</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                <div class="card-content text-end mb-0">
                    <h4 class="mb-0">Daños y perjuicios a la hacienda pública</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-0 gap-3">
                        <div class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                            <ion-icon name="warning-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">10</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection