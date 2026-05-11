@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Nuevo Tipo de Apoyo @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-plus me-2"></i> Nuevo Tipo de Apoyo</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('financial_support_types.store') }}" enctype="multipart/form-data">
                            @csrf
                            {{-- Campos del formulario --}}
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('financial_support_types.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
