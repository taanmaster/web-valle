@extends('layouts.master')
@section('title')
    Bienestar Laboral
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Desempeño Laboral
        @endslot
        @slot('title')
            Bienestar Laboral
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            {{-- Hero --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card text-center"
                        style="background:#e8e8e8; border:none; border-radius:16px; padding:60px 40px;">
                        <h2 style="font-weight:800; letter-spacing:2px;">BIENESTAR LABORAL</h2>
                        <p class="mt-3 mb-0 mx-auto" style="max-width:680px;">
                            En esta administración, sabemos que detrás de cada trámite, cada proyecto y cada atención
                            ciudadana, hay una persona increíble. Tú eres el motor de nuestra institución, y para que
                            ese motor funcione al 100%, lo más importante es que tú te sientas bien.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ¿Qué es el Bienestar? --}}
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h4 style="color:#1a1aff; border-bottom:3px solid #1a1aff; padding-bottom:8px;">
                        ¿Qué es el Bienestar para nosotros?
                    </h4>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card h-100" style="background:#f0f0f0; border:none; border-radius:16px;">
                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                            <p class="mb-0">
                                No es solo tener un escritorio cómodo; es que vengas a trabajar con una sonrisa, que
                                sepas manejar los días difíciles y que sientas que aquí, además de un profesional,
                                eres un ser humano valorado.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card h-100 d-flex align-items-center justify-content-center"
                        style="background:#e0e0e0; border:none; border-radius:16px; min-height:180px;">
                        <i class='bx bx-image-alt' style="font-size:2.5rem; color:#aaa;"></i>
                    </div>
                </div>
            </div>

            {{-- Blog entries --}}
            @if ($posts->count() > 0)
                <div class="row mb-3">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Artículos publicados</h5>
                    </div>
                </div>

                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('welfare.admin.detail', $post->id) }}" class="text-decoration-none">
                                <div class="card" style="border-radius:12px; overflow:hidden;">
                                    <img src="{{ asset('images/welfare-blog/' . $post->hero_img) }}" alt="{{ $post->title }}"
                                        style="height:200px; object-fit:cover; width:100%; background:#ccc;">
                                    <div class="card-body" style="background:#555; border-radius:0 0 12px 12px;">
                                        <h6 class="text-white mb-1" style="font-weight:700; text-transform:uppercase;">
                                            {{ $post->title }}
                                        </h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-secondary" style="width:10px;height:10px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row mb-3">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Artículos publicados</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center py-5 text-muted">
                        <i class='bx bx-file-blank' style="font-size:2.5rem;"></i>
                        <p class="mt-2">No hay entradas todavía.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
