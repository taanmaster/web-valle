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

        .birthday-hero img {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.45;
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

        /* Visor de foto del mes */
        .bd-viewer {
            border-radius: 1rem;
            background: #ebebeb;
            overflow: hidden;
            min-height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 2rem;
        }

        .bd-viewer img {
            width: 100%;
            height: 100%;
            max-height: 640px;
            object-fit: cover;
            display: block;
        }

        .bd-viewer .bd-empty {
            text-align: center;
            color: #aaa;
            padding: 4rem 1rem;
        }

        .bd-photo-swap {
            transition: opacity .25s ease, transform .25s ease;
            opacity: 1;
            transform: scale(1);
            width: 100%;
        }

        .bd-photo-swap.is-fading {
            opacity: 0;
            transform: scale(.985);
        }

        /* Botones de mes */
        .bd-month-btn {
            width: 100%;
            padding: .9rem 0;
            border-radius: 50rem;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            font-size: .85rem;
        }

        @media (prefers-reduced-motion: reduce) {
            .bd-photo-swap { transition: none; }
        }
    </style>

    {{-- Hero --}}
    <div class="birthday-hero">
        <img src="{{ asset('images/birthday.png') }}" alt="">
        <div class="content z-3 position-relative top-0 left-0 right-0 bottom-0">
            <h2>En su día especial reciban<br>nuestros mejores deseos</h2>

            <p>
                ¡Muchas felicidades! En esta administración creemos que los grandes cambios comienzan con personas felices y
                motivadas. Hoy brindamos por tu vida y por la huella positiva que dejas en tu departamento. Que hoy sea un
                día
                para recargar baterías, disfrutar el camino y recordar que tu talento es nuestro mayor orgullo.
                ¡Sigue brillando y transformando tu entorno!
            </p>
        </div>
    </div>

    {{-- Foto del mes --}}
    <div class="bd-viewer">
        <div id="bd-photo-container" class="bd-photo-swap">
            @php $current = $months->firstWhere('num', $currentMonth); @endphp
            @if ($current && $current['photo'])
                <img id="bd-photo" src="{{ $current['photo'] }}" alt="Cumpleaños de {{ $current['name'] }}">
            @else
                <div class="bd-empty" id="bd-photo">
                    <i class="ti ti-cake" style="font-size:3rem;"></i>
                    <p class="mb-0 fw-semibold mt-2">Aún no hay foto para {{ $current['name'] ?? 'este mes' }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Botones de meses --}}
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3 mb-4" role="group" aria-label="Meses de cumpleaños">
        @foreach ($months as $month)
            <div class="col">
                <button type="button"
                    class="btn bd-month-btn {{ $month['num'] === $currentMonth ? 'btn-primary active' : 'btn-light' }}"
                    data-month="{{ $month['num'] }}"
                    data-photo="{{ $month['photo'] ?? '' }}"
                    data-name="{{ $month['name'] }}"
                    @if ($month['num'] === $currentMonth) aria-pressed="true" @endif>
                    {{ $month['name'] }}
                </button>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('bd-photo-container');
            const buttons = document.querySelectorAll('.bd-month-btn');

            // Pre-carga de fotos para que el cambio sea instantáneo
            buttons.forEach(btn => {
                if (btn.dataset.photo) {
                    const img = new Image();
                    img.src = btn.dataset.photo;
                }
            });

            buttons.forEach(btn => {
                btn.addEventListener('click', function () {
                    if (this.classList.contains('active')) return;

                    // Estado activo (Bootstrap)
                    buttons.forEach(b => {
                        b.classList.remove('btn-primary', 'active');
                        b.classList.add('btn-light');
                        b.removeAttribute('aria-pressed');
                    });
                    this.classList.remove('btn-light');
                    this.classList.add('btn-primary', 'active');
                    this.setAttribute('aria-pressed', 'true');

                    const photo = this.dataset.photo;
                    const name = this.dataset.name;

                    // Fade out → swap → fade in
                    container.classList.add('is-fading');
                    setTimeout(() => {
                        if (photo) {
                            container.innerHTML = '<img id="bd-photo" src="' + photo +
                                '" alt="Cumpleaños de ' + name + '">';
                        } else {
                            container.innerHTML = '<div class="bd-empty" id="bd-photo">' +
                                '<i class="ti ti-cake" style="font-size:3rem;"></i>' +
                                '<p class="mb-0 fw-semibold mt-2">Aún no hay foto para ' + name + '</p></div>';
                        }
                        container.classList.remove('is-fading');
                    }, 250);
                });
            });
        });
    </script>
@endsection
