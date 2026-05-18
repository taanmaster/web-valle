@extends('layouts.master')
@section('title') Alta de Cumpleaños @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Comunicación y Vinculación @endslot
        @slot('li_2') Alta de Cumpleaños @endslot
        @slot('title') Cumpleaños de Administración @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            @livewire('birthday.crud-modal')
        </div>
    </div>
@endsection
