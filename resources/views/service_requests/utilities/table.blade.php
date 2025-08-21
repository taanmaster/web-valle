<div>
    <style>
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .table td {
            vertical-align: middle;
        }

        .table-responsive {
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        @media (max-width: 768px) {
            .table td {
                font-size: 0.875rem;
            }

            .btn-sm {
                font-size: 0.75rem;
            }
        }
    </style>

    <div class="row mb-3 align-items-center">
        <div class="col-md-4">
            <label for="">Buscar un trámite o servicio</label>
            <input type="text" class="form-control" placeholder="Ingrese un nombre" wire:model.live="title" />
        </div>

        <div class="col-md-3">
            <label for="">Filtrar por dependencia</label>
            <select class="form-select" aria-label="Default select example" wire:model.live="dependency_name">
                <option selected>Seleccione una dependencia</option>
                @foreach ($dependencies as $item)
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 text-end">

            @if ($title !== '' || $dependency_name !== '')
                <button class="btn btn-secondary btn-sm" wire:click="resetFilters">Limpiar Filtros</button>
            @endif

            @if ($mode === 0)
                <a href="{{ route('institucional_development.requests.create') }}" class="btn btn-primary btn-sm"
                    wire:click="resetFilters">Nueva</a>
            @endif
        </div>
    </div>

    <div class="row">
        @if ($mode === 1 && $title === '' && $dependency_name === '')
            <div class="col-md-6">

                <h3 class="mb-3">Los más populares</h3>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dependencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($popularRequests as $request)
                                <tr>
                                    <td>{{ $request->name }}</td>
                                    <td>{{ $request->dependency_name }}</td>
                                    <td>
                                        <a href="{{ route('tramites_y_servicios.show', $request->id) }}"
                                            class="btn btn-link btn-sm">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif


        <div @if ($mode === 1 && $title === '' && $dependency_name === '') class="col-md-6" @else class="col-md-12" @endif>

            @if ($mode === 1)
                <h3 class="mb-3">Trámites en línea</h3>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            @if ($mode === 0)
                                <th>Popular</th>
                            @endif
                            <th>Título</th>
                            <th>Dependencia</th>
                            @if ($mode === 0)
                                <th>Descripción</th>
                                <th>Requisitos</th>
                                <th>Costo</th>
                                <th>Archivos</th>
                            @endif
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            <tr>
                                @if ($mode === 0)
                                    <td>
                                        <button wire:click="toggleFavorite({{ $request->id }})"
                                            class="btn btn-sm btn-link">
                                            @if ($request->is_favorite)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        </button>
                                    </td>
                                @endif

                                <td>{{ $request->name }}</td>
                                <td>{{ $request->dependency_name }}</td>

                                @if ($mode === 0)
                                    <td>
                                        @if ($request->description)
                                            {{ Str::limit($request->description, 100) }}
                                        @else
                                            <span class="text-muted">Sin descripción</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($request->requirements)
                                            {{ Str::limit($request->requirements, 80) }}
                                        @else
                                            <span class="text-muted">Sin requisitos</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($request->cost)
                                            ${{ number_format($request->cost, 2) }}
                                        @else
                                            <span class="text-muted">Sin costo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @if ($request->steps_filename)
                                                <a href="{{ $request->steps_filename }}" target="_blank"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-file-alt"></i> Pasos
                                                </a>
                                            @endif
                                            @if ($request->procedure_filename)
                                                <a href="{{ $request->procedure_filename }}" target="_blank"
                                                    class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-file-pdf"></i> Procedimiento
                                                </a>
                                            @endif
                                            @if (!$request->steps_filename && !$request->procedure_filename)
                                                <span class="text-muted small">Sin archivos</span>
                                            @endif
                                        </div>
                                    </td>
                                @endif

                                @if ($mode == 0)
                                    <td>
                                        <a href="{{ route('institucional_development.requests.show', $request->id) }}"
                                            class="btn btn-link btn-sm">Ver</a>
                                        <a href="{{ route('institucional_development.requests.edit', $request->id) }}"
                                            class="btn btn-link btn-sm">Editar</a>

                                        <form method="POST"
                                            action="{{ route('institucional_development.requests.destroy', $request->id) }}"
                                            style="display: inline-block;">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class='bx bx-trash-alt text-danger'></i> Eliminar
                                            </button>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                @else
                                    <td>
                                        <a href="{{ route('tramites_y_servicios.show', $request->id) }}"
                                            class="btn btn-link btn-sm">Ver</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
