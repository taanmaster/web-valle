@extends('layouts.master')
@section('title') Módulo de Ayuda @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Admin @endslot
        @slot('li_2') Módulo de Ayuda @endslot
        @slot('title') Módulo de Ayuda @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:ayuda.entries-table />
        </div>
    </div>
@endsection
