@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Protección Civil @endslot
@slot('li_3') <a href="{{ route('proteccion_civil.procedures.index') }}">Catálogo de trámites</a> @endslot
@slot('title') {{ $procedure ? 'Editar trámite' : 'Nuevo trámite' }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        @livewire('proteccion-civil.procedures.form', ['procedure' => $procedure])
    </div>
</div>
@include('proteccion_civil._styles')
@endsection
