@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Resultados de Búsqueda @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- HEADER DE MÓDULO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-search fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Resultados de Búsqueda</h3>
                            <p class="text-muted mb-0">
                                @if(Request::input('query'))
                                    Resultados para: <strong>"{{ Request::input('query') }}"</strong> &mdash;
                                @endif
                                <span class="badge bg-info">{{ $financial_supports->count() }} resultado(s)</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <a href="{{ route('financial_supports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form role="search" action="{{ route('back.financial_supports.query') }}" class="row g-3 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label fw-semibold">Buscar apoyo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="search" name="query" value="{{ Request::input('query') }}" placeholder="Folio del apoyo...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLA O ESTADO VACÍO --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @if($financial_supports->count())
                    @include('financial_supports.utilities._table')
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted">¡No hay resultados con esa búsqueda!</h5>
                        <p class="text-muted mb-4">Mejora tus términos de búsqueda o utiliza la búsqueda avanzada.</p>
                        <a href="{{ route('financial_supports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Volver al listado
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
