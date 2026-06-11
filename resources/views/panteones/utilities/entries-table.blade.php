<div>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-uppercase mb-0">Registro Panteones</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('panteones.admin.create') }}" class="btn btn-primary fw-semibold px-4">
                Crear Nuevo
            </a>
            <button wire:click="toggleFilters" class="btn btn-secondary fw-semibold px-4">
                Filtros
            </button>
        </div>
    </div>

    {{-- Filtros --}}
    @if ($show_filters)
        <div class="row mb-4 align-items-end g-3">
            <div class="col-md-4">
                <label class="form-label text-muted small">Folio</label>
                <input type="text" class="form-control rounded-pill" placeholder="Todos"
                    wire:model.live="filter_folio">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small">Fecha</label>
                <input type="date" class="form-control rounded-pill" placeholder="dd/mm/yyyy"
                    wire:model.live="filter_fecha">
            </div>
            @if ($filter_folio || $filter_fecha)
                <div class="col-md-4">
                    <button wire:click="resetFilters" class="btn btn-link text-danger p-0">
                        Limpiar filtros
                    </button>
                </div>
            @endif
        </div>
    @endif

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-uppercase text-center" style="font-size: 0.85rem; color: #555;">
                        <th class="py-3">Folio</th>
                        <th class="py-3">Entero</th>
                        <th class="py-3">Fecha de Registro</th>
                        <th class="py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($panteones as $registro)
                        <tr class="text-center border-top">
                            <td class="py-3">{{ $registro->folio ?? '—' }}</td>
                            <td class="py-3">{{ $registro->entero ?? '—' }}</td>
                            <td class="py-3">
                                {{ $registro->fecha ? $registro->fecha->format('d/m/Y') : '—' }}
                            </td>
                            <td class="py-3">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a href="{{ route('panteones.admin.show', $registro->id) }}"
                                        class="text-dark" title="Ver">
                                        <i class="bx bx-show fs-5"></i>
                                    </a>
                                    <a href="{{ route('panteones.admin.edit', $registro->id) }}"
                                        class="text-dark" title="Editar">
                                        <i class="bx bx-pencil fs-5"></i>
                                    </a>
                                    <form method="POST"
                                        action="{{ route('panteones.admin.destroy', $registro->id) }}"
                                        onsubmit="return confirm('¿Eliminar este registro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                            style="font-size: 0.8rem;">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                No hay registros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-3">
        {{ $panteones->links() }}
    </div>
</div>
