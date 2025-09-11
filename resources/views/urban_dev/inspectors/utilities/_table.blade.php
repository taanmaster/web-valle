<div class="row">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 15%;">Estatus</th>
                    <th style="width: 20%;">Solicitante</th>
                    <th style="width: 25%;">Domicilio</th>
                    <th style="width: 15%;">Fecha de Ingreso</th>
                    <th style="width: 15%;">Fecha de Entrega a Inspector</th>
                    <th style="width: 10%;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urban_dev_requests as $request)
                    <tr>
                        <td>
                            <span class="badge bg-{{ $request->status_color }} mb-0">{{ $request->status_label }}</span>
                            <br><small class="text-muted">{{ $request->request_type_label }}</small>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $request->user->name }}</strong>
                                <br><small class="text-muted">{{ $request->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            <small>{{ Str::limit($request->user_address, 60) }}</small>
                        </td>
                        <td>
                            <small class="fw-bold">{{ $request->created_at->format('d/m/Y') }}</small>
                            <br><small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            @if($request->inspection_start_date)
                                <small class="fw-bold text-success">{{ $request->inspection_start_date->format('d/m/Y') }}</small>
                                <br><small class="text-muted">Asignado</small>
                            @else
                                <span class="text-muted">Pendiente</span>
                                <br><small class="text-warning">Sin asignar</small>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('urban_dev.requests.show', $request->id) }}"
                                class="btn btn-sm btn-outline-info" title="Ver Detalle">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
