<div>
    @if (session()->has('observation_saved'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('observation_saved') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Botón nueva observación --}}
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newObservationModal">
            <i class='bx bx-plus'></i> Nueva Observación
        </button>
    </div>

    {{-- Lista de observaciones --}}
    @if ($observations->count() > 0)
        @foreach ($observations as $obs)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong>{{ $obs->user->name ?? 'Usuario' }}</strong>
                            <small class="text-muted ms-2">{{ $obs->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    <p class="mb-0">{{ $obs->observation }}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <i class='bx bx-message-square-detail display-4 text-muted'></i>
            <h5 class="mt-3">No hay observaciones</h5>
            <p class="text-muted">Las observaciones se mostrarán aquí cuando se agreguen.</p>
        </div>
    @endif

    {{-- Modal nueva observación --}}
    <div class="modal fade" id="newObservationModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Observación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="observation" class="form-label">Observación <span class="text-danger">*</span></label>
                        <textarea wire:model="observation" class="form-control" id="observation" rows="4"
                            placeholder="Escribe tu observación aquí..."></textarea>
                        @error('observation')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button wire:click="saveObservation" class="btn btn-primary" data-bs-dismiss="modal">
                        <i class='bx bx-save'></i> Guardar Observación
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
