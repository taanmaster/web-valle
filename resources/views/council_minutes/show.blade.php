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
            Normativa municipal
        @endslot
        @slot('title')
            Actas de Consejo
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <h4>Información General</h4>

            <livewire:council-minute.crud :mode="$mode" :minute="$minute" />
        </div>
    </div>
@endsection
