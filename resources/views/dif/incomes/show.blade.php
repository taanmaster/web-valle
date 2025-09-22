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
            Ingresos
        @endslot
    @endcomponent


    <livewire:dif.incomes.crud :mode="$mode" :income="$income" />
@endsection
