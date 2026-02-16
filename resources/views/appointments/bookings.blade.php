@extends('layouts.master')
@section('title') Intranet @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Citas @endslot
        @slot('title') Citas Agendadas @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:appointments.bookings-table />
    </div>
@endsection
