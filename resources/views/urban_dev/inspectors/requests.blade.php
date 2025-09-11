@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('title') Mis Solicitudes Asignadas @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-8 text-start">
                <h4 class="mb-0">Mis Solicitudes Asignadas</h4>
                <p class="text-muted">Solicitudes de desarrollo urbano asignadas a ti como inspector</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="badge bg-info fs-6">
                    <i class="fas fa-clipboard-list"></i> 
                    Total: {{ $urban_dev_requests->total() }}
                </div>
            </div>
        </div>

        @if($urban_dev_requests->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <i class="fas fa-clipboard-check" style="font-size: 80px; color: #6c757d; margin-bottom: 30px;"></i>
                            <h4>¡No tienes solicitudes asignadas!</h4>
                            <p class="mb-4 text-muted">Las solicitudes aparecerán aquí cuando un administrador te las asigne.</p>
                            <a href="{{ route('urban_dev.inspectors.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Volver a Inspectores
                            </a>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('urban_dev.inspectors.utilities._table')
                    </div>
                </div>
            </div>
        </div>
    
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <small class="text-muted">
                    Mostrando {{ $urban_dev_requests->firstItem() ?? 0 }} a {{ $urban_dev_requests->lastItem() ?? 0 }} 
                    de {{ $urban_dev_requests->total() }} solicitudes
                </small>
            </div>
            <div>
                {{ $urban_dev_requests->links('pagination::bootstrap-5') }}
            </div>
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

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
</style>
@endsection
@endsection
