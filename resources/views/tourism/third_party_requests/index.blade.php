@extends('layouts.master')
@section('title')
    Turismo
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Turismo
        @endslot
        @slot('li_2')
            Apoyo a Terceros
        @endslot
        @slot('title')
            Solicitudes de Apoyo a Terceros
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <livewire:tourism.third-party-request.entries-table />
                </div>
            </div>
        </div>
    </div>
@endsection
