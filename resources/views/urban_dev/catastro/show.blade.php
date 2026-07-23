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
            Desarrollo Urbano
        @endslot
        @slot('li_3')
            <a href="{{ route('urban_dev.catastro.index') }}">Catastro</a>
        @endslot
        @slot('title')
            Captura de predio · Solicitud #{{ $castro->urban_dev_request_id }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            @livewire('urban-dev.castro.crud', [
                'castro' => $castro,
                'mode' => $mode,
            ])
        </div>
    </div>
@endsection
