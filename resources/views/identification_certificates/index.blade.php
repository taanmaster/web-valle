@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Secretaria Particular
        @endslot
        @slot('title')
            Constancias de Identificacion
        @endslot
    @endcomponent

    <div class="content">
        <div class="row">
            <livewire:identification-certificates.table :mode="0" />
        </div>
    </div>
@endsection
