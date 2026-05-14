@extends('layouts.master')
@section('title') Editar Entrada @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Programa de Capacitación @endslot
        @slot('li_2') Blog @endslot
        @slot('title') Editar @endslot
    @endcomponent
    <livewire:training-blog.crud :mode="$mode" :entry="$entry" />
@endsection
