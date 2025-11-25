<div>
    @if ($materials->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay materiales guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('acquisitions.materials.create') }}"
                                class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Nuevo
                                Material y/o servicio</a>
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
                        <th>SKU</th>
                        <th>Título</th>
                        <th>Dependencia</th>
                        <th>Tipo</th>
                        <th>Proveedor</th>
                        <th>Cantidad</th>
                        <th>Estatus</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($materials as $material)
                        <tr>
                            <td scope="row">{{ $material->sku }}</td>
                            <td>
                                <p>{{ $material->title }}</p>
                            </td>
                            <td>
                                {{ $material->dependency_name }}
                            </td>
                            <td>
                                {{ $material->category }}
                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <p>{{ $material->current_stock }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    @if ($material->is_active)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Archivado</span>
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
                                                href="{{ route('acquisitions.materials.show', $material->id) }}">
                                                <i class="fas fa-eye text-primary me-2"></i>
                                                <span class="fw-medium">Ver Material</span>
                                            </a>
                                        </li>

                                        <!-- Editar medicamento -->
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('acquisitions.materials.edit', $material->id) }}">
                                                <i class="fas fa-edit text-secondary me-2"></i>
                                                <span class="fw-medium">Editar Material</span>
                                            </a>
                                        </li>
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
