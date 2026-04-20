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
                            <ion-icon name="storefront-outline"></ion-icon> Servicios Municipales en Línea
                        </h5>
                        <a href="{{ route('citizen.cart.index') }}" class="btn btn-outline-primary btn-sm position-relative">
                            <ion-icon name="cart-outline"></ion-icon> Carrito
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($services->isEmpty())
                        <div class="text-center text-muted py-5">
                            <ion-icon name="cube-outline" style="font-size:3rem"></ion-icon>
                            <p class="mt-2">No hay servicios disponibles por el momento.</p>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($services as $service)
                            <div class="col-md-6">
                                <div class="card h-100 border">
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title mb-1">
                                            <ion-icon name="document-text-outline"></ion-icon>
                                            Solicitar {{ $service->name }}
                                        </h6>
                                        @if($service->description)
                                            <p class="card-text text-muted small mb-2">{{ $service->description }}</p>
                                        @endif
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-success fs-6">${{ number_format($service->unit_price, 2) }}</span>
                                            <form action="{{ route('citizen.cart.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="billable_service_id" value="{{ $service->id }}">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <ion-icon name="cart-outline"></ion-icon> Agregar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
