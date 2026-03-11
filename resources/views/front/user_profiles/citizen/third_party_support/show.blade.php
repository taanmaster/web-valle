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
                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="mb-1">
                                    <ion-icon name="earth-outline"></ion-icon> {{ $thirdPartyRequest->event_name }}
                                </h5>
                                <div class="d-flex gap-3 text-muted small">
                                    <span><strong>Folio:</strong> {{ $thirdPartyRequest->folio }}</span>
                                    <span><strong>Enviada:</strong> {{ $thirdPartyRequest->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <span class="badge bg-{{ $thirdPartyRequest->status_color }} fs-6">
                                {{ $thirdPartyRequest->status }}
                            </span>
                        </div>

                        {{-- Componente compartido --}}
                        <livewire:tourism.third-party-request.request-detail
                            :request="$thirdPartyRequest"
                            mode="citizen" />


                        {{-- Botón Volver --}}
                        <div class="text-center mt-4">
                            <a href="{{ route('citizen.third_party.index') }}" class="btn btn-secondary">
                                <ion-icon name="arrow-back-outline"></ion-icon> Volver a Mis Solicitudes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
