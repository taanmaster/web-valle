@extends('layouts.master')
@section('title') Cobros en Línea — Órdenes @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Tesorería @endslot
        @slot('title') Cobros en Línea — Órdenes @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-shopping-bag fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">
                            <i class="fas fa-receipt text-primary me-2"></i> Órdenes de Cobro en Línea
                        </h3>
                        <p class="text-muted mb-0">
                            <i class="fas fa-clipboard-list me-1"></i>
                            Gestión de órdenes de pago de servicios municipales en línea
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg me-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Filtros --}}
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-search me-1"></i> Buscar:
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" name="search"
                                               class="form-control border-start-0"
                                               placeholder="Buscar por folio o ciudadano..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-credit-card me-1"></i> Estado de pago:
                                    </label>
                                    <select name="payment_status" class="form-select">
                                        <option value="">Todos</option>
                                        @foreach(['Pago Pendiente','Referencia Expirada','Pagado'] as $ps)
                                            <option value="{{ $ps }}" {{ request('payment_status') === $ps ? 'selected' : '' }}>{{ $ps }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-truck me-1"></i> Estado de entrega:
                                    </label>
                                    <select name="delivery_status" class="form-select">
                                        <option value="">Todos</option>
                                        @foreach(['Pendiente','Entregado','Cancelado'] as $ds)
                                            <option value="{{ $ds }}" {{ request('delivery_status') === $ds ? 'selected' : '' }}>{{ $ds }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-1"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                            @if(request()->hasAny(['search', 'payment_status', 'delivery_status']))
                                <div class="mt-3">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i> Limpiar Filtros
                                    </a>
                                </div>
                            @endif
                        </form>

                        @if($orders->count() == 0)
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-shopping-bag fa-5x text-muted opacity-50"></i>
                                </div>
                                <h4 class="fw-bold mb-3">No hay órdenes registradas</h4>
                                <p class="text-muted mb-4">
                                    Aún no se han generado órdenes de cobro en línea.
                                </p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-white"><i class="fas fa-barcode me-1"></i> Folio</th>
                                            <th class="text-white"><i class="fas fa-user me-1"></i> Ciudadano</th>
                                            <th class="text-white"><i class="fas fa-calendar-alt me-1"></i> Fecha</th>
                                            <th class="text-white"><i class="fas fa-credit-card me-1"></i> Método</th>
                                            <th class="text-end text-white"><i class="fas fa-dollar-sign me-1"></i> Total</th>
                                            <th class="text-center text-white"><i class="fas fa-box-open me-1"></i> Artículos</th>
                                            <th class="text-center text-white"><i class="fas fa-money-check-alt me-1"></i> Pago</th>
                                            <th class="text-center text-white"><i class="fas fa-truck me-1"></i> Entrega</th>
                                            <th class="text-center text-white"><i class="fas fa-cog me-1"></i> Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark">
                                                    <i class="fas fa-barcode me-1"></i>{{ $order->folio }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="fas fa-user text-info"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $order->user->name ?? '—' }}</div>
                                                        <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="far fa-calendar-alt text-muted me-1"></i>
                                                {{ $order->created_at->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary text-uppercase">
                                                    {{ $order->payment_method }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-bold text-success">
                                                ${{ number_format($order->total, 2) }}
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $popoverContent = $order->items->map(fn($i) =>
                                                        '<span class="text-nowrap">' .
                                                        e($i->service_name) .
                                                        ' <span class="badge bg-secondary">×' . $i->quantity . '</span>' .
                                                        '</span>'
                                                    )->implode('<br>');
                                                @endphp
                                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold"
                                                      style="font-size:.85rem;cursor:default"
                                                      data-bs-toggle="popover"
                                                      data-bs-trigger="hover focus"
                                                      data-bs-placement="left"
                                                      data-bs-html="true"
                                                      data-bs-title="<i class='fas fa-box-open me-1'></i> Artículos"
                                                      data-bs-content="{{ $popoverContent }}">
                                                    {{ $order->items->sum('quantity') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $pBadge = match($order->payment_status) {
                                                        'Pagado'               => 'success',
                                                        'Referencia Expirada'  => 'danger',
                                                        default                => 'warning',
                                                    };
                                                    $pIcon = match($order->payment_status) {
                                                        'Pagado'               => 'fa-check-circle',
                                                        'Referencia Expirada'  => 'fa-exclamation-circle',
                                                        default                => 'fa-clock',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $pBadge }}">
                                                    <i class="fas {{ $pIcon }} me-1"></i>{{ $order->payment_status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $dBadge = match($order->delivery_status) {
                                                        'Entregado' => 'success',
                                                        'Cancelado' => 'danger',
                                                        default     => 'warning',
                                                    };
                                                    $dIcon = match($order->delivery_status) {
                                                        'Entregado' => 'fa-check-circle',
                                                        'Cancelado' => 'fa-times-circle',
                                                        default     => 'fa-clock',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $dBadge }}">
                                                    <i class="fas {{ $dIcon }} me-1"></i>{{ $order->delivery_status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.orders.show', $order) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       data-bs-toggle="tooltip"
                                                       title="Ver detalle">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($orders->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Mostrando <strong>{{ $orders->firstItem() }}</strong> a <strong>{{ $orders->lastItem() }}</strong> de <strong>{{ $orders->total() }}</strong> registros
                                    </div>
                                    <div>
                                        {{ $orders->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });

        // Popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (el) { return new bootstrap.Popover(el); });
    });
</script>
@endpush
@endsection
