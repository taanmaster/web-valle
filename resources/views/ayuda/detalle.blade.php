@extends('layouts.master')
@section('title') {{ $guia->titulo }} @endsection
@section('content')
    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:ayuda.guia-detalle :guia="$guia" context="admin" />
        </div>
    </div>
@endsection
