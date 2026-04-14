@extends('front.layouts.app')

@section('content')
<div class="container py-4">
    @include('front.user_profiles.partials._profile_card')

    <div class="row g-3 mt-0">
        <div class="col-md-3">
            @include('front.user_profiles.partials._profile_nav')
        </div>
        <div class="col-md-9">

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Resumen del pedido --}}
            <div class="card wow fadeInUp mb-3">
                <div class="card-body">
                    <h5 class="mb-3"><ion-icon name="receipt-outline"></ion-icon> Resumen del pedido</h5>
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Servicio</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                            <tr>
                                <td>{{ $item->billableService->name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format($item->billableService->unit_price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="2">TOTAL</th>
                                <th class="text-end">${{ number_format($cart->items->sum(fn($i) => $i->billableService->unit_price * $i->quantity), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Selección de método de pago --}}
            <div class="card wow fadeInUp">
                <div class="card-body">
                    <h5 class="mb-3"><ion-icon name="card-outline"></ion-icon> Método de pago</h5>

                    <form action="{{ route('citizen.checkout.pay') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-4">
                            {{-- Tarjeta BanBajío --}}
                            <div class="col-md-6">
                                <label class="card border p-3 w-100 cursor-pointer" style="cursor:pointer">
                                    <input type="radio" name="payment_method" value="banbajio" class="d-none payment-radio">
                                    <div class="d-flex align-items-center gap-3">
                                        <ion-icon name="card-outline" style="font-size:2rem;color:#0066cc"></ion-icon>
                                        <div>
                                            <div class="fw-semibold">Tarjeta Bancaria</div>
                                            <small class="text-muted">Débito / Crédito — BanBajío</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            {{-- OXXOPay --}}
                            <div class="col-md-6">
                                <label class="card border p-3 w-100 cursor-pointer" style="cursor:pointer">
                                    <input type="radio" name="payment_method" value="oxxopay" class="d-none payment-radio">
                                    <div class="d-flex align-items-center gap-3">
                                        <ion-icon name="cash-outline" style="font-size:2rem;color:#e00000"></ion-icon>
                                        <div>
                                            <div class="fw-semibold">Pago en efectivo</div>
                                            <small class="text-muted">OXXOPay — paga en cualquier OXXO</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            {{-- Pago de prueba (solo APP_ENV=local) --}}
                            @if(app()->environment('local'))
                            <div class="col-md-6">
                                <label class="card border border-warning p-3 w-100" style="cursor:pointer">
                                    <input type="radio" name="payment_method" value="test_payment" class="d-none payment-radio">
                                    <div class="d-flex align-items-center gap-3">
                                        <ion-icon name="flask-outline" style="font-size:2rem;color:#f0ad4e"></ion-icon>
                                        <div>
                                            <div class="fw-semibold">
                                                Pago de Prueba
                                                <span class="badge bg-warning text-dark ms-1" style="font-size:0.65rem;">SOLO LOCAL</span>
                                            </div>
                                            <small class="text-muted">Simula un pago con tarjeta bancaria aprobado</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endif
                        </div>

                        @error('payment_method')
                            <div class="text-danger small mb-3">{{ $message }}</div>
                        @enderror

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('citizen.cart.index') }}" class="btn btn-outline-secondary btn-sm">
                                <ion-icon name="arrow-back-outline"></ion-icon> Volver al carrito
                            </a>
                            <button type="submit" class="btn btn-success" id="btn-pagar" disabled>
                                <ion-icon name="lock-closed-outline"></ion-icon> Pagar ahora
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.payment-radio').forEach(radio => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('.card.border').forEach(c => c.classList.remove('border-primary', 'bg-light'));
        radio.closest('.card').classList.add('border-primary', 'bg-light');
        document.getElementById('btn-pagar').disabled = false;
    });
});
</script>
@endpush
