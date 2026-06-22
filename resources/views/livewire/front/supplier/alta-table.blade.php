<div>
    <!-- Filtros (en tiempo real) -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Estado</label>
                    <select wire:model.live="status" id="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="solicitud">Solicitud</option>
                        <option value="validacion">Validación</option>
                        <option value="aprobacion">Aprobación</option>
                        <option value="pago_pendiente">Pago Pendiente</option>
                        <option value="padron_activo">Padrón Activo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="person_type" class="form-label">Tipo</label>
                    <select wire:model.live="person_type" id="person_type" class="form-select">
                        <option value="">Todos</option>
                        <option value="fisica">Persona Física</option>
                        <option value="moral">Persona Moral</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <div class="position-relative">
                        <input type="text" wire:model.live.debounce.400ms="search" id="search" class="form-control"
                               placeholder="Nombre de empresa o folio">
                        <div wire:loading wire:target="search"
                             class="spinner-border spinner-border-sm text-primary position-absolute top-50 end-0 translate-middle-y me-2"
                             role="status"></div>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" wire:click="clearFilters" class="btn btn-outline-secondary"
                            @disabled($status === '' && $person_type === '' && $search === '')>
                        <ion-icon name="close-outline"></ion-icon> Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de altas -->
    <div class="table-responsive" wire:loading.class="opacity-50">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Tipo</th>
                    <th>Nombre/Razón Social</th>
                    <th>Estado</th>
                    <th>Progreso</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                    <tr wire:key="supplier-{{ $supplier->id }}">
                        <td>
                            <strong>{{ $supplier->registration_number }}</strong>
                        </td>
                        <td>
                            @if($supplier->person_type === 'fisica')
                                <span class="badge bg-primary">
                                    <ion-icon name="person-outline"></ion-icon> Física
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <ion-icon name="business-outline"></ion-icon> Moral
                                </span>
                            @endif
                        </td>
                        <td>
                            {{ $supplier->display_name }}
                        </td>
                        <td>
                            {!! $supplier->status_badge !!}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1" style="height: 20px; min-width: 100px;">
                                    <div class="progress-bar {{ $supplier->progress_percentage == 100 ? 'bg-success' : 'bg-primary' }}"
                                         role="progressbar"
                                         style="width: {{ $supplier->progress_percentage }}%"
                                         aria-valuenow="{{ $supplier->progress_percentage }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        {{ $supplier->progress_percentage }}%
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <small>{{ $supplier->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <a href="{{ route('supplier.alta.form', $supplier->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Editar">
                                    <ion-icon name="create-outline"></ion-icon> Editar
                                </a>
                                @php $altaPagada = in_array($supplier->id, $paidSupplierIds ?? []); @endphp
                                @if($altaPagada)
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                                        <ion-icon name="checkmark-circle"></ion-icon> Pagada
                                    </span>
                                @elseif($supplier->status === 'pago_pendiente')
                                    <form action="{{ route('citizen.supplier_alta.pay_online', $supplier->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning fw-semibold">
                                            <ion-icon name="cart-outline"></ion-icon> Agregar a carrito
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted mb-0">No se encontraron altas con los filtros aplicados</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    @if($suppliers->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $suppliers->links() }}
        </div>
    @endif
</div>
