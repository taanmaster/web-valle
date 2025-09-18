@extends('layouts.master')

@section('title')
    Consultas Médicas
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
            Consultas Médicas
        @endslot
    @endcomponent

    <div class="row">

    </div>
@endsection

@section('script')
@endsection
