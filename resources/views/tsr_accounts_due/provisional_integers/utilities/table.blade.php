<div>
    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>
                Desde aquí puedes revisar enteros emitidos, abrir su detalle y descargar el formato para impresión.
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
                        <i class="fas fa-search me-1"></i> Folio:
                    </label>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="folio"
                        placeholder="Buscar por folio de entero">
                </div>
                <div class="col-lg-2">
                    <a href="{{ route('account_due_provisional_integers.index') }}" class="btn btn-outline-secondary w-100" title="Limpiar filtros">
                        <i class="fas fa-times me-1"></i> Limpiar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($integers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Fecha</th>
                                <th class="fw-semibold">Folio</th>
                                <th class="fw-semibold">Dependencia</th>
                                <th class="fw-semibold">Fundamento</th>
                                <th class="fw-semibold">Método de Pago</th>
                                <th class="fw-semibold">Elaborado por</th>
                                <th class="fw-semibold">Nombre</th>
                                <th class="fw-semibold">Cantidad</th>
                                <th class="fw-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($integers as $integer)
                                <tr>
                                    <td>{{ $integer->created_at->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-primary">{{ $integer->id }}</span></td>
                                    <td>{{ $integer->dependency_name }}</td>
                                    <td>{{ $integer->basis }}</td>
                                    <td>{{ $integer->payment_method }}</td>
                                    <td>{{ $integer->created_by }}</td>
                                    <td>{{ $integer->name }}</td>
                                    <td>${{ number_format($integer->qty_integer, 2) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="javascript:void(0)" class="btn btn-outline-primary show-btn"
                                                data-id="{{ $integer->id }}" title="Ver entero" aria-label="Ver entero">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('account_due_provisional_integers.print', $integer->id) }}"
                                                class="btn btn-outline-secondary" title="Descargar entero" aria-label="Descargar entero">
                                                <i class="fas fa-download"></i>
                                            </a>
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
                    <h5 class="text-muted">No hay enteros registrados</h5>
                    <p class="text-muted mb-0">Genera un entero desde el detalle de un perfil para verlo en este listado.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="enteroModal" tabindex="-1" aria-labelledby="enteroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="enteroModalLabel">Entero Provisional para Pago</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <livewire:tsr_accounts_due.profiles.integer-modal />
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var enteroModal = new bootstrap.Modal(document.getElementById('enteroModal'), {
                keyboard: false
            });

            document.querySelectorAll('.show-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const integerId = this.getAttribute('data-id');
                    enteroModal.show();
                    Livewire.dispatch('selectInteger', {
                        id: integerId
                    });
                });
            });
        </script>
    @endpush
</div>
