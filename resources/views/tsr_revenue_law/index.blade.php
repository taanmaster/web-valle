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
            Ley de Ingresos
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalIncome"
                        class="btn btn-primary">Nuevo Ingreso</a>
                </div>
            </div>

            <livewire:tsr-revenue-law.income-modal />
            <livewire:tsr-revenue-law.concept-modal />

            @if ($incomes->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay ingresos guardados en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalIncome"
                                        class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nuevo
                                        Ingreso</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">

                    @include('tsr_revenue_law.utilities._table')

                </div>

                <div class="d-flex align-items-center justify-content-center">
                    {{ $incomes->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
