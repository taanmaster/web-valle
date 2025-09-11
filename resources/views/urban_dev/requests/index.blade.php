@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('title') Solicitudes de Desarrollo Urbano @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-8 text-start">
                <h4 class="mb-0">Solicitudes de Desarrollo Urbano</h4>
                <p class="text-muted">Gestión de solicitudes enviadas por los ciudadanos</p>
            </div>
            <div class="col-md-4 text-end">
                @include('urban_dev.requests.utilities._search_options')
            </div>
        </div>

        @if($urban_dev_requests->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay solicitudes de Desarrollo Urbano en la base de datos!</h4>
                            <p class="mb-4">Las solicitudes aparecerán aquí cuando los ciudadanos las envíen desde el portal.</p>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            @include('urban_dev.requests.utilities._table')
        </div>
    
        <div class="align-items-center mt-4">
            {{ $urban_dev_requests->links('pagination::bootstrap-5') }}
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

.dropdown-menu {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.15);
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection
@endsection
