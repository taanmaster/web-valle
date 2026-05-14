@extends('layouts.master')
@section('title') {{ $entry->title }} @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Eventos Conmemorativos @endslot
        @slot('li_2') Artículo @endslot
        @slot('title') {{ $entry->title }} @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            {{-- Acciones --}}
            <div class="d-flex mb-3" style="gap:8px;">
                <a href="{{ route('events_blog.admin.edit', $entry->id) }}" class="btn btn-sm btn-outline-secondary">
                    <i class='bx bx-edit'></i> Editar
                </a>
                <a href="{{ route('events_blog.admin.index') }}" class="btn btn-sm btn-secondary">
                    &larr; Volver
                </a>
            </div>

            {{-- Hero --}}
            <div class="card mb-4"
                style="border-radius:16px; overflow:hidden; min-height:380px; position:relative; background:#d0d0d0;">
                @if ($entry->hero_img && $entry->hero_img !== 'empty-image.jpg')
                    <img src="{{ asset('images/events-blog/' . $entry->hero_img) }}"
                        style="width:100%; height:380px; object-fit:cover; position:absolute; top:0; left:0;" alt="">
                    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.35);"></div>
                @endif
                <div style="position:relative; z-index:1; display:flex; flex-direction:column; justify-content:center; align-items:center; min-height:380px; padding:40px;">
                    <h1 style="font-size:clamp(2rem,5vw,3.5rem); font-weight:800; text-transform:uppercase; text-align:center;
                        color:{{ $entry->hero_img && $entry->hero_img !== 'empty-image.jpg' ? '#fff' : '#555' }}; letter-spacing:2px;">
                        {{ $entry->title }}
                    </h1>
                    @if ($entry->description)
                        <p style="color:{{ $entry->hero_img && $entry->hero_img !== 'empty-image.jpg' ? 'rgba(255,255,255,0.85)' : '#777' }}; text-align:center; max-width:600px; margin-top:12px;">
                            {{ $entry->description }}
                        </p>
                    @endif
                </div>
                @if ($entry->published_at)
                    <div style="position:absolute; bottom:16px; left:50%; transform:translateX(-50%); white-space:nowrap;
                        color:{{ $entry->hero_img && $entry->hero_img !== 'empty-image.jpg' ? 'rgba(255,255,255,0.8)' : '#888' }}; font-size:0.85rem;">
                        Publicado el <strong>{{ \Carbon\Carbon::parse($entry->published_at)->translatedFormat('M d, Y') }}</strong>
                    </div>
                @endif
            </div>

            {{-- Contenido 1 --}}
            @if ($entry->content_1)
                <div class="mb-4" style="max-width:860px;">
                    {!! $entry->content_1 !!}
                </div>
            @endif

            {{-- Galería primeras 3 imágenes --}}
            @if ($entry->images->count() > 0)
                <div class="row mb-4">
                    <div class="col-md-6">
                        @foreach ($entry->images->take(1) as $image)
                            <img src="{{ asset($image->image_path) }}" class="img-fluid w-100"
                                style="border-radius:16px; object-fit:cover; height:340px;" alt="">
                        @endforeach
                    </div>
                    <div class="col-md-6 d-flex flex-column" style="gap:12px;">
                        @foreach ($entry->images->skip(1)->take(2) as $image)
                            <img src="{{ asset($image->image_path) }}" class="img-fluid w-100"
                                style="border-radius:16px; object-fit:cover; height:163px;" alt="">
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Contenido 2 --}}
            @if ($entry->content_2)
                <div class="mb-4" style="max-width:860px;">
                    {!! $entry->content_2 !!}
                </div>
            @endif

            {{-- Resto de imágenes --}}
            @if ($entry->images->count() > 3)
                <div class="row mb-4">
                    @foreach ($entry->images->skip(3) as $image)
                        <div class="col-md-3 mb-3">
                            <img src="{{ asset($image->image_path) }}" class="img-fluid w-100"
                                style="border-radius:12px; object-fit:cover; height:150px;" alt="">
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
@endsection
