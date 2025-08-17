<div>
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

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Dependencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->dependency_name }}</td>

                        @if ($mode == 0)
                            <td>
                                <a href="{{ route('institucional_development.requests.show', $request->id) }}"
                                    class="btn btn-link btn-sm">Ver</a>
                                <a href="{{ route('institucional_development.requests.edit', $request->id) }}"
                                    class="btn btn-link btn-sm">Editar</a>
                                <button class="btn btn-danger btn-sm"
                                    wire:click="confirmDelete({{ $request->id }})">Eliminar</button>
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
