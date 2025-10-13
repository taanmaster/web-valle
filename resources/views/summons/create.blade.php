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
            Trámites
        @endslot
        @slot('title')
            Citatorios
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:summons.crud :mode="$mode" />
        </div>
    </div>
@endsection
