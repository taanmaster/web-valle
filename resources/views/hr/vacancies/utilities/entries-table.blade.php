<div>
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" wire:model.live="search"
                placeholder="Buscar por nombre del puesto...">
        </div>

        <div class="col-md-4">
            <label for="status_filter" class="form-label">Estado</label>
            <select name="status_filter" class="form-control" wire:model.live="status_filter">
                <option value="">Todos</option>
                <option value="Programada">Programada</option>
                <option value="Abierta">Abierta</option>
                <option value="Cerrada">Cerrada</option>
            </select>
        </div>

        <div class="col-md text-end">
            @if ($status_filter != '' || $search != '')
                <button wire:click="resetFilters" class="btn btn-secondary">Reiniciar Filtros</button>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Puesto</th>
                    <th>Dependencia</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Publicacion</th>
                    <th>Cierre</th>
                    <th>Aplicantes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vacancies as $vacancy)
                    @php $computedStatus = $vacancy->computed_status; @endphp
                    <tr>
                        <td>{{ $vacancy->position_name }}</td>
                        <td>{{ $vacancy->dependency ?? 'N/A' }}</td>
                        <td>{{ $vacancy->employment_type ?? 'N/A' }}</td>
                        <td>
                            <span
                                class="badge {{ $computedStatus == 'Abierta' ? 'bg-success' : ($computedStatus == 'Programada' ? 'bg-warning' : 'bg-danger') }}">
                                {{ $computedStatus }}
                            </span>
                        </td>
                        <td>{{ $vacancy->published_at ? $vacancy->published_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>{{ $vacancy->closing_date ? $vacancy->closing_date->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $vacancy->applications->count() }}</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('hr.vacancies.admin.show', $vacancy->id) }}"
                                    class="btn btn-sm btn-outline-primary">Ver</a>
                                <a href="{{ route('hr.vacancies.admin.edit', $vacancy->id) }}"
                                    class="btn btn-sm btn-outline-secondary">Editar</a>
                                <form method="POST" action="{{ route('hr.vacancies.admin.destroy', $vacancy->id) }}"
                                    style="display: inline-block;">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Estas seguro de eliminar esta vacante?')">
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
                        <td colspan="8" class="text-center">No se encontraron vacantes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        {{ $vacancies->links() }}
    </div>
</div>
