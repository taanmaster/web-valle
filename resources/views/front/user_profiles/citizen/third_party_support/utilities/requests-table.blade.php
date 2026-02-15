<div>
    {{-- Filtros --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" wire:model.live="search" placeholder="Buscar por nombre del evento...">
        </div>
        <div class="col-md-3">
            <label for="date_filter" class="form-label">Fecha de Envío</label>
            <input type="date" class="form-control" wire:model.live="date_filter">
        </div>
        <div class="col-md-3">
            <label for="event_type_filter" class="form-label">Tipo de Evento</label>
            <select class="form-select" wire:model.live="event_type_filter">
                <option value="">Todos</option>
                <option value="Festival">Festival</option>
                <option value="Exposición">Exposición</option>
                <option value="Cultural">Cultural</option>
                <option value="Deportivo">Deportivo</option>
                <option value="Gastronómico">Gastronómico</option>
                <option value="Musical">Musical</option>
                <option value="Religioso">Religioso</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            @if ($search != '' || $date_filter != '' || $event_type_filter != '')
                <button wire:click="resetFilters" class="btn btn-outline-secondary w-100">Limpiar</button>
            @endif
        </div>
    </div>

    {{-- Lista de solicitudes --}}
    @if ($requests->count() > 0)
        @foreach ($requests as $request)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h6 class="mb-1">{{ $request->event_name }}</h6>
                            <p class="text-muted mb-0 small">
                                <strong>Folio:</strong> {{ $request->folio }}
                                <span class="mx-2">|</span>
                                <strong>Enviada:</strong> {{ $request->created_at->format('d/m/Y') }}
                                <span class="mx-2">|</span>
                                <strong>Tipo:</strong> {{ $request->event_type }}
                                <span class="mx-2">|</span>
                                <strong>Apoyo:</strong> {{ $request->support_type }}
                            </p>
                        </div>
                        <div class="col-md-3 text-center">
                            <span class="badge bg-{{ $request->status_color }}">{{ $request->status }}</span>
                        </div>
                        <div class="col-md-2 text-end">
                            <a href="{{ route('citizen.third_party.show', $request->id) }}" class="btn btn-outline-primary btn-sm">
                                <ion-icon name="eye-outline"></ion-icon> Ver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-3">
            {{ $requests->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5">
            <ion-icon name="earth-outline" class="display-4 text-muted mb-3 d-block mx-auto"></ion-icon>
            <h5>No tienes solicitudes de apoyo</h5>
            <p class="text-muted">Crea tu primera solicitud para solicitar apoyo turístico para tu evento.</p>
            <a href="{{ route('citizen.third_party.create') }}" class="btn btn-primary">
                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
            </a>
        </div>
    @endif
</div>
