<div class="row">

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Solicitante</th>
                    <th>Tipo de Solicitud</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urban_dev_requests as $request)
                    <tr>
                        <td><span class="badge bg-{{ $request->status_color }} mb-0">{{ $request->status_label }}</span>
                        </td>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->request_type_label }}</td>
                        <td>
                            @if ($request->description)
                                {{ Str::limit($request->description, 100) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('urban_dev.requests.show', $request->id) }}"
                                class="btn btn-sm btn-outline-info">Ver Detalle</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
