@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Protección Civil @endslot
@slot('title') Bandeja de seguimiento @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <p class="pc-eyebrow mb-1">2 · Expedientes</p>
                <h4 class="mb-1">Bandeja de seguimiento de trámites</h4>
                
            </div>
            <a href="{{ route('proteccion_civil.cases.create') }}" class="btn pc-btn"><i class="ti ti-plus"></i> Crear carpeta</a>
        </div>
        @livewire('proteccion-civil.cases.table')
    </div>
</div>
@include('proteccion_civil._styles')
@endsection
