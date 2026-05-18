@extends('layouts.master')
@section('title')
    Ver Entrada
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
            Ver
        @endslot
    @endcomponent

    <livewire:general-blog.crud :mode="$mode" :entry="$entry" :type="'events'" />
@endsection
