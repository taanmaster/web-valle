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

    {{-- Modal: artículo agregado al carrito --}}
    @if(session('cart_added_folio'))
        <div class="modal fade" id="cartAddedModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
                <div class="modal-content" style="border-radius: 14px; border: none;">
                    <div class="modal-body p-4 text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                            <ion-icon name="checkmark-circle" style="font-size: 1.6rem; color: #198754;"></ion-icon>
                            <h5 class="fw-bold mb-0">Artículo agregado a tu carrito</h5>
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3 my-4">
                            <ion-icon name="document-text-outline" style="font-size: 2rem; color: #212529;"></ion-icon>
                            <div class="text-start">
                                <div class="fw-semibold">Trámite</div>
                                <div class="text-muted small">Folio: {{ session('cart_added_folio') }}</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('citizen.cart.index') }}" class="btn btn-dark fw-semibold text-uppercase">
                                Ver carrito
                            </a>
                            <a href="{{ route('citizen.checkout.index') }}" class="btn btn-dark fw-semibold text-uppercase">
                                Pagar pedido
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const el = document.getElementById('cartAddedModal');
                if (el) new bootstrap.Modal(el).show();
            });
        </script>
        @endpush
    @endif
@endsection
