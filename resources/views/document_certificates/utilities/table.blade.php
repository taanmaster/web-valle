<div>
    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Estatus</label>
                    <select class="form-select form-select-sm" wire:model.live="statusFilter">
                        <option value="">Todos los estatus</option>
                        <option value="Solicitud nueva">Solicitud nueva</option>
                        <option value="En revisión">En revisión</option>
                        <option value="Documentos pendientes">Documentos pendientes</option>
                        <option value="Pago pendiente">Pago pendiente</option>
                        <option value="Pago recibido">Pago recibido</option>
                        <option value="Aprobada">Aprobada</option>
                        <option value="Rechazada">Rechazada</option>
                        <option value="Completada">Completada</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Desde</label>
                    <input type="date" class="form-control form-control-sm" wire:model.live="startDate">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hasta</label>
                    <input type="date" class="form-control form-control-sm" wire:model.live="endDate">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" wire:click="clearFilters">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($certificates->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted">No se encontraron certificaciones.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Folio</th>
                        <th>Fecha Solicitud</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $certificate)
                        <tr>
                            <td><span class="fw-bold text-primary">{{ $certificate->folio }}</span></td>
                            <td>{{ $certificate->created_at->format('d/m/Y') }}</td>
                            <td>{{ $certificate->full_name }}</td>
                            <td>
                                <span class="text-muted" title="{{ $certificate->filename }}">
                                    {{ Str::limit($certificate->filename, 40) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'Solicitud nueva'       => 'secondary',
                                        'En revisión'           => 'info',
                                        'Documentos pendientes' => 'warning',
                                        'Pago pendiente'        => 'warning',
                                        'Pago recibido'         => 'primary',
                                        'Aprobada'              => 'success',
                                        'Rechazada'             => 'danger',
                                        'Completada'            => 'dark',
                                    ];
                                    $color = $statusColors[$certificate->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $certificate->status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('document_certificates.show', $certificate->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $certificates->links() }}
        </div>
    @endif
</div>
