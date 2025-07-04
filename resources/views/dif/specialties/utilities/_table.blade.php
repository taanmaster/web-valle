@if ($specialties->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($specialties as $specialty)
                    <tr>
                        <td>{{ $specialty->id }}</td>
                        <td>{{ $specialty->name }}</td>
                        <td>{{ Str::limit($specialty->description, 50, '...') ?: 'Sin descripción' }}</td>
                        <td>
                            @if($specialty->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>{{ $specialty->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('dif.specialties.show', $specialty->id) }}" 
                                   class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dif.specialties.edit', $specialty->id) }}" 
                                   class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $specialty->id }}" 
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de Confirmación para cada registro -->
                            <div class="modal fade" id="deleteModal{{ $specialty->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle text-warning"></i> Confirmar Eliminación
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar esta especialidad?</p>
                                            <div class="alert alert-info">
                                                <strong>Especialidad:</strong> {{ $specialty->name }}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form method="POST" action="{{ route('dif.specialties.destroy', $specialty->id) }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No hay especialidades registradas.
        <a href="{{ route('dif.specialties.create') }}" class="btn btn-primary btn-sm ms-2">
            <i class="fas fa-plus"></i> Agregar la primera especialidad
        </a>
    </div>
@endif
