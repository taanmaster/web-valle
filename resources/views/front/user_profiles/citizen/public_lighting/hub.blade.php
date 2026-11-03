@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="#" role="tab">
                                    <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-4">
                            <ion-icon name="bulb-outline"></ion-icon> Alumbrado Público — Mis Solicitudes
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 mb-2">
                                                <ion-icon name="bulb-outline" class="me-1"></ion-icon> Alumbrado Público
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-semibold">Peticiones servicio de alumbrado público</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            Reporta luminarias apagadas, intermitentes o dañadas en tu colonia.
                                        </p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('citizen.public_lighting.create') }}" class="btn" style="background-color:#6d1b2b; color:#fff;">
                                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Petición
                                            </a>
                                            <a href="{{ route('citizen.public_lighting.index') }}" class="btn btn-secondary">
                                                <ion-icon name="eye-outline"></ion-icon> Ver Peticiones
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
