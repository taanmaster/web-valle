@extends('layouts.master')
@section('title') Editar {{ $regulatoryImpact->isAir() ? 'AIR' : 'Exención' }} — {{ $regulatoryImpact->folio }} @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Desarrollo Institucional @endslot
        @slot('li_3') <a href="{{ route('institucional_development.regulatory_impact.index') }}">Impacto Regulatorio</a> @endslot
        @slot('title') Editar {{ $regulatoryImpact->folio }} @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header {{ $regulatoryImpact->isAir() ? 'bg-warning' : 'bg-secondary' }} text-{{ $regulatoryImpact->isAir() ? 'dark' : 'white' }} d-flex align-items-center">
                        <i class="fas fa-edit fa-lg me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">
                                Editar — {{ $regulatoryImpact->type_label }}
                            </h5>
                            <small class="opacity-75">Folio: <strong>{{ $regulatoryImpact->folio }}</strong></small>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('institucional_development.regulatory_impact.update', $regulatoryImpact) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if($regulatoryImpact->isAir())
                                @include('regulatory_impact._form_air', ['folio' => $regulatoryImpact->folio])
                            @else
                                @include('regulatory_impact._form_exencion', ['folio' => $regulatoryImpact->folio])
                            @endif

                            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn {{ $regulatoryImpact->isAir() ? 'btn-warning text-dark' : 'btn-secondary' }} fw-semibold px-4">
                                    <i class="fas fa-save me-2"></i> Actualizar
                                </button>
                                <a href="{{ route('institucional_development.regulatory_impact.show', $regulatoryImpact) }}"
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
