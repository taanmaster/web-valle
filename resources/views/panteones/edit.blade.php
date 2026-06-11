@extends('layouts.master')
@section('title')
    Panteones — Editar Registro
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Panteones
        @endslot
        @slot('li_2')
            Editar Registro
        @endslot
        @slot('title')
            Editar Registro
        @endslot
    @endcomponent

    <livewire:panteon.crud :panteon="$panteon" :mode="$mode" />
@endsection
