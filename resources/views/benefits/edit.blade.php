@extends('layouts.master')
@section('title') Editar Beneficio @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Mis Beneficios @endslot
        @slot('li_2') Entradas @endslot
        @slot('title') {{ $entry->title }} @endslot
    @endcomponent

    <livewire:benefits.crud :entry="$entry" :mode="$mode" />
@endsection
