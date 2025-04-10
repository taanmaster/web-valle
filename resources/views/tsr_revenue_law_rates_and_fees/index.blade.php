@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Tesorería
        @endslot
        @slot('title')
            Tarifas y costos de ingresos de Valle
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#rateModal"
                        class="btn btn-primary">Agregar Tarifa</a>
                </div>
            </div>
            @if ($rates->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay tarifas guardadas en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#rateModal"
                                        class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nueva
                                        Tarifa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @include('tsr_revenue_law_rates_and_fees.utilities._table')
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    {{ $rates->links() }}
                </div>
            @endif

        </div>
    </div>

    <div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="rateModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h6 class="modal-title m-0 text-white" id="modalCreate">Nueva Tarifa o Costo</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                @livewire('tsr-revenue-law.rates-and-fees-modal')

            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
@endsection
