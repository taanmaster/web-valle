@extends('front.layouts.app')

@section('content')
<div class="container">

    {{-- Banner/Header --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-3.jpg') }}" alt="AIR y Exención">
                <div class="overlay" style="opacity: .5"></div>
                <div class="card-content text-center w-100">
                    <p class="small-uppercase mb-0">Consulta Pública</p>
                    <h1 class="display-1 mb-0">AIR y Exención</h1>
                </div>
            </div>
        </div>
    </div>

    {{-- Descripción --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card card-normal wow fadeInUp">
                <div class="card-content">
                    <p class="mb-0">Tu participación es clave para crear reglas claras. En este espacio puedes revisar y opinar sobre los <strong>Análisis de Impacto Regulatorio (AIR)</strong> y las <strong>Solicitudes de Exención</strong> de las nuevas propuestas de trámites y servicios. Nuestro objetivo es asegurar que las regulaciones generen mayores beneficios que costos para la ciudadanía.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Dos tarjetas de clasificación --}}
    <div class="row">

        {{-- Tarjeta AIR --}}
        <div class="col-md-6 mb-4">
            <div class="card card-normal wow fadeInUp h-100">
                <div class="card-content">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </div>
                        <div>
                            <h4 class="mb-0">Análisis de Impacto Regulatorio</h4>
                            <p class="mb-0 text-muted small">Consulta los análisis regulatorios publicados por el municipio.</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle mb-0">
                            <thead class="table-warning">
                                <tr>
                                    <th>Folio</th>
                                    <th>Propuesta</th>
                                    <th>Dependencia</th>
                                    <th>Dictamen</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($airRecords as $record)
                                    <tr>
                                        <td><span class="badge bg-warning text-dark fw-bold">{{ $record->folio }}</span></td>
                                        <td class="small">{{ Str::limit($record->nombre_propuesta, 45) }}</td>
                                        <td class="small text-muted">{{ $record->dependency->name ?? '—' }}</td>
                                        <td><span class="badge bg-{{ $record->dictamen_badge_class }}">{{ ucfirst($record->dictamen_status) }}</span></td>
                                        <td>
                                            <a href="{{ route('front.regulatory_impact.air_show', $record->id) }}"
                                               class="btn btn-sm btn-outline-warning">
                                                Ver <ion-icon name="chevron-forward-outline"></ion-icon>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            No hay registros publicados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($airRecords->hasPages())
                        <div class="mt-3">
                            {{ $airRecords->appends(['page_ex' => request('page_ex')])->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('front.regulatory_impact.air_index') }}" class="btn btn-warning btn-sm">
                            Ver todos <ion-icon name="arrow-forward-outline"></ion-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta Exención --}}
        <div class="col-md-6 mb-4">
            <div class="card card-normal wow fadeInUp h-100">
                <div class="card-content">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="card-icon card-icon-static bg-secondary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="document-outline"></ion-icon>
                        </div>
                        <div>
                            <h4 class="mb-0">Solicitudes de Exención</h4>
                            <p class="mb-0 text-muted small">Consulta las solicitudes de exención de análisis regulatorio.</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Folio</th>
                                    <th>Título</th>
                                    <th>Dependencia</th>
                                    <th>Dictamen</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exencionRecords as $record)
                                    <tr>
                                        <td><span class="badge bg-secondary fw-bold">{{ $record->folio }}</span></td>
                                        <td class="small">{{ Str::limit($record->titulo_regulacion, 45) }}</td>
                                        <td class="small text-muted">{{ $record->dependency->name ?? '—' }}</td>
                                        <td><span class="badge bg-{{ $record->dictamen_badge_class }}">{{ ucfirst($record->dictamen_status) }}</span></td>
                                        <td>
                                            <a href="{{ route('front.regulatory_impact.exencion_show', $record->id) }}"
                                               class="btn btn-sm btn-outline-secondary">
                                                Ver <ion-icon name="chevron-forward-outline"></ion-icon>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            No hay registros publicados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($exencionRecords->hasPages())
                        <div class="mt-3">
                            {{ $exencionRecords->appends(['page_air' => request('page_air')])->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('front.regulatory_impact.exencion_index') }}" class="btn btn-secondary btn-sm">
                            Ver todos <ion-icon name="arrow-forward-outline"></ion-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

                   