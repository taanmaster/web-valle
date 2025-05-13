@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12 mb-4">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('images/blog/' . $blog->hero_img) }}" alt="">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <h2>{{ $blog->title }}</h2>
                        <p>{{ $blog->description }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                {!! $blog->content_1 !!}
            </div>

            @if (count($blog->images) > 0)
                <div class="col-md-12 mb-4">
                    <div class="row">
                        @foreach ($blog->images->take(3) as $index => $image)
                            @if ($index === 0)
                                <div class="col-md-6 mb-4">
                                    <img src="{{ asset('images/blog/' . $image) }}" class="img-fluid" alt="">
                                </div>
                            @else
                                <div class="col-md-3 mb-4">
                                    <img src="{{ asset('images/blog/' . $image) }}" class="img-fluid" alt="">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="col-md-12 mb-4">
                {!! $blog->content_2 !!}
            </div>
        </div>
    </div>
@endsection
