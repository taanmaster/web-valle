<div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('panteon_import_row_errors'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>La importación terminó con observaciones.</strong>
            <ul class="mb-0 mt-2">
                @foreach (session('panteon_import_row_errors') as $row => $errors)
                    <li>Fila {{ $row }}: {{ implode(' ', $errors) }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-uppercase mb-0">Registro Panteones</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('panteones.admin.create') }}" class="btn btn-primary fw-semibold px-4">
                Crear Nuevo
            </a>
            <button type="button" class="btn btn-outline-success fw-semibold px-4" data-bs-toggle="modal"
                data-bs-target="#importPanteones">
                <i class="ti ti-file-import me-1"></i> Importar
            </button>
            <button wire:click="toggleFilters" class="btn btn-secondary fw-semibold px-4">
                Filtros
            </button>
        </div>
    </div>

    <div class="modal fade" id="importPanteones" tabindex="-1" aria-labelledby="importPanteonesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importPanteonesLabel">Importar registros de panteones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form method="POST" action="{{ route('panteones.admin.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted small mb-3">
                            Se aceptan archivos CSV, XLS y XLSX. El sistema identifica la fila de encabezados y
                            reconoce: fecha, entero, folio, nombre, concepto, finado, panteón, sección, manzana o
                            bloque, terreno, cantidad y observaciones o estatus.
                        </p>

                        <div class="alert alert-warning d-flex gap-2" role="alert">
                            <i class="ti ti-alert-triangle fs-5"></i>
                            <div>
                                La importación conserva todas las filas y no elimina ni combina registros. Si el
                                archivo ya se importó, sus datos se cargarán nuevamente y se duplicarán.
                            </div>
                        </div>

                        <label for="panteones-import-file" class="form-label fw-semibold">Archivo</label>
                        <input id="panteones-import-file" class="form-control" type="file" name="import_file"
                            accept=".csv,.xls,.xlsx" required>

                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="1" id="confirm-duplicates"
                                name="confirm_duplicates" required>
                            <label class="form-check-label" for="confirm-duplicates">
                                Confirmo que revisé el archivo y entiendo que una importación repetida duplica la
                                información.
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-upload me-1"></i> Importar archivo
                        </button>
                    </div>
                </form>
            </div>
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
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>
                                    <a href="{{ route('panteones.admin.edit', $registro->id) }}"
                                        class="text-dark" title="Editar">
                                        <i class="ti ti-pencil fs-5"></i>
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
    <div class="d-flex justify-content-center mt-4">
        {{ $panteones->links('pagination::bootstrap-5') }}
    </div>
</div>
