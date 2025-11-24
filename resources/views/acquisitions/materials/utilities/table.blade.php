<div>
    @if ($materials->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay medicamentos guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('acquisitions.materials.create') }}"
                                class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nuevo
                                Medicamento</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Medicamento</th>
                        <th>Inventario Total</th>
                        <th>Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($materials as $material)
                        <tr>
                            <th scope="row">#{{ $material->id }}</th>
                            <td>
                                <div>
                                    <strong>{{ $material->generic_name }}</strong>
                                    @if ($material->commercial_name)
                                        <br><small class="text-muted">{{ $material->commercial_name }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold fs-4 {{ $totalStock > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $totalStock }}
                                    </span>
                                    <small class="text-muted">unidades</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    @if ($material->is_active)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Archivado</span>
                                    @endif

                                    @if ($variantsCount > 0)
                                        <span class="badge {{ $stockStatus['badge_class'] }}">
                                            {{ $stockStatus['label'] }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Sin variantes</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton{{ $material->id }}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-cog"></i> Acciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $material->id }}">
                                        <!-- Ver medicamento -->
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('dif.materials.show', $material->id) }}">
                                                <i class="fas fa-eye text-primary me-2"></i>
                                                <span class="fw-medium">Ver Medicamento</span>
                                            </a>
                                        </li>

                                        <!-- Editar medicamento -->
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('dif.materials.edit', $material->id) }}">
                                                <i class="fas fa-edit text-secondary me-2"></i>
                                                <span class="fw-medium">Editar Medicamento</span>
                                            </a>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <!-- Nueva variante -->
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('dif.material_variants.create', ['material_id' => $material->id]) }}">
                                                <i class="fas fa-plus text-success me-2"></i>
                                                <span class="fw-medium">Nueva Variante</span>
                                            </a>
                                        </li>

                                        <!-- Ver variantes -->
                                        @if ($variantsCount > 0)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('dif.materials.show', $material->id) }}">
                                                    <i class="fas fa-list text-info me-2"></i>
                                                    <span class="fw-medium">Ver Variantes ({{ $variantsCount }})</span>
                                                </a>
                                            </li>
                                        @endif

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <!-- Registrar movimiento -->
                                        @if ($variantsCount > 0)
                                            <li>
                                                <h6 class="dropdown-header">
                                                    <i class="fas fa-exchange-alt text-warning me-2"></i>
                                                    Registrar Movimiento
                                                </h6>
                                            </li>
                                            @foreach ($material->variants as $variant)
                                                <li>
                                                    <a class="dropdown-item ps-4"
                                                        href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}">
                                                        <i class="fas fa-arrow-right text-muted me-2"></i>
                                                        <span>{{ $variant->name }}</span>
                                                        <small class="text-muted d-block">Stock:
                                                            {{ $variant->getCurrentStock() }} unidades</small>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li>
                                                <span class="dropdown-item-text text-muted">
                                                    <i class="fas fa-exchange-alt me-2"></i>
                                                    No hay variantes para movimientos
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="align-items-center mt-4">
            {{ $materials->links() }}
        </div>
    @endif
</div>
