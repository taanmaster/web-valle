<div>
    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>
                Registra ingresos seleccionando un entero provisional y utiliza Ver para revisar su recibo asociado.
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Fecha desde:</label>
                    <input type="date" class="form-control" wire:model.live="start_date">
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Fecha hasta:</label>
                    <input type="date" class="form-control" wire:model.live="end_date">
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1"></i> Clave de cuenta:
                    </label>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="code"
                        placeholder="Buscar por clave única">
                </div>
                <div class="col-lg-2">
                    <a href="{{ route('account_due_incomes.index') }}" class="btn btn-outline-secondary w-100" title="Limpiar filtros">
                        <i class="fas fa-times me-1"></i> Limpiar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($incomes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold"># Recibo</th>
                                <th class="fw-semibold">Fecha y hora</th>
                                <th class="fw-semibold">Departamento</th>
                                <th class="fw-semibold">Contribuyente</th>
                                <th class="fw-semibold">Clave</th>
                                <th class="fw-semibold">Concepto de cobro</th>
                                <th class="fw-semibold">Importe</th>
                                <th class="fw-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomes as $income)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $income->id }}</span></td>
                                    <td>{{ $income->created_at->format('d/m/Y h:m') }}</td>
                                    <td>{{ $income->department }}</td>
                                    <td>{{ $income->name }}</td>
                                    <td>{{ $income->code }}</td>
                                    <td>{{ $income->concept }}</td>
                                    <td>${{ number_format($income->qty_integer, 2) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('account_due_incomes.show', $income->id) }}"
                                                class="btn btn-outline-primary" title="Ver ingreso" aria-label="Ver ingreso">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal_{{ $income->id }}" title="Eliminar ingreso" aria-label="Eliminar ingreso">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-folder-open fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">No hay ingresos registrados</h5>
                    <p class="text-muted mb-4">Genera un ingreso para iniciar el flujo de recibos y corte diario.</p>
                    <a href="{{ route('account_due_incomes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Crear Primer Ingreso
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
