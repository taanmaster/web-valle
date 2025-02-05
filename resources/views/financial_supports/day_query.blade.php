@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Documentos @endslot
@slot('title') Apoyos Económicos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                @include('financial_supports.utilities._search_options')
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">Nuevo Apoyo</a>
            </div>

            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-uppercase text-uppercase fs-7 me-3 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-filter-alt'></i> Filtrar <i class="fas fa-caret-down"></i>
                        </button>
                        <div class="dropdown-menu me-5" aria-labelledby="dropdownMenuButton">
                            <form class="form-horizontal px-4 py-2" role="search" action="{{ route('report.query') }}">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="form-group mb-3">
                                            <label for="filter">Fecha <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date_start">
                                        </div>
                                    </div>
    
                                    <div class="col-md-12 text-right mb-0">
                                        <button type="submit" class="btn btn-primary btn-block"><i class='bx bx-search' ></i> Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="d-flex gap-4 align-items-center justify-content-center">
                <form role="search" action="{{ route('report.query') }}" style="display: inline-block;">
                    <button type="submit" class="btn btn-outline-secondary py-1 px-2" style="font-size: 1.5em; border-radius:20px;">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                    
                    <input type="hidden" name="date_start" value="{{ Carbon\Carbon::parse(Request::input('date_start'))->subDay()->format('Y-m-d') }}">
                </form>

                <h5 class="box-title fs-5">Apoyos del día: {{ Carbon\Carbon::parse(Request::input('date_start'))->translatedFormat('d M Y') }}</h5>

                <form role="search" action="{{ route('report.query') }}" style="display: inline-block;">
                    <button type="submit" class="btn btn-outline-secondary py-1 px-2" style="font-size: 1.5em; border-radius:20px;">
                        <i class="fa fa-arrow-right"></i>
                    </button>

                    <input type="hidden" name="date_start" value="{{ Carbon\Carbon::parse(Request::input('date_start'))->addDay()->format('Y-m-d') }}">
                </form>
            </div>
        </div>

        @include('financial_supports.utilities._modal')

        @if($financial_supports->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay elementos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('financial_supports.create') }}" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nuevo Apoyo</a>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row mt-5"> 
            @include('financial_supports.utilities._table')
        </div>
    
        {{--  
        <div class="d-flex align-items-center justify-content-center">
            {{ $financial_supports->links() }}
        </div>
        --}}
        @endif    
    </div>
</div>
@endsection
