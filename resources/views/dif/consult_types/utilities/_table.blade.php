@if ($consultTypes->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultTypes as $consultType)
                    <tr>
                        <td>{{ $consultType->id }}</td>
                        <td>{{ $consultType->name }}</td>
                        <td>{{ Str::limit($consultType->description, 50, '...') ?: 'Sin descripción' }}</td>
                        <td>{{ $consultType->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('dif.consult_types.show', $consultType->id) }}" 
                                   class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dif.consult_types.edit', $consultType->id) }}" 
                                   class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $consultType->id }}" 
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de Confirmación para cada registro -->
                            <div class="modal fade" id="deleteModal{{ $consultType->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle text-warning"></i> Confirmar Eliminación
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar este tipo de consulta?</p>
                                            <div class="alert alert-info">
                                                <strong>Tipo de Consulta:</strong> {{ $consultType->name }}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form method="POST" action="{{ route('dif.consult_types.destroy', $consultType->id) }}" style="display:inline">
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
        <i class="fas fa-info-circle"></i> No hay tipos de consulta registrados.
        <a href="{{ route('dif.consult_types.create') }}" class="btn btn-primary btn-sm ms-2">
            <i class="fas fa-plus"></i> Agregar el primer tipo de consulta
        </a>
    </div>
@endif
