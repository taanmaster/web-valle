@extends('layouts.master')
@section('title')
    {{ $entry->title }}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Medio Ambiente
        @endslot
        @slot('li_2')
            Blog
        @endslot
        @slot('title')
            {{ $entry->title }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="d-flex gap-2 mb-4">
                        <a href="{{ route('medio_ambiente_blog.admin.edit', $entry->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <a href="{{ route('medio_ambiente_blog.admin.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bx bx-arrow-back"></i> Volver
                        </a>
                    </div>

                    @if ($entry->hero_img)
                        <img src="{{ $entry->hero_img }}" class="img-fluid w-100 rounded mb-4"
                            alt="Portada de {{ $entry->title }}">
                    @endif

                    <h2 class="mb-2">{{ $entry->title }}</h2>
                    @if ($entry->published_at)
                        <p class="text-muted small mb-4">
                            Publicado el {{ \Carbon\Carbon::parse($entry->published_at)->translatedFormat('d \d\e F, Y') }}
                        </p>
                    @endif

                    @if ($entry->description)
                        <p class="lead mb-4">{{ $entry->description }}</p>
                    @endif

                    @if ($entry->content_1)
                        <div class="mb-4">{!! $entry->content_1 !!}</div>
                    @endif

                    @if ($entry->images->count())
                        <div class="row mb-4">
                            @foreach ($entry->images as $image)
                                <div class="col-md-4 mb-3">
                                    <img src="{{ $image->image_path }}" class="img-fluid w-100 rounded" alt="">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($entry->content_2)
                        <div class="mb-0">{!! $entry->content_2 !!}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
