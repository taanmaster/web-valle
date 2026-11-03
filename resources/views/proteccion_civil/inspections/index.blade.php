@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Protección Civil @endslot
@slot('title') Mis inspecciones @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <p class="pc-eyebrow mb-1">2 · Expedientes · Inspector</p>
                <h4 class="mb-1">Mis inspecciones asignadas</h4>
                <p class="text-muted mb-0">Sólo ves los expedientes en los que el consultor te asignó una inspección. Abre uno para registrar fecha de visita, resultado, fotos y acta.</p>
            </div>
            
        </div>
        @livewire('proteccion-civil.inspections.table')
    </div>
</div>
@include('proteccion_civil._styles')
@endsection
