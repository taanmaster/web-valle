<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este perfil médico?</p>
                <p class="text-muted">Esta acción no se puede deshacer.</p>
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
