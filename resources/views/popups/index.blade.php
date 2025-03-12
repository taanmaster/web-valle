@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Popups @endslot
@slot('title') Popups @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                <a href="{{ route('popups.create') }}" class="btn btn-primary">Agregar Elemento</a>
            </div>
        </div>

        @if($popups->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('img/illustration/icon-documentation.webp') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay popups guardadas en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargar popups en tu plataforma usando el botón superior.</p>
                            <a href="{{ route('popups.create') }}" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Crear nuevo Pop-up</a>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            @include('popups.utilities._table')
        </div>
    
        <div class="d-flex align-items-center justify-content-center">
            {{ $popups->links() }}
        </div>
        @endif    
    </div>
</div>
@endsection