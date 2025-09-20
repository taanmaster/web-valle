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
            Salidas
        @endslot
    @endcomponent

    <livewire:dif.expenses.crud :mode="$mode" :expense="$expense" />
@endsection
