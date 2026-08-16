@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.environment.utilities._nav')

        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-center">
                <h2 class="mb-4 wow fadeInUp d-flex align-items-center justify-content-center gap-2">
                    <ion-icon name="{{ $procedure['icon'] }}" class="text-success"></ion-icon>
                    {{ $procedure['title'] }}
                </h2>

                <div class="d-flex flex-wrap justify-content-center gap-3 wow fadeInUp">
                    {{-- La ruta del hub ya exige sesión de ciudadano: si no hay
                         sesión, Laravel redirige al login por sí solo. --}}
                    <a href="{{ route('citizen.my_requests', 'medio-ambiente') }}" class="btn btn-primary px-4">
                        Iniciar trámite
                    </a>

                    @if (!empty($procedure['has_floristic_list']))
                        <a href="{{ route('environment.floristic_list') }}"
                            class="btn btn-secondary px-4 d-inline-flex align-items-center gap-2">
                            <ion-icon name="download-outline"></ion-icon> Consultar listado florístico
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- PASOS --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                @foreach ($procedure['steps'] as $index => $step)
                    <div class="card card-normal wow fadeInUp mb-3">
                        <div class="card-content">
                            <h5 class="fw-bold mb-1">{{ $loop->iteration }}. {{ $step['title'] }}</h5>
                            <p class="text-muted mb-0">{{ $step['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- DONACIÓN: aviso de disponibilidad --}}
        @if (!empty($procedure['warning']))
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="alert alert-warning border-0 shadow-sm wow fadeInUp" role="alert">
                        <h6 class="fw-bold mb-1">{{ $procedure['warning']['title'] }}</h6>
                        <p class="mb-0">{{ $procedure['warning']['text'] }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- COSTO --}}
        @if (!empty($procedure['cost']))
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="card card-normal bg-light wow fadeInUp">
                        <div class="card-content">
                            <h6 class="fw-bold text-uppercase mb-2">Costo</h6>
                            <p class="mb-0">{{ $procedure['cost']['label'] }}</p>

                            @if (!empty($procedure['cost']['note']))
                                <p class="text-muted small mb-0 mt-3">{{ $procedure['cost']['note'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- DONACIÓN: nota de disponibilidad y rechazo --}}
        @if (!empty($procedure['notice']))
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="card card-normal bg-light wow fadeInUp">
                        <div class="card-content">
                            <p class="text-muted small mb-0">{{ $procedure['notice'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
