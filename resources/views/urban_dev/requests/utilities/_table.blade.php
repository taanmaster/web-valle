<div class="row">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10%;">Fecha</th>
                    <th style="width: 15%;">Solicitante</th>
                    <th style="width: 10%;">Entero</th>
                    <th style="width: 10%;">Licencia</th>
                    <th style="width: 10%;">Folio</th>
                    <th style="width: 15%;">Concepto</th>
                    <th style="width: 15%;">Domicilio</th>
                    <th style="width: 10%;">Fecha Entrega Inspector</th>
                    <th style="width: 5%;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urban_dev_requests as $request)
                    <tr>
                        <td>
                            <small class="fw-bold">{{ $request->created_at->format('d/m/Y') }}</small>
                            <br><small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $request->user->name }}</strong>
                                <br><small class="text-muted">{{ $request->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            @if($request->payment_ref_number_1)
                                <span class="badge bg-success">{{ $request->payment_ref_number_1 }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($request->inspector_license_number)
                                <span class="badge bg-info text-dark">{{ $request->inspector_license_number }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($request->payment_ref_number_2)
                                <span class="badge bg-warning text-dark">{{ $request->payment_ref_number_2 }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold">{{ $request->request_type_label }}</span>
                            <br><span class="badge bg-{{ $request->status_color }} mb-0">{{ $request->status_label }}</span>
                        </td>
                        <td>
                            <small>{{ Str::limit($request->user_address, 50) }}</small>
                        </td>
                        <td>
                            @if($request->inspection_start_date)
                                <small class="fw-bold text-success">{{ $request->inspection_start_date->format('d/m/Y') }}</small>
                                @if($request->inspector)
                                    <br><small class="text-muted">{{ $request->inspector->name }}</small>
                                @endif
                            @else
                                <span class="text-muted">Pendiente</span>
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
