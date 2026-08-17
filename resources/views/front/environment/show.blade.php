@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.environment.utilities._nav')

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ $blog->hero_img ?: asset('front/img/placeholder.jpg') }}"
                        alt="Portada de {{ $blog->title }}">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        @if ($blog->published_at)
                            <p class="small-uppercase mb-0">
                                {{ \Carbon\Carbon::parse($blog->published_at)->translatedFormat('d \d\e F, Y') }}</p>
                        @endif
                        <h1 class="display-1 mb-0">{{ $blog->title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        @if ($blog->description)
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <p class="lead mb-0 wow fadeInUp">{{ $blog->description }}</p>
                </div>
            </div>
        @endif

        @if ($blog->content_1)
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="card card-normal wow fadeInUp">
                        <div class="card-content">{!! $blog->content_1 !!}</div>
                    </div>
                </div>
            </div>
        @endif

        @if ($blog->images->count())
            <div class="row justify-content-center mb-4">
                @foreach ($blog->images as $image)
                    <div class="col-md-4 mb-3">
                        <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                            <img src="{{ $image->image_path }}" class="img-fluid h-100 w-100" style="object-fit: cover;"
                                alt="Imagen de {{ $blog->title }}">
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($blog->content_2)
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="card card-normal wow fadeInUp">
                        <div class="card-content">{!! $blog->content_2 !!}</div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <a href="{{ route('environment.list') }}"
                    class="btn btn-secondary d-inline-flex align-items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon> Volver a artículos
                </a>
            </div>
        </div>
    </div>
@endsection
