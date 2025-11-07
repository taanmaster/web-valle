<div class="col-lg-12">
    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 15%;">Proveedor</th>
                            <th style="width: 12%;">RFC</th>
                            <th style="width: 10%;">Tipo</th>
                            <th style="width: 10%;">Estatus</th>
                            <th style="width: 15%;">Progreso Documentos</th>
                            <th style="width: 13%;">Fecha Solicitud</th>
                            <th style="width: 10%;" class="text-center">Autorizado</th>
                            <th style="width: 10%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                        <tr>
                            <td class="text-center"><strong>#{{ $supplier->id }}</strong></td>
                            <td>
                                @if($supplier->person_type == 'fisica')
                                    {{ $supplier->first_name }} {{ $supplier->last_name }}
                                @else
                                    {{ $supplier->business_name }}
                                @endif
                            </td>
                            <td><code>{{ $supplier->rfc }}</code></td>
                            <td>
                                @if($supplier->person_type == 'fisica')
                                    <span class="badge bg-info">Persona Física</span>
                                @else
                                    <span class="badge bg-primary">Persona Moral</span>
                                @endif
                            </td>
                            <td>
                                @switch($supplier->status)
                                    @case('solicitud')
                                        <span class="badge bg-secondary">Solicitud</span>
                                        @break
                                    @case('validacion')
                                        <span class="badge bg-warning">Validación</span>
                                        @break
                                    @case('aprobacion')
                                        <span class="badge bg-info">Aprobación</span>
                                        @break
                                    @case('pago_pendiente')
                                        <span class="badge bg-primary">Pago Pendiente</span>
                                        @break
                                    @case('padron_activo')
                                        <span class="badge bg-success">Padrón Activo</span>
                                        @break
                                    @case('rechazado')
                                        <span class="badge bg-danger">Rechazado</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @php
                                    $total = $supplier->files->count();
                                    $approved = $supplier->files->where('status', 'aprobado')->count();
                                    $rejected = $supplier->files->where('status', 'rechazado')->count();
                                    $pending = $supplier->files->where('status', 'pendiente')->count();
                                    $percentage = $total > 0 ? round(($approved / $total) * 100) : 0;
                                @endphp
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: {{ $percentage }}%">
                                        {{ $approved }}/{{ $total }}
                                    </div>
                                </div>
                                <small class="text-muted">
                                    <i class="bx bx-check text-success"></i> {{ $approved }}
                                    <i class="bx bx-x text-danger ms-2"></i> {{ $rejected }}
                                    <i class="bx bx-time text-warning ms-2"></i> {{ $pending }}
                                </small>
                            </td>
                            <td>
                                <small>{{ $supplier->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td class="text-center">
                                @if($supplier->approval)
                                    @if($supplier->approval->link_approval && $supplier->approval->director_approval)
                                        <ion-icon name="checkmark-done-circle" class="text-success" style="font-size: 24px;"></ion-icon>
                                    @elseif($supplier->approval->link_approval || $supplier->approval->director_approval)
                                        <ion-icon name="checkmark-circle" class="text-warning" style="font-size: 24px;"></ion-icon>
                                    @else
                                        <ion-icon name="close-circle" class="text-danger" style="font-size: 24px;"></ion-icon>
                                    @endif
                                @else
                                    <ion-icon name="remove-circle" class="text-muted" style="font-size: 24px;"></ion-icon>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <ion-icon name="ellipsis-horizontal"></ion-icon>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('acquisitions.suppliers.show', $supplier) }}">
                                                <ion-icon name="eye-outline"></ion-icon> Ver Detalles
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('acquisitions.suppliers.contact', $supplier) }}">
                                                <ion-icon name="mail-outline"></ion-icon> Contactar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
