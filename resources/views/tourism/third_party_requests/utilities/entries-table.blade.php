<div>
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" wire:model.live="search"
                placeholder="Buscar por nombre del solicitante...">
        </div>

        <div class="col-md-3">
            <label for="status_filter" class="form-label">Estado</label>
            <select name="status_filter" class="form-control" wire:model.live="status_filter">
                <option value="">Todos</option>
                <option value="Enviada">Enviada</option>
                <option value="En Revisión">En Revisión</option>
                <option value="Aprobada">Aprobada</option>
                <option value="Rechazada">Rechazada</option>
                <option value="Cancelada">Cancelada</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="date_filter" class="form-label">Fecha Evento</label>
            <input type="date" class="form-control" id="date_filter" name="date_filter"
                wire:model.live="date_filter">
        </div>

        <div class="col-md-2 text-end d-flex align-items-end">
            @if ($status_filter != '' || $search != '' || $date_filter != '')
                <button wire:click="resetFilters" class="btn btn-secondary w-100">Reiniciar Filtros</button>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Solicitante</th>
                    <th>Folio</th>
                    <th>Evento</th>
                    <th>Fecha Evento</th>
                    <th>Fecha Envío</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td>{{ $request->full_name }}</td>
                        <td><span class="fw-bold">{{ $request->folio }}</span></td>
                        <td>{{ $request->event_name }}</td>
                        <td>{{ $request->start_date->format('d/m/Y') }}</td>
                        <td>{{ $request->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $request->status_color }}">
                                {{ $request->status }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('tourism.third_party_requests.admin.show', $request->id) }}"
                                    class="btn btn-sm btn-outline-primary">Ver</a>
                                <form method="POST"
                                    action="{{ route('tourism.third_party_requests.admin.destroy', $request->id) }}"
                                    style="display: inline-block;">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar esta solicitud?')">
                                        Borrar
                                    </button>
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No se encontraron solicitudes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        {{ $requests->links() }}
    </div>
</div>
