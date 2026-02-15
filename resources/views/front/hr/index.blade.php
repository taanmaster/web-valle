@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <h2>Vacantes - Recursos Humanos</h2>
                        <p>Conoce las oportunidades laborales disponibles en el municipio</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row wow fadeInUp mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                        <ion-icon name="briefcase-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Vacantes disponibles</h3>
                </div>
            </div>
        </div>

        @if ($vacancies->count() == 0)
            <div class="row wow fadeInUp">
                <div class="col-md-12 text-center py-5">
                    <h4>No hay vacantes disponibles por el momento</h4>
                    <p class="text-muted">Vuelve pronto para ver nuevas oportunidades laborales.</p>
                </div>
            </div>
        @else
            <div class="row wow fadeInUp">
                @foreach ($vacancies as $vacancy)
                    @php $computedStatus = $vacancy->computed_status; @endphp
                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('rrhh.vacancy.detail', $vacancy->id) }}" class="text-decoration-none">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ $vacancy->position_name }}</h5>
                                        <span
                                            class="badge {{ $computedStatus == 'Abierta' ? 'bg-success' : ($computedStatus == 'Programada' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $computedStatus }}
                                        </span>
                                    </div>

                                    @if ($vacancy->dependency)
                                        <p class="text-muted mb-1">
                                            <ion-icon name="business-outline"></ion-icon>
                                            {{ $vacancy->dependency }}
                                        </p>
                                    @endif

                                    @if ($vacancy->employment_type)
                                        <p class="text-muted mb-1">
                                            <ion-icon name="briefcase-outline"></ion-icon>
                                            {{ $vacancy->employment_type }}
                                        </p>
                                    @endif

                                    @if ($vacancy->location)
                                        <p class="text-muted mb-1">
                                            <ion-icon name="location-outline"></ion-icon>
                                            {{ $vacancy->location }}
                                        </p>
                                    @endif

                                    @if ($vacancy->closing_date)
                                        <p class="text-muted mb-0 mt-2">
                                            <small>
                                                <ion-icon name="calendar-outline"></ion-icon>
                                                Cierre: {{ $vacancy->closing_date->format('d/m/Y') }}
                                            </small>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="d-flex align-items-center justify-content-center mt-4">
                {{ $vacancies->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
