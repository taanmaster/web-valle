@extends('layouts.master')
@section('title') Programa de Capacitación - Descargables @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Programa de Capacitación @endslot
        @slot('title') Descargables @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            @livewire('training-downloadable.crud-modal')
        </div>
    </div>
@endsection
