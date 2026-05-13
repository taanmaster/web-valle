@extends('layouts.master')
@section('title')
    Dirección de Salud
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dirección de Salud
        @endslot
        @slot('li_2')
            Blog
        @endslot
        @slot('title')
            Ver Entrada
        @endslot
    @endcomponent

    <livewire:health-direction.blog.crud :mode="$mode" :blog="$blog" />
@endsection
