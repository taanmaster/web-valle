@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('li_3') <a href="{{ route('properties.index') }}">Propiedades</a> @endslot
@slot('title') Detalle de Propiedad @endslot
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
        <!-- Información Principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-home me-2"></i> Información de la Propiedad</h5>

                    @hasanyrole(['all', 'cto_admin'])
                    <div>
                        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-light">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>
                        <form action="{{ route('properties.destroy', $property->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta propiedad?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash me-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                    @endhasanyrole
                </div>
                <div class="card-body p-4">
                    <!-- Contribuyente -->
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-user me-2 text-primary"></i> Información del Contribuyente</h6>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Tipo</small>
                            <strong>{{ $property->taxpayer_type ? ucfirst($property->taxpayer_type) : '-' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Nombre</small>
                            <strong>{{ $property->taxpayer_name ?? '-' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Teléfono</small>
                            <strong>{{ $property->taxpayer_phone ?? '-' }}</strong>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Dirección</h6>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <small class="text-muted d-block">Dirección Completa</small>
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
                    @if($property->notification_address)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <small class="text-muted d-block">Dirección de Notificación</small>
                                <strong>{{ $property->notification_address }}</strong>
                            </div>
                        </div>
                    @endif

                    <!-- Información del Predio -->
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-building me-2 text-primary"></i> Información del Predio</h6>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Cuenta Catastral</small>
                            <strong>{{ $property->location_account ?? '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Tipo de Cuota</small>
                            @if($property->cuota_type)
                                <span class="badge {{ $property->cuota_type == 'cuota_minima' ? 'bg-info' : 'bg-warning' }}">
                                    {{ $property->cuota_type == 'cuota_minima' ? 'Cuota Mínima' : 'Cuota Normal' }}
                                </span>
                            @else
                                <strong>-</strong>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Tipo de Predio</small>
                            <strong>{{ $property->location_type ?? '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Número de Predio</small>
                            <strong>{{ $property->location_num ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Superficie Terreno</small>
                            <strong>{{ $property->location_surface ? number_format($property->location_surface, 2) . ' m²' : '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Superficie Construida</small>
                            <strong>{{ $property->location_surface_built ? number_format($property->location_surface_built, 2) . ' m²' : '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Uso del Predio</small>
                            <strong>{{ $property->location_use ?? '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Condición</small>
                            <strong>{{ $property->location_condition ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Valor Catastral</small>
                            <strong class="text-success">{{ $property->location_law_value ? '$' . number_format($property->location_law_value, 2) : '-' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Origen del Predio</small>
                            <strong>{{ $property->location_origin ?? '-' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Último Avalúo</small>
                            <strong>{{ $property->last_appraisal ? $property->last_appraisal->format('d/m/Y') : '-' }}</strong>
                        </div>
                    </div>
                    @if($property->location_note)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <small class="text-muted d-block">Nota del Predio</small>
                                <strong>{{ $property->location_note }}</strong>
                            </div>
                        </div>
                    @endif

                    <!-- Información de Pagos -->
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-dollar-sign me-2 text-primary"></i> Información de Pagos</h6>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Tasa</small>
                            <strong>{{ $property->tax_rate ?? '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Pago Anual</small>
                            <strong>{{ $property->payment_anual ? '$' . number_format($property->payment_anual, 2) : '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Pago Bimestral</small>
                            <strong>{{ $property->payment_bimonthly ? '$' . number_format($property->payment_bimonthly, 2) : '-' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Total de Pago</small>
                            <strong>{{ $property->total_payment ? '$' . number_format($property->total_payment, 2) : '-' }}</strong>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Fecha de Emisión</small>
                            <strong>{{ $property->issue_date ? $property->issue_date->format('d/m/Y') : '-' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Fecha de Vigencia</small>
                            <strong>{{ $property->validity_date ? $property->validity_date->format('d/m/Y') : '-' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Fecha de Pago</small>
                            <strong>{{ $property->payment_date ? $property->payment_date->format('d/m/Y') : '-' }}</strong>
                        </div>
                    </div>
                    @if($property->bank_reference_json)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <small class="text-muted d-block">Referencias Bancarias</small>
                                <strong>{{ is_array($property->bank_reference_json) ? json_encode($property->bank_reference_json) : $property->bank_reference_json }}</strong>
                            </div>
                        </div>
                    @endif

                    @if($property->notes)
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-sticky-note me-2 text-primary"></i> Notas</h6>
                        <p>{{ $property->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Estado de Cuenta -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i> Estado de Cuenta</h5>
                </div>
                <div class="card-body p-4">
                    @php
                        // Obtener años únicos de los recibos
                        $years = $property->propertyTaxes->pluck('tax_year')->unique()->sort()->reverse();
                    @endphp

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
                                            role="tab" 
                                            aria-controls="content-{{ $year }}" 
                                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
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
                                    $totalGastosEjecucion = 0; // Puede agregarse en el futuro
                                    $totalHonorarios = 0; // Puede agregarse en el futuro
                                    $totalCOA = 0; // Costo de Operación Adicional
                                    $totalDAP = 0; // Derechos Administrativos de Pago
                                    
                                    $totalAdeudo = $receiptsYear->sum('subtotal');
                                    $totalAPagar = $receiptsYear->sum('total_payment');
                                @endphp

                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                                     id="content-{{ $year }}" 
                                     role="tabpanel" 
                                     aria-labelledby="tab-{{ $year }}">
                                    
                                    <!-- Encabezado del año -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="fw-bold text-center mb-3">ESTADO DE CUENTA - AÑO {{ $year }}</h5>
                                            <p class="text-center text-muted mb-0">
                                                {{ $property->taxpayer_name }}<br>
                                                Cuenta Catastral: {{ $property->location_account }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Tabla de bimestres -->
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered align-middle">
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="fw-bold mb-3 text-center">CARGOS</h6>
                                                    <table class="table table-sm mb-0">
                                                        <tr>
                                                            <td>Del Bimestre 1 al Bimestre 6 de {{ $year }}</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>RECARGOS</td>
                                                            <td class="text-end">${{ number_format($totalRecargos, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>GASTOS DE EJECUCIÓN</td>
                                                            <td class="text-end">${{ number_format($totalGastosEjecucion, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>HONORARIOS DE VALUACIÓN</td>
                                                            <td class="text-end">${{ number_format($totalHonorarios, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>C.O.A</td>
                                                            <td class="text-end">${{ number_format($totalCOA, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>D.A.P</td>
                                                            <td class="text-end">${{ number_format($totalDAP, 2) }}</td>
                                                        </tr>
                                                        <tr class="fw-bold border-top">
                                                            <td>TOTAL DEL ADEUDO</td>
                                                            <td class="text-end">${{ number_format($totalAdeudo, 2) }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="fw-bold mb-3 text-center">DESCUENTOS</h6>
                                                    <table class="table table-sm mb-0">
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="text-end"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="text-end"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="text-end"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="text-end"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="text-end"></td>
                                                        </tr>
                                                        <tr class="fw-bold border-top">
                                                            <td>TOTAL DEL DESCUENTOS</td>
                                                            <td class="text-end">${{ number_format($totalDescuentos, 2) }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total a pagar -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="alert alert-success text-center">
                                                <h4 class="mb-0">
                                                    <i class="fas fa-dollar-sign me-2"></i>
                                                    <strong>A PAGAR:</strong> ${{ number_format($totalAPagar, 2) }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Información adicional -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><strong>Contribuyente:</strong> {{ $property->taxpayer_name }}</p>
                                                            <p class="mb-1"><strong>Ubicación del Predio:</strong><br>
                                                                {{ $property->street }} {{ $property->street_num }}
                                                                @if($property->int_num) Int. {{ $property->int_num }} @endif<br>
                                                                {{ $property->suburb }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><strong>Predio:</strong></p>
                                                            <p class="mb-1">Cuenta: {{ $property->location_account }}</p>
                                                            <p class="mb-1">Clave Catastral: {{ $property->location_num ?? 'N/A' }}</p>
                                                            <p class="mb-1">Superficie: {{ $property->location_surface ? number_format($property->location_surface, 2) . ' m²' : 'N/A' }}</p>
                                                            <p class="mb-1">Uso: {{ $property->location_use ?? 'N/A' }}</p>
                                                            <p class="mb-1">
                                                                @if($property->cuota_type == 'cuota_minima')
                                                                    Cuota Mínima
                                                                @else
                                                                    Cuota Normal
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay recibos registrados para generar el estado de cuenta</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recibos de la Propiedad -->
            <div class="card border-0 shadow-sm">
                @hasanyrole(['all', 'cto_admin'])
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i> Recibos de Predial</h5>
                    <a href="{{ route('property_taxes.create', ['property_id' => $property->id]) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus me-1"></i> Nuevo Recibo
                    </a>
                </div>
                @endhasanyrole
                
                <div class="card-body p-4">
                    @if($property->propertyTaxes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Año</th>
                                        <th>Bimestre</th>
                                        <th>Tipo</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Estado</th>
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
                                                <a href="{{ route('property_taxes.show', $tax->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay recibos registrados para esta propiedad</p>
                            <a href="{{ route('property_taxes.create', ['property_id' => $property->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Crear Primer Recibo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Información Rápida -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Información Rápida</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Total de Recibos</small>
                        <h4 class="mb-0 text-primary">{{ $property->propertyTaxes->count() }}</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Recibos Pagados</small>
                        <h4 class="mb-0 text-success">{{ $property->propertyTaxes->where('payment_status', 'pagado')->count() }}</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Recibos Pendientes</small>
                        <h4 class="mb-0 text-warning">{{ $property->propertyTaxes->where('payment_status', 'pendiente')->count() }}</h4>
                    </div>
                    <div>
                        <small class="text-muted d-block">Recibos Vencidos</small>
                        <h4 class="mb-0 text-danger">{{ $property->propertyTaxes->where('payment_status', 'vencido')->count() }}</h4>
                    </div>
                </div>
            </div>

            <!-- Historial de Actividad -->
            @if($logs->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="fas fa-history me-2"></i> Historial de Actividad</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
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
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
