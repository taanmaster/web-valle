@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Trámites
        @endslot
        @slot('title')
            Citatorios
        @endslot
    @endcomponent

    <div class="content">


        <div class="row">
            <livewire:summons.table :mode="$mode" />
        </div>
    </div>
@endsection
