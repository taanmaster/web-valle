@extends('front.layouts.app')

@section('content')
<div class="container py-4">
    @include('front.user_profiles.partials._profile_card')

    <div class="row g-3 mt-0">
        <div class="col-md-3">
            @include('front.user_profiles.partials._profile_nav')
        </div>
        <div class="col-md-9">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card wow fadeInUp">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">
                            <ion-icon name="cart-outline"></ion-icon> Mi Carrito
                        </h5>
                        <a href="{{ route('citizen.services.index') }}" class="btn btn-outline-secondary btn-sm">
                            <ion-icon name="arrow-back-outline"></ion-icon> Seguir comprando
                        </a>
                    </div>

                    @if($cart->items->isEmpty())
                        <div class="text-center text-muted py-5">
                            <ion-icon name="cart-outline" style="font-size:3rem"></ion-icon>
                            <p class="mt-2">Tu carrito está vacío.</p>
                            <a href="{{ route('citizen.services.index') }}" class="btn btn-primary btn-sm mt-2">Ver servicios</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Servicio</th>
                                        <th class="text-center" style="width:160px">Copias / Cantidad</th>
                                        <th class="text-end">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $item->billableService->name }}</div>
                                            <div class="text-muted small">${{ number_format($item->billableService->unit_price, 2) }} c/u</div>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('citizen.cart.update', $item) }}" method="POST" class="d-flex align-items-center justify-content-center gap-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="btn btn-outline-secondary btn-sm px-2">−</button>
                                                <span class="fw-bold mx-1">{{ $item->quantity }}</span>
                                                <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="btn btn-outline-secondary btn-sm px-2">+</button>
                                            </form>
                                        </td>
                                        <td class="text-end fw-semibold">
                                            ${{ number_format($item->billableService->unit_price * $item->quantity, 2) }}
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('citizen.cart.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted">Total:</span>
                                <span class="fs-4 fw-bold ms-2">
                                    ${{ number_format($cart->items->sum(fn($i) => $i->billableService->unit_price * $i->quantity), 2) }}
                                </span>
                            </div>
                            <a href="{{ route('citizen.checkout.index') }}" class="btn btn-success">
                                <ion-icon name="card-outline"></ion-icon> Proceder al pago
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
