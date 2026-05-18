@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Consulta por Día @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- HEADER DE MÓDULO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-hand-holding-usd fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Apoyos Económicos</h3>
                            <p class="text-muted mb-0">Consulta de apoyos entregados por día</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Apoyo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Buscar por folio</label>
                        <form role="search" action="{{ route('back.financial_supports.query') }}" class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="search" name="query" placeholder="Folio del apoyo...">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Filtrar por fecha</label>
                        <form role="search" action="{{ route('report.query') }}" class="input-group">
                            <input type="date" class="form-control" name="date_start" value="{{ Request::input('date_start') }}">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- NAVEGACIÓN POR DÍA --}}
        <div class="d-flex gap-3 align-items-center justify-content-center mb-4">
            <form role="search" action="{{ route('report.query') }}">
                <input type="hidden" name="date_start" value="{{ Carbon\Carbon::parse(Request::input('date_start'))->subDay()->format('Y-m-d') }}">
                <button type="submit" class="btn btn-outline-secondary" title="Día anterior" aria-label="Día anterior">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </form>
            <h5 class="mb-0 fw-bold">Apoyos del día: {{ Carbon\Carbon::parse(Request::input('date_start'))->translatedFormat('d M Y') }}</h5>
            <form role="search" action="{{ route('report.query') }}">
                <input type="hidden" name="date_start" value="{{ Carbon\Carbon::parse(Request::input('date_start'))->addDay()->format('Y-m-d') }}">
                <button type="submit" class="btn btn-outline-secondary" title="Día siguiente" aria-label="Día siguiente">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>

        @include('financial_supports.utilities._modal')

        {{-- TABLA O ESTADO VACÍO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                @if($financial_supports->count() == 0)
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted">No hay apoyos registrados en este día</h5>
                        <p class="text-muted mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Apoyo
                        </a>
                    </div>
                @else
                    @include('financial_supports.utilities._table')
                @endif
            </div>
        </div>

        {{-- DESCARGA CORTE --}}
        <form method="POST" action="{{ route('financial_supports.downloadCashCut') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="date_start" value="{{ Request::input('date_start') }}">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i> Descargar Corte de este día
            </button>
        </form>

    </div>
@endsection
