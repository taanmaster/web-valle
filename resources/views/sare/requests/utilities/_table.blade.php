<div class="row">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Solicitante</th>
                    <th>Nombre Comercial</th>
                    <th>RFC</th>
                    <th>Tipo de Solicitud</th>
                    <th>Número Catastral</th>
                    <th>Fecha de Solicitud</th>
                    <th>Empleos a generar</th>
                    <th>Archivos adjuntos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sare_requests as $request)
                    <tr>
                        <td>
                            <span class="badge bg-{{ $request->status_color }} mb-0">{{ $request->status_label }}</span>
                        </td>
                        <td>{{ $request->rfc_name }}</td>
                        <td>{{ $request->commercial_name }}</td>
                        <td>{{ $request->rfc_num }}</td>
                        <td>
                            <p class="mb-1">
                                @switch($request->request_type)
                                    @case('general')
                                        General
                                    @break

                                    @case('nuevo')
                                        Nuevo
                                    @break

                                    @case('renovacion')
                                        Renovación
                                    @break

                                    @case('anuncio')
                                        Anuncio
                                    @break

                                    @default
                                        {{ $request->request_type }}
                                @endswitch
                            </p>
                        </td>
                        <td>{{ $request->catastral_num }}</td>
                        <td>{{ $request->request_date }}</td>
                        <td>
                            {{ $request->jobs_to_generate }}
                        </td>
                        <td>
                            @if ($request->files->count() > 0)
                                {{ $request->files->count() }} archivo(s)
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('sare.request.show', $request->id) }}"
                                class="btn btn-sm btn-outline-info">Ver Detalle</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
