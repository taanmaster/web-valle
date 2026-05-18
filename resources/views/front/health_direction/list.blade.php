@extends('front.layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp justify-content-center align-items-center">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                    <div class="card-content text-center">
                        <h4>Dirección de Salud</h4>
                        <h1>{{ $category }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12 wow fadeInUp">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h2 class="mb-0">{{ $category }}</h2>
                    </div>
                    <a href="{{ route('health_direction.index') }}" class="btn btn-link p-0 d-flex align-items-center gap-1">
                        <ion-icon name="arrow-back"></ion-icon> Regresar
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <livewire:front.health-direction.blog-list :category="$category" />
            </div>
        </div>

    </div>
@endsection
