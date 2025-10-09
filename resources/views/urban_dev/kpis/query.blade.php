@extends('layouts.master')

@section('title')Intranet @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
    @slot('li_1') Intranet @endslot
    @slot('li_2') Desarrollo Urbano @endslot
    @slot('title') Resultados Filtrados de Indicadores @endslot
    @endcomponent


    @section('scripts')

    @endsection
@endsection
