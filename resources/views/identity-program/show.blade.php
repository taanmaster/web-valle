@extends('layouts.master')
@section('title') Ver Entrada @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Programa de Identidad @endslot
        @slot('li_2') Entradas @endslot
        @slot('title') {{ $entry->title }} @endslot
    @endcomponent

    <livewire:identity-program.crud :entry="$entry" :mode="$mode" />
@endsection
