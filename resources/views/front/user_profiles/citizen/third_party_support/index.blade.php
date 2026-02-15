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
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <ion-icon name="earth-outline"></ion-icon> Mis Solicitudes de Apoyo a Terceros
                            </h5>
                            <a href="{{ route('citizen.third_party.create') }}" class="btn btn-primary">
                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <livewire:front.tourism.third-party-requests-table />

                        {{-- Ayuda --}}
                        <div class="border rounded text-center p-3 mt-4">
                            <p class="text-muted mb-0 small">
                                ¿Necesitas ayuda? Contacta a la Dirección de Turismo:
                                <a href="mailto:turismo@valledesantiago.gob.mx">turismo@valledesantiago.gob.mx</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
