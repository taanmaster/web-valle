@extends('layouts.master')
@section('title') Nuevo Servicio @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Tesorería @endslot
        @slot('li_3') <a href="{{ route('admin.billable_services.index') }}">Servicios Cobrables</a> @endslot
        @slot('title') Nuevo Servicio @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Registrar Nuevo Servicio Cobrable</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.billable_services.store') }}" method="POST">
                            @csrf
                            @include('backoffice.billable_services._form')
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar
                                </button>
                                <a href="{{ route('admin.billable_services.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
