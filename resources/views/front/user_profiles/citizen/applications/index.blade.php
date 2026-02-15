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
                        {{-- Header con estadísticas --}}
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                            <h4 class="fw-semibold mb-2 mb-md-0">Solicitudes de Vacantes</h4>
                            @if ($vacancies->count() > 0)
                                @php
                                    $totalOpen = $vacancies->where('computed_status', 'Abierta')->count();
                                    $totalClosed = $vacancies->filter(fn($v) => $v->computed_status !== 'Abierta')->count();
                                    $totalApplied = count($appliedVacancyIds);
                                @endphp
                                <div class="d-flex gap-3">
                                    <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-3 py-2">
                                        {{ $totalOpen }} {{ $totalOpen == 1 ? 'abierta' : 'abiertas' }}
                                    </span>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary fw-semibold px-3 py-2">
                                        {{ $totalClosed }} {{ $totalClosed == 1 ? 'concluida' : 'concluidas' }}
                                    </span>
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-3 py-2">
                                        {{ $totalApplied }} {{ $totalApplied == 1 ? 'aplicada' : 'aplicadas' }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        @if ($vacancies->count() == 0)
                            <div class="text-center py-5 wow fadeInUp">
                                <ion-icon name="briefcase-outline" class="display-4 text-muted mb-3 d-block mx-auto"></ion-icon>
                                <h5 class="fw-semibold">No hay vacantes disponibles</h5>
                                <p class="text-muted">Vuelve pronto para ver nuevas oportunidades laborales.</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush wow fadeInUp">
                                @foreach ($vacancies as $vacancy)
                                    @php
                                        $computedStatus = $vacancy->computed_status;
                                        $isOpen = $computedStatus === 'Abierta';
                                        $hasApplied = in_array($vacancy->id, $appliedVacancyIds);
                                    @endphp
                                    <a href="{{ route('citizen.profile.applications.show', $vacancy->id) }}"
                                        class="list-group-item list-group-item-action border rounded mb-2 px-3 py-3 {{ !$isOpen && !$hasApplied ? 'opacity-50 pe-none' : '' }}">
                                        <div class="d-flex align-items-center gap-3">
                                            {{-- Indicador lateral --}}
                                            <div class="rounded-pill {{ $isOpen ? 'bg-success' : 'bg-secondary' }}"
                                                style="width: 4px; min-height: 40px; align-self: stretch;"></div>

                                            {{-- Contenido --}}
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                                    <h6 class="fw-semibold mb-0">{{ $vacancy->position_name }}</h6>
                                                    <span class="badge {{ $isOpen ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 {{ $isOpen ? 'text-success' : 'text-secondary' }}">
                                                        {{ $isOpen ? 'Abierta' : 'Concluida' }}
                                                    </span>
                                                    @if ($hasApplied)
                                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                                            <ion-icon name="checkmark-circle" class="me-1" style="font-size: 13px; vertical-align: -2px;"></ion-icon>
                                                            Aplicaste
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-wrap gap-3 text-muted small">
                                                    @if ($vacancy->dependency)
                                                        <span>
                                                            <ion-icon name="business-outline" class="me-1"></ion-icon>
                                                            {{ $vacancy->dependency }}
                                                        </span>
                                                    @endif
                                                    @if ($vacancy->employment_type)
                                                        <span>
                                                            <ion-icon name="briefcase-outline" class="me-1"></ion-icon>
                                                            {{ $vacancy->employment_type }}
                                                        </span>
                                                    @endif
                                                    @if ($vacancy->location)
                                                        <span>
                                                            <ion-icon name="location-outline" class="me-1"></ion-icon>
                                                            {{ $vacancy->location }}
                                                        </span>
                                                    @endif
                                                    @if ($vacancy->closing_date)
                                                        <span>
                                                            <ion-icon name="calendar-outline" class="me-1"></ion-icon>
                                                            Cierre: {{ $vacancy->closing_date->format('d/m/Y') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Flecha --}}
                                            <ion-icon name="chevron-forward-outline" class="text-muted fs-5 d-none d-md-block"></ion-icon>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $vacancies->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                        {{-- Ayuda --}}
                        <div class="border rounded text-center p-3 mt-4">
                            <p class="text-muted mb-0 small">
                                ¿Necesitas ayuda? Contacta a soporte ciudadano:
                                <a href="mailto:comunicacion.social@valledesantiago.gob.mx">comunicacion.social@valledesantiago.gob.mx</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
