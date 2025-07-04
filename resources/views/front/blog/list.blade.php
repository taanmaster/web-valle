@extends('front.layouts.app')

@section('content')
    <div class="container">

        @if ($category == 'Dif')
        @else
            <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                    <div class="card card-image card-image-banner wow fadeInUp">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder-2.jpg') }}" alt=""
                            style="object-position: top;">
                        <div class="overlay"></div>
                        <div class="card-content">
                            <h2>Cambia la forma <br>en la que ves tu ciudad</h2>
                            <p>Este blog es un espacio para descubrir todo lo que está pasando cerca de ti. Aquí compartimos
                                historias que inspiran, informan y conectan.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 wow fadeInUp">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                        <ion-icon name="documents-outline"></ion-icon>
                    </div>
                    <h2 class="mb-0">Noticias

                        @if ($category != '')
                            {{ $category }}
                        @endif

                    </h2>
                </div>
            </div>

            <livewire:front.blog.list-blog :mode="$mode" :category="$category" />
        </div>
    </div>
@endsection
