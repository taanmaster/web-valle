@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.environment.utilities._nav')

        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="mb-0 wow fadeInUp">Artículos</h2>
                <p class="text-muted mb-0">Publicaciones de la Dirección de Medio Ambiente.</p>
            </div>
        </div>

        <div class="row">
            @forelse ($blogs as $blog)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('environment.detail', $blog->slug) }}"
                        class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                        <img src="{{ $blog->hero_img ?: asset('front/img/placeholder.jpg') }}" class="card-img-top"
                            alt="Portada de {{ $blog->title }}">
                        <div class="overlay"></div>

                        <div class="card-content">
                            <h2>{{ $blog->title }}</h2>
                            @if ($blog->description)
                                <p class="mb-0">{{ $blog->description }}</p>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="card card-normal wow fadeInUp">
                        <div class="card-content text-center py-5">
                            <ion-icon name="newspaper-outline" class="text-muted" style="font-size: 3rem"></ion-icon>
                            <p class="text-muted mb-0 mt-3">Aún no hay artículos publicados.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection
