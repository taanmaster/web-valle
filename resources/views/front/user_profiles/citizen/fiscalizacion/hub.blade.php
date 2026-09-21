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
                            <ion-icon name="shield-checkmark-outline"></ion-icon> Fiscalización — Mis Solicitudes
                        </h5>

                        <div class="row">
                            {{-- Tarjeta 1: Permiso de Venta en Vía Pública (funcional) --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 mb-2">
                                                <ion-icon name="shield-checkmark-outline" class="me-1"></ion-icon> Fiscalización
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-semibold">Permiso de Venta en Vía Pública</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            Trámite para solicitar un permiso de ocupación temporal del espacio en la vía pública para venta de productos
                                        </p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('citizen.fisc.street_vending.create') }}" class="btn" style="background-color:#6d1b2b; color:#fff;">
                                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                                            </a>
                                            <a href="{{ route('citizen.fisc.street_vending.index') }}" class="btn btn-secondary">
                                                <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tarjeta 2: Autorización de Eventos en Vía Pública (próximamente) --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 mb-2">
                                                <ion-icon name="shield-checkmark-outline" class="me-1"></ion-icon> Fiscalización
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-semibold">Autorización de Eventos en Vía Pública</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            Trámite para autorizar eventos en espacio público.
                                        </p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('citizen.fisc.public_event.create') }}" class="btn" style="background-color:#6d1b2b; color:#fff;">
                                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                                            </a>
                                            <a href="{{ route('citizen.fisc.public_event.index') }}" class="btn btn-secondary">
                                                <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tarjeta 3: Autorización de Eventos Particulares --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 mb-2">
                                                <ion-icon name="shield-checkmark-outline" class="me-1"></ion-icon> Fiscalización
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-semibold">Autorización de Eventos Particulares</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            Trámite para autorizar eventos en espacios cerrados o salones (no vía pública).
                                        </p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('citizen.fisc.private_event.create') }}" class="btn" style="background-color:#6d1b2b; color:#fff;">
                                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                                            </a>
                                            <a href="{{ route('citizen.fisc.private_event.index') }}" class="btn btn-secondary">
                                                <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tarjeta 4: Permiso de Publicidad en Vía Pública (captura exclusiva de Fiscalización) --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 mb-2">
                                                <ion-icon name="shield-checkmark-outline" class="me-1"></ion-icon> Fiscalización
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-semibold">Permiso de Publicidad en Vía Pública</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            Incluye lonas, carteles, perifoneo y volanteo.
                                        </p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('citizen.fisc.advertising.index') }}" class="btn btn-secondary">
                                                <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                            </a>
                                        </div>
                                        <small class="text-muted mt-2">
                                            <ion-icon name="information-circle-outline"></ion-icon> Este trámite se captura en Fiscalización, acude con tu material publicitario.
                                        </small>
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
