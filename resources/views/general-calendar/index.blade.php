@extends('layouts.master')
@section('title') Trámites Calendario @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Calendario General @endslot
        @slot('li_2') Trámites @endslot
        @slot('title') Listado @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:general-calendar.procedures-table />
        </div>
    </div>
@endsection
