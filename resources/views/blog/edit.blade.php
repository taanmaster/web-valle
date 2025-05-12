@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Entrada
        @endslot
        @slot('title')
            Crear
        @endslot
    @endcomponent


    <livewire:blog.crud :mode="$mode" :blog="$blog" />
@endsection
