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
                                <ion-icon name="earth-outline"></ion-icon> Nueva Solicitud de Apoyo a Terceros
                            </h5>
                            <a href="{{ route('citizen.third_party.index') }}" class="btn btn-outline-secondary btn-sm">
                                <ion-icon name="arrow-back-outline"></ion-icon> Volver
                            </a>
                        </div>

                        <livewire:front.tourism.third-party-wizard />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
