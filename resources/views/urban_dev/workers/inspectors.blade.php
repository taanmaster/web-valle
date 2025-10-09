@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('title') Directorio de Inspectores @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-8 text-start">
                <h4 class="mb-0">Directorio de Inspectores</h4>
                <p class="text-muted">Gestión del directorio de inspectores de Desarrollo Urbano</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('urban_dev.workers.create') }}" class="btn btn-success">
                    <i class='fas fa-plus-circle me-2'></i> Agregar Inspector
                </a>
            </div>
        </div>

        @if($workers->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <div class="mb-4">
                                <i class="fas fa-user-tie" style="font-size: 120px; color: #6c757d; opacity: 0.3;"></i>
                            </div>
                            <h4>¡No hay inspectores registrados!</h4>
                            <p class="text-muted mb-4">Empieza a crear el directorio de inspectores para el área de Desarrollo Urbano.</p>
                            <a href="{{ route('urban_dev.workers.create') }}" class="btn btn-success">
                                <i class='fas fa-plus-circle me-2'></i> Agregar Inspector
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            @include('urban_dev.workers._workers_table')
        </div>

        <div class="align-items-center mt-4">
            {{ $workers->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@section('scripts')
<style>
    .table th {
        background-color: #495057;
        color: white;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        font-size: 0.875rem;
    }

    .table td {
        vertical-align: middle;
        font-size: 0.875rem;
    }

    .table-striped > tbody > tr:nth-of-type(odd) > td {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .badge {
        font-size: 0.75em;
    }

    .btn-group .btn {
        padding: 0.375rem 0.75rem;
    }
</style>
@endsection
@endsection
