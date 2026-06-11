@extends('layouts.master')
@section('title') Nueva Entrada @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Programa de Identidad @endslot
        @slot('li_2') Entradas @endslot
        @slot('title') Nueva Entrada @endslot
    @endcomponent

    <livewire:identity-program.crud :mode="$mode" />
@endsection
