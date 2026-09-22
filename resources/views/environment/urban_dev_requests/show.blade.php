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
            <a href="{{ route('environment.urban_dev_requests.index') }}">Solicitudes de Visto Bueno Ambiental</a>
        @endslot
        @slot('title')
            Folio {{ $review->urbanDevRequest->folio }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <a href="{{ route('environment.urban_dev_requests.index') }}" class="btn btn-link ps-0 mb-2">
                <i class="fas fa-arrow-left me-1"></i> Volver a la bandeja
            </a>

            @livewire('environment.urban-dev-requests.review', ['review' => $review])
        </div>
    </div>
@endsection
