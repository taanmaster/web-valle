@extends('layouts.master')
@section('title') Editar Guía @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Módulo de Ayuda @endslot
        @slot('li_2') Editar Guía @endslot
        @slot('title') {{ $guia->titulo }} @endslot
    @endcomponent

    <livewire:ayuda.crud :guia="$guia" :mode="$mode" />
@endsection
