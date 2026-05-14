@extends('layouts.master')
@section('title')
    {{ $post->title }}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Programa de Capacitación
        @endslot
        @slot('li_2')
            Blog
        @endslot
        @slot('title')
            {{ $post->title }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            {{-- Acciones --}}
            <div class="mb-3 d-flex" style="gap: 8px;">
                <a href="{{ route('training.admin.index') }}" class="btn btn-sm btn-secondary"
                    style="width: fit-content">
                    &larr; Volver
                </a>
                <a href="{{ route('training_blog.admin.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary"
                    style="width: fit-content">
                    <i class='bx bx-edit'></i> Editar
                </a>
            </div>

            {{-- Hero --}}
            <div class="card mb-4"
                style="border-radius: 16px; overflow: hidden; min-height: 380px; position: relative; background: #d0d0d0;">
                @if ($post->hero_img)
                    <img src="{{ $post->hero_img }}"
                        style="width: 100%; height: 380px; object-fit: cover; position: absolute; top: 0; left: 0;"
                        alt="">
                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.35);"></div>
                @endif
                <div
                    style="position: relative; z-index: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 380px; padding: 40px;">
                    <h1
                        style="font-size: clamp(2rem,5vw,3.5rem); font-weight: 800; text-transform: uppercase; text-align: center; color: {{ $post->hero_img ? '#fff' : '#555' }}; letter-spacing: 2px;">
                        {{ $post->title }}
                    </h1>
                </div>
                @if ($post->published_at)
                    <div
                        style="position: absolute; bottom: 16px; left: 50%; transform: translateX(-50%); color: {{ $post->hero_img ? 'rgba(255,255,255,0.8)' : '#888' }}; font-size: 0.85rem;">
                        Publicado el
                        <strong>{{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('M d, Y') }}</strong>
                    </div>
                @endif
            </div>

            {{-- Contenido 1 --}}
            @if ($post->content_1)
                <div class="mb-4" style="max-width: 860px;">
                    {!! $post->content_1 !!}
                </div>
            @endif

            {{-- Galería de imágenes (primeras 3) --}}
            @if ($post->images->count() > 0)
                <div class="row mb-4">
                    <div class="col-md-6">
                        @foreach ($post->images->take(1) as $image)
                            <img src="{{ $image->image_path }}" class="img-fluid w-100"
                                style="border-radius: 16px; object-fit: cover; height: 340px;" alt="">
                        @endforeach
                    </div>
                    <div class="col-md-6 d-flex flex-column" style="gap: 12px;">
                        @foreach ($post->images->skip(1)->take(2) as $image)
                            <img src="{{ $image->image_path }}" class="img-fluid w-100"
                                style="border-radius: 16px; object-fit: cover; height: 163px;" alt="">
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Contenido 2 --}}
            @if ($post->content_2)
                <div class="mb-4" style="max-width: 860px;">
                    {!! $post->content_2 !!}
                </div>
            @endif

            {{-- Resto de imágenes --}}
            @if ($post->images->count() > 3)
                <div class="row mb-4">
                    @foreach ($post->images->skip(3) as $image)
                        <div class="col-md-3 mb-3">
                            <img src="{{ $image->image_path }}" class="img-fluid w-100"
                                style="border-radius: 12px; object-fit: cover; height: 150px;" alt="">
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
@endsection
