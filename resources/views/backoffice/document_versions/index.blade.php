@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('li_3') <a href="{{ route('backoffice.documents.show', $document->id) }}">{{ $document->folio }}</a> @endslot
@slot('title') Control de Versiones @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-history fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-history text-secondary me-2"></i> Control de Versiones
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-file-alt me-1"></i>
                                Historial del oficio: <strong>{{ $document->folio }}</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-end">
                    <a href="{{ route('backoffice.documents.show', $document->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Oficio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if($versions->count() == 0)
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-history fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No hay versiones registradas</h5>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Tipo de Actividad</th>
                                        <th class="fw-semibold">Detalle</th>
                                        <th class="fw-semibold">Elemento Modificado</th>
                                        <th class="fw-semibold">Modificado por</th>
                                        <th class="fw-semibold">Fecha y Hora</th>
                                        <th class="fw-semibold text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($versions as $version)
                                        <tr>
                                            <td>{!! $version->activity_type_badge !!}</td>
                                            <td>
                                                <span title="{{ $version->activity_detail }}">
                                                    {{ Str::limit($version->activity_detail, 50) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($version->modified_field)
                                                    <span class="badge bg-light text-dark">{{ $version->modified_field }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $version->modifiedByUser->name ?? 'Sistema' }}</td>
                                            <td>{{ $version->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('backoffice.documents.versions.show', [$document->id, $version->id]) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i> Ver Versión
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $versions->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
