@extends('layouts.master')
@section('title')
    Calendario Medio Ambiente
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Medio Ambiente
        @endslot
        @slot('title')
            Calendario de Talleres y Pláticas
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Calendario de Talleres y Pláticas</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    @livewire('environment-events.table')

                </div>
            </div>
        </div>
    </div>
@endsection
