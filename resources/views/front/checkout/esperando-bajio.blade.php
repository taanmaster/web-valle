@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body text-center p-4">
                    <ion-icon name="time-outline" class="text-primary" style="font-size:3rem"></ion-icon>
                    <h4 class="mt-3">Esperando confirmación de pago</h4>
                    <p class="text-muted mb-4">Completa el pago en la pestaña segura de BanBajío. Esta página se actualizará al recibir la confirmación.</p>
                    <a href="{{ $paymentUrl }}" target="_blank" rel="noopener" class="btn btn-primary">Abrir portal de pago</a>
                    <p id="payment-status" class="small text-muted mt-4 mb-0">Tu pago está pendiente.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const paymentUrl = @json($paymentUrl);
const statusUrl = @json(route('citizen.checkout.status', $dbOrder));
const statusMessage = document.getElementById('payment-status');

window.open(paymentUrl, '_blank', 'noopener');

const pollPaymentStatus = async () => {
    try {
        const response = await fetch(statusUrl, { headers: { Accept: 'application/json' } });
        const payment = await response.json();

        statusMessage.textContent = `Estatus: ${payment.payment_status}`;
        if (payment.payment_status === 'Pagado') {
            window.location.assign(@json(route('bajiopay.complete')));
        }
    } catch (_) {
        statusMessage.textContent = 'Seguimos esperando la confirmación de BanBajío.';
    }
};

pollPaymentStatus();
setInterval(pollPaymentStatus, 5000);
</script>
@endpush