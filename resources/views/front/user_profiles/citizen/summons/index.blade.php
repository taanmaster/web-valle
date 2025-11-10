@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="citizenProfileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.index') }}" id="inicio-tab"
                                    role="tab">
                                    <ion-icon name="home-outline"></ion-icon> Inicio
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.edit') }}" id="perfil-tab"
                                    role="tab">
                                    <ion-icon name="create-outline"></ion-icon> Editar Perfil
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.requests') }}" id="solicitudes-tab"
                                    role="tab">
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
                                <a class="nav-link active" href="{{ route('citizen.summons.index') }}" id="citatorios-tab"
                                    role="tab">
                                    <ion-icon name="document-text-outline"></ion-icon>Citatorios
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.settings') }}" id="configuraciones-tab"
                                    role="tab">
                                    <ion-icon name="cog-outline"></ion-icon> Configuraciones
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <!-- Lista de solicitudes -->
                        <div class="row">
                            @if ($summons->count() > 0)
                                <livewire:summons.table :mode="$mode" :citizen="$citizenId" />
                            @else
                                <!-- Estado vacío -->
                                <div class="col-md-12" id="emptyState">
                                    <div class="text-center py-5">
                                        <i class="bx bx-file display-1 text-muted"></i>
                                        <h5 class="mt-3">No tienes solicitudes citatorios</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .avatar {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-lg {
            width: 4rem;
            height: 4rem;
        }

        .avatar-initial {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .timeline-item {
            display: block;
            margin-bottom: 0.5rem;
        }

        .dropzone {
            min-height: 10rem;
            border: 3px dotted #d9d9d9;
            position: relative;
            border-radius: 15px;
            margin-bottom: 20px;
        }
    </style>
@endsection
