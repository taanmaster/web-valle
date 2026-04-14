@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <ion-icon name="close-circle-outline" style="font-size:4rem;color:#dc3545"></ion-icon>
            <h4 class="mt-3">Pago no completado</h4>
            <p class="text-muted">No se pudo procesar tu pago. Puedes intentarlo de nuevo.</p>
            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="{{ route('citizen.cart.index') }}" class="btn btn-outline-secondary btn-sm">
                    <ion-icon name="cart-outline"></ion-icon> Volver al carrito
                </a>
                <a href="{{ route('citizen.orders.index') }}" class="btn btn-primary btn-sm">
                    <ion-icon name="list-outline"></ion-icon> Mis órdenes
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
