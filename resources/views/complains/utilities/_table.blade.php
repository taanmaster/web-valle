<div class="row mb-3">
    <div class="col-md-3">
        <label for="">Rango de fechas de creación</label>
        <div class="input-group mb-3">
            <input type="date" class="form-control" wire:model.live="start_date">
            <span class="input-group-text">a</span>
            <input type="date" class="form-control" wire:model.live="end_date">
        </div>
    </div>

</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Asunto</th>
                <th>Denuncia</th>
                <th>Pruebas</th>
                <th>Acción</th>
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
                        {{ $complain->message ?? 'N/A' }}
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
                        <button class="btn btn-link btn-sm">
                            Descargar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
