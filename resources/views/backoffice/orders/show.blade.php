@extends('layouts.master')
@section('title') Orden {{ $order->folio }} @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Tesorería @endslot
        @slot('li_3') <a href="{{ route('admin.orders.index') }}">Cobros en Línea</a> @endslot
        @slot('title') Detalle de Orden @endslot
    @endcomponent

    <div class="container-fluid py-4">

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

            {{-- Columna principal --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i> Orden de Cobro
                        </h5>
                        <span class="badge bg-white text-primary fs-6">{{ $order->folio }}</span>
                    </div>
                    <div class="card-body p-4">

                        {{-- Datos generales --}}
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <small class="text-muted d-block">Folio</small>
                                <h5 class="mb-0">{{ $order->folio }}</h5>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Método de Pago</small>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary text-uppercase fs-6">
                                    {{ $order->payment_method }}
                                </span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Fecha</small>
                                <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <small class="text-muted d-block">Estado de Pago</small>
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
                                <span class="badge bg-{{ $pBadge }} fs-6">
                                    <i class="fas {{ $pIcon }} me-1"></i>{{ $order->payment_status }}
                                </span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Estado de Entrega</small>
                                @php
                                    $dBadge = match($order->delivery_status) {
                                        'Entregado' => 'success',
                                        'Cancelado' => 'danger',
                                        default     => 'warning',
                                    };
                                @endphp
                                <span class="badge bg-{{ $dBadge }} fs-6">{{ $order->delivery_status }}</span>
                            </div>
                            @if($order->paid_at)
                            <div class="col-md-4">
                                <small class="text-muted d-block">Fecha de Pago</small>
                                <strong>{{ $order->paid_at->format('d/m/Y H:i') }}</strong>
                            </div>
                            @endif
                        </div>

                        {{-- Servicios contratados --}}
                        <h6 class="border-bottom pb-2 mb-3 mt-4">
                            <i class="fas fa-list me-2 text-primary"></i> Servicios Contratados
                        </h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-white">Servicio</th>
                                        <th class="text-center text-white">Cant.</th>
                                        <th class="text-end text-white">P. Unitario</th>
                                        <th class="text-end text-white">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->service_name }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="text-end">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Total --}}
                        <div class="alert alert-success border-0 mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Total de la Orden:</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h3 class="mb-0 text-success">${{ number_format($order->total, 2) }}</h3>
                                </div>
                            </div>
                        </div>

                        @if($order->payment_reference)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <small class="text-muted d-block">Referencia de Pago</small>
                                <strong>{{ $order->payment_reference }}</strong>
                            </div>
                        </div>
                        @endif

                        @if($order->notes)
                        <h6 class="border-bottom pb-2 mb-3 mt-4">
                            <i class="fas fa-sticky-note me-2 text-primary"></i> Notas
                        </h6>
                        <p>{{ $order->notes }}</p>
                        @endif

                        {{-- Actualizar estado de entrega --}}
                        <h6 class="border-bottom pb-2 mb-3 mt-4">
                            <i class="fas fa-truck me-2 text-primary"></i> Actualizar Estado de Entrega
                        </h6>
                        <form action="{{ route('admin.orders.update_status', $order) }}" method="POST"
                              class="d-flex align-items-center gap-3">
                            @csrf @method('PATCH')
                            <select name="delivery_status" class="form-select w-auto">
                                @foreach(['Pendiente', 'Entregado', 'Cancelado'] as $ds)
                                    <option value="{{ $ds }}" {{ $order->delivery_status === $ds ? 'selected' : '' }}>
                                        {{ $ds }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Actualizar estado
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Datos del ciudadano --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-user me-2"></i> Ciudadano</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Nombre</small>
                            <strong>{{ $order->user->name ?? '—' }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Correo electrónico</small>
                            <strong>{{ $order->user->email ?? '—' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Resumen --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Resumen</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Folio</small>
                            <h5 class="mb-0">{{ $order->folio }}</h5>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Total</small>
                            <h4 class="mb-0 text-success">${{ number_format($order->total, 2) }}</h4>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Pago</small>
                            <span class="badge bg-{{ $pBadge }} fs-6">{{ $order->payment_status }}</span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Entrega</small>
                            <span class="badge bg-{{ $dBadge }} fs-6">{{ $order->delivery_status }}</span>
                        </div>
                    </div>
                </div>

                {{-- Cronología --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="fas fa-history me-2"></i> Cronología</h6>
                    </div>
                    <div class="card-body p-3">

                        {{-- Nota admin --}}
                        <form action="{{ route('admin.orders.update_note', $order) }}" method="POST" class="mb-4">
                            @csrf @method('PATCH')
                            <textarea name="admin_note"
                                      class="form-control form-control-sm mb-2 @error('admin_note') is-invalid @enderror"
                                      rows="2"
                                      placeholder="Deja un comentario...">{{ old('admin_note', $order->admin_note) }}</textarea>
                            @error('admin_note')
                                <div class="invalid-feedback d-block mb-1">{{ $message }}</div>
                            @enderror
                            <div class="d-grid">
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-paper-plane me-1"></i> Publicar
                                </button>
                            </div>
                        </form>

                        {{-- Línea de tiempo --}}
                        @php
                            $events = collect();

                            $events->push([
                                'at'    => $order->created_at,
                                'icon'  => 'fa-user',
                                'color' => 'primary',
                                'text'  => ($order->user->name ?? 'El ciudadano') . ' realizó este pedido.',
                            ]);

                            if ($order->payment_method === 'oxxopay' && $order->payment_reference) {
                                $events->push([
                                    'at'    => $order->created_at,
                                    'icon'  => 'fa-barcode',
                                    'color' => 'secondary',
                                    'text'  => 'Se generó la referencia de pago OXXO: <strong>' . e($order->payment_reference) . '</strong>',
                                    'html'  => true,
                                ]);
                            }

                            if ($order->paid_at) {
                                $method = strtoupper($order->payment_method);
                                $ref    = $order->payment_reference ? ' con la referencia <strong>' . e($order->payment_reference) . '</strong>' : '';
                                $events->push([
                                    'at'    => $order->paid_at,
                                    'icon'  => 'fa-check-circle',
                                    'color' => 'success',
                                    'text'  => 'Se procesó pago de <strong>$' . number_format($order->paid_amount ?? $order->total, 2) . '</strong> por ' . $method . $ref . '.',
                                    'html'  => true,
                                ]);
                            }

                            if ($order->cancelled_at) {
                                $events->push([
                                    'at'    => $order->cancelled_at,
                                    'icon'  => 'fa-times-circle',
                                    'color' => 'danger',
                                    'text'  => 'Orden cancelada.',
                                ]);
                            }

                            if ($order->delivered_at) {
                                $events->push([
                                    'at'    => $order->delivered_at,
                                    'icon'  => 'fa-box-open',
                                    'color' => 'success',
                                    'text'  => 'Artículo entregado.',
                                ]);
                            }

                            if ($order->admin_note) {
                                $events->push([
                                    'at'    => $order->updated_at,
                                    'icon'  => 'fa-comment-alt',
                                    'color' => 'warning',
                                    'text'  => e($order->admin_note),
                                ]);
                            }

                            $events = $events->sortByDesc('at')->values();
                        @endphp

                        <ul class="list-unstyled mb-0" style="position:relative">
                            {{-- línea vertical --}}
                            <div style="position:absolute;left:11px;top:0;bottom:0;width:2px;background:#dee2e6;z-index:0"></div>

                            @foreach($events as $event)
                            <li class="d-flex align-items-start mb-3" style="position:relative;z-index:1">
                                <div class="rounded-circle bg-{{ $event['color'] }} d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width:24px;height:24px;min-width:24px">
                                    <i class="fas {{ $event['icon'] }} text-white" style="font-size:.6rem"></i>
                                </div>
                                <div>
                                    <div class="small">
                                        @if(!empty($event['html']))
                                            {!! $event['text'] !!}
                                        @else
                                            {{ $event['text'] }}
                                        @endif
                                    </div>
                                    <div class="text-muted" style="font-size:.7rem">
                                        {{ $event['at']->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                    </div>
                </div>

                {{-- Volver --}}
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i> Volver al listado
                </a>

            </div>
        </div>
    </div>
@endsection
