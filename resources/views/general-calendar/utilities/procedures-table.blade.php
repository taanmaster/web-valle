<div>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
        <h4 class="fw-bold text-uppercase mb-0">Trámites Calendario</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('general_calendar.admin.create') }}" class="btn btn-primary fw-semibold px-4">Crear Nuevo</a>
            <button wire:click="toggleFilters" class="btn btn-secondary fw-semibold px-4">Filtros</button>
        </div>
    </div>

    {{-- Alertas flash --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bx bx-check-circle fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filtros --}}
    @if ($show_filters)
        <div class="row g-3 mb-4 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Nombre</label>
                <input type="text" class="form-control rounded-pill" placeholder="Buscar por nombre"
                    wire:model.live.debounce.300ms="filter_nombre">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Estatus</label>
                <select class="form-select rounded-pill" wire:model.live="filter_estatus">
                    <option value="">Todos</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            @if ($filter_nombre || $filter_estatus !== '')
                <div class="col-md-3">
                    <button wire:click="resetFilters" class="btn btn-link text-danger p-0 mt-3">Limpiar filtros</button>
                </div>
            @endif
        </div>
    @endif

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <table class="table table-borderless align-middle mb-0">
                <thead>
                    <tr style="border-bottom: 1.5px solid #e5e5e5;">
                        <th class="ps-4 py-3 text-uppercase text-center"
                            style="font-size: .8rem; color: #888; font-weight: 600;">Nombre del Trámite</th>
                        <th class="py-3 text-uppercase text-center"
                            style="font-size: .8rem; color: #888; font-weight: 600;">Estatus</th>
                        <th class="pe-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($procedures as $procedure)
                        <tr style="border-bottom: 1px solid #f0f0f0;" wire:key="proc-{{ $procedure->id }}">
                            <td class="ps-4 py-3 text-center">{{ $procedure->name }}</td>
                            <td class="py-3 text-center">
                                <span class="badge bg-{{ $procedure->status ? 'success' : 'secondary' }}">
                                    {{ $procedure->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="pe-4 py-3 text-end" style="white-space: nowrap;">
                                <a href="{{ route('general_calendar.admin.show', $procedure->id) }}"
                                    class="btn btn-link p-0 me-2" title="Ver" aria-label="Ver">
                                    <i class="ti ti-eye" style="font-size: 1.3rem; color: #555;"></i>
                                </a>
                                <a href="{{ route('general_calendar.admin.edit', $procedure->id) }}"
                                    class="btn btn-link p-0 me-3" title="Editar" aria-label="Editar">
                                    <i class="ti ti-pencil" style="font-size: 1.25rem; color: #555;"></i>
                                </a>
                                <button wire:click="delete({{ $procedure->id }})"
                                    wire:confirm="¿Eliminar este trámite? Se eliminarán también sus citas y configuración."
                                    class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                    title="Eliminar" aria-label="Eliminar">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">No hay trámites registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $procedures->links() }}</div>
</div>
