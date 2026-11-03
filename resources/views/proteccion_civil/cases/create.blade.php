@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Protección Civil @endslot
@slot('title') Crear carpeta @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <p class="pc-eyebrow mb-1">2 · Expedientes</p>
                <h4 class="mb-1">Crear carpeta presencial</h4>
                <p class="text-muted mb-0">Para ciudadanos o empresas que acuden directamente a las oficinas de Protección Civil.</p>
            </div>
            <a href="{{ route('proteccion_civil.cases.index') }}" class="btn btn-outline-secondary"><i class="ti ti-arrow-left"></i> Bandeja</a>
        </div>
        @livewire('proteccion-civil.cases.create')
    </div>
</div>
@include('proteccion_civil._styles')
@endsection
