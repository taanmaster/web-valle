@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')

    <style>
        .home-hero {
            position: relative;
            width: 100%;
            height: 720px;
            overflow: hidden;
            border-radius: 0.5rem;
            background-color: #3a2020;
            margin-bottom: 2rem;
        }

        .home-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.75);
            position: absolute;
            z-index: 0;
            top: 0;
            left: 0;
        }

        .home-hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(85, 19, 18, 0.88);
            padding: 14px 24px;
        }

        .home-hero-overlay h2 {
            color: #fff;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin: 0;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .section-link {
            font-size: 0.85rem;
            color: #551312;
            text-decoration: none;
            font-weight: 500;
        }

        .section-link:hover {
            text-decoration: underline;
            color: #551312;
        }

        .event-card {
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #e9ecef;
            background: #f5f5f5;
            aspect-ratio: 1 / 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            position: relative;
            text-decoration: none;
        }

        .event-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .event-card-body {
            background: rgba(85, 19, 18, 0.82);
            color: #fff;
            padding: 10px 12px;
        }

        .event-card-title {
            font-size: 0.85rem;
            font-weight: 600;
            margin: 0 0 2px 0;
            color: #fff;
        }

        .event-card-date {
            font-size: 0.75rem;
            opacity: 0.85;
            margin: 0;
        }

        .event-card-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8e4e4;
        }

        .info-card {
            border: 1.5px solid #e0e0e0;
            border-radius: 0.75rem;
            padding: 1.5rem;
            height: 100%;
            background: #fff;
        }

        .info-card h5 {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.75rem;
            line-height: 1.35;
        }

        .info-card p {
            font-size: 0.875rem;
            color: #555;
            line-height: 1.6;
        }

        .info-card ul {
            padding-left: 1.1rem;
            margin-bottom: 0;
        }

        .info-card ul li {
            font-size: 0.875rem;
            margin-bottom: 0.35rem;
        }

        .info-card a {
            color: #551312;
            text-decoration: none;
        }

        .info-card a:hover {
            text-decoration: underline;
        }

        .events-empty {
            aspect-ratio: 1 / 1;
            background: #ebebeb;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 0.8rem;
            flex-direction: column;
            gap: 6px;
        }
    </style>

    {{-- Hero Banner --}}
    <div class="home-hero">
        <img src="{{ asset('images/group-pic.png') }}" alt="">
        <div class="home-hero-overlay">
            <h2>Nuestro Equipo Valle de Santiago</h2>
        </div>
    </div>

    {{-- Eventos Conmemorativos --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="section-title mb-0">Eventos conmemorativos</h4>
        <a href="{{ route('events_blog.admin.index') }}" class="section-link">
            Ver más eventos &nbsp;<i class="ti ti-arrow-right"></i>
        </a>
    </div>

    <div class="row g-3 mb-4">
        @forelse($events as $event)
            <div class="col-6 col-md-3">
                <a href="{{ route('events_blog.admin.detail', $event->id) }}" class="event-card d-block">
                    @if ($event->hero_img)
                        <img src="{{ $event->hero_img }}"
                            style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" alt="">
                    @else
                        <div class="event-card-placeholder">
                            <i class="ti ti-calendar-event" style="font-size: 2.5rem; color: #bbb;"></i>
                        </div>
                    @endif
                    <div class="event-card-body" style="position:relative;z-index:1;">
                        <p class="event-card-title">{{ $event->title }}</p>
                        @if ($event->published_at)
                            <p class="event-card-date">
                                {{ \Carbon\Carbon::parse($event->published_at)->format('d M Y') }}
                            </p>
                        @endif
                    </div>
                </a>
            </div>
        @empty
            @for ($i = 0; $i < 4; $i++)
                <div class="col-6 col-md-3">
                    <div class="events-empty">
                        <i class="ti ti-calendar-off" style="font-size: 2rem;"></i>
                        <span>Sin eventos</span>
                    </div>
                </div>
            @endfor
        @endforelse
    </div>

    {{-- Tres tarjetas informativas --}}
    <div class="row g-3 mb-4">

        {{-- Desempeño Laboral --}}
        <div class="col-12 col-md-4">
            <div class="info-card">
                <h5>Desempeño Laboral</h5>
                <p>Agrupa iniciativas relacionadas al desarrollo y evaluación del personal.</p>
                <ul>
                    <li><a href="#">Sistema de evaluación de desempeño</a></li>
                    <li><a href="#">Bienestar laboral</a></li>
                </ul>
            </div>
        </div>

        {{-- Programa de Profesionalización --}}
        <div class="col-12 col-md-4">
            <div class="info-card">
                <h5>Programa de Profesionalización</h5>
                <p>Tu crecimiento empieza aquí. Este portal reúne capacitaciones diseñadas para impulsar tu carrera y tu
                    bienestar.</p>
                <p>La oferta se basa en dos pilares:<br>
                    1- Formación técnica especializada para mejorar tu desempeño profesional<br>
                    2- Talleres de bienestar personal para potenciar enfoque, creatividad y equilibrio emocional
                </p>
                <p>El objetivo es ayudarte a lograr un balance entre tu desarrollo profesional y tu vida personal.</p>
                <p>Explora la oferta académica y comienza hoy.</p>
                <ul>
                    <li><a href="#">Programas de capacitación</a></li>
                </ul>
            </div>
        </div>

        {{-- Comunicación y Vinculación --}}
        <div class="col-12 col-md-4">
            <div class="info-card">
                <h5>Comunicación y Vinculación Organizacional Interdepartamental</h5>
                <p>Espacio para fortalecer la cultura organizacional y comunicación interna.</p>
                <ul>
                    <li><a href="#">Cumpleaños de la administración</a></li>
                    <li><a href="#">Programas de identidad</a></li>
                </ul>
            </div>
        </div>

    </div>

@endsection

@section('script')
@endsection
