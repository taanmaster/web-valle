@extends('layouts.master')
@section('title') Programa de Identidad @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Programa de Identidad @endslot
        @slot('li_2') Entradas @endslot
        @slot('title') Listado @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:identity-program.entries-table />
        </div>
    </div>
@endsection
