<div>
    @if ($movements->count() == 0)
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
        <div class="row mb-4"></div>


        <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Tipo</th>
                        <th>SKU</th>
                        <th>Nombre</th>
                        <th>Dependencia</th>
                        <th>Proveedor</th>
                        <th>

                            @switch($mode)
                                @case(1)
                                    Cantidad Ingresada
                                @break

                                @case(2)
                                    Cantidad Egresaa
                                @break

                                @default
                                    Cantidad Disponible
                            @endswitch

                        </th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($movements as $movement)
                        <tr>
                            <td>{{ $movement->material->category }}</td>
                            <td>
                                {{ $movement->material->sku }}
                            </td>
                            <td>
                                {{ $movement->material->title }}
                            </td>
                            <td>
                                {{ $movement->material->dependency_name }}
                            </td>
                            <td>
                                {{ $movement->supplier->owner_name }}
                            </td>
                            <td>
                                {{ $movement->material->current_stock }}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton{{ $movement->material->id }}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-cog"></i> Acciones
                                    </button>
                                    <ul class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton{{ $movement->material->id }}">
                                        <!-- Ver medicamento -->
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('acquisitions.materials.show', $movement->material->id) }}">
                                                <i class="fas fa-eye text-primary me-2"></i>
                                                <span class="fw-medium">Ver Medicamento</span>
                                            </a>
                                        </li>

                                        <!-- Editar medicamento -->
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('acquisitions.materials.edit', $movement->material->id) }}">
                                                <i class="fas fa-edit text-secondary me-2"></i>
                                                <span class="fw-medium">Editar Medicamento</span>
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
            {{ $movements->links() }}
        </div>
    @endif
</div>
