@extends('layouts.master')
@section('title') Análisis de Impacto Regulatorio @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Desarrollo Institucional @endslot
        @slot('title') Análisis de Impacto Regulatorio @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-balance-scale fa-2x text-warning"></i>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">Análisis de Impacto Regulatorio</h3>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    Gestión de solicitudes AIR y Exenciones
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 text-end d-flex justify-content-end gap-2 flex-wrap">
                        <a href="{{ route('institucional_development.regulatory_impact.create', ['type' => 'air']) }}"
                           class="btn btn-warning text-dark fw-semibold">
                            <i class="fas fa-plus me-1"></i> Nueva AIR
                        </a>
                        <a href="{{ route('institucional_development.regulatory_impact.create', ['type' => 'exencion']) }}"
                           class="btn btn-outline-warning fw-semibold">
                            <i class="fas fa-plus me-1"></i> Nueva Exención
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-3" id="airTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="air-tab" data-bs-toggle="tab"
                        data-bs-target="#air-panel" type="button" role="tab">
                    <i class="fas fa-file-alt me-1"></i> AIR
                    <span class="badge bg-warning text-dark ms-1">{{ $airRecords->total() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="ex-tab" data-bs-toggle="tab"
                        data-bs-target="#ex-panel" type="button" role="tab">
                    <i class="fas fa-file-excel me-1"></i> Exenciones
                    <span class="badge bg-secondary ms-1">{{ $exencionRecords->total() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="airTabsContent">

            {{-- TAB AIR --}}
            <div class="tab-pane fade show active" id="air-panel" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        @if($airRecords->count() === 0)
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-4x text-muted opacity-50 mb-3"></i>
                                <h5 class="fw-bold">No hay solicitudes AIR registradas</h5>
                                <a href="{{ route('institucional_development.regulatory_impact.create', ['type' => 'air']) }}"
                                   class="btn btn-warning mt-2 text-dark">
                                    <i class="fas fa-plus me-1"></i> Crear primera AIR
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Nombre de la Propuesta</th>
                                            <th>Dependencia</th>
                                            <th>Fecha Vigencia</th>
                                            <th class="text-center">Dictamen</th>
                                            <th class="text-center">Front</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($airRecords as $record)
                                        <tr>
                                            <td><span class="badge bg-warning text-dark fw-bold">{{ $record->folio }}</span></td>
                                            <td class="fw-semibold">{{ Str::limit($record->nombre_propuesta, 55) }}</td>
                                            <td class="text-muted small">{{ $record->dependency->name ?? '—' }}</td>
                                            <td class="small">{{ $record->fecha_vigencia ? $record->fecha_vigencia->format('d/m/Y') : '—' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $record->dictamen_badge_class }}">
                                                    {{ ucfirst($record->dictamen_status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($record->show_in_front)
                                                    <i class="fas fa-check-circle text-success" title="Visible"></i>
                                                @else
                                                    <i class="fas fa-times-circle text-muted" title="Oculto"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('institucional_development.regulatory_impact.show', $record) }}"
                                                       class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @unless(in_array($record->dictamen_status, ['aprobado', 'rechazado']))
                                                    <a href="{{ route('institucional_development.regulatory_impact.edit', $record) }}"
                                                       class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endunless
                                                    <form action="{{ route('institucional_development.regulatory_impact.destroy', $record) }}"
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Eliminar este registro?')">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($airRecords->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <div class="text-muted small">
                                        Mostrando {{ $airRecords->firstItem() }} – {{ $airRecords->lastItem() }} de {{ $airRecords->total() }} registros
                                    </div>
                                    <div>{{ $airRecords->appends(['page_ex' => request('page_ex')])->links('pagination::bootstrap-5') }}</div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- TAB EXENCIONES --}}
            <div class="tab-pane fade" id="ex-panel" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        @if($exencionRecords->count() === 0)
                            <div class="text-center py-5">
                                <i class="fas fa-file-excel fa-4x text-muted opacity-50 mb-3"></i>
                                <h5 class="fw-bold">No hay solicitudes de exención registradas</h5>
                                <a href="{{ route('institucional_development.regulatory_impact.create', ['type' => 'exencion']) }}"
                                   class="btn btn-outline-warning mt-2">
                                    <i class="fas fa-plus me-1"></i> Crear primera Exención
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Título de la Regulación</th>
                                            <th>Dependencia</th>
                                            <th>Fecha Envío</th>
                                            <th class="text-center">Dictamen</th>
                                            <th class="text-center">Front</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exencionRecords as $record)
                                        <tr>
                                            <td><span class="badge bg-secondary fw-bold">{{ $record->folio }}</span></td>
                                            <td class="fw-semibold">{{ Str::limit($record->titulo_regulacion, 55) }}</td>
                                            <td class="text-muted small">{{ $record->dependency->name ?? '—' }}</td>
                                            <td class="small">{{ $record->fecha_envio ? $record->fecha_envio->format('d/m/Y') : '—' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $record->dictamen_badge_class }}">
                                                    {{ ucfirst($record->dictamen_status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($record->show_in_front)
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @else
                                                    <i class="fas fa-times-circle text-muted"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('institucional_development.regulatory_impact.show', $record) }}"
                                                       class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @unless(in_array($record->dictamen_status, ['aprobado', 'rechazado']))
                                                    <a href="{{ route('institucional_development.regulatory_impact.edit', $record) }}"
                                                       class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endunless
                                                    <form action="{{ route('institucional_development.regulatory_impact.destroy', $record) }}"
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Eliminar este registro?')">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($exencionRecords->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <div class="text-muted small">
                                        Mostrando {{ $exencionRecords->firstItem() }} – {{ $exencionRecords->lastItem() }} de {{ $exencionRecords->total() }} registros
                                    </div>
                                    <div>{{ $exencionRecords->appends(['page_air' => request('page_air')])->links('pagination::bootstrap-5') }}</div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

        </div>{{-- /tab-content --}}
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Activar tooltip
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));

        // Mantener tab activo si viene de paginación de Exenciones
        @if(request('page_ex'))
            var exTab = document.getElementById('ex-tab');
            if (exTab) { bootstrap.Tab.getOrCreateInstance(exTab).show(); }
        @endif
    });
</script>
@endpush
@endsection
