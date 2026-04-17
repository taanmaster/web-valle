@extends('front.layouts.app')

@section('content')
<div class="container">

    {{-- Breadcrumb --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('front.regulatory_impact.index') }}">Impacto Regulatorio</a></li>
                    <li class="breadcrumb-item active">Análisis de Impacto Regulatorio</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card card-normal wow fadeInUp">
                <div class="card-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </div>
                        <div>
                            <h2 class="mb-1">Análisis de Impacto Regulatorio</h2>
                            <p class="mb-0 text-muted">Consulta los análisis regulatorios publicados. Puedes participar dejando tus comentarios en la sección de Consulta Pública de cada registro.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Listado --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-normal wow fadeInUp">
                <div class="card-content">

                    @forelse($records as $record)
                        <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-warning text-dark fw-bold">{{ $record->folio }}</span>
                                </div>
                                <div>
                                    <p class="mb-1 fw-semibold">{{ $record->nombre_propuesta }}</p>
                                    <small class="text-muted">
                                        {{ $record->dependency->name ?? '' }}
                                        @if($record->fecha_vigencia)
                                            · Vigencia: {{ $record->fecha_vigencia->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-3 d-flex align-items-center gap-2">
                                <span class="badge bg-{{ $record->dictamen_badge_class }}">
                                    {{ ucfirst($record->dictamen_status) }}
                                </span>
                                <a href="{{ route('front.regulatory_impact.air_show', $record->id) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    Ver <ion-icon name="chevron-forward-outline"></ion-icon>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <ion-icon name="document-text-outline" style="font-size:3rem;"></ion-icon>
                            <p class="mt-2">No hay análisis de impacto regulatorio publicados en este momento.</p>
                        </div>
                    @endforelse

                    @if($records->hasPages())
                        <div class="mt-4">
                            {{ $records->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- Volver --}}
    <div class="row mt-3 mb-5">
        <div class="col-md-12">
            <a href="{{ route('front.regulatory_impact.index') }}" class="btn btn-outline-secondary btn-sm">
                <ion-icon name="arrow-back-outline"></ion-icon> Volver a Impacto Regulatorio
            </a>
        </div>
    </div>

</div>
@endsection
