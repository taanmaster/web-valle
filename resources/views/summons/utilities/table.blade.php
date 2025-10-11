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

        <div class="col-md-3 text-end">
            <a href="{{ route('summons.create') }}" class="btn btn-primary btn-sm">Agregar Citatorio</a>
        </div>

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
                            {{ $summon->created_at ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $summon->name ?? 'N/A' }}
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
                        @if ($mode == 0)
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
