@extends('layouts.master')

@section('title')Tipos de Consulta @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('title') Tipos de Consulta @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-stethoscope"></i> Tipos de Consulta
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.consult_types.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Agregar Tipo de Consulta
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('dif.consult_types.utilities._search_options')
                    @include('dif.consult_types.utilities._table')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                {{ $consultTypes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
