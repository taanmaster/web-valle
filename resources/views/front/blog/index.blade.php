@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-2.jpg') }}" alt="" style="object-position: top;">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <h2>Cambia la forma <br>en la que ves tu ciudad</h2>
                        <p>Este blog es un espacio para descubrir todo lo que está pasando cerca de ti. Aquí compartimos historias que inspiran, informan y conectan.</p>
                    </div>
                </div>
            </div>
        </div>

        @if (count($fav_posts) > 0)
            <div class="row wow fadeInUp">
                <div class="col-md-12">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h3 class="mb-0">Artículos Destacados</h3>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                    <p class="mb-0">Categoría basada en el número de lecturas.</p>
                    <a href="{{ route('blog.list') }}" class="btn btn-link p-0">
                        Ver más artículos
                        <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
            </div>


            <div class="row wow fadeInUp">
                @foreach ($fav_posts->take(3) as $index => $fav_post)
                    @if ($index === 0)
                        <a href="{{ route('blog.detail', $fav_post->slug) }}" class="col-md-12 mb-3">
                            <div class="card card-image card-image-banner wow fadeInUp">
                                <img class="card-img-top" src="{{ asset('images/blog/' . $fav_post->hero_img) }}"
                                    alt="">
                                <div class="overlay"></div>
                                <div class="card-content w-100">
                                    <div class="d-flex aling-items-center justify-content-between w-100">
                                        <h1 class="mb-0">{{ $fav_post->title }}</h1>
                                        <p class="mb-0">{{ $fav_post->writer }}</p>
                                    </div>

                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('blog.detail', $fav_post->slug) }}" class="col-md-6 mb-4">
                            <div class="card card-image justify-content-end wow fadeInUp" style="height: 400px">
                                <img class="card-img-top" src="{{ asset('images/blog/' . $fav_post->hero_img) }}"
                                    alt="">
                                <div class="overlay"></div>
                                <div class="card-content w-100">
                                    <div class="d-flex aling-items-center justify-content-between w-100">
                                        <h3 class="mb-0">{{ $fav_post->title }}</h3>
                                        <p class="mb-0 truncate-text">{{ $fav_post->writer }}</p>
                                    </div>

                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
            
        <div class="row wow fadeInUp mb-4">
            <h2>Artículos Recientes</h2>
            <div class="d-flex align-items-center justify-content-between w-100">
                <p class="mb-0">Categoría basada en el número de lecturas.</p>
                <a href="{{ route('blog.list') }}" class="btn btn-link">
                    Ver más artículos
                    <ion-icon name="arrow-forward"></ion-icon>
                </a>
            </div>
        </div>

        <div class="row wow fadeInUp">
            <livewire:front.blog.list-blog :mode="$mode" />
        </div>
    </div>
@endsection
