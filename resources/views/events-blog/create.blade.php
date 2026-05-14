@extends('layouts.master')
@section('title')
    Nueva Entrada
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eventos Conmemorativos
        @endslot
        @slot('li_2')
            Entrada
        @endslot
        @slot('title')
            Crear Entrada
        @endslot
    @endcomponent

    <livewire:general-blog.crud :mode="$mode" :type="'events'" />
@endsection
