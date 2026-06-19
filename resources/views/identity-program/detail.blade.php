@extends('layouts.master')
@section('title') {{ $entry->title }} @endsection

@push('stylesheets')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
    integrity="sha384-G0pg86Lj7XwiCQ/NoHwtwRHuXmraYGh2A3fl8nJ/PC+IYnAjhsf0l7sOJr4Qiqj0"
    crossorigin="anonymous" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,650&display=swap" rel="stylesheet">
<style>
    .ipd { --ip-brick: #551312; --ip-cream: #FAF6EF; --ip-amber: #F5C842; --ip-ink: #2b2118; }

    .ipd-hero { position: relative; border-radius: 18px; overflow: hidden; min-height: 340px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #551312 0%, #7a2422 100%); }
    .ipd-hero img.ipd-hero-bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .ipd-hero .ipd-overlay { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(25, 12, 8, .35) 0%, rgba(25, 12, 8, .65) 100%); }
    .ipd-hero-content { position: relative; text-align: center; color: #fff; padding: 3rem 1.5rem; max-width: 760px; }
    .ipd-hero-content h1 { font-family: 'Fraunces', serif; font-weight: 650; font-size: clamp(1.8rem, 4vw, 3rem); margin-bottom: .75rem; }
    .ipd-hero-content .ipd-desc { font-size: .95rem; opacity: .85; margin-bottom: 1.25rem; }
    .ipd-hero-content .ipd-meta { font-size: .8rem; letter-spacing: .08em; text-transform: uppercase; opacity: .75; }

    .ipd-body { max-width: 820px; margin: 0 auto; padding: 2.5rem 0; }
    .ipd-content { color: #4a4238; line-height: 1.75; font-size: .98rem; }
    .ipd-content h1, .ipd-content h2, .ipd-content h3 { font-family: 'Fraunces', serif; color: var(--ip-ink); }

    .ipd-gallery { display: grid; grid-template-columns: 1.25fr 1fr; gap: 1rem; margin: 2.25rem 0; }
    .ipd-gallery .ipd-g-item { border-radius: 16px; overflow: hidden; background: #e7e2d9; min-height: 200px; }
    .ipd-gallery .ipd-g-item:first-child { grid-row: span 2; min-height: 420px; }
    .ipd-gallery img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
    .ipd-gallery .ipd-g-item:hover img { transform: scale(1.05); }
    .ipd-gallery--single { grid-template-columns: 1fr; }
    .ipd-gallery--single .ipd-g-item:first-child { grid-row: auto; }

    @keyframes ipdFadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
    .ipd-reveal { animation: ipdFadeUp .55s ease both; }

    @media (prefers-reduced-motion: reduce) {
        .ipd-reveal { animation: none; }
        .ipd-gallery img { transition: none; }
    }

    @media (max-width: 767.98px) {
        .ipd-gallery { grid-template-columns: 1fr; }
        .ipd-gallery .ipd-g-item:first-child { grid-row: auto; min-height: 240px; }
    }
</style>
@endpush

@section('content')
    <div class="row layout-spacing">
        <div class="main-content ipd">

            <div class="mb-3">
                <a href="{{ route('identity_program.admin.portal') }}" class="btn btn-link text-muted p-0">
                    <i class="bx bx-left-arrow-alt"></i> Volver al Programa de Identidad
                </a>
            </div>

            {{-- Hero --}}
            <div class="ipd-hero ipd-reveal">
                @if ($entry->hero_img)
                    <img src="{{ $entry->hero_img }}" alt="{{ $entry->title }}" class="ipd-hero-bg">
                @endif
                <div class="ipd-overlay"></div>
                <div class="ipd-hero-content">
                    <h1>{{ $entry->title }}</h1>
                    @if ($entry->description)
                        <p class="ipd-desc">{{ $entry->description }}</p>
                    @endif
                    @if ($entry->published_at)
                        <div class="ipd-meta">
                            Publicado el {{ $entry->published_at->translatedFormat('d \d\e F \d\e Y') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="ipd-body">

                {{-- Contenido 1 --}}
                @if ($entry->content_1)
                    <div class="ipd-content trix-content ipd-reveal" style="animation-delay: .12s;">
                        {!! $entry->content_1 !!}
                    </div>
                @endif

                {{-- Galería --}}
                @if ($entry->images->isNotEmpty())
                    <div class="ipd-gallery {{ $entry->images->count() === 1 ? 'ipd-gallery--single' : '' }} ipd-reveal"
                        style="animation-delay: .2s;">
                        @foreach ($entry->images as $image)
                            <div class="ipd-g-item">
                                <img src="{{ $image->image_path }}" alt="{{ $entry->title }}">
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Contenido 2 --}}
                @if ($entry->content_2)
                    <div class="ipd-content trix-content ipd-reveal" style="animation-delay: .28s;">
                        {!! $entry->content_2 !!}
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection
