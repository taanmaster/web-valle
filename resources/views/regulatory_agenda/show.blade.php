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
            Agenda regulatoria
        @endslot
        @slot('title')
            Detalle de la dependencia
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <h4>Información General</h4>

            <div class="row mb-4">
                <div class="col-md-6">
                    <p>
                        <strong>Nombre:</strong> {{ $dependency->name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Descripción:</strong> {{ $dependency->description ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3>Regulaciones</h3>
                <a href="javascript:void(0)" class="btn btn-primary new-fraction" style="max-width: 180px">Nueva
                    regulación</a>
            </div>


            @if ($dependency->regulations->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay Regulaciones guardadas en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-primary btn-uppercase new-fraction"><i
                                            class="fas fa-plus"></i> Nueva
                                        Regulación</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @include('regulatory_agenda.utilities._regulations_table')
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    {{ $dependency->regulations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
