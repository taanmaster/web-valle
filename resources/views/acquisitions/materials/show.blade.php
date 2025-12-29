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
            Adquisiciones
        @endslot
        @slot('title')
            Productos y servicio
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:acquisitions.materials.crud :mode="$mode" :material="$material" />
        </div>
    </div>
@endsection
