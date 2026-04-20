@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            @if($order)
            <div class="card shadow-sm">
                <div class="card-body text-center py-4">
                    @if($order->payment_method === 'oxxopay')
                        <ion-icon name="storefront-outline" style="font-size:4rem;color:#e00000"></ion-icon>
                        <h4 class="mt-2 mb-1">Orden Guardada</h4>
                        <p class="text-muted mb-0">Para completar tu orden debes realizar el pago en efectivo en tu tienda OXXO más cercana con la referencia que te proporcionaron. Al completarla tu orden aparecerá como pagada y podrás descargar el recibo.</p>
                    @else
                        <ion-icon name="checkmark-circle-outline" style="font-size:4rem;color:#28a745"></ion-icon>
                        <h4 class="mt-2 mb-0">¡Pago procesado!</h4>
                        <p class="text-muted">Tu orden ha sido registrada exitosamente.</p>
                    @endif
                </div>

                {{-- Cabecera de la orden --}}
                <div class="card-body border-top">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="text-muted small">Folio</div>
                            <div class="fw-bold">{{ $order->folio }}</div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Estado del pago</div>
                            <div class="fw-bold text-warning">{{ $order->payment_status }}</div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Estado de entrega</div>
                            <div class="fw-bold text-warning">{{ $order->delivery_status }}</div>
                        </div>
                    </div>
                </div>

                {{-- Items --}}
                <div class="card-body border-top">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center border rounded p-2 mb-2">
                        <ion-icon name="document-text-outline" class="me-3 fs-4 text-secondary"></ion-icon>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $item->service_name }}</div>
                            <div class="text-muted small">Folio: {{ $order->folio }}</div>
                        </div>
                        <div class="fw-bold">${{ number_format($item->subtotal, 2) }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Totales --}}
                <div class="card-body border-top">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold">TOTAL</span>
                        <span class="fw-bold">${{ number_format($order->total, 2) }}</span>
                    </div>
                    @if($order->paid_amount)
                    <div class="d-flex justify-content-between text-success">
                        <span class="fw-bold">PAGADO</span>
                        <span class="fw-bold">${{ number_format($order->paid_amount, 2) }}</span>
                    </div>
                    @endif
                </div>

                {{-- Método de pago --}}
                <div class="card-body border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-uppercase">Método de pago</span>
                        <div class="text-end">
                            <span class="fw-semibold text-uppercase">{{ $order->payment_method }}</span>
                            @if($order->payment_reference)
                                <br><small class="text-muted">Referencia: {{ $order->payment_reference }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body border-top d-flex justify-content-between">
                    <a href="{{ route('citizen.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                        <ion-icon name="list-outline"></ion-icon> Mis órdenes
                    </a>
                    @if($order->payment_status === 'Pagado')
                        <a href="{{ route('citizen.orders.receipt', $order) }}" class="btn btn-primary btn-sm">
                            <ion-icon name="download-outline"></ion-icon> Descargar recibo
                        </a>
                    @else
                        <span class="btn btn-outline-secondary btn-sm disabled" title="El recibo estará disponible cuando se confirme el pago">
                            <ion-icon name="download-outline"></ion-icon> Recibo pendiente
                        </span>
                    @endif
                </div>
            </div>

            @else
            {{-- Sin orden en sesión --}}
            <div class="card shadow-sm text-center py-5">
                <ion-icon name="checkmark-circle-outline" style="font-size:4rem;color:#28a745"></ion-icon>
                <h4 class="mt-3">Tu pago fue recibido</h4>
                <p class="text-muted">Puedes consultar el detalle en <strong>Mis órdenes</strong>.</p>
                <div class="mt-3">
                    <a href="{{ route('citizen.orders.index') }}" class="btn btn-primary btn-sm">
                        <ion-icon name="list-outline"></ion-icon> Ver mis órdenes
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
