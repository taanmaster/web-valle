@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <a href="{{ route('rrhh.index') }}" class="btn btn-link mb-3 p-0">
                    <ion-icon name="arrow-back"></ion-icon> Volver a vacantes
                </a>

                @php $computedStatus = $vacancy->computed_status; @endphp

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h2 class="mb-0">{{ $vacancy->position_name }}</h2>
                            <span
                                class="badge {{ $computedStatus == 'Abierta' ? 'bg-success' : ($computedStatus == 'Programada' ? 'bg-warning' : 'bg-danger') }} fs-6">
                                {{ $computedStatus }}
                            </span>
                        </div>

                        <div class="row mb-4">
                            @if ($vacancy->dependency)
                                <div class="col-md-6 mb-2">
                                    <strong><ion-icon name="business-outline"></ion-icon> Dependencia:</strong>
                                    {{ $vacancy->dependency }}
                                </div>
                            @endif
                            @if ($vacancy->employment_type)
                                <div class="col-md-6 mb-2">
                                    <strong><ion-icon name="briefcase-outline"></ion-icon> Tipo de empleo:</strong>
                                    {{ $vacancy->employment_type }}
                                </div>
                            @endif
                            @if ($vacancy->work_schedule)
                                <div class="col-md-6 mb-2">
                                    <strong><ion-icon name="time-outline"></ion-icon> Horario:</strong>
                                    {{ $vacancy->work_schedule }}
                                </div>
                            @endif
                            @if ($vacancy->location)
                                <div class="col-md-6 mb-2">
                                    <strong><ion-icon name="location-outline"></ion-icon> Ubicacion:</strong>
                                    {{ $vacancy->location }}
                                </div>
                            @endif
                            @if ($vacancy->closing_date)
                                <div class="col-md-6 mb-2">
                                    <strong><ion-icon name="calendar-outline"></ion-icon> Fecha de cierre:</strong>
                                    {{ $vacancy->closing_date->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        </div>

                        @if ($vacancy->description)
                            <div class="mb-4">
                                <h4>Descripcion del puesto</h4>
                                <div>{!! $vacancy->description !!}</div>
                            </div>
                        @endif

                        @if ($vacancy->requirements)
                            <div class="mb-4">
                                <h4>Requisitos</h4>
                                <div>{!! $vacancy->requirements !!}</div>
                            </div>
                        @endif

                        <hr>

                        {{-- Action button --}}
                        <div class="text-center">
                            @if ($computedStatus == 'Cerrada')
                                <button class="btn btn-secondary btn-lg" disabled>
                                    <ion-icon name="lock-closed-outline"></ion-icon> Vacante cerrada
                                </button>
                            @elseif ($computedStatus == 'Abierta')
                                @auth
                                    @php
                                        $alreadyApplied = $vacancy
                                            ->applications()
                                            ->where('user_id', auth()->id())
                                            ->exists();
                                    @endphp

                                    @if ($alreadyApplied)
                                        <button class="btn btn-success btn-lg" disabled>
                                            <ion-icon name="checkmark-circle-outline"></ion-icon> Ya aplicaste a esta vacante
                                        </button>
                                    @else
                                        <a href="{{ route('rrhh.vacancy.apply', $vacancy->id) }}"
                                            class="btn btn-primary btn-lg">
                                            <ion-icon name="document-text-outline"></ion-icon> Aplicar a esta vacante
                                        </a>
                                    @endif
                                @else
                                    @php
                                        session(['url.intended' => route('rrhh.vacancy.apply', $vacancy->id)]);
                                    @endphp
                                    <p class="text-muted mb-3">Para aplicar a esta vacante necesitas una cuenta</p>
                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                            <ion-icon name="log-in-outline"></ion-icon> Iniciar sesion
                                        </a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                                            <ion-icon name="person-add-outline"></ion-icon> Crear cuenta
                                        </a>
                                    </div>
                                @endauth
                            @else
                                <button class="btn btn-warning btn-lg" disabled>
                                    <ion-icon name="time-outline"></ion-icon> Vacante programada - Aun no disponible
                                </button>
                            @endif
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success mt-3 text-center">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
