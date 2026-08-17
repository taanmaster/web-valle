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
        @slot('li_3')
            <a href="{{ route('environment.requests.index') }}">Solicitudes</a>
        @endslot
        @slot('title')
            Solicitud #{{ $environmentRequest->id }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">

                    @livewire('environment-requests.crud', ['environmentRequest' => $environmentRequest])

                </div>
            </div>
        </div>
    </div>
@endsection
