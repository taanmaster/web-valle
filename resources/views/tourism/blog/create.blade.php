@extends('layouts.master')
@section('title')
    Turismo
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Turismo
        @endslot
        @slot('li_2')
            Blog
        @endslot
        @slot('title')
            Crear Entrada
        @endslot
    @endcomponent

    <livewire:tourism.blog.crud :mode="$mode" />
@endsection
