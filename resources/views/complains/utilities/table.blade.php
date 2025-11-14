<div>
    <div class="row mb-3 justify-content-between align-items-center">
        <div class="col-md-3">
            <label for="">Rango de fechas de creación</label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" wire:model.live="start_date">
                <span class="input-group-text">a</span>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>

        @if ($start_date != null or $end_date != null)
            <div class="col-md-2">
                <button wire:click="resetFilters" class="btn btn-secondary">Limpiar filtros</button>
            </div>
        @endif

    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Anónimo</th>
                    <th>Seguimiento</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Asunto</th>
                    <th>Acción</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($complains as $complain)
                    <tr>
                        <td>{{ $complain->id }}</td>
                        <td>
                            {{ $complain->name ?? 'N/A' }}<br>
                        </td>
                        <td>
                            {{ $complain->address ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $complain->phone ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $complain->email ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $complain->subject ?? 'N/A' }}
                        </td>
                        <td>
                            @if ($complain->files)
                                <ul>
                                    @foreach ($complain->files as $file)
                                        <li>
                                            <a href="{{ $file->filename }}" target="_blank">
                                                {{ $file->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-link btn-sm" wire:click="downloadFile('{{ $complain->id }}')">
                                Descargar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
