@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Detalle del Tipo de Apoyo @endslot
    @endcomponent

    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-lg-8 mx-auto">

                {{-- HEADER DE MÓDULO --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-tag fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1 fw-bold">{{ $financial_support_type->name }}</h3>
                                    <p class="text-muted mb-0">
                                        <span class="badge bg-secondary">#{{ $financial_support_type->id }}</span>
                                        @if($financial_support_type->monthly_cap)
                                            <span class="badge bg-info ms-1">${{ number_format($financial_support_type->monthly_cap, 2) }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('financial_support_types.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Volver
                                </a>
                                <form method="POST" action="{{ route('financial_support_types.destroy', $financial_support_type->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Eliminar" aria-label="Eliminar"
                                        onclick="return confirm('¿Estás seguro de eliminar este tipo de apoyo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DOCUMENTACIÓN REQUERIDA --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Documentación Requerida</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_birth_certificate ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Acta de nacimiento
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_ine ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                INE
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_address_proof ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Comprobante de domicilio
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_rfc ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                RFC
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_death_certificate ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Acta de defunción
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_funeral_payment ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Hoja de paga funeraria
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_cemetery_docs ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Documentos del panteón
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_study_certificate ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Constancia de estudios
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_medical_prescriptions ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Recetas médicas
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_medical_certificate ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Constancia médica
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                {!! $financial_support_type->doc_hospital_visit_card ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>' !!}
                                Tarjetón de visita al hospital
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer text-muted">
                        <small><i class="fas fa-clock me-1"></i> Creado: {{ $financial_support_type->created_at->format('d/m/Y') }}</small>
                        <small class="ms-3"><i class="fas fa-edit me-1"></i> Actualizado: {{ $financial_support_type->updated_at->format('d/m/Y') }}</small>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
