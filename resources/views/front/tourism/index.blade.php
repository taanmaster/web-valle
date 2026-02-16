@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                @if ($banners->count() > 0)
                    <div class="owl-carousel owl-theme main-carousel h-100">
                        @foreach ($banners as $banner)
                            <div class="item main-banner banner-{{ $banner->id }} h-100">
                                <div class="card card-image card-image-banner wow fadeInUp h-100">
                                    <img class="card-img-top desktop-banner"
                                        src="{{ asset('front/img/banners/' . $banner->image) }}" alt="">
                                    <img class="card-img-top responsive-banner"
                                        src="{{ asset('front/img/banners/' . $banner->image_responsive) }}" alt="">

                                    <div class="overlay"></div>
                                    <div class="card-content">
                                        <h2>{{ $banner->title }}</h2>
                                        <p>{{ $banner->subtitle }}</p>

                                        @if ($banner->has_button == true)
                                            <a href="{{ $banner->link }}" class="btn btn-primary"
                                                style="background-color: {{ $banner->hex_button ?? 'black' }} !important; color:{{ $banner->hex_text_button ?? 'white' }} !important; border: {{ $banner->hex_button }} !important;">{{ $banner->text_button }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card card-image card-image-banner wow fadeInUp h-100">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                        <div class="overlay"></div>
                        <div class="card-content">
                            <h2>Turismo en Valle de Santiago</h2>
                            <p>Descubre los atractivos turísticos, la cultura y las tradiciones de nuestro municipio</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if (count($fav_posts) > 0)
            <div class="row wow fadeInUp">
                <div class="col-md-12">
                    <div class="d-flex align-items-center gap-3">
                        <div
                            class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h3 class="mb-0">Artículos Destacados</h3>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                    <p class="mb-0">Los artículos más relevantes sobre turismo.</p>
                    <a href="{{ route('turismo.front.blog.list') }}" class="btn btn-link p-0">
                        Ver más artículos
                        <ion-icon name="arrow-forward"></ion-icon>
                    </a>
                </div>
            </div>

            <div class="row wow fadeInUp">
                @foreach ($fav_posts->take(3) as $index => $fav_post)
                    @if ($index === 0)
                        <a href="{{ route('turismo.front.blog.detail', $fav_post->slug) }}" class="col-md-12 mb-3">
                            <div class="card card-image card-image-banner wow fadeInUp">
                                <img class="card-img-top"
                                    src="{{ asset('images/tourism/blog/' . $fav_post->hero_img) }}" alt="">
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
                        <a href="{{ route('turismo.front.blog.detail', $fav_post->slug) }}" class="col-md-6 mb-4">
                            <div class="card card-image justify-content-end wow fadeInUp" style="height: 400px">
                                <img class="card-img-top"
                                    src="{{ asset('images/tourism/blog/' . $fav_post->hero_img) }}" alt="">
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
            <div class="d-flex align-items-center justify-content-between w-100">
                <h2>Todas las publicaciones</h2>
                <a href="{{ route('turismo.front.blog.list') }}" class="btn btn-link">
                    Ver más artículos
                    <ion-icon name="arrow-forward"></ion-icon>
                </a>
            </div>
        </div>

        <div class="row wow fadeInUp">
            <livewire:front.tourism.blog.list-blog :mode="0" />
        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('libs/owl-carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/owl-carousel/dist/assets/owl.theme.default.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('libs/owl-carousel/dist/owl.carousel.min.js') }}"></script>

    <script>
        $('.main-carousel').owlCarousel({
            loop: false,
            margin: 0,
            nav: true,
            dots: false,
            items: 1,
        });
    </script>
@endpush
