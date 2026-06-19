@extends('layouts.master')
@section('title')
    Panteones — Ver Registro
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Panteones
        @endslot
        @slot('li_2')
            Ver Registro
        @endslot
        @slot('title')
            Ver Registro
        @endslot
    @endcomponent

    <livewire:panteon.crud :panteon="$panteon" :mode="$mode" />
@endsection
