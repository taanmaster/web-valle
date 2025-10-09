<div class="col-lg-12">
    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Foto</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th style="width: 140px;">No. Empleado</th>
                            <th>Puesto/Cargo</th>
                            <th style="width: 180px;">Vigencia</th>
                            <th style="width: 140px;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workers as $worker)
                        <tr>
                            <td class="text-center">
                                @if($worker->s3_asset_url)
                                    <img src="{{ $worker->s3_asset_url }}" alt="{{ $worker->full_name }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #dee2e6;">
                                @else
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width: 45px; height: 45px; font-weight: 600; font-size: 16px;">
                                        {{ strtoupper(substr($worker->name, 0, 1)) }}{{ strtoupper(substr($worker->last_name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $worker->name }}</strong>
                            </td>
                            <td>{{ $worker->last_name }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $worker->employee_number }}</span>
                            </td>
                            <td>{{ $worker->position }}</td>
                            <td>
                                @if($worker->validity_date_end)
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $isExpired = $worker->validity_date_end < $now;
                                    @endphp
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $worker->validity_date_start->format('d/m/Y') }}
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar-times me-1"></i>
                                        {{ $worker->validity_date_end->format('d/m/Y') }}
                                    </small>
                                    @if($isExpired)
                                        <span class="badge bg-danger mt-1">Vencida</span>
                                    @else
                                        <span class="badge bg-success mt-1">Vigente</span>
                                    @endif
                                @else
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Desde: {{ $worker->validity_date_start->format('d/m/Y') }}
                                    </small>
                                    <span class="badge bg-success mt-1">Vigente</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('urban_dev.workers.show', $worker->id) }}" class="btn btn-sm btn-info" title="Ver Perfil">
                                        <i class='fas fa-eye'></i>
                                    </a>
                                    <a href="{{ route('urban_dev.workers.edit', $worker->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class='fas fa-edit'></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $worker->id }})" title="Eliminar">
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $worker->id }}" action="{{ route('urban_dev.workers.destroy', $worker->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(workerId) {
        if (confirm('¿Estás seguro de que deseas eliminar este trabajador? Esta acción no se puede deshacer.')) {
            document.getElementById('delete-form-' + workerId).submit();
        }
    }
</script>
