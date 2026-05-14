@extends('layouts.master')
@section('title') Programa de Capacitación - Nueva Entrada @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Programa de Capacitación @endslot
        @slot('li_2') Blog @endslot
        @slot('title') Nueva Entrada @endslot
    @endcomponent
    <livewire:training-blog.crud :mode="$mode" />
@endsection
