@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Protección Civil @endslot
@slot('title') Catálogo de trámites @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <p class="pc-eyebrow mb-1">1 · Trámites</p>
                <h4 class="mb-1">Catálogo de trámites</h4>
                <p class="text-muted mb-0">Opiniones técnicas y permisos que ofrece Protección Civil. Los publicados aparecen como tarjeta en el front informativo.</p>
            </div>
            <a href="{{ route('proteccion_civil.procedures.create') }}" class="btn pc-btn">
                <i class="ti ti-plus"></i> Crear trámite
            </a>
        </div>

        @if ($procedures->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                    <h4>¡Aún no hay trámites registrados!</h4>
                    <p class="mb-4">Crea el primer trámite de Protección Civil para empezar a recibir expedientes.</p>
                    <a href="{{ route('proteccion_civil.procedures.create') }}" class="btn pc-btn">Crear trámite</a>
                </div>
            </div>
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="pc-thead">
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Prefijo de folio</th>
                                <th class="text-end">Vigencia</th>
                                <th>Publicado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($procedures as $procedure)
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $procedure->name }}</span>
                                        <small class="d-block text-muted">{{ $procedure->requirements_count }} requisitos activos</small>
                                    </td>
                                    <td>
                                        <span @class(['badge rounded-pill', 'bg-danger-subtle text-danger' => $procedure->type === 'technical_opinion', 'bg-primary-subtle text-primary' => $procedure->type === 'permit'])>
                                            {{ $procedure->type_label }}
                                        </span>
                                    </td>
                                    <td class="font-monospace fw-semibold">{{ $procedure->folio_prefix }}</td>
                                    <td class="text-end">{{ $procedure->validity_days }} días</td>
                                    <td>
                                        @if ($procedure->is_published)
                                            <span class="badge rounded-pill bg-success-subtle text-success">Sí · publicado</span>
                                        @else
                                            <span class="badge rounded-pill border text-dark">No</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('proteccion_civil.procedures.edit', $procedure) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@include('proteccion_civil._styles')
@endsection
