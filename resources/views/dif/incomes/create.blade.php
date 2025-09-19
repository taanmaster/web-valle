@extends('layouts.master')

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
            Ingreso
        @endslot
    @endcomponent


    <div class="row">
    </div>
@endsection
