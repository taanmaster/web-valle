@extends('front.layouts.app')

@section('title', 'Mis Mensajes')

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
                        <h5 class="card-title mb-0">
                            <ion-icon name="mail-outline"></ion-icon> Mis Mensajes
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($messages->isEmpty())
                            <div class="text-center py-5">
                                <ion-icon name="mail-outline" class="text-muted" style="font-size: 3rem"></ion-icon>
                                <p class="text-muted mb-0 mt-3">No tienes mensajes.</p>
                            </div>
                        @else
                            <div class="list-group">
                                @foreach ($messages as $message)
                                    <a href="{{ route('citizen.messages.show', $message->id) }}"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-{{ $message->read_at ? 'normal' : 'bold' }}">
                                                {{ $message->subject }}
                                            </div>
                                            <small class="text-muted">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        @unless ($message->read_at)
                                            <span class="badge bg-danger rounded-pill">Nuevo</span>
                                        @endunless
                                    </a>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $messages->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
