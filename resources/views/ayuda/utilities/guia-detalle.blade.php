<div class="guia-detalle" x-data="{ zoom: null, zoomAlt: '' }" @keydown.escape.window="zoom = null">
    @php
        $isAdmin = $this->context === 'admin';
        $indexRoute = $isAdmin ? 'ayuda.admin.guias' : 'ayuda.front.index';
    @endphp

    <style>
        .guia-detalle {
            --gd-navy-1: #33415c;
            --gd-navy-2: #1c2433;
            --gd-navy-bar: #131a27;
            --gd-green: #43925c;
            --gd-green-bg: #eaf4ec;
            --gd-green-text: #2f7a4a;
            --gd-red: #c05b52;
            --gd-red-bg: #f9e9e9;
            --gd-red-text: #a94a42;
            --gd-amber: #c8a52d;
            --gd-amber-bg: #faf3dc;
            --gd-amber-text: #8a6c14;
            --gd-blue: #4d82c4;
            --gd-blue-bg: #e9f1fb;
            --gd-blue-text: #3a67a0;
            --gd-line: #e3e7eb;
            --gd-muted: #8a929b;
        }

        .guia-detalle [x-cloak] {
            display: none !important;
        }

        /* ---- Hero ---- */
        .guia-detalle .gd-hero-media {
            min-height: 170px;
            background: linear-gradient(160deg, var(--gd-navy-1), var(--gd-navy-2));
        }

        .guia-detalle .gd-hero-bar {
            background: var(--gd-navy-bar);
        }

        .guia-detalle .gd-title {
            color: #fff;
            font-weight: 800;
            letter-spacing: .02em;
            font-size: clamp(1.4rem, 3.5vw, 2.1rem);
        }

        .guia-detalle .gd-meta {
            color: rgba(255, 255, 255, .72);
            font-size: .85rem;
            font-weight: 600;
        }

        .guia-detalle .gd-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .45);
            display: inline-block;
            flex: 0 0 auto;
        }

        /* ---- Progreso ---- */
        .guia-detalle .gd-progress {
            height: 8px;
            border-radius: 99px;
            background: #e9ecef;
        }

        .guia-detalle .gd-progress-bar {
            background: var(--gd-green);
            border-radius: 99px;
            transition: width .35s ease;
        }

        /* ---- Timeline ---- */
        .guia-detalle .gd-step-num {
            width: 44px;
            height: 44px;
            flex: 0 0 auto;
            border-radius: 50%;
            border: 2px solid #ced4da;
            background: #fff;
            color: var(--gd-muted);
            font-weight: 700;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .guia-detalle .gd-connector {
            width: 2px;
            flex-grow: 1;
            background: var(--gd-line);
            margin: 6px 0;
        }

        .guia-detalle .gd-step-title {
            font-weight: 800;
            font-size: 1.3rem;
            color: #212529;
        }

        /* ---- Callouts ---- */
        .guia-detalle .gd-callout {
            display: flex;
            align-items: flex-start;
            gap: .65rem;
            padding: .7rem .9rem;
            border-radius: .5rem;
            border-left: 4px solid transparent;
            font-size: .875rem;
            font-weight: 600;
            text-decoration: none;
        }

        .guia-detalle .gd-callout i.bx {
            font-size: 1.15rem;
            line-height: 1.35;
            flex: 0 0 auto;
        }

        .guia-detalle .gd-callout .gd-arrow {
            margin-left: auto;
            align-self: center;
        }

        .guia-detalle .gd-callout-link {
            background: var(--gd-green-bg);
            border-color: var(--gd-green);
            color: var(--gd-green-text);
        }

        .guia-detalle .gd-callout-warning {
            background: var(--gd-red-bg);
            border-color: var(--gd-red);
            color: var(--gd-red-text);
        }

        .guia-detalle .gd-callout-info {
            background: var(--gd-amber-bg);
            border-color: var(--gd-amber);
            color: var(--gd-amber-text);
        }

        .guia-detalle .gd-callout-file {
            background: var(--gd-blue-bg);
            border-color: var(--gd-blue);
            color: var(--gd-blue-text);
        }

        .guia-detalle a.gd-callout:hover {
            filter: brightness(.96);
        }

        .guia-detalle a.gd-callout:hover .gd-arrow {
            transform: translateX(3px);
        }

        .guia-detalle .gd-arrow {
            transition: transform .2s ease;
        }

        /* ---- Captura ---- */
        .guia-detalle .gd-shot {
            display: block;
            width: 100%;
            padding: 0;
            border: 1px solid var(--gd-line);
            border-radius: .75rem;
            overflow: hidden;
            background: #fff;
            cursor: zoom-in;
        }

        .guia-detalle .gd-shot img {
            width: 100%;
            height: auto;
            display: block;
        }

        .guia-detalle .gd-shot-hint {
            display: block;
            padding: .35rem;
            font-size: .75rem;
            color: var(--gd-muted);
            text-align: center;
        }

        .guia-detalle .gd-shot:focus-visible {
            outline: 3px solid rgba(67, 146, 92, .4);
            outline-offset: 2px;
        }

        /* ---- Lightbox ---- */
        .guia-detalle .gd-lightbox {
            position: fixed;
            inset: 0;
            z-index: 1080;
            background: rgba(15, 20, 30, .82);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            cursor: zoom-out;
        }

        .guia-detalle .gd-lightbox img {
            max-width: 100%;
            max-height: 100%;
            border-radius: .5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .5);
        }

        /* ---- Volver ---- */
        .guia-detalle .gd-back {
            background: #fff;
            border: 1px solid var(--gd-line);
            border-radius: .75rem;
            font-weight: 700;
            padding: .7rem 1.5rem;
            color: #212529;
        }

        .guia-detalle .gd-back:hover {
            background: #f8f9fa;
        }

        @media (prefers-reduced-motion: reduce) {
            .guia-detalle * {
                transition: none !important;
            }
        }
    </style>

    {{-- Hero --}}
    <div class="rounded-4 overflow-hidden shadow-sm mb-4">
        <div class="gd-hero-media position-relative">
            @if ($guia->imagen_portada)
                <img src="{{ $guia->portadaUrl() }}" alt="" class="w-100 h-100 position-absolute top-0 start-0"
                    style="object-fit:cover;">
            @endif
        </div>
        <div class="gd-hero-bar px-4 py-3">
            <h2 class="gd-title text-uppercase mb-2">{{ $guia->titulo }}</h2>
            <div class="d-flex flex-wrap column-gap-4 row-gap-1">
                @if ($guia->dependencia)
                    <span class="gd-meta d-flex align-items-center gap-2">
                        <span class="gd-dot"></span> {{ $guia->dependencia }}
                    </span>
                @endif
                @if ($guia->categoria)
                    <span class="gd-meta d-flex align-items-center gap-2">
                        <span class="gd-dot"></span> {{ $guia->categoria->nombre }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Descripción --}}
    @if ($guia->descripcion)
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4 text-secondary">
            {{ $guia->descripcion }}
        </div>
    @endif

    @if ($total > 0)
        {{-- Timeline de pasos --}}
        <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5 mb-4">
            @foreach ($guia->pasos as $i => $p)
                <div class="d-flex gap-3 gap-lg-4">
                    {{-- Riel: número + conector --}}
                    <div class="d-flex flex-column align-items-center">
                        <div class="gd-step-num" aria-hidden="true">
                            {{ $i + 1 }}
                        </div>
                        @unless ($loop->last)
                            <span class="gd-connector" aria-hidden="true"></span>
                        @endunless
                    </div>

                    {{-- Contenido del paso --}}
                    <div class="flex-grow-1 {{ $loop->last ? '' : 'pb-4' }}">
                        <div class="row g-4">
                            <div class="{{ $p->imagen_apoyo ? 'col-lg-8' : 'col-12' }}">
                                <h3 class="gd-step-title mb-1">{{ $p->titulo }}</h3>
                                @if ($p->descripcion)
                                    <p class="text-muted mb-3">{{ $p->descripcion }}</p>
                                @endif

                                <div class="d-flex flex-column gap-2">
                                    {{-- Enlace --}}
                                    @if ($p->enlace_url)
                                        <a href="{{ $p->enlace_url }}" target="_blank" rel="noopener"
                                            class="gd-callout gd-callout-link">
                                            <i class="bx bx-link-external"></i>
                                            <span>{{ $p->enlace_texto ?: $p->enlace_url }}</span>
                                            <i class="bx bx-right-arrow-alt gd-arrow"></i>
                                        </a>
                                    @endif

                                    {{-- Pregunta frecuente --}}
                                    @if ($p->pregunta_frecuente)
                                        <div class="gd-callout gd-callout-info">
                                            <i class="bx bx-info-circle"></i>
                                            <span>{{ $p->pregunta_frecuente }}</span>
                                        </div>
                                    @endif

                                    {{-- Advertencia --}}
                                    @if ($p->mensaje_advertencia)
                                        <div class="gd-callout gd-callout-warning">
                                            <i class="bx bx-error"></i>
                                            <span>{{ $p->mensaje_advertencia }}</span>
                                        </div>
                                    @endif

                                    {{-- Archivo adjunto --}}
                                    @if ($p->archivo_adjunto)
                                        <a href="{{ $p->archivoAdjuntoUrl() }}" target="_blank" rel="noopener"
                                            class="gd-callout gd-callout-file">
                                            <i class="bx bx-file"></i>
                                            <span>Descargar archivo adjunto</span>
                                            <i class="bx bx-download gd-arrow"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Imagen de apoyo --}}
                            @if ($p->imagen_apoyo)
                                <div class="col-lg-4">
                                    <button type="button" class="gd-shot"
                                        @click="zoom = '{{ $p->imagenApoyoUrl() }}'; zoomAlt = 'Imagen de apoyo del paso {{ $i + 1 }}'"
                                        aria-label="Ampliar imagen de apoyo del paso {{ $i + 1 }}">
                                        <img src="{{ $p->imagenApoyoUrl() }}"
                                            alt="Imagen de apoyo del paso {{ $i + 1 }}" loading="lazy">
                                        <span class="gd-shot-hint">captura · clic para ampliar</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-4 shadow-sm text-center py-5 text-muted mb-4">
            Esta guía no tiene pasos aún.
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route($indexRoute) }}" class="btn gd-back shadow-sm">
            Volver al listado
        </a>
    </div>

    {{-- Lightbox --}}
    <div x-show="zoom" x-cloak x-transition.opacity class="gd-lightbox" @click="zoom = null" role="dialog"
        aria-modal="true" aria-label="Imagen ampliada">
        <img :src="zoom" :alt="zoomAlt">
    </div>
</div>
