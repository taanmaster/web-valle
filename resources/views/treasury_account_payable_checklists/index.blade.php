@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Checklists @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">Nuevo Checklist</a>
            </div>
        </div>

        @include('treasury_account_payable_checklists.utilities._modal')

        @if($checklists->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay checklists guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nuevo Checklist</a>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            @include('treasury_account_payable_checklists.utilities._table')
        </div>
    
        <div class="align-items-center mt-4">
            {{ $checklists->links('pagination::bootstrap-5') }}
        </div>
        @endif    
    </div>
</div>
@endsection