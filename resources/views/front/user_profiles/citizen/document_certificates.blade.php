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
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <ion-icon name="document-text-outline"></ion-icon> Mis Certificaciones de Documentos
                            </h5>
                            <a href="{{ route('citizen.profile.document_certificates.create') }}"
                                class="btn btn-primary">
                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                            </a>
                        </div>

                        <div class="row">
                            <livewire:document-certificates.table :mode="1" :userId="Auth::user()->id" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
