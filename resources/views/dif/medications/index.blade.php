@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Medicamentos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                @include('dif.medications.utilities._search_options')
                <a href="{{ route('dif.medications.create') }}" class="btn btn-primary">Nuevo Medicamento</a>
            </div>
        </div>

        @include('dif.medications.utilities._modal')

        @if($medications->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay medicamentos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('dif.medications.create') }}" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nuevo Medicamento</a>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            @include('dif.medications.utilities._table')
        </div>
    
        <div class="align-items-center mt-4">
            {{ $medications->links('pagination::bootstrap-5') }}
        </div>
        @endif    
    </div>
</div>
@endsection
