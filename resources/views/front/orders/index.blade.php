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
                    <h5 class="mb-4"><ion-icon name="receipt-outline"></ion-icon> Mis Órdenes / Pagos</h5>

                    @if($orders->isEmpty())
                        <div class="text-center text-muted py-5">
                            <ion-icon name="receipt-outline" style="font-size:3rem"></ion-icon>
                            <p class="mt-2">Aún no tienes órdenes registradas.</p>
                            <a href="{{ route('citizen.services.index') }}" class="btn btn-primary btn-sm mt-2">Ver servicios</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Método</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Pago</th>
                                        <th class="text-center">Entrega</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td class="fw-semibold">{{ $order->folio }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="text-uppercase">{{ $order->payment_method }}</td>
                                        <td class="text-end">${{ number_format($order->total, 2) }}</td>
                                        <td class="text-center">
                                            @php
                                                $pBadge = match($order->payment_status) {
                                                    'Pagado'               => 'success',
                                                    'Referencia Expirada'  => 'danger',
                                                    default                => 'warning',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $pBadge }}">{{ $order->payment_status }}</span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $dBadge = match($order->delivery_status) {
                                                    'Entregado' => 'success',
                                                    'Cancelado' => 'danger',
                                                    default     => 'warning',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $dBadge }}">{{ $order->delivery_status }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('citizen.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <ion-icon name="eye-outline"></ion-icon>
                                            </a>
                                            @if($order->payment_status === 'Pagado')
                                                <a href="{{ route('citizen.orders.receipt', $order) }}" class="btn btn-sm btn-outline-secondary" title="Descargar recibo">
                                                    <ion-icon name="download-outline"></ion-icon>
                                                </a>
                                            @else
                                                <span class="btn btn-sm btn-outline-secondary disabled" title="Disponible al confirmar pago">
                                                    <ion-icon name="download-outline"></ion-icon>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $orders->links() }}</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
