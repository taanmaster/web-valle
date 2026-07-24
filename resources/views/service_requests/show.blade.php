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
            Detalle del trámite
        @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:service-requests.crud :mode="$mode" :request="$request" />
    </div>
@endsection
