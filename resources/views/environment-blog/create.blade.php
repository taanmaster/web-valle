@extends('layouts.master')
@section('title')
    Nueva Entrada
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Medio Ambiente
        @endslot
        @slot('li_2')
            Blog
        @endslot
        @slot('title')
            Crear Entrada
        @endslot
    @endcomponent

    <livewire:general-blog.crud :mode="$mode" :type="'medio_ambiente'" />
@endsection
