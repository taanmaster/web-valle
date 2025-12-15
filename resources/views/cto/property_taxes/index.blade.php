@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Recibos de Predial @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-file-invoice-dollar fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-receipt text-primary me-2"></i> Recibos de Predial
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Gestión de recibos de impuestos prediales
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('property_taxes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nuevo Recibo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pagados</h6>
                            <h4 class="mb-0 fw-bold">{{ $stats['paid'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pendientes</h6>
                            <h4 class="mb-0 fw-bold">{{ $stats['pending'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Vencidos</h6>
                            <h4 class="mb-0 fw-bold">{{ $stats['overdue'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Recaudado</h6>
                            <h4 class="mb-0 fw-bold">${{ number_format($stats['total_collected'] ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('property_taxes.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1"></i> Buscar:
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="search"
                                           class="form-control border-start-0"
                                           placeholder="Buscar por folio o cuenta..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i> Año:
                                </label>
                                <select name="year" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar me-1"></i> Bimestre:
                                </label>
                                <select name="bimonthly" class="form-select">
                                    <option value="">Todos</option>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ request('bimonthly') == $i ? 'selected' : '' }}>
                                            {{ $i }}° Bimestre
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-filter me-1"></i> Estado:
                                </label>
                                <select name="status" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="pagado" {{ request('status') == 'pagado' ? 'selected' : '' }}>
                                        Pagado
                                    </option>
                                    <option value="pendiente" {{ request('status') == 'pendiente' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                    <option value="vencido" {{ request('status') == 'vencido' ? 'selected' : '' }}>
                                        Vencido
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-receipt me-1"></i> Tipo Cuota:
                                </label>
                                <select name="cuota_type" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="cuota_minima" {{ request('cuota_type') == 'cuota_minima' ? 'selected' : '' }}>
                                        Cuota Mínima
                                    </option>
                                    <option value="cuota_normal" {{ request('cuota_type') == 'cuota_normal' ? 'selected' : '' }}>
                                        Cuota Normal
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                        @if(request()->hasAny(['search', 'year', 'bimonthly', 'status', 'cuota_type']))
                            <div class="mt-3">
                                <a href="{{ route('property_taxes.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Limpiar Filtros
                                </a>
                            </div>
                        @endif
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-lg me-3"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($propertyTaxes->count() == 0)
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-file-invoice fa-5x text-muted opacity-50"></i>
                            </div>
                            <h4 class="fw-bold mb-3">No hay recibos registrados</h4>
                            <p class="text-muted mb-4">
                                Comienza agregando el primer recibo de impuesto predial.
                            </p>
                            <a href="{{ route('property_taxes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Agregar Primer Recibo
                            </a>
                        </div>
                    @else
                        <!-- Tabla de recibos -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-white"><i class="fas fa-barcode me-1"></i> Folio</th>
                                        <th class="text-white"><i class="fas fa-home me-1"></i> Propiedad</th>
                                        <th class="text-center text-white"><i class="fas fa-calendar-alt me-1"></i> Año</th>
                                        <th class="text-center text-white"><i class="fas fa-calendar me-1"></i> Bimestre</th>
                                        <th class="text-white"><i class="fas fa-receipt me-1"></i> Tipo Cuota</th>
                                        <th class="text-end text-white"><i class="fas fa-dollar-sign me-1"></i> Total a Pagar</th>
                                        <th class="text-center text-white"><i class="fas fa-info-circle me-1"></i> Estado</th>
                                        <th class="text-white"><i class="far fa-calendar-check me-1"></i> Fecha Pago</th>
                                        <th class="text-center text-white"><i class="fas fa-cog me-1"></i> Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($propertyTaxes as $tax)
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark">
                                                    <i class="fas fa-barcode me-1"></i>
                                                    {{ $tax->folio ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="fas fa-home text-info"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $tax->property->taxpayer_name ?? 'N/A' }}</div>
                                                        <small class="text-muted">
                                                            <i class="fas fa-hashtag me-1"></i>
                                                            {{ $tax->property->location_account ?? 'N/A' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $tax->tax_year }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                    {{ $tax->bimonthly_period }}° Bimestre
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $tax->cuota_type == 'cuota_minima' ? 'bg-info' : 'bg-warning' }} bg-opacity-10 text-{{ $tax->cuota_type == 'cuota_minima' ? 'info' : 'warning' }}">
                                                    {{ $tax->cuota_type == 'cuota_minima' ? 'Cuota Mínima' : 'Cuota Normal' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-bold text-success">
                                                    ${{ number_format($tax->total_payment ?? 0, 2) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($tax->payment_status == 'pagado')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i> Pagado
                                                    </span>
                                                @elseif($tax->payment_status == 'vencido')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-exclamation-circle me-1"></i> Vencido
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i> Pendiente
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($tax->payment_date)
                                                    <div class="d-flex align-items-center">
                                                        <i class="far fa-calendar-check text-success me-2"></i>
                                                        <span>{{ $tax->payment_date->format('d/m/Y') }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('property_taxes.show', $tax->id) }}" 
                                                       class="btn btn-sm btn-outline-info"
                                                       data-bs-toggle="tooltip"
                                                       title="Ver recibo">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($tax->payment_status != 'pagado')
                                                        <a href="{{ route('property_taxes.edit', $tax->id) }}" 
                                                           class="btn btn-sm btn-outline-warning"
                                                           data-bs-toggle="tooltip"
                                                           title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('property_taxes.mark-paid', $tax->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-success"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Marcar como pagado">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('property_taxes.print', $tax->id) }}" 
                                                       class="btn btn-sm btn-outline-secondary"
                                                       data-bs-toggle="tooltip"
                                                       title="Imprimir recibo"
                                                       target="_blank">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if($propertyTaxes->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Mostrando <strong>{{ $propertyTaxes->firstItem() }}</strong> a <strong>{{ $propertyTaxes->lastItem() }}</strong> de <strong>{{ $propertyTaxes->total() }}</strong> registros
                                </div>
                                <div>
                                    {{ $propertyTaxes->links('pagination::bootstrap-5') }}
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
    // Inicializar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
