@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12 mb-3">
                <a href="{{ route('health_direction.list', $blog->category) }}"
                    class="btn btn-link p-0 d-flex align-items-center gap-1">
                    <ion-icon name="arrow-back"></ion-icon> Regresar
                </a>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('images/health_direction/blog/' . $blog->hero_img) }}"
                        alt="{{ $blog->title }}">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <h2>{{ $blog->title }}</h2>
                        <p>{{ $blog->description }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4 d-flex align-items-center justify-content-between">
                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary">
                    {{ $blog->category }}
                </span>
                <small class="text-muted">{{ $blog->published_at }}</small>
            </div>

            @if (!empty($blog->content_1))
                <div class="col-md-12 mb-4">
                    {!! $blog->content_1 !!}
                </div>
            @endif

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

            @if (!empty($blog->content_2))
                <div class="col-md-12 mb-4">
                    {!! $blog->content_2 !!}
                </div>
            @endif

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

            @if ($blog->writer)
                <div class="col-md-12">
                    <small class="text-muted">Publicado por {{ $blog->writer }}</small>
                </div>
            @endif
        </div>
    </div>
@endsection
