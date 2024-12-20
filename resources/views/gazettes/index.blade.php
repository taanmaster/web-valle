@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Documentos @endslot
@slot('title') Gaceta Municipal @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div class="d-md-block">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary btn-uppercase d-flex align-items-center text-uppercase fs-7"><i class='bx bx-plus-circle mr-4'></i> Nueva Validación</a>
                </div>
            </div>
        </div>
    
        @if($gazettes->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('back/assets/img/scrumboard-upload-img.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay elementos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('gazettes.create') }}" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nueva Validación</a>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            @include('back.gazettes.utilities._table')
        </div>
    
        <div class="d-flex align-items-center justify-content-center">
            {{ $gazettes->links() }}
        </div>
        @endif    
    </div>
</div>
@endsection
