@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('li_3') <a href="{{ route('property_taxes.index') }}">Recibos</a> @endslot
@slot('title') Detalle del Recibo @endslot
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
        <!-- Información Principal del Recibo -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i> Recibo de Predial</h5>
                    <div>
                        @if($propertyTax->payment_status != 'pagado')
                            <a href="{{ route('property_taxes.edit', $propertyTax->id) }}" class="btn btn-sm btn-light">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                        @endif
                        <a href="{{ route('property_taxes.print', $propertyTax->id) }}" class="btn btn-sm btn-light" target="_blank">
                            <i class="fas fa-print me-1"></i> Imprimir
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Información del Recibo -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Folio</small>
                            <h5 class="mb-0">{{ $propertyTax->folio ?? 'N/A' }}</h5>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Año</small>
                            <h5 class="mb-0">{{ $propertyTax->tax_year }}</h5>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Bimestre</small>
                            <h5 class="mb-0">{{ $propertyTax->bimonthly_period }}°</h5>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Estado</small>
                            @if($propertyTax->payment_status == 'pagado')
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i> Pagado
                                </span>
                            @elseif($propertyTax->payment_status == 'vencido')
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-exclamation-circle me-1"></i> Vencido
                                </span>
                            @else
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-clock me-1"></i> Pendiente
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Tipo de Cuota</small>
                            <span class="badge {{ $propertyTax->cuota_type == 'cuota_minima' ? 'bg-info' : 'bg-warning' }} fs-6">
                                {{ $propertyTax->cuota_type == 'cuota_minima' ? 'Cuota Mínima' : 'Cuota Normal' }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Fecha de Emisión</small>
                            <strong>{{ $propertyTax->issue_date ? $propertyTax->issue_date->format('d/m/Y') : '-' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Fecha de Pago</small>
                            <strong>{{ $propertyTax->payment_date ? $propertyTax->payment_date->format('d/m/Y') : '-' }}</strong>
                        </div>
                    </div>

                    <!-- Información de la Propiedad -->
                    <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-home me-2 text-primary"></i> Propiedad</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Contribuyente</small>
                            <strong>{{ $propertyTax->property->taxpayer_name ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Cuenta Catastral</small>
                            <strong>{{ $propertyTax->property->location_account ?? 'N/A' }}</strong>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <small class="text-muted d-block">Dirección</small>
                            <strong>
                                {{ $propertyTax->property->street }} {{ $propertyTax->property->street_num }}
                                @if($propertyTax->property->int_num)
                                    Int. {{ $propertyTax->property->int_num }}
                                @endif
                                <br>
                                {{ $propertyTax->property->suburb }}
                            </strong>
                        </div>
                    </div>

                    <!-- Valores y Pagos -->
                    <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-dollar-sign me-2 text-primary"></i> Valores y Pagos</h6>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Valor del Predio</small>
                            <strong>${{ number_format($propertyTax->property_value ?? 0, 2) }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Pago Bimestral</small>
                            <strong>${{ number_format($propertyTax->bimonthly_payment ?? 0, 2) }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Tasa</small>
                            <strong>{{ $propertyTax->tax_rate ?? '-' }}</strong>
                        </div>
                    </div>

                    <!-- Conceptos -->
                    <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-list me-2 text-primary"></i> Conceptos de Pago</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td><strong>Cuenta Corriente (Cve.)</strong></td>
                                    <td class="text-end">${{ number_format($propertyTax->current_amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Movimientos/Rezagos (Mov.)</strong></td>
                                    <td class="text-end">${{ number_format($propertyTax->arrears_amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Efectos</strong></td>
                                    <td class="text-end">${{ number_format($propertyTax->effects ?? 0, 2) }}</td>
                                </tr>
                                @if($propertyTax->arrears_period)
                                    <tr>
                                        <td><strong>Periodo de Rezago</strong></td>
                                        <td class="text-end">{{ $propertyTax->arrears_period }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Periodo Corriente</strong></td>
                                    <td class="text-end">${{ number_format($propertyTax->current_period_amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Rezago</strong></td>
                                    <td class="text-end">${{ number_format($propertyTax->total_arrears ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Impuesto Predial</strong></td>
                                    <td class="text-end"><strong>${{ number_format($propertyTax->property_tax_total ?? 0, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Descuentos y Recargos -->
                    @if($propertyTax->discount || $propertyTax->surcharges || $propertyTax->surcharges_discount || $propertyTax->execution_expenses_discount)
                        <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-percentage me-2 text-primary"></i> Descuentos y Recargos</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-sm">
                                <tbody>
                                    @if($propertyTax->discount)
                                        <tr>
                                            <td><strong>Descuento</strong></td>
                                            <td class="text-end text-success">-${{ number_format($propertyTax->discount, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($propertyTax->surcharges)
                                        <tr>
                                            <td><strong>Recargos</strong></td>
                                            <td class="text-end text-danger">${{ number_format($propertyTax->surcharges, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($propertyTax->surcharges_discount)
                                        <tr>
                                            <td><strong>Descuento en Recargos</strong></td>
                                            <td class="text-end text-success">-${{ number_format($propertyTax->surcharges_discount, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($propertyTax->execution_expenses_discount)
                                        <tr>
                                            <td><strong>Desc. Gastos de Ejecución</strong></td>
                                            <td class="text-end text-success">-${{ number_format($propertyTax->execution_expenses_discount, 2) }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Total -->
                    <div class="alert alert-success border-0 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="mb-0">Total a Pagar:</h6>
                                @if($propertyTax->total_payment_text)
                                    <small class="text-muted">{{ $propertyTax->total_payment_text }}</small>
                                @endif
                            </div>
                            <div class="col-md-6 text-end">
                                <h3 class="mb-0 text-success">${{ number_format($propertyTax->total_payment ?? 0, 2) }}</h3>
                            </div>
                        </div>
                    </div>

                    @if($propertyTax->bank_reference)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <small class="text-muted d-block">Referencia Bancaria</small>
                                <strong>{{ $propertyTax->bank_reference }}</strong>
                            </div>
                        </div>
                    @endif

                    @if($propertyTax->notes)
                        <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-sticky-note me-2 text-primary"></i> Notas</h6>
                        <p>{{ $propertyTax->notes }}</p>
                    @endif

                    <!-- Acciones -->
                    @if($propertyTax->payment_status != 'pagado')
                        <div class="d-flex gap-2 mt-4">
                            <form action="{{ route('property_taxes.mark-paid', $propertyTax->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" onclick="return confirm('¿Marcar este recibo como pagado?')">
                                    <i class="fas fa-check-circle me-2"></i> Marcar como Pagado
                                </button>
                            </form>
                            <form action="{{ route('property_taxes.destroy', $propertyTax->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este recibo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Resumen -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Resumen</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Periodo</small>
                        <h5 class="mb-0">{{ $propertyTax->tax_year }} - Bimestre {{ $propertyTax->bimonthly_period }}</h5>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Total a Pagar</small>
                        <h4 class="mb-0 text-success">${{ number_format($propertyTax->total_payment ?? 0, 2) }}</h4>
                    </div>
                    <div>
                        <small class="text-muted d-block">Estado</small>
                        @if($propertyTax->payment_status == 'pagado')
                            <span class="badge bg-success fs-6">Pagado</span>
                        @elseif($propertyTax->payment_status == 'vencido')
                            <span class="badge bg-danger fs-6">Vencido</span>
                        @else
                            <span class="badge bg-warning fs-6">Pendiente</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Enlace a la Propiedad -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-link me-2"></i> Propiedad Asociada</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('properties.show', $propertyTax->property->id) }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-home me-2"></i> Ver Propiedad
                    </a>
                </div>
            </div>

            <!-- Historial -->
            @if($logs->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="fas fa-history me-2"></i> Historial</h6>
                    </div>
                    <div class="card-body">
                        @foreach($logs as $log)
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                                <p class="mb-0">
                                    <strong>{{ $log->by->name ?? 'Sistema' }}</strong> {{ $log->data }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
