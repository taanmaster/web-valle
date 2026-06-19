@extends('layouts.master')
@section('title') Editar Trámite @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Calendario General @endslot
        @slot('li_2') Trámites @endslot
        @slot('title') {{ $procedure->name }} @endslot
    @endcomponent

    <livewire:general-calendar.crud :procedure="$procedure" :mode="$mode" />
@endsection
