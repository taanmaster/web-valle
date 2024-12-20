@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Usuarios @endslot
@slot('title') Listado @endslot
@endcomponent

<div class="row">
    <div class="col">
        <h4>Usuario: {{ $user->name }}</h4>
        <p>{{ $user->email }}</p>
    </div>
</div>

@endsection
