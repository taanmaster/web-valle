@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Repositorio @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                @include('transparency_files.utilities._search_options')
            </div>
        </div>

        @if($transparency_files->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay elementos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente. Desde la vista de detalle de la dependencia.</p>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info" role="alert">
            Los archivos que se visualización en este repositorio se pueden subir desde la vista de detalle de la dependencia.
        </div>

        <div class="row"> 
            @include('transparency_files.utilities._table')
        </div>
    
        <div class="d-flex align-items-center justify-content-center">
            {{ $transparency_files->links() }}
        </div>
        @endif    
    </div>
</div>
@endsection