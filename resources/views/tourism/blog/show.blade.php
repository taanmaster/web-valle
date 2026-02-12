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
            Ver Entrada
        @endslot
    @endcomponent

    <livewire:tourism.blog.crud :mode="$mode" :blog="$blog" />
@endsection
