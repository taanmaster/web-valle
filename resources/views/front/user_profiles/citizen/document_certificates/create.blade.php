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
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4 gap-3">
                            <a href="{{ route('citizen.profile.document_certificates') }}"
                                class="btn btn-outline-secondary btn-sm">
                                <ion-icon name="arrow-back-outline"></ion-icon> Regresar
                            </a>
                            <h5 class="mb-0">
                                <ion-icon name="document-text-outline"></ion-icon>
                                Nueva Solicitud de Certificación de Documento
                            </h5>
                        </div>

                        <livewire:front.document-certificates.crud />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
