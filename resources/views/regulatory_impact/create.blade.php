@extends('layouts.master')
@section('title') {{ $type === 'air' ? 'Nueva AIR' : 'Nueva Exención' }} @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Desarrollo Institucional @endslot
        @slot('li_3') <a href="{{ route('institucional_development.regulatory_impact.index') }}">Impacto Regulatorio</a> @endslot
        @slot('title') {{ $type === 'air' ? 'Nueva AIR' : 'Nueva Solicitud de Exención' }} @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header {{ $type === 'air' ? 'bg-warning' : 'bg-secondary' }} text-{{ $type === 'air' ? 'dark' : 'white' }} d-flex align-items-center">
                        <i class="fas fa-{{ $type === 'air' ? 'file-alt' : 'file-excel' }} fa-lg me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">
                                {{ $type === 'air' ? 'Formulario de Análisis de Impacto Regulatorio (AIR)' : 'Solicitud de Exención de Análisis de Impacto Regulatorio' }}
                            </h5>
                            <small class="opacity-75">Folio: <strong>{{ $folio }}</strong></small>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('institucional_development.regulatory_impact.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf

                            @if($type === 'air')
                                @include('regulatory_impact._form_air')
                            @else
                                @include('regulatory_impact._form_exencion')
                            @endif

                            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn {{ $type === 'air' ? 'btn-warning text-dark' : 'btn-secondary' }} fw-semibold px-4">
                                    <i class="fas fa-paper-plane me-2"></i> Guardar y Enviar
                                </button>
                                <a href="{{ route('institucional_development.regulatory_impact.index') }}"
                                   class="btn btn-outline-secondary">
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
