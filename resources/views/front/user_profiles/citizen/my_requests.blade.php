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
                        <h5 class="mb-4">
                            <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes
                        </h5>

                        <div class="row">
                            {{-- Card S.A.R.E --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-2">
                                                <ion-icon name="document-text-outline" class="me-1"></ion-icon> S.A.R.E
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-semibold">S.A.R.E</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            Gestiona y da seguimiento a tus solicitudes ciudadanas de S.A.R.E.
                                        </p>
                                        <a href="{{ route('citizen.profile.requests') }}" class="btn btn-primary">
                                            <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Apoyos a Terceros --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 mb-2">
                                                <ion-icon name="earth-outline" class="me-1"></ion-icon> Turismo
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-semibold">Apoyos a Terceros</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            Gestiona y da seguimiento a tus solicitudes ciudadanas de apoyo a terceros de Turismo.
                                        </p>
                                        <a href="{{ route('citizen.third_party.index') }}" class="btn btn-success">
                                            <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Ayuda --}}
                        <div class="border rounded text-center p-3 mt-2">
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
