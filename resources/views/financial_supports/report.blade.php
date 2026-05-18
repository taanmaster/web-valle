@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Reporte Mensual @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- HEADER DE MÓDULO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-chart-bar fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">Reporte de Apoyos Económicos</h3>
                        <p class="text-muted mb-0">
                            Desde: {{ Carbon\Carbon::parse($date_start)->translatedFormat('d M Y') }}
                            &mdash;
                            Hasta: {{ Carbon\Carbon::parse($date_end)->translatedFormat('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTRO DE RANGO DE FECHAS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('kpi.query') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="date_start" class="form-label fw-semibold">Fecha inicio</label>
                        <input type="date" id="date_start" name="date_start"
                               class="form-control"
                               value="{{ $date_start }}">
                    </div>
                    <div class="col-md-4">
                        <label for="date_end" class="form-label fw-semibold">Fecha fin</label>
                        <input type="date" id="date_end" name="date_end"
                               class="form-control"
                               value="{{ $date_end }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Consultar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TARJETAS KPI --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <i class="fas fa-hands-helping fa-2x text-primary mb-3"></i>
                        <h2 class="fw-bold text-primary">{{ $num_apoyos_mes }}</h2>
                        <p class="text-muted mb-0">Apoyos del mes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <i class="fas fa-dollar-sign fa-2x text-success mb-3"></i>
                        <h2 class="fw-bold text-success">${{ number_format($cantidad_invertida_apoyos, 2) }}</h2>
                        <p class="text-muted mb-0">Invertido en apoyos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <i class="fas fa-user-plus fa-2x text-info mb-3"></i>
                        <h2 class="fw-bold text-info">{{ $cantidad_particulares_nuevos }}</h2>
                        <p class="text-muted mb-0">Particulares nuevos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <i class="fas fa-users fa-2x text-warning mb-3"></i>
                        <h2 class="fw-bold text-warning">{{ $cantidad_particulares_apoyados }}</h2>
                        <p class="text-muted mb-0">Particulares apoyados</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection