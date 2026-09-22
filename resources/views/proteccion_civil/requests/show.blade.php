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
            Protección Civil
        @endslot
        @slot('li_3')
            <a href="{{ route('proteccion_civil.requests.index') }}">Solicitudes de Factibilidad</a>
        @endslot
        @slot('title')
            Folio {{ $review->urbanDevRequest->folio }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <a href="{{ route('proteccion_civil.requests.index') }}" class="btn btn-link ps-0 mb-2">
                <i class="fas fa-arrow-left me-1"></i> Volver a la bandeja
            </a>

            @livewire('proteccion-civil.requests.review', ['review' => $review])
        </div>
    </div>
@endsection
