@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp">

                    <img src="" alt="">

                    <div class="overlay"></div>

                    <div class="content">
                        <h1 class="mb-0">En Construcción</h1>
                        <p>Este sitio web está en constante cambio, seguimos trabajando para traerte a ti toda la
                            información
                            importante de tu municipio.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h2>Artículos Destacados</h2>
            <div class="d-flex align-items-center justify-content-between w-100">
                <p class="mb-0">Categoría basada en el número de lecturas.</p>
                <a href="" class="btn btn-link">
                    Ver más artículos
                    <ion-icon name="arrow-forward"></ion-icon>
                </a>
            </div>
        </div>

        <div class="row">
            @foreach ($fav_posts as $fav_post)
                @if ($index === 1)
                    <div class="col-md-12">
                        <a class="card card-normal wow fadeInUp">
                            <img src="{{ asset('storage/' . $fav_post->image) }}" alt="">
                            <div class="overlay"></div>
                            <div class="content">
                                <h1>{{ $fav_post->title }}</h1>
                                <p>{{ $fav_post->description }}</p>
                                <a href="{{ route('blog.show', $fav_post->slug) }}" class="btn btn-primary">Leer más</a>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="col-md-6">
                        <a class="card card-normal wow fadeInUp">
                            <img src="{{ asset('storage/' . $fav_post->image) }}" alt="">
                            <div class="overlay"></div>
                            <div class="content">
                                <h1>{{ $fav_post->title }}</h1>
                                <p>{{ $fav_post->description }}</p>
                                <a href="{{ route('blog.show', $fav_post->slug) }}" class="btn btn-primary">Leer más</a>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
