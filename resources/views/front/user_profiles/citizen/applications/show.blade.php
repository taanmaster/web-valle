@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        {{-- Volver --}}
                        <a href="{{ route('citizen.profile.applications') }}"
                            class="btn btn-link p-0 mb-3 text-decoration-none">
                            <ion-icon name="arrow-back-outline"></ion-icon> Volver a vacantes
                        </a>

                        <div class="row">
                            {{-- Detalle de la vacante --}}
                            <div class="col-lg-5 mb-4 mb-lg-0">
                                @php $computedStatus = $vacancy->computed_status; @endphp
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <h5 class="fw-semibold mb-0">{{ $vacancy->position_name }}</h5>
                                        <span
                                            class="badge {{ $computedStatus === 'Abierta' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $computedStatus === 'Abierta' ? 'Abierta' : 'Concluida' }}
                                        </span>
                                    </div>

                                    <ul class="list-unstyled text-muted small mb-0">
                                        @if ($vacancy->dependency)
                                            <li class="mb-2">
                                                <ion-icon name="business-outline" class="me-1"></ion-icon>
                                                {{ $vacancy->dependency }}
                                            </li>
                                        @endif
                                        @if ($vacancy->employment_type)
                                            <li class="mb-2">
                                                <ion-icon name="briefcase-outline" class="me-1"></ion-icon>
                                                {{ $vacancy->employment_type }}
                                            </li>
                                        @endif
                                        @if ($vacancy->work_schedule)
                                            <li class="mb-2">
                                                <ion-icon name="time-outline" class="me-1"></ion-icon>
                                                {{ $vacancy->work_schedule }}
                                            </li>
                                        @endif
                                        @if ($vacancy->location)
                                            <li class="mb-2">
                                                <ion-icon name="location-outline" class="me-1"></ion-icon>
                                                {{ $vacancy->location }}
                                            </li>
                                        @endif
                                        @if ($vacancy->closing_date)
                                            <li class="mb-2">
                                                <ion-icon name="calendar-outline" class="me-1"></ion-icon>
                                                Cierre: {{ $vacancy->closing_date->format('d/m/Y') }}
                                            </li>
                                        @endif
                                    </ul>

                                    @if ($vacancy->description)
                                        <hr>
                                        <h6 class="fw-semibold small text-uppercase text-muted">Descripcion</h6>
                                        <div class="small mb-0">{!! $vacancy->description !!}</div>
                                    @endif

                                    @if ($vacancy->requirements)
                                        <hr>
                                        <h6 class="fw-semibold small text-uppercase text-muted">Requisitos</h6>
                                        <div class="small mb-0">{!! $vacancy->requirements !!}</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Formulario de aplicacion --}}
                            <div class="col-lg-7">
                                @if ($hasApplied)
                                    <div class="border rounded p-4 text-center">
                                        <ion-icon name="checkmark-circle" class="text-success"
                                            style="font-size: 48px;"></ion-icon>
                                        <h5 class="fw-semibold mt-3">Ya aplicaste a esta vacante</h5>
                                        <p class="text-muted mb-0">Tu solicitud fue recibida. Te contactaremos si tu perfil
                                            es seleccionado.</p>
                                    </div>
                                @elseif ($vacancy->computed_status !== 'Abierta')
                                    <div class="border rounded p-4 text-center">
                                        <ion-icon name="lock-closed-outline" class="text-secondary"
                                            style="font-size: 48px;"></ion-icon>
                                        <h5 class="fw-semibold mt-3">Vacante concluida</h5>
                                        <p class="text-muted mb-0">Esta vacante ya no acepta nuevas solicitudes.</p>
                                    </div>
                                @else
                                    <div class="border rounded p-3">
                                        <h5 class="fw-semibold mb-3">Aplicar a vacante</h5>
                                        <livewire:front.h-r.apply-form :vacancy="$vacancy" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
