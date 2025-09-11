@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('li_3') <a href="{{ route('urban_dev.requests.index') }}">Solicitudes</a> @endslot
@slot('title') Resultados de Búsqueda @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3>Resultados de Búsqueda 
                            <span class="badge bg-info">{{ $urban_dev_requests->total() }}</span>
                        </h3>
                        @if(request()->hasAny(['fecha_inicio', 'fecha_fin', 'folio', 'solicitante', 'estatus', 'tipo_tramite', 'inspector']))
                            <div class="mt-2">
                                <small class="text-muted">Filtros aplicados:</small>
                                <div class="mt-1">
                                    @if(request('fecha_inicio') || request('fecha_fin'))
                                        <span class="badge bg-secondary me-1">
                                            <i class="fas fa-calendar"></i>
                                            @if(request('fecha_inicio') && request('fecha_fin'))
                                                {{ request('fecha_inicio') }} - {{ request('fecha_fin') }}
                                            @elseif(request('fecha_inicio'))
                                                Desde: {{ request('fecha_inicio') }}
                                            @else
                                                Hasta: {{ request('fecha_fin') }}
                                            @endif
                                        </span>
                                    @endif
                                    
                                    @if(request('folio'))
                                        <span class="badge bg-secondary me-1">
                                            <i class="fas fa-hashtag"></i> Folio: {{ request('folio') }}
                                        </span>
                                    @endif
                                    
                                    @if(request('solicitante'))
                                        <span class="badge bg-secondary me-1">
                                            <i class="fas fa-user"></i> Solicitante: {{ request('solicitante') }}
                                        </span>
                                    @endif
                                    
                                    @if(request('estatus'))
                                        @php
                                            $estatusLabels = [
                                                'new' => 'Nuevo',
                                                'entry' => 'Ingreso',
                                                'validation' => 'Validación',
                                                'requires_correction' => 'Requiere Corrección',
                                                'inspection' => 'Inspección',
                                                'resolved' => 'Resolución'
                                            ];
                                        @endphp
                                        <span class="badge bg-secondary me-1">
                                            <i class="fas fa-flag"></i> Estatus: {{ $estatusLabels[request('estatus')] ?? request('estatus') }}
                                        </span>
                                    @endif
                                    
                                    @if(request('tipo_tramite'))
                                        @php
                                            $tramiteLabels = [
                                                'uso-de-suelo' => 'Licencia de Uso de Suelo',
                                                'constancia-de-factibilidad' => 'Constancia de Factibilidad',
                                                'permiso-de-anuncios' => 'Permiso de Anuncios y Toldos',
                                                'certificacion-numero-oficial' => 'Certificación de Número Oficial',
                                                'permiso-de-division' => 'Permiso de División',
                                                'uso-de-via-publica' => 'Uso de Vía Pública',
                                                'licencia-de-construccion' => 'Licencia de Construcción',
                                                'permiso-construccion-panteones' => 'Permiso de Construcción en Panteones'
                                            ];
                                        @endphp
                                        <span class="badge bg-secondary me-1">
                                            <i class="fas fa-cog"></i> Trámite: {{ $tramiteLabels[request('tipo_tramite')] ?? request('tipo_tramite') }}
                                        </span>
                                    @endif
                                    
                                    @if(request('inspector'))
                                        @php
                                            $inspector = \App\Models\User::find(request('inspector'));
                                        @endphp
                                        <span class="badge bg-secondary me-1">
                                            <i class="fas fa-user-check"></i> Inspector: {{ $inspector ? $inspector->name : request('inspector') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('urban_dev.requests.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                        
                        <!-- Dropdown de Exportación -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download"></i> Exportar <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <h6 class="dropdown-header">
                                    <i class="fas fa-file-export"></i> Opciones de Exportación
                                </h6>
                                <button type="button" class="dropdown-item" onclick="exportQueryResults('excel')">
                                    <i class="fas fa-file-excel text-success me-2"></i> Exportar a Excel
                                </button>
                                <button type="button" class="dropdown-item" onclick="exportQueryResults('pdf')">
                                    <i class="fas fa-file-pdf text-danger me-2"></i> Exportar a PDF
                                </button>
                                <div class="dropdown-divider"></div>
                                <small class="dropdown-item-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i> Se exportarán {{ $urban_dev_requests->total() }} resultado(s)
                                </small>
                            </div>
                        </div>
                    </div>
                        @include('urban_dev.requests.utilities._search_options')
                    </div>
                </div>
                <hr>
            </div>	
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        @if($urban_dev_requests->count())
                            @include('urban_dev.requests.utilities._table')
                            
                            <!-- Paginación -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <small class="text-muted">
                                        Mostrando {{ $urban_dev_requests->firstItem() ?? 0 }} a {{ $urban_dev_requests->lastItem() ?? 0 }} 
                                        de {{ $urban_dev_requests->total() }} resultados
                                    </small>
                                </div>
                                <div>
                                    {{ $urban_dev_requests->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @else
                            <div class="text-center my-5">
                                <i class="fas fa-search" style="font-size: 48px; color: #6c757d;"></i>
                                <h4 class="mb-3 mt-3">¡No hay resultados con esa búsqueda!</h4>
                                <p class="text-muted">Mejora tus términos de búsqueda o utiliza diferentes filtros.</p>
                                <a href="{{ route('urban_dev.requests.index') }}" class="btn btn-primary">
                                    <i class="fas fa-list"></i> Ver Todas las Solicitudes
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<style>
.badge {
    font-size: 0.75em;
}

.table th {
    background-color: #495057;
    color: white;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

.table-striped > tbody > tr:nth-of-type(odd) > td {
    background-color: rgba(0, 0, 0, 0.02);
}

.dropdown-menu {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.15);
}
</style>

<script>
function exportQueryResults(format) {
    // Construir la URL con los parámetros actuales de la búsqueda
    let baseUrl = '';
    if (format === 'excel') {
        baseUrl = '{{ route("urban_dev.requests.export-excel") }}';
    } else if (format === 'pdf') {
        baseUrl = '{{ route("urban_dev.requests.export-pdf") }}';
    }

    // Obtener los parámetros actuales de la URL
    const params = new URLSearchParams();
    
    @if(request('fecha_inicio'))
        params.append('fecha_inicio', '{{ request('fecha_inicio') }}');
    @endif
    
    @if(request('fecha_fin'))
        params.append('fecha_fin', '{{ request('fecha_fin') }}');
    @endif
    
    @if(request('folio'))
        params.append('folio', '{{ request('folio') }}');
    @endif
    
    @if(request('solicitante'))
        params.append('solicitante', '{{ request('solicitante') }}');
    @endif
    
    @if(request('estatus'))
        params.append('estatus', '{{ request('estatus') }}');
    @endif
    
    @if(request('tipo_tramite'))
        params.append('tipo_tramite', '{{ request('tipo_tramite') }}');
    @endif
    
    @if(request('inspector'))
        params.append('inspector', '{{ request('inspector') }}');
    @endif

    const fullUrl = baseUrl + (params.toString() ? '?' + params.toString() : '');
    
    // Mostrar indicador de carga
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generando...';
    button.disabled = true;

    // Abrir la URL en una nueva ventana para descargar
    window.open(fullUrl, '_blank');

    // Restaurar el botón después de un breve delay
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    }, 2000);
}
</script>
@endsection
@endsection
