@if ($medicalProfiles->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ciudadano</th>
                    <th>Número Médico</th>
                    <th>Tipo de Sangre</th>
                    <th>Género</th>
                    <th>Edad</th>
                    <th>Programas</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicalProfiles as $medicalProfile)
                    <tr>
                        <td>{{ $medicalProfile->id }}</td>
                        <td>
                            <strong>{{ $medicalProfile->citizen->name ?? 'N/A' }} {{ $medicalProfile->citizen->last_name ?? '' }}</strong>
                            <br>
                            <small class="text-muted">ID: {{ $medicalProfile->citizen->id ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $medicalProfile->medical_num }}</td>
                        <td>
                            @if($medicalProfile->blood_type)
                                <span class="badge bg-info">{{ $medicalProfile->blood_type }}</span>
                            @else
                                <span class="text-muted">No especificado</span>
                            @endif
                        </td>
                        <td>
                            @if($medicalProfile->gender == 'Masculino')
                                <span class="badge bg-primary">{{ $medicalProfile->gender }}</span>
                            @elseif($medicalProfile->gender == 'Femenino')
                                <span class="badge bg-success">{{ $medicalProfile->gender }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $medicalProfile->gender }}</span>
                            @endif
                        </td>
                        <td>{{ $medicalProfile->age ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-info">
                                <i class="fas fa-folder"></i> {{ $medicalProfile->programs->count() }} programa(s)
                            </span>
                        </td>
                        <td>{{ $medicalProfile->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('dif.medical_profiles.show', $medicalProfile->id) }}" 
                                   class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dif.medical_profiles.edit', $medicalProfile->id) }}" 
                                   class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $medicalProfile->id }}" 
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de Confirmación para cada registro -->
                            <div class="modal fade" id="deleteModal{{ $medicalProfile->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle text-warning"></i> Confirmar Eliminación
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar este perfil médico?</p>
                                            <div class="alert alert-info">
                                                <strong>Ciudadano:</strong> {{ $medicalProfile->citizen->name ?? 'N/A' }} {{ $medicalProfile->citizen->last_name ?? '' }}<br>
                                                <strong>Número Médico:</strong> {{ $medicalProfile->medical_num }}<br>
                                                <strong>Programas asociados:</strong> {{ $medicalProfile->programs->count() }}
                                            </div>
                                            @if($medicalProfile->programs->count() > 0)
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-exclamation-triangle"></i> 
                                                    <strong>Atención:</strong> Este perfil médico tiene programas asociados. 
                                                    Al eliminarlo, se removerán todas las asociaciones con los programas.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form method="POST" action="{{ route('dif.medical_profiles.destroy', $medicalProfile->id) }}" style="display:inline">
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
        <i class="fas fa-info-circle"></i> No hay perfiles médicos registrados.
        <a href="{{ route('dif.medical_profiles.create') }}" class="btn btn-primary btn-sm ms-2">
            <i class="fas fa-plus"></i> Agregar el primer perfil médico
        </a>
    </div>
@endif
