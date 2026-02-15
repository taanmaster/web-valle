<div class="p-4 bg-light">
    <div class="row">
        <div class="col-md-6">
            <h5>{{ $application->first_name }} {{ $application->last_name }}</h5>
            <p class="mb-1"><strong>Email:</strong> {{ $application->email }}</p>
            <p class="mb-1"><strong>Telefono:</strong> {{ $application->phone ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Fecha de aplicacion:</strong> {{ $application->created_at->format('d/m/Y H:i') }}</p>
            @if ($application->cv_path)
                <a href="{{ $application->cv_url }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                    <i class='bx bx-download'></i> Descargar CV
                </a>
            @endif
        </div>
        <div class="col-md-6">
            <label for="observations" class="form-label"><strong>Observaciones</strong></label>
            <textarea class="form-control" wire:model="observations" rows="4"
                placeholder="Agregar observaciones sobre este aplicante..."></textarea>
            <button wire:click="saveObservations" class="btn btn-sm btn-success mt-2">
                Guardar Observaciones
            </button>
            @if (session()->has('observation_saved'))
                <span class="text-success ms-2">{{ session('observation_saved') }}</span>
            @endif
        </div>
    </div>
</div>
