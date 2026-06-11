@extends('layouts.master')
@section('title') Nueva Guía @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Módulo de Ayuda @endslot
        @slot('li_2') Nueva Guía @endslot
        @slot('title') Nueva Guía @endslot
    @endcomponent

    <livewire:ayuda.crud :mode="$mode" />
@endsection
