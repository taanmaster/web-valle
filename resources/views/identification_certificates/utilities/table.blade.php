<div>
    <div class="row mb-3">
        <div class="col-md-2">
            <select class="form-select" wire:model.live="statusFilter">
                <option value="">Todos los estatus</option>
                <option value="Solicitud nueva">Solicitud nueva</option>
                <option value="En revision">En revision</option>
                <option value="Documentos pendientes">Documentos pendientes</option>
                <option value="Pago pendiente">Pago pendiente</option>
                <option value="Pago recibido">Pago recibido</option>
                <option value="Aprobada">Aprobada</option>
                <option value="Rechazada">Rechazada</option>
                <option value="Completada">Completada</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" class="form-control" wire:model.live="startDate" placeholder="Desde">
        </div>
        <div class="col-md-2">
            <input type="date" class="form-control" wire:model.live="endDate" placeholder="Hasta">
        </div>
        <div class="col-md text-end">
            @if (!empty($statusFilter) || !empty($startDate) || !empty($endDate))
                <button class="btn btn-outline-secondary btn-sm" wire:click="clearFilters">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            @endif
        </div>
    </div>

    @if ($certificates->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>No hay constancias de identificacion registradas</h4>
                            <p class="mb-4">Las solicitudes de los ciudadanos apareceran aqui.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha Solicitud</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $certificate)
                        <tr>
                            <td>
                                <strong>{{ $certificate->folio }}</strong>
                            </td>
                            <td>
                                {{ $certificate->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ $certificate->full_name }}
                            </td>
                            <td>
                                {{ $certificate->certificate_type }}
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'Solicitud nueva' => 'warning',
                                        'En revision' => 'info',
                                        'Documentos pendientes' => 'secondary',
                                        'Pago pendiente' => 'primary',
                                        'Pago recibido' => 'info',
                                        'Aprobada' => 'success',
                                        'Rechazada' => 'danger',
                                        'Completada' => 'success',
                                    ];
                                    $color = $statusColors[$certificate->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $certificate->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('identification_certificates.show', $certificate->id) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="align-items-center mt-4">
            {{ $certificates->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
