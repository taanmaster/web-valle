@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Protección Civil @endslot
@slot('title') Expediente {{ $case->folio }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        @livewire('proteccion-civil.cases.show', ['case' => $case])
    </div>
</div>
@include('proteccion_civil._styles')
@endsection
