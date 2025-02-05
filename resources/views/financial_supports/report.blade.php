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
        <div class="row">
            <div class="col-12">
                <h4>Reporte de Apoyos Económicos</h4>
                <p>Desde: {{ Carbon\Carbon::now()->startOfMonth() }} Hasta: {{ Carbon\Carbon::now()->endOfMonth() }}</p>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Número de Apoyos al Mes</h5>
                        <p class="card-text">{{ $num_apoyos_mes }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cantidad Invertida en Apoyos</h5>
                        <p class="card-text">${{ number_format($cantidad_invertida_apoyos, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cantidad de Particulares Nuevos</h5>
                        <p class="card-text">{{ $cantidad_particulares_nuevos }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cantidad de Particulares Apoyados</h5>
                        <p class="card-text">{{ $cantidad_particulares_apoyados }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection