@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') SARE @endslot
@slot('title') Solicitudes SARE @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                <h4 class="mb-0">Solicitudes del Sistema de Apertura Rápida de Empresas</h4>
                <p class="text-muted">Gestión de solicitudes enviadas por los ciudadanos</p>
            </div>
        </div>

        @if($sare_requests->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay solicitudes SARE en la base de datos!</h4>
                            <p class="mb-4">Las solicitudes aparecerán aquí cuando los ciudadanos las envíen desde el portal.</p>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            @include('sare.requests.utilities._table')
        </div>
    
        <div class="align-items-center mt-4">
            {{ $sare_requests->links('pagination::bootstrap-5') }}
        </div>
        @endif    
    </div>
</div>
@endsection
