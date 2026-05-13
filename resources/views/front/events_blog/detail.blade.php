@extends('front.layouts.app')

@section('content')
    <div class="container">

        {{-- Hero --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-12 mb-4">
                <div class="card card-image card-image-banner wow fadeInUp" style="position:relative;">
                    <img class="card-img-top"
                        src="{{ asset('images/events-blog/' . $entry->hero_img) }}"
                        alt="{{ $entry->title }}"
                        style="max-height:420px;object-fit:cover;width:100%;">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <h2>{{ $entry->title }}</h2>
                        <p>{{ $entry->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Meta --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                @if ($entry->published_at)
                    <p class="text-muted mb-4">
                        <strong>Publicado el:</strong>
                        {{ \Carbon\Carbon::parse($entry->published_at)->format('d M, Y') }}
                    </p>
                @endif

                {{-- Contenido 1 --}}
                @if ($entry->content_1)
                    <div class="mb-4">
                        {!! $entry->content_1 !!}
                    </div>
                @endif

                {{-- Galería primeras 3 imágenes --}}
                @if ($entry->images->count() > 0)
                    <div class="mb-4">
                        <div class="row">
                            @foreach ($entry->images->take(1) as $image)
                                <div class="col-md-6 mb-3">
                                    <img src="{{ asset($image->image_path) }}"
                                        class="img-fluid w-100"
                                        style="object-fit:cover;border-radius:8px;max-height:300px;"
                                        alt="">
                                </div>
                            @endforeach
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach ($entry->images->skip(1)->take(2) as $image)
                                        <div class="col-12 mb-3">
                                            <img src="{{ asset($image->image_path) }}"
                                                class="img-fluid w-100"
                                                style="object-fit:cover;border-radius:8px;max-height:140px;"
                                                alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Contenido 2 --}}
                @if ($entry->content_2)
                    <div class="mb-4">
                        {!! $entry->content_2 !!}
                    </div>
                @endif

                {{-- Resto de imágenes --}}
                @if ($entry->images->count() > 3)
                    <div class="mb-4">
                        <div class="row">
                            @foreach ($entry->images->skip(3) as $image)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset($image->image_path) }}"
                                        class="img-fluid w-100"
                                        style="object-fit:cover;border-radius:8px;height:150px;"
                                        alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('events_blog.front.index') }}" class="btn btn-outline-secondary">
                        &larr; Volver a Eventos
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
