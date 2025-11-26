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
            Movimientos
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:acquisitions.inventory.movement :movement="$movement" :mode="$mode" />
        </div>
    </div>
@endsection
