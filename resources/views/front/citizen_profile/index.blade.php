@extends('front.layouts.app')

@push('styles')

@endpush

@section('content')
<div class="container py-4">
    @if(session('welcome'))
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-check-circle display-6 me-3"></i>
                        <div>
                            <h5 class="alert-heading">¡Bienvenido {{ Auth::user()->name }}!</h5>
                            <p class="mb-0">Tu cuenta ha sido creada exitosamente. Ahora puedes acceder a todos los servicios ciudadanos disponibles.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            
            @include('front.citizen_profile.partials._profile_card')

            <!-- Menú de navegación -->
            <div class="card wow fadeInUp">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="citizenProfileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="{{ route('citizen.profile.index') }}" 
                               id="inicio-tab" role="tab">
                                <ion-icon name="home-outline"></ion-icon> Inicio
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('citizen.profile.edit') }}" 
                               id="perfil-tab" role="tab">
                                <ion-icon name="create-outline"></ion-icon> Editar Perfil
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('citizen.profile.requests') }}" 
                               id="solicitudes-tab" role="tab">
                                <ion-icon name="file-tray-full-outline"></ion-icon> Solicitudes S.A.R.E
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('citizen.profile.urban_dev_requests') }}" 
                               id="solicitudes-tab" role="tab">
                                <ion-icon name="file-tray-full-outline"></ion-icon> Trámites Desarrollo Urbano
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('citizen.profile.settings') }}" 
                               id="configuraciones-tab" role="tab">
                                <ion-icon name="cog-outline"></ion-icon> Configuraciones
                            </a>
                        </li>
                    </ul>
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
                                            <p class="card-text">Gestiona y da seguimiento a tus solicitudes ciudadanas.</p>
                                        </div>
                                        <a href="{{ route('citizen.profile.requests') }}" class="btn btn-primary quick-action-btn">
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
                                            <p class="card-text">Actualiza tu información personal y datos de contacto.</p>
                                        </div>
                                        <a href="{{ route('citizen.profile.edit') }}" class="btn btn-success quick-action-btn">
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
                                            <p class="card-text">Ajusta tus preferencias y configuraciones de cuenta.</p>
                                        </div>
                                        <a href="{{ route('citizen.profile.settings') }}" class="btn btn-info quick-action-btn">
                                            Configurar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h6 class="alert-heading">
                                    <i class="bx bx-info-circle"></i> Información importante
                                </h6>
                                <p class="mb-0">
                                    Bienvenido al portal ciudadano. Aquí podrás realizar solicitudes, dar seguimiento a trámites, 
                                    actualizar tu información personal y configurar tus preferencias de notificaciones.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="mb-3">Acciones Rápidas</h6>
                            <div class="btn-group" role="group">
                                <a href="{{ route('citizen.profile.requests') }}" class="btn btn-outline-primary">
                                    <i class="bx bx-plus"></i> Nueva Solicitud
                                </a>
                                <a href="{{ route('citizen.profile.edit') }}" class="btn btn-outline-success">
                                    <i class="bx bx-edit"></i> Actualizar Datos
                                </a>
                                <a href="#" class="btn btn-outline-info">
                                    <i class="bx bx-help-circle"></i> Ayuda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection