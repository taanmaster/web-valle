@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Medio Ambiente
        @endslot
        @slot('title')
            Solicitudes Dirección de Medio Ambiente
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Solicitudes Dirección de Medio Ambiente</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    @livewire('environment-requests.table')

                </div>
            </div>
        </div>
    </div>
@endsection
