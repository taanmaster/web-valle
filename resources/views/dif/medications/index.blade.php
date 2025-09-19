@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Medicamentos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                @include('dif.medications.utilities._search_options')
                <a href="{{ route('dif.medications.create') }}" class="btn btn-primary">Nuevo Medicamento</a>
                <a href="{{ route('dif.stock_movements.index') }}" class="btn btn-info">
                    <i class="fas fa-boxes"></i> Ver Inventario
                </a>
            </div>
        </div>

        @include('dif.medications.utilities._modal')

        @if($medications->count() == 0)
        <div class="row"> 
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body"> 
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay medicamentos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('dif.medications.create') }}" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nuevo Medicamento</a>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row"> 
            @include('dif.medications.utilities._table')
        </div>

        <!-- Resumen estadístico -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Resumen de Medicamentos</h6>
                        <div class="row">
                            @php
                                $totalMedications = $medications->total();
                                $activeMedications = $medications->where('is_active', true)->count();
                                $totalVariants = $medications->sum(function($med) { return $med->getVariantsCount(); });
                                $totalStock = $medications->sum(function($med) { return $med->getTotalStock(); });
                                $medicationsWithStock = $medications->filter(function($med) { 
                                    return $med->getTotalStock() > 0; 
                                })->count();
                            @endphp
                            
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="text-primary">{{ $totalMedications }}</h5>
                                    <small class="text-muted">Total Medicamentos</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="text-success">{{ $activeMedications }}</h5>
                                    <small class="text-muted">Activos</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="text-info">{{ $totalVariants }}</h5>
                                    <small class="text-muted">Total Variantes</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-warning">{{ $totalStock }}</h5>
                                    <small class="text-muted">Unidades en Stock</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-success">{{ $medicationsWithStock }}</h5>
                                    <small class="text-muted">Con Existencias</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="align-items-center mt-4">
            {{ $medications->links('pagination::bootstrap-5') }}
        </div>
        @endif    
    </div>
</div>
@endsection
