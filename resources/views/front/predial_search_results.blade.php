@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <!-- Botón para regresar -->
    <div class="mb-4">
        <a href="{{ route('predial.search') }}" class="btn btn-outline-secondary">
            <ion-icon name="arrow-back-outline" class="me-2"></ion-icon> Hacer otra búsqueda
        </a>
    </div>

    <!-- Información Principal del Predio -->
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-header bg-primary text-white py-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0 text-white">
                        <ion-icon name="home-outline" class="me-2"></ion-icon>
                        Información de tu Propiedad
                    </h3>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <!-- Contribuyente -->
            <h5 class="border-bottom pb-3 mb-4">
                <ion-icon name="person-outline" class="text-primary me-2"></ion-icon>
                Información del Contribuyente
            </h5>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <small class="text-muted d-block mb-1">Tipo</small>
                    <strong>{{ $property->taxpayer_type ? ucfirst($property->taxpayer_type) : '-' }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <small class="text-muted d-block mb-1">Nombre</small>
                    <strong>{{ $property->taxpayer_name ?? '-' }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <small class="text-muted d-block mb-1">Teléfono</small>
                    <strong>{{ $property->taxpayer_phone ?? '-' }}</strong>
                </div>
            </div>

            <!-- Dirección -->
            <h5 class="border-bottom pb-3 mb-4">
                <ion-icon name="location-outline" class="text-primary me-2"></ion-icon>
                Dirección del Predio
            </h5>
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <strong>
                        {{ $property->street }} {{ $property->street_num }}
                        @if($property->int_num)
                            Int. {{ $property->int_num }}
                        @endif
                        <br>
                        {{ $property->suburb }}
                    </strong>
                </div>
            </div>

            <!-- Información del Predio -->
            <h5 class="border-bottom pb-3 mb-4">
                <ion-icon name="business-outline" class="text-primary me-2"></ion-icon>
                Datos del Predio
            </h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <small class="text-muted d-block mb-1">Cuenta Catastral</small>
                    <strong>{{ $property->location_account ?? '-' }}</strong>
                </div>
                <div class="col-md-3 mb-3">
                    <small class="text-muted d-block mb-1">Tipo de Cuota</small>
                    @if($property->cuota_type)
                        <span class="badge {{ $property->cuota_type == 'cuota_minima' ? 'bg-info' : 'bg-warning' }}">
                            {{ $property->cuota_type == 'cuota_minima' ? 'Cuota Mínima' : 'Cuota Normal' }}
                        </span>
                    @else
                        <strong>-</strong>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <small class="text-muted d-block mb-1">Superficie</small>
                    <strong>{{ $property->location_surface ? number_format($property->location_surface, 2) . ' m²' : '-' }}</strong>
                </div>
                <div class="col-md-3 mb-3">
                    <small class="text-muted d-block mb-1">Valor Catastral</small>
                    <strong class="text-success">{{ $property->location_law_value ? '$' . number_format($property->location_law_value, 2) : '-' }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Estado de Cuenta -->
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-header bg-warning text-dark py-4 d-flex justify-content-between align-items-center">
            <h3 class="mb-0 text-white">
                <ion-icon name="document-text-outline" class="me-2"></ion-icon>
                Estado de Cuenta
            </h3>
            <a href="{{ route('predial.account-statement.print', $property->id) }}" 
               class="btn btn-dark"
               target="_blank">
                <ion-icon name="print-outline" class="me-1"></ion-icon> Imprimir Estado de Cuenta
            </a>
        </div>
        <div class="card-body p-4">
            @if($years->count() > 0)
                <!-- Pestañas por año -->
                <ul class="nav nav-tabs mb-4" id="estadoCuentaTabs" role="tablist">
                    @foreach($years as $index => $year)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                    id="tab-{{ $year }}" 
                                    data-bs-toggle="tab" 
                                    data-bs-target="#content-{{ $year }}" 
                                    type="button" 
                                    role="tab">
                                Año {{ $year }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content" id="estadoCuentaTabsContent">
                    @foreach($years as $index => $year)
                        @php
                            // Obtener recibos del año
                            $receiptsYear = $property->propertyTaxes->where('tax_year', $year)->sortBy('bimonthly_period');
                            
                            // Calcular totales
                            $totalRecargos = $receiptsYear->sum('surcharge_amount');
                            $totalDescuentos = $receiptsYear->sum('discount_amount');
                            $totalAdeudo = $receiptsYear->sum('subtotal');
                            $totalAPagar = $receiptsYear->sum('total_payment');
                        @endphp

                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                             id="content-{{ $year }}" 
                             role="tabpanel">
                            
                            <!-- Encabezado del año -->
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-2">ESTADO DE CUENTA - AÑO {{ $year }}</h4>
                                <p class="text-muted mb-0">
                                    {{ $property->taxpayer_name }}<br>
                                    Cuenta Catastral: {{ $property->location_account }}
                                </p>
                            </div>

                            <!-- Tabla de bimestres -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Bimestre</th>
                                            <th class="text-center">Folio</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-end">Subtotal</th>
                                            <th class="text-end">Recargos</th>
                                            <th class="text-end">Descuentos</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($receiptsYear as $receipt)
                                            <tr>
                                                <td class="text-center">{{ $receipt->bimonthly_period }}°</td>
                                                <td class="text-center">{{ $receipt->folio ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    @if($receipt->payment_status == 'pagado')
                                                        <span class="badge bg-success">Pagado</span>
                                                    @elseif($receipt->payment_status == 'vencido')
                                                        <span class="badge bg-danger">Vencido</span>
                                                    @else
                                                        <span class="badge bg-warning">Pendiente</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">${{ number_format($receipt->subtotal ?? 0, 2) }}</td>
                                                <td class="text-end">${{ number_format($receipt->surcharge_amount ?? 0, 2) }}</td>
                                                <td class="text-end">${{ number_format($receipt->discount_amount ?? 0, 2) }}</td>
                                                <td class="text-end fw-bold">${{ number_format($receipt->total_payment ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Resumen de cargos y descuentos -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3 text-center">CARGOS</h6>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td>Del Bimestre 1 al 6 de {{ $year }}</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>RECARGOS</td>
                                                    <td class="text-end">${{ number_format($totalRecargos, 2) }}</td>
                                                </tr>
                                                <tr class="fw-bold border-top">
                                                    <td>TOTAL DEL ADEUDO</td>
                                                    <td class="text-end">${{ number_format($totalAdeudo, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3 text-center">DESCUENTOS</h6>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td class="text-end"></td>
                                                </tr>
                                                <tr class="fw-bold border-top">
                                                    <td>TOTAL DE DESCUENTOS</td>
                                                    <td class="text-end">${{ number_format($totalDescuentos, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total a pagar -->
                            <div class="alert alert-success text-center">
                                <h3 class="mb-0">
                                    <ion-icon name="cash-outline" class="me-2"></ion-icon>
                                    <strong>TOTAL A PAGAR:</strong> ${{ number_format($totalAPagar, 2) }}
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <ion-icon name="document-text-outline" style="font-size: 4rem;" class="text-muted mb-3 d-block mx-auto"></ion-icon>
                    <p class="text-muted">No hay recibos registrados para este predio</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Listado de Recibos -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-success text-white py-4">
            <h3 class="mb-0 text-white">
                <ion-icon name="receipt-outline" class="me-2"></ion-icon>
                Recibos del Predio
            </h3>
        </div>
        <div class="card-body p-4">
            @if($property->propertyTaxes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Folio</th>
                                <th>Año</th>
                                <th>Bimestre</th>
                                <th>Tipo</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Fecha de Pago</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($property->propertyTaxes as $tax)
                                <tr>
                                    <td>{{ $tax->folio ?? 'N/A' }}</td>
                                    <td>{{ $tax->tax_year }}</td>
                                    <td>{{ $tax->bimonthly_period }}°</td>
                                    <td>
                                        <span class="badge {{ $tax->cuota_type == 'cuota_minima' ? 'bg-info' : 'bg-warning' }}">
                                            {{ $tax->cuota_type == 'cuota_minima' ? 'Mínima' : 'Normal' }}
                                        </span>
                                    </td>
                                    <td class="text-end">${{ number_format($tax->total_payment ?? 0, 2) }}</td>
                                    <td class="text-center">
                                        @if($tax->payment_status == 'pagado')
                                            <span class="badge bg-success">Pagado</span>
                                        @elseif($tax->payment_status == 'vencido')
                                            <span class="badge bg-danger">Vencido</span>
                                        @else
                                            <span class="badge bg-warning">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $tax->payment_date ? $tax->payment_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('predial.receipt.print', $tax->id) }}" 
                                           class="btn btn-sm btn-outline-secondary"
                                           title="Imprimir recibo"
                                           target="_blank">
                                            <ion-icon name="print-outline"></ion-icon>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Resumen estadístico -->
                <div class="row mt-4 pt-4 border-top">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-primary mb-0">{{ $property->propertyTaxes->count() }}</h4>
                            <small class="text-muted">Total Recibos</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-success mb-0">{{ $property->propertyTaxes->where('payment_status', 'pagado')->count() }}</h4>
                            <small class="text-muted">Pagados</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-warning mb-0">{{ $property->propertyTaxes->where('payment_status', 'pendiente')->count() }}</h4>
                            <small class="text-muted">Pendientes</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-danger mb-0">{{ $property->propertyTaxes->where('payment_status', 'vencido')->count() }}</h4>
                            <small class="text-muted">Vencidos</small>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <ion-icon name="receipt-outline" style="font-size: 4rem;" class="text-muted mb-3 d-block mx-auto"></ion-icon>
                    <p class="text-muted">No hay recibos registrados para este predio</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Información de contacto -->
    <div class="card border-0 bg-light mt-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">
                <ion-icon name="information-circle-outline" class="text-info me-2"></ion-icon>
                ¿Tienes dudas sobre tu estado de cuenta?
            </h5>
            <p class="mb-0">
                <ion-icon name="call-outline" class="text-primary me-2"></ion-icon>
                Comunícate con Tesorería Municipal para más información sobre pagos, descuentos y formas de pago disponibles.
            </p>
        </div>
    </div>
</div>
@endsection