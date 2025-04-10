@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Tesorería
        @endslot
        @slot('li_2')
            <a href="{{ route('trs_admin_revenue_collection.index') }}">
                Disposiciones Administrativas de Recaudación
            </a>
        @endslot
        @slot('title')
            Detalle del artículo
        @endslot
    @endcomponent

    <div class="row layout-spacing">


        <div class="main-content">


            <h4>Información General</h4>


            <div class="row mb-4">
                <div class="col-md-6">
                    <p>
                        <strong>Nombre:</strong> {{ $article->name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Descripción:</strong> {{ $article->description ?? 'N/A' }}
                    </p>
                </div>
            </div>


            <div class="d-flex align-items-center justify-content-between mb-4">

                <h3>Tarifas</h3>

                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#fractionModal" class="btn btn-primary"
                    style="max-width: 180px">Nueva fracción</a>

            </div>

            <livewire:tsr-admin-revenue-collection.fraction-modal :articleId="$article->id" />
            <livewire:tsr-admin-revenue-collection.clause-modal :articleId="$article->id" />
            <livewire:tsr-admin-revenue-collection.variant-modal :articleId="$article->id" />


            @if ($fractions->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay Tarifas guardadas en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#fractionModal"
                                        class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nueva
                                        Fracción</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @include('tsr_admin_revenue_collection.utilities._table_show')
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    {{ $fractions->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
