@extends('layouts.master')
@section('title')Estudios Socioeconómicos @endsection

@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Estudios Socioeconómicos @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Estudios Socioeconómicos</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dif.socio_economic_tests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nuevo Estudio
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Filtros de búsqueda -->
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Buscar por nombre, CURP o estado..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Todos los estados</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completado</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprobado</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="{{ route('dif.socio_economic_tests.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Tabla de estudios -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Ciudadano</th>
                                <th>CURP</th>
                                <th>Coordinación</th>
                                <th>Estado</th>
                                <th>Paso Actual</th>
                                <th>Puntaje Total</th>
                                <th>Vulnerabilidad</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tests as $test)
                            <tr>
                                <td>{{ $test->id }}</td>
                                <td>
                                    <strong>{{ $test->citizen_name }} {{ $test->citizen_last_name }}</strong><br>
                                    <small class="text-muted">{{ $test->citizen_phone }}</small>
                                </td>
                                <td>
                                    <span class="font-monospace">{{ $test->citizen_curp }}</span>
                                </td>
                                <td>
                                    {{ $test->coordination->name ?? 'N/A' }}
                                </td>
                                <td>
                                    @switch($test->status)
                                        @case('draft')
                                            <span class="badge bg-warning">Borrador</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-info">Completado</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success">Aprobado</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Rechazado</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">{{ $test->current_step }}/5</span>
                                        <div class="progress flex-fill" style="height: 6px;">
                                            <div class="progress-bar" style="width: {{ $test->getProgressPercentage() }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($test->total_score)
                                        <strong>{{ $test->total_score }}</strong> pts
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($test->total_score)
                                        @php
                                            $vulnerabilityLevel = '';
                                            $vulnerabilityClass = '';
                                            $score = $test->total_score;
                                            
                                            if ($score >= 63) {
                                                $vulnerabilityLevel = 'Alta';
                                                $vulnerabilityClass = 'bg-danger';
                                            } elseif ($score >= 48 && $score <= 62) {
                                                $vulnerabilityLevel = 'Media';
                                                $vulnerabilityClass = 'bg-warning';
                                            } elseif ($score >= 31 && $score <= 47) {
                                                $vulnerabilityLevel = 'Baja';
                                                $vulnerabilityClass = 'bg-info';
                                            } elseif ($score >= 25 && $score <= 30) {
                                                $vulnerabilityLevel = 'No sujeto';
                                                $vulnerabilityClass = 'bg-success';
                                            } else {
                                                $vulnerabilityLevel = 'Sin clasificar';
                                                $vulnerabilityClass = 'bg-secondary';
                                            }
                                        @endphp
                                        <span class="badge {{ $vulnerabilityClass }}">{{ $vulnerabilityLevel }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $test->created_at->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ $test->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('dif.socio_economic_tests.show', $test->id) }}" 
                                           class="btn btn-outline-primary" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($test->status === 'draft')
                                            @switch($test->current_step)
                                                @case(1)
                                                    <a href="{{ route('dif.socio_economic_tests.step2', $test->id) }}" 
                                                       class="btn btn-outline-success" title="Continuar">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                    @break
                                                @case(2)
                                                    <a href="{{ route('dif.socio_economic_tests.step3', $test->id) }}" 
                                                       class="btn btn-outline-success" title="Continuar">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                    @break
                                                @case(3)
                                                    <a href="{{ route('dif.socio_economic_tests.step4', $test->id) }}" 
                                                       class="btn btn-outline-success" title="Continuar">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                    @break
                                                @case(4)
                                                    <a href="{{ route('dif.socio_economic_tests.step5', $test->id) }}" 
                                                       class="btn btn-outline-success" title="Finalizar">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    @break
                                            @endswitch
                                            
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="confirmDelete({{ $test->id }})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                        <p>No hay estudios socioeconómicos registrados.</p>
                                        <a href="{{ route('dif.socio_economic_tests.create') }}" class="btn btn-primary">
                                            Crear primer estudio
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($tests->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $tests->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar este estudio socioeconómico? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(testId) {
    const form = document.getElementById('deleteForm');
    form.action = `/dif/socio-economic-tests/${testId}`;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush