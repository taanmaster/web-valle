<div>
    <div class="row justify-content-end mb-3">

        {{-- Filtros de búsqueda --}}

        {{--
    <div class="col-md-3">
        <label for="">Rango de fechas de creación</label>
        <div class="input-group mb-3">
            <input type="date" class="form-control" wire:model.live="start_date">
            <span class="input-group-text">a</span>
            <input type="date" class="form-control" wire:model.live="end_date">
        </div>
    </div>

     --}}
        @if ($mode != 1)
            <div class="col-md-3 text-end">
                <a href="{{ route('summons.create') }}" class="btn btn-primary btn-sm">Agregar Citatorio</a>
            </div>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>No. Citatorio</th>
                    <th>Fecha Expedición</th>
                    <th>Nombre</th>
                    <th>Calle</th>
                    <th>Número</th>
                    <th>Colonia</th>
                    <th>Inspector</th>
                    @if ($mode == 1)
                        <th>Acción</th>
                    @endif
                    @if ($mode == 0)
                        <th>Acción</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($summons as $summon)
                    <tr>
                        <td>{{ $summon->folio }}</td>
                        <td>
                            {{ $summon->number ?? 'N/A' }}<br>
                        </td>
                        <td>
                            {{ $summon->expiration_date ? \Carbon\Carbon::parse($summon->expiration_date)->format('Y-m-d') : 'N/A' }}
                        </td>
                        <td>
                            {{ $summon->full_name ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $summon->street ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $summon->external_number ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $summon->suburb ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $summon->worker->name ?? 'N/A' }} {{ $summon->worker->last_name ?? 'N/A' }}
                        </td>
                        @if ($mode == 1)
                            <td>
                                <a href="{{ route('citizen.summons.show', $summon->id) }}"
                                    class="btn btn-sm btn-primary">Ver</a>
                            </td>
                        @endif
                        <td></td>
                        @if ($mode == 0)
                            <td>
                                <a href="{{ route('summons.edit', $summon->id) }}"
                                    class="btn btn-sm btn-primary">Editar</a>

                                <a href="{{ route('summons.show', $summon->id) }}"
                                    class="btn btn-sm btn-secondary">Ver</a>

                                <form action="{{ route('summons.destroy', $summon->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                        data-original-title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este citatorio?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
