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
                        <p>Este blog es un espacio para descubrir todo lo que está pasando cerca de ti. Aquí compartimos
                            historias que inspiran, informan y conectan.</p>
                    </div>
                </div>
            </div>
        </div>

        @if (count($fav_posts) > 0)
            <div class="row">
                <h2>Artículos Destacados</h2>
                <div class="d-flex align-items-center justify-content-between w-100">
                    <p class="mb-0">Categoría basada en el número de lecturas.</p>
                    <a href="{{ route('blog.list') }}" class="btn btn-link">
                        Ver más artículos
                        <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
            </div>


            <div class="row">
                @foreach ($fav_posts->take(3) as $index => $fav_post)
                    @if ($index === 0)
                        <a href="" class="col-md-12 mb-3">
                            <div class="card card-image card-image-banner wow fadeInUp">
                                <img src="{{ asset('storage/' . $fav_post->image) }}" alt="">
                                <div class="overlay"></div>
                                <div class="content w-100">
                                    <div class="d-flex aling-items-center justify-content-between w-100">
                                        <h1 class="mb-0">{{ $fav_post->title }}</h1>
                                        <p class="mb-0">{{ $fav_post->writer }}</p>
                                    </div>

                                </div>
                            </div>
                        </a>
                    @else
                        <a href="" class="col-md-6 mb-4">
                            <div class="card">
                                <img src="{{ asset('images/blog/' . $fav_post->hero_img) }}" class="card-img-top"
                                    alt="Portada de {{ $fav_post->title }}">
                                <div class="card-body">
                                    <p>
                                        {{ $fav_post->published_at }}
                                    </p>
                                    <h5 class="card-title mb-3">{{ $fav_post->title }}</h5>
                                    <p class="card-text">
                                        {{ $fav_post->description }}
                                    </p>

                                    <div class="d-flex mt-3 w-100 justify-content-between align-items-center">
                                        <p class="mb-0">
                                            {{ $fav_post->category }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="row mb-4">
            <h2>Artículos Recientes</h2>
            <div class="d-flex align-items-center justify-content-between w-100">
                <p class="mb-0">Categoría basada en el número de lecturas.</p>
                <a href="{{ route('blog.list') }}" class="btn btn-link">
                    Ver más artículos
                    <ion-icon name="arrow-forward"></ion-icon>
                </a>
            </div>
        </div>

        <div class="row">

            <livewire:front.blog.list-blog :mode="$mode" />

        </div>
    </div>
@endsection
