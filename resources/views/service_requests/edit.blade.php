@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Mejora regulatoria
        @endslot
        @slot('li_2')
            Trámites y servicios
        @endslot
        @slot('title')
            Trámites
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:service-requests.crud :mode="$mode" :request="$request" />
        </div>
    </div>
@endsection
