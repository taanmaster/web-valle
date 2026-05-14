@extends('layouts.master')
@section('title')
    Programa de Capacitación
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Programa de Profesionalización
        @endslot
        @slot('title')
            Programa de Capacitación
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            {{-- Hero Banner --}}
            <div class="row mb-4">
                <div class="col-12">
                    {{-- Imagen de fondo pendiente por proporcionar --}}
                    <div class="card text-center"
                        style="background: #d6d6d6; border: none; border-radius: 16px; padding: 80px 40px; position: relative; overflow: hidden;">
                        <h2
                            style="font-weight: 800; letter-spacing: 3px; color: #fff; text-shadow: 0 2px 8px rgba(0,0,0,.4);">
                            PROGRAMA DE CAPACITACIÓN
                        </h2>
                        <div class="mt-4">
                            <a href="{{ route('training_blog.admin.index') }}" class="btn px-5 py-2 fw-bold"
                                style="background: #f5c842; color: #1a1a1a; border-radius: 50px; letter-spacing: 1px; font-size: .85rem;">
                                CONOCE LAS CAPACITACIONES
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Entradas del Blog --}}
            @if ($posts->count() > 0)
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('training.admin.detail', $post->id) }}" class="text-decoration-none">
                                <div class="card" style="border-radius: 12px; overflow: hidden;">
                                    <img src="{{ asset('images/training-blog/' . $post->hero_img) }}"
                                        alt="{{ $post->title }}"
                                        style="height: 200px; object-fit: cover; width: 100%; background: #ccc;">
                                    <div class="card-body" style="background: #555; border-radius: 0 0 12px 12px;">
                                        <h6 class="text-white mb-1" style="font-weight: 700; text-transform: uppercase;">
                                            {{ $post->title }}
                                        </h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-secondary" style="width: 10px; height: 10px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Skeleton: se reemplaza cuando existan entradas reales --}}
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card" style="border-radius: 12px; overflow: hidden;">
                            <div style="height: 200px; background: #d6d6d6;"></div>
                            <div class="card-body" style="background: #888; border-radius: 0 0 12px 12px;">
                                <p class="text-white mb-1 fw-bold" style="text-transform: uppercase; font-size: .8rem;">
                                    Sin título
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 10px; height: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card" style="border-radius: 12px; overflow: hidden;">
                            <div style="height: 200px; background: #d6d6d6;"></div>
                            <div class="card-body" style="background: #888; border-radius: 0 0 12px 12px;">
                                <p class="text-white mb-1 fw-bold" style="text-transform: uppercase; font-size: .8rem;">
                                    Sin título
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-secondary" style="width: 10px; height: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
