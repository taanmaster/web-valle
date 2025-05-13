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
            </tr>
        </thead>
        <tbody>
            @foreach ($complains as $complain)
                <tr>
                    <td>{{ $complain->id }}</td>
                    <td>
                        <strong>Nombre:</strong> {{ $complain->name ?? 'N/A' }}<br>
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
                        {{ $complain->complain ?? 'N/A' }}
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
