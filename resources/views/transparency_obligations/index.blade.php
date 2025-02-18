@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Obligaciones @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                @include('financial_support_types.utilities._search_options')
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">Nuevo Apoyo</a>
            </div>
        </div>

        @include('financial_support_types.utilities._modal')

        @if($financial_support_types->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay elementos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('financial_support_types.create') }}" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nuevo Apoyo</a>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            @include('financial_support_types.utilities._table')
        </div>
    
        <div class="d-flex align-items-center justify-content-center">
            {{ $financial_support_types->links() }}
        </div>
        @endif    
    </div>
</div>
@endsection
