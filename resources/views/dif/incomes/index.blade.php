@extends('layouts.master')

@section('title')
    Ingresos
@endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            DIF
        @endslot
        @slot('title')
            Ingresos
        @endslot
    @endcomponent

    <div class="row">
    </div>
@endsection
