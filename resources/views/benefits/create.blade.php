@extends('layouts.master')
@section('title') Nuevo Beneficio @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Mis Beneficios @endslot
        @slot('li_2') Entradas @endslot
        @slot('title') Nuevo Beneficio @endslot
    @endcomponent

    <livewire:benefits.crud :mode="$mode" />
@endsection
