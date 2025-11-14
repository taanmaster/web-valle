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
                            @if ($complain->anonymus == true)
                                Si
                            @else
                                No
                            @endif
                        </td>
                        <td>
                            @if ($complain->notification_email == true)
                                Correo
                            @endif
                            @if ($complain->notification_home == true)
                                Domicilio
                            @endif
                        </td>
                        <td>
                            {{ $complain->name ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $complain->subject ?? 'N/A' }}
                        </td>
                        <td>
                            <button class="btn btn-link btn-sm" wire:click="downloadFile('{{ $complain->id }}')">
                                Descargar
                            </button>
                        </td>
                        <td>
                            <select wire:model="status.{{ $complain->id }}"
                                wire:change="updateStatus({{ $complain->id }})" class="form-control">
                                <option value="">Selecciona una opción</option>
                                <option value="En proceso">En proceso</option>
                                <option value="Concluida">Concluida</option>
                            </select>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
