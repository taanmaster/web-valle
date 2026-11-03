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
                        <h6 class="mb-0">Protección Civil - Mis trámites</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="row">
                            @forelse ($procedures as $procedure)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border">
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-3">
                                                <span class="badge bg-secondary bg-opacity-10 text-dark px-3 py-2">
                                                    <ion-icon name="radio-outline" class="me-1"></ion-icon> Protección Civil
                                                </span>
                                            </div>
                                            <h5 class="card-title fw-semibold">{{ $procedure->name }}</h5>
                                            <p class="card-text text-muted flex-grow-1">{{ $procedure->description }}</p>
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('citizen.civil_protection.start', $procedure) }}" class="btn" style="background-color:#6d1b2b; color:#fff;">
                                                    <ion-icon name="add-circle-outline"></ion-icon> Iniciar
                                                </a>
                                                <a href="{{ route('citizen.civil_protection.index') }}" class="btn btn-secondary">
                                                    <ion-icon name="eye-outline"></ion-icon> Ver mis trámites
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <ion-icon name="file-tray-outline" style="font-size: 3rem;" class="text-muted"></ion-icon>
                                    <p class="mb-0 text-muted">Por ahora no hay trámites de Protección Civil disponibles en línea.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

