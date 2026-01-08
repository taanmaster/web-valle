<div>
    @if ($mode != 0)
        <div class="row justify-content-end mb-4">
            <div class="col-md-2 d-inline-block">
                <input type="text" wire:model="sku" class="form-control disabled" disabled>
            </div>
        </div>
    @endif
    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Información</h4>
                    </div>
                    <div class="row card-body">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Nombre <span
                                    class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required
                                wire:model="title" @if ($mode == 1) disabled @endif>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span
                                    class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                @if ($mode == 1) disabled @endif wire:model="description"></textarea>
                        </div>

                    </div>
                </div>
                @if ($mode == 1)
                    <div class="card">
                        <div class="card-header">
                            <h4>Inventario</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Cantidad</h5>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled wire:model="current_stock">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                @if ($mode != 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Estado</h4>
                            <div class="card-body">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            wire:model="is_active" @if ($mode == 1) disabled @endif
                                            @if ($material != null && $material->is_active == 1) checked @endif>
                                        <label class="form-check-label" for="is_active">Activo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Organización</h4>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="category" class="form-label">Categoría <span
                                        class="text-danger tx-12">*</span></label>
                                <select name="category" id="category" wire:model="category" class="form-control"
                                    required @if ($mode == 1) disabled @endif>
                                    <option selected>Selecciona una opción</option>
                                    <option value="Material">Material</option>
                                    <option value="Servicio">Servicio</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dependency_name" class="form-label">Dependencia <span
                                        class="text-danger tx-12">*</span></label>
                                <select name="dependency_name" id="dependency_name" wire:model="dependency_name"
                                    class="form-control" required @if ($mode == 1) disabled @endif>
                                    <option selected>Selecciona una opción</option>
                                    @foreach ($dependencies as $dependency)
                                        <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($mode == 1)
            <div class="row my-4">

                <div class="d-flex justify-content-between mb-3">
                    <h5 class="mb-0">Movimiento de inventario</h5>
                    <a href="{{ route('acquisitions.inventory.create', $material->id) }}" class="btn btn-primary btn-sm"
                        style="max-width: fit-content">Registrar
                        Movimiento</a>
                </div>

                @if ($material->movementItems->count() != null)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Movimiento</th>
                                    <th>Cantidad</th>
                                    <th>Proveedor</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($material->movementItems as $movement)
                                    <tr>
                                        <td>{{ $movement->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $movement->movement->type }}</td>
                                        <td>
                                            @if ($movement->movement->type == 'Entrada')
                                                +
                                            @else
                                                -
                                            @endif
                                            {{ $movement->quantity }}
                                        </td>
                                        <td>{{ $movement->movement->supplier->owner_name }}</td>
                                        <td>
                                            <a href="{{ route('acquisitions.inventory.show', $movement->id) }}"
                                                class="btn btn-secondary btn-sm">
                                                Ver movimiento
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif

        <div class="row">
            <div class="col-12 text-end">
                @switch($mode)
                    @case(0)
                        <button type="submit" class="btn btn-dark btn-sm">Guardar</button>
                    @break

                    @case(2)
                        <button type="submit" class="btn btn-dark btn-sm">Guardar</button>
                    @break
                @endswitch
                <a href="{{ route('acquisitions.materials.index') }}" class="btn btn-secondary btn-sm">Regresar</a>
            </div>
        </div>
    </form>
</div>
