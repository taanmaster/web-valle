@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-2.jpg') }}" alt=""
                        style="object-position: top;">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <h2>Blog de Turismo</h2>
                        <p>Descubre los atractivos turísticos, la cultura y las tradiciones de Valle de Santiago</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 wow fadeInUp">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                        <ion-icon name="documents-outline"></ion-icon>
                    </div>
                    <h2 class="mb-0">Publicaciones de Turismo</h2>
                </div>
            </div>

            <livewire:front.tourism.blog.list-blog :mode="1" />
        </div>
    </div>
@endsection
