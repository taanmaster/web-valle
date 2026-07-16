@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 wow fadeInUp">
                <a href="{{ url()->previous() }}" class="btn btn-link p-0 d-flex align-items-center gap-1">
                    <ion-icon name="arrow-back"></ion-icon> Regresar
                </a>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12 mb-4">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('images/health_direction/blog/' . $blog->hero_img) }}"
                        alt="{{ $blog->title }}">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <span class="badge rounded-pill bg-light text-primary mb-2">{{ $blog->category }}</span>
                        <h2>{{ $blog->title }}</h2>
                        <p>{{ $blog->description }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <small class="text-muted">{{ $blog->published_at }}</small>
                    @if ($blog->writer)
                        <small class="text-muted">{{ $blog->writer }}</small>
                    @endif
                </div>
            </div>

            <div class="col-md-12 mb-4">
                {!! $blog->content_1 !!}
            </div>

            @if ($blog->images != null && count($blog->images) > 0)
                <div class="col-md-12 mb-4">
                    <div class="row h-100">
                        @foreach ($blog->images->take(1) as $index => $image)
                            <div class="col-md-6 h-100">
                                <img src="{{ asset($image->image_path) }}" class="img-fluid h-100 w-100"
                                    style="object-fit: cover; border-radius:8px" alt="">
                            </div>
                        @endforeach
                        <div class="col-md-6 d-flex flex-column justify-content-between">
                            @foreach ($blog->images->skip(1)->take(2) as $index => $image)
                                <div class="w-100">
                                    <img src="{{ asset($image->image_path) }}" class="img-fluid" alt=""
                                        style="object-fit: cover; border-radius:8px">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12 mb-4">
                {!! $blog->content_2 !!}
            </div>

            @if (count($blog->images) > 3)
                <div class="col-md-12 mb-4">
                    <div class="row">
                        @foreach ($blog->images->skip(3)->take(4) as $index => $image)
                            <div class="col-md-3 h-100">
                                <img src="{{ asset($image->image_path) }}" class="img-fluid h-100 w-100"
                                    style="object-fit: cover; border-radius:8px" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
