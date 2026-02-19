@extends('layouts.master')
@section('title') Intranet @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Citas @endslot
        @slot('title') Citas del {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} — {{ $appointment->name }} @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:appointments.bookings-day-detail
            :appointmentId="$appointment->id"
            :date="$date"
        />
    </div>
@endsection
