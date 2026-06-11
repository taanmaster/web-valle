@extends('layouts.master')
@section('title')
    Panteones — Nuevo Registro
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Panteones
        @endslot
        @slot('li_2')
            Nuevo Registro
        @endslot
        @slot('title')
            Nuevo Registro
        @endslot
    @endcomponent

    <livewire:panteon.crud :mode="$mode" />
@endsection
