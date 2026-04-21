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
                            <ion-icon name="receipt-outline"></ion-icon> Detalle de Orden
                        </h5>
                        <a href="{{ route('citizen.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                            <ion-icon name="arrow-back-outline"></ion-icon> Mis órdenes
                        </a>
                    </div>

                    {{-- Cabecera --}}
                    <div class="row text-center mb-4">
                        <div class="col-4">
                            <div class="text-muted small">Folio</div>
                            <div class="fw-bold">{{ $order->folio }}</div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Estado del pago</div>
                            @php
                                $pBadge = match($order->payment_status) {
                                    'Pagado'               => 'success',
                                    'Referencia Expirada'  => 'danger',
                                    default                => 'warning',
                                };
                            @endphp
                            <span class="badge bg-{{ $pBadge }} fs-6">{{ $order->payment_status }}</span>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Estado de entrega</div>
                            @php
                                $dBadge = match($order->delivery_status) {
                                    'Entregado' => 'success',
                                    'Cancelado' => 'danger',
                                    default     => 'warning',
                                };
                            @endphp
                            <span class="badge bg-{{ $dBadge }} fs-6">{{ $order->delivery_status }}</span>
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="border rounded p-3 mb-3">
                        @foreach($order->items as $item)
                        <div class="d-flex align-items-center mb-2 {{ !$loop->last ? 'border-bottom pb-2' : '' }}">
                            <ion-icon name="document-text-outline" class="me-3 text-secondary fs-4" style="min-width:24px"></ion-icon>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $item->service_name }}</div>
                                <div class="text-muted small">${{ number_format($item->unit_price, 2) }} × {{ $item->quantity }}</div>
                                @if($item->related_folio)
                                    <div class="text-muted small mt-1">
                                        <ion-icon name="link-outline"></ion-icon>
                                        Trámite: <strong>{{ $item->related_folio }}</strong>
                                        <span class="ms-1">({{ class_basename($item->related_model_type) }})</span>
                                    </div>
                                @endif
                            </div>
                            <div class="fw-semibold">${{ number_format($item->subtotal, 2) }}</div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Totales --}}
                    <div class="border rounded p-3 mb-3">
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
                    <div class="border rounded p-3 mb-4">
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

                    @if($order->payment_status === 'Pagado')
                    <div class="text-end">
                        <a href="{{ route('citizen.orders.receipt', $order) }}" class="btn btn-primary">
                            <ion-icon name="download-outline"></ion-icon> Descargar recibo PDF
                        </a>
                    </div>
                    @else
                    <div class="alert alert-warning d-flex align-items-center gap-2 mb-0">
                        <ion-icon name="time-outline" style="font-size:1.4rem"></ion-icon>
                        <span>El recibo estará disponible para descarga una vez que se confirme el pago.</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
