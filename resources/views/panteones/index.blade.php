@extends('layouts.master')
@section('title')
    Panteones
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Admin
        @endslot
        @slot('li_2')
            Panteones
        @endslot
        @slot('title')
            Registro Panteones
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:panteon.entries-table />
        </div>
    </div>
@endsection
