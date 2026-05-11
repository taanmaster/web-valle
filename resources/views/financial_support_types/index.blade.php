@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Tipos de Apoyos @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- HEADER DE MÓDULO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-tags fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Tipos de Apoyos Económicos</h3>
                            <p class="text-muted mb-0">Catálogo de tipos de apoyo y documentación requerida</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Tipo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form role="search" action="{{ route('back.financial_support_types.query') }}" class="row g-3 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label fw-semibold">Buscar tipo de apoyo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="search" name="query" placeholder="Nombre del tipo de apoyo...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        @include('financial_support_types.utilities._modal')

        {{-- TABLA O ESTADO VACÍO --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @if($financial_support_types->count() == 0)
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted">No hay tipos de apoyo registrados</h5>
                        <p class="text-muted mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Tipo
                        </a>
                    </div>
                @else
                    @include('financial_support_types.utilities._table')
                    <div class="d-flex justify-content-center mt-4">
                        {{ $financial_support_types->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
