@extends('layouts.master')

@section('title')Consultas Médicas @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('title') Consultas Médicas @endslot
    @endcomponent

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Listado de Consultas Médicas</h4>
                        <div>
                            <a href="{{ route('dif.consults.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nueva Consulta
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Búsqueda -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('dif.consults.index') }}" class="d-flex">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por número, paciente, doctor o estado..." aria-label="Buscar consultas">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('dif.consults.index') }}" class="btn btn-outline-danger">
                                            <i class="fas fa-times"></i> Limpiar
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <span class="badge bg-primary">
                                    Total: {{ $consults->total() }} consulta(s)
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Fecha</th>
                                    <th>Paciente</th>
                                    <th>Doctor</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consults as $consult)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $consult->consult_num }}</span>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar text-muted"></i>
                                            {{ $consult->consult_date?->format('d/m/Y') ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @if($consult->citizen)
                                                <strong>{{ $consult->citizen->name }}</strong>
                                                <br><small class="text-muted">{{ $consult->citizen->curp }}</small>
                                            @else
                                                <span class="text-muted">No asignado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($consult->doctor)
                                                <strong>{{ $consult->doctor->name }}</strong>
                                                @if($consult->doctor->specialty)
                                                    <br><small class="text-muted">{{ $consult->doctor->specialty->name }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">No asignado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($consult->consultType)
                                                <span class="badge bg-info">{{ $consult->consultType->name }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $consult->status_badge }}">{{ $consult->status_name }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dif.consults.show', $consult) }}" class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dif.consults.edit', $consult) }}" class="btn btn-warning btn-sm" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $consult->id }}" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal de Eliminación -->
                                    <div class="modal fade" id="deleteModal{{ $consult->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-warning">
                                                        <strong>¿Está seguro que desea eliminar esta consulta?</strong>
                                                    </div>
                                                    <p><strong>Consulta:</strong> {{ $consult->consult_num }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="POST" action="{{ route('dif.consults.destroy', $consult) }}" style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No se encontraron consultas médicas</h5>
                                                <p class="text-muted">
                                                    @if(request('search'))
                                                        No hay consultas que coincidan con "{{ request('search') }}"
                                                    @else
                                                        Aún no hay consultas médicas registradas.
                                                    @endif
                                                </p>
                                                <a href="{{ route('dif.consults.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Crear Primera Consulta
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($consults->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $consults->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
