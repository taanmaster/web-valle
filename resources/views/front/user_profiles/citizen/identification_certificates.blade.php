@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menu de navegacion -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <ion-icon name="id-card-outline"></ion-icon> Mis Constancias de Identificacion
                            </h5>
                            <a href="{{ route('citizen.profile.identification_certificates.create') }}"
                                class="btn btn-primary">
                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                            </a>
                        </div>

                        <div class="row">
                            <livewire:identification-certificates.table :mode="1" :userId="Auth::user()->id" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
