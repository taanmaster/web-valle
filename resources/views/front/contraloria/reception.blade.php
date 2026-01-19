@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.contraloria.utilities._nav')

        <div class="row justify-content-center mb-5">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('contra-img/contra-45.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Contraloría Interna Municipal</p>
                        <h1 class="display-1 mb-3">Entrega - Recepción</h1>
                        <p class="p mb-0 ms-auto me-auto" style="width: 70%;">La entrega-recepción es el procedimiento
                            administrativo obligatorio, mediante el cual los servidores públicos entregan, a quien los
                            sustituyan o reciba de manera provisional, los recursos humanos, materiales, técnicos y
                            financieros que le hayan sido asignados; esto mediante el documento denominado como Acta Entrega
                            - Recepción.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-info">
                        <ion-icon name="information-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">El procedimiento de Entrega - Recepción tiene como finalidad</h3>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-6 mb-3 wow fadeInUp">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <h2 class="mb-0 text-white">1</h2>
                        </div>
                        <p class="justify-p mb-0">Para los servidores públicos salientes, liberarlos de responsabilidad
                            administrativa respecto de la entrega-recepción, más no de las faltas en que hubiesen incurrido
                            en el ejercicio de sus funciones al frente de la responsabilidad encomendada</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3 wow fadeInUp">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <h2 class="mb-0 text-white">2</h2>
                        </div>
                        <p class="justify-p mb-0">Para los servidores públicos entrantes, constituir el punto de partida de
                            su actuación al frente de su nueva responsabilidad.</p>
                    </div>
                </div>
            </div>
        </div>

        @include('front.contraloria.utilities._footer')
    </div>
@endsection

@push('styles')
    <style>
        .card-image-banner .card-content p {
            max-width: 70%;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 768px) {
            .card-image-banner .card-content p {
                max-width: 90%;
            }
        }
    </style>
@endpush
