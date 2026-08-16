@extends('front.layouts.app')

@section('title', 'Mensaje')

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
                        <h5 class="card-title mb-0">{{ $message->subject }}</h5>
                        <small class="text-muted">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <div class="card-body">
                        <p class="mb-4" style="white-space: pre-line;">{{ $message->body }}</p>

                        <a href="{{ route('citizen.messages.index') }}" class="btn btn-secondary">
                            <ion-icon name="arrow-back-outline"></ion-icon> Volver a Mis Mensajes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
