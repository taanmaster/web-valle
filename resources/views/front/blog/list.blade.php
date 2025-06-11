@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <h2>Cambia la forma en la que ves tu ciudad</h2>
                        <p>Este blog es un espacio para descubrir todo lo que está pasando cerca de ti. Aquí compartimos historias que inspiran, informan y conectan.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <livewire:front.blog.list-blog :mode="$mode" />
        </div>
    </div>
@endsection
