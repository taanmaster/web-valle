@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Protección Civil @endslot
@slot('title') Seguimiento de vigencias @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="mb-4">
            <p class="pc-eyebrow mb-1">3 · Documentos emitidos</p>
            <h4 class="mb-1">Seguimiento de opiniones técnicas y permisos</h4>
            <p class="text-muted mb-0">Vigente: le queda más de la mitad de su vigencia · Por vencer: la mitad o menos · Vencida: 0 días.</p>
        </div>
        @livewire('proteccion-civil.validity.table')
    </div>
</div>
@include('proteccion_civil._styles')
@endsection
