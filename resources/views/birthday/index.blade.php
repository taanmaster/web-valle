@extends('layouts.master')
@section('title')
    Cumpleaños de Admin
@endsection
@section('content')
    <style>
        .birthday-hero {
            border-radius: 1rem;
            background: #e8e4e4;
            padding: 3rem 3rem 3rem 3rem;
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .birthday-hero-img {
            position: absolute;
            top: 1.5rem;
            right: 2rem;
            width: 90px;
            height: 90px;
            background: #d4cfcf;
            border-radius: .75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
        }

        .birthday-hero h2 {
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            font-weight: 800;
            text-transform: uppercase;
            color: #1a1a1a;
            letter-spacing: 1px;
            max-width: 600px;
            line-height: 1.25;
            margin-bottom: 1.25rem;
        }

        .birthday-hero p {
            font-size: .9rem;
            color: #555;
            max-width: 680px;
            line-height: 1.65;
        }

        .birthday-card {
            background: #ebebeb;
            border-radius: .75rem;
            padding: 1.1rem 1.25rem 1rem;
        }

        .birthday-card .bd-date {
            font-size: .78rem;
            color: #888;
            margin-bottom: .4rem;
        }

        .birthday-card .bd-name {
            font-size: .9rem;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            margin-bottom: .2rem;
        }

        .birthday-card .bd-area {
            font-size: .82rem;
            color: #666;
        }
    </style>

    {{-- Hero --}}
    <div class="birthday-hero">
        <div class="birthday-hero-img">
            <i class="ti ti-photo" style="font-size:2.5rem;"></i>
        </div>

        <h2>En su día especial reciban<br>nuestros mejores deseos</h2>

        <p>
            ¡Muchas felicidades! En esta administración creemos que los grandes cambios comienzan con personas felices y
            motivadas. Hoy brindamos por tu vida y por la huella positiva que dejas en tu departamento. Que hoy sea un día
            para recargar baterías, disfrutar el camino y recordar que tu talento es nuestro mayor orgullo.
            ¡Sigue brillando y transformando tu entorno!
        </p>
    </div>

    {{-- Grid de cumpleaños --}}
    <div class="row g-3">
        @forelse ($birthdays as $birthday)
            <div class="col-12 col-md-4">
                <div class="birthday-card">
                    <p class="bd-date">{{ \Carbon\Carbon::parse($birthday->birthday_date)->format('d/m/y') }}</p>
                    <p class="bd-name">{{ $birthday->name }}</p>
                    <p class="bd-area">{{ $birthday->area }}</p>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="d-flex flex-column align-items-center justify-content-center py-5 text-center"
                    style="background:#f5f3f3; border-radius:1rem; gap:12px;">
                    <i class="ti ti-cake" style="font-size:3rem; color:#ccc;"></i>
                    <p class="mb-0 fw-semibold" style="color:#aaa; font-size:.95rem;">
                        Aún no hay cumpleaños registrados
                    </p>
                    <a href="{{ route('birthday.admin.manage') }}" class="btn btn-sm btn-primary mt-1">
                        Agregar cumpleaños
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
