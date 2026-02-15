@extends('layouts.master')
@section('title')
    Recursos Humanos
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Recursos Humanos
        @endslot
        @slot('li_2')
            Vacantes
        @endslot
        @slot('title')
            Crear Vacante
        @endslot
    @endcomponent

    <livewire:h-r.vacancy.crud :mode="$mode" />
@endsection
