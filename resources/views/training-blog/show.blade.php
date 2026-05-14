@extends('layouts.master')
@section('title') Ver Entrada @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Programa de Capacitación @endslot
        @slot('li_2') Blog @endslot
        @slot('title') Ver @endslot
    @endcomponent
    <livewire:training-blog.crud :mode="$mode" :entry="$entry" />
@endsection
