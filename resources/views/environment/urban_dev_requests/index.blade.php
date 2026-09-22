@extends('layouts.master')
@section('title')
    Intranet
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
            Solicitudes de Visto Bueno Ambiental
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    @livewire('environment.urban-dev-requests.table')
                </div>
            </div>
        </div>
    </div>
@endsection
