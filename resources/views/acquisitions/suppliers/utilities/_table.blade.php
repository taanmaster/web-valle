<div class="col-lg-12">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;" class="text-center text-white">
                                <i class="fas fa-hashtag me-1"></i> ID
                            </th>
                            <th style="width: 15%;" class="text-white">
                                <i class="fas fa-user me-1"></i> Proveedor
                            </th>
                            <th style="width: 12%;" class="text-white">
                                <i class="fas fa-id-card me-1"></i> RFC
                            </th>
                            <th style="width: 10%;" class="text-white">
                                <i class="fas fa-tag me-1"></i> Tipo
                            </th>
                            <th style="width: 10%;" class="text-white">
                                <i class="fas fa-info-circle me-1"></i> Estatus
                            </th>
                            <th style="width: 15%;" class="text-white">
                                <i class="fas fa-chart-line me-1"></i> Progreso Documentos
                            </th>
                            <th style="width: 13%;" class="text-white">
                                <i class="fas fa-calendar me-1"></i> Fecha Solicitud
                            </th>
                            <th style="width: 10%;" class="text-center text-white">
                                <i class="fas fa-check-circle me-1"></i> Autorizado
                            </th>
                            <th style="width: 10%;" class="text-center text-white">
                                <i class="fas fa-cog me-1"></i> Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-secondary bg-opacity-10 text-dark fw-bold">#{{ $supplier->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                        @if($supplier->person_type == 'fisica')
                                            <i class="fas fa-user text-primary"></i>
                                        @else
                                            <i class="fas fa-building text-primary"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-semibold">
                                            @if($supplier->person_type == 'fisica')
                                                {{ $supplier->owner_name }}
                                            @else
                                                {{ $supplier->business_name ?? 'Sin Configurar' }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="fas fa-id-card me-1"></i> {{ $supplier->rfc ?? 'Sin Configurar' }}
                                </span>
                            </td>
                            <td>
                                @if($supplier->person_type == 'fisica')
                                    <span class="badge bg-info">
                                        <i class="fas fa-user me-1"></i> Persona Física
                                    </span>
                                @else
                                    <span class="badge bg-primary">
                                        <i class="fas fa-building me-1"></i> Persona Moral
                                    </span>
                                @endif
                            </td>
                            <td>
                                @switch($supplier->status)
                                    @case('solicitud')
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-file-alt me-1"></i> Solicitud
                                        </span>
                                        @break
                                    @case('validacion')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-tasks me-1"></i> Validación
                                        </span>
                                        @break
                                    @case('aprobacion')
                                        <span class="badge bg-info">
                                            <i class="fas fa-check-circle me-1"></i> Aprobación
                                        </span>
                                        @break
                                    @case('pago_pendiente')
                                        <span class="badge bg-primary">
                                            <i class="fas fa-money-bill-wave me-1"></i> Pago Pendiente
                                        </span>
                                        @break
                                    @case('padron_activo')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-double me-1"></i> Padrón Activo
                                        </span>
                                        @break
                                    @case('rechazado')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i> Rechazado
                                        </span>
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
                                    
                                    // Determinar color de la barra de progreso
                                    $progressColor = 'bg-danger';
                                    if ($percentage >= 75) {
                                        $progressColor = 'bg-success';
                                    } elseif ($percentage >= 50) {
                                        $progressColor = 'bg-info';
                                    } elseif ($percentage >= 25) {
                                        $progressColor = 'bg-warning';
                                    }
                                @endphp
                                <div class="progress mb-2" style="height: 24px;">
                                    <div class="progress-bar {{ $progressColor }} progress-bar-striped" 
                                         role="progressbar" 
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <strong>{{ $approved }}/{{ $total }}</strong>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-success">
                                        <i class="fas fa-check-circle me-1"></i> {{ $approved }}
                                    </small>
                                    <small class="text-danger">
                                        <i class="fas fa-times-circle me-1"></i> {{ $rejected }}
                                    </small>
                                    <small class="text-warning">
                                        <i class="fas fa-clock me-1"></i> {{ $pending }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <small>{{ $supplier->created_at->format('d/m/Y') }}</small>
                                </div>
                                <div class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    <small>{{ $supplier->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($supplier->approval)
                                    @if($supplier->approval->link_approval && $supplier->approval->director_approval)
                                        <div class="d-inline-block" data-bs-toggle="tooltip" title="Totalmente autorizado">
                                            <i class="fas fa-check-double fa-2x text-success"></i>
                                        </div>
                                    @elseif($supplier->approval->link_approval || $supplier->approval->director_approval)
                                        <div class="d-inline-block" data-bs-toggle="tooltip" title="Parcialmente autorizado">
                                            <i class="fas fa-check-circle fa-2x text-warning"></i>
                                        </div>
                                    @else
                                        <div class="d-inline-block" data-bs-toggle="tooltip" title="Sin autorización">
                                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="d-inline-block" data-bs-toggle="tooltip" title="Pendiente de revisión">
                                        <i class="fas fa-minus-circle fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('acquisitions.suppliers.show', $supplier) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" 
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('acquisitions.suppliers.show', $supplier) }}">
                                                <i class="fas fa-eye text-primary me-2"></i> Ver Detalles
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('acquisitions.suppliers.contact', $supplier) }}">
                                                <i class="fas fa-envelope text-warning me-2"></i> Contactar
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
