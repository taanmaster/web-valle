@extends('layouts.master')
@section('title') Editar Servicio @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Tesorería @endslot
        @slot('li_3') <a href="{{ route('admin.billable_services.index') }}">Servicios Cobrables</a> @endslot
        @slot('title') Editar Servicio @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Servicio Cobrable</h5>
                        <span class="badge bg-white text-primary">{{ $servicio->name }}</span>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.billable_services.update', $servicio) }}" method="POST">
                            @csrf @method('PUT')
                            @include('backoffice.billable_services._form')
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Actualizar
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
