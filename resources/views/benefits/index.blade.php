@extends('layouts.master')
@section('title') Mis Beneficios @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Mis Beneficios @endslot
        @slot('li_2') Entradas @endslot
        @slot('title') Listado @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:benefits.entries-table />
        </div>
    </div>
@endsection
