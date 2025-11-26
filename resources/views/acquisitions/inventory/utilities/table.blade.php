<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>
                @switch($mode)
                    @case(1)
                        Ingresos
                    @break

                    @case(2)
                        Egresos
                    @break

                    @default
                        Inventario
                @endswitch
            </h2>
        </div>
        <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-end gap-3">
                @if ($view != 'Entrada')
                    <button type="button" wire:click="income" class="btn btn-success btn-sm"
                        style="max-width: fit-content">
                        Ver entradas
                    </button>
                @endif
                @if ($view != 'Salida')
                    <button type="button" wire:click="outcome" class="btn btn-danger btn-sm"
                        style="max-width: fit-content">
                        Ver Salidas
                    </button>
                @endif
                @if ($view != '')
                    <button type="button" wire:click="showAll" class="btn btn-secondary btn-sm"
                        style="max-width: fit-content">
                        Ver Todos
                    </button>
                @endif
                @if ($movements->count() != 0)
                    <button type="button" wire:click="export" class="btn btn-outline-primary btn-sm"
                        style="max-width: fit-content">
                        Exportar
                        @switch($mode)
                            @case(1)
                                Ingresos
                            @break

                            @case(2)
                                Egresos
                            @break

                            @default
                                Inventario
                        @endswitch
                    </button>
                    <a href="{{ route('acquisitions.inventory.create') }}" class="btn btn-primary btn-sm"
                        style="max-width: fit-content">
                        Crear Movimiento
                    </a>
                @endif
            </div>
        </div>
    </div>
    @if ($movements->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay inventario en la base de datos!</h4>
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
                        @if ($mode != 0)
                            <th>Tipo</th>
                        @endif
                        <th>SKU</th>
                        <th>Nombre</th>
                        <th>Dependencia</th>
                        @if ($mode != 0)
                            <th>Proveedor</th>
                        @endif
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

                    @if ($mode != 0)
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
                                    @if ($movement->type == 'Entrada')
                                        +
                                    @else
                                        -
                                    @endif
                                    {{ $movement->quantity }}
                                </td>
                                <td>
                                    <button type="button" wire:click="download({{ $movement->id }})"
                                        class="btn btn-secondary btn-sm">
                                        Descargar
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $movement->material->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cog"></i> Acciones
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $movement->material->id }}">
                                            <!-- Ver medicamento -->
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('acquisitions.inventory.show', $movement->material->id) }}">
                                                    <i class="fas fa-eye text-primary me-2"></i>
                                                    <span class="fw-medium">Ver Movimiento</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($movements as $movement)
                            <tr>
                                <td>
                                    {{ $movement->sku }}
                                </td>
                                <td>
                                    {{ $movement->title }}
                                </td>
                                <td>
                                    {{ $movement->dependency_name }}
                                </td>
                                <td>
                                    {{ $movement->current_stock }}
                                </td>
                                <td>
                                    <a href="{{ route('acquisitions.materials.show', $movement->id) }}"
                                        class="btn btn-secondary btn-sm">
                                        Ver Material
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="align-items-center mt-4">
            {{ $movements->links() }}
        </div>
    @endif
</div>
