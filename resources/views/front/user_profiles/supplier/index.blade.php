@extends('front.layouts.app')

@push('styles')
@endpush

@section('content')
    <div class="container py-4">
        @if (session('welcome'))
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-check-circle display-6 me-3"></i>
                            <div>
                                <h5 class="alert-heading">¡Bienvenido {{ Auth::user()->name }}!</h5>
                                <p class="mb-0">Tu cuenta ha sido creada exitosamente. Ahora puedes acceder a todos los
                                    servicios ciudadanos disponibles.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">

                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <!-- Contenido de la pestaña Inicio -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card quick-action-card wow fadeInUp h-100">
                                    <div class="card-body">
                                        <div class="quick-action-icon primary">
                                            <ion-icon name="file-tray-full-outline"></ion-icon>
                                        </div>
                                        <div class="quick-action-content">
                                            <div>
                                                <h5 class="card-title">Mis Solicitudes</h5>
                                                <p class="card-text">Gestiona y da seguimiento a tus solicitudes ciudadanas.
                                                </p>
                                            </div>
                                            <a href="{{ route('citizen.profile.requests') }}"
                                                class="btn btn-primary quick-action-btn">
                                                Ver Solicitudes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="card quick-action-card wow fadeInUp h-100">
                                    <div class="card-body">
                                        <div class="quick-action-icon success">
                                            <ion-icon name="person-circle-outline"></ion-icon>
                                        </div>
                                        <div class="quick-action-content">
                                            <div>
                                                <h5 class="card-title">Mi Perfil</h5>
                                                <p class="card-text">Actualiza tu información personal y datos de contacto.
                                                </p>
                                            </div>
                                            <a href="{{ route('citizen.profile.edit') }}"
                                                class="btn btn-success quick-action-btn">
                                                Editar Perfil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="card quick-action-card wow fadeInUp h-100">
                                    <div class="card-body">
                                        <div class="quick-action-icon info">
                                            <ion-icon name="cog-outline"></ion-icon>
                                        </div>
                                        <div class="quick-action-content">
                                            <div>
                                                <h5 class="card-title">Configuraciones</h5>
                                                <p class="card-text">Ajusta tus preferencias y configuraciones de cuenta.
                                                </p>
                                            </div>
                                            <a href="{{ route('citizen.profile.settings') }}"
                                                class="btn btn-info quick-action-btn">
                                                Configurar
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
