@extends('layouts.master')
@section('title') Portal de Guías (Admin) @endsection
@section('content')
    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:ayuda.guias-index context="admin" />
        </div>
    </div>
@endsection
