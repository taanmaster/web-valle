<div>
    <div class="row mb-3 align-items-center">
        <div class="col-md-3">
            <label for="">Rango de fechas de creación</label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" wire:model.live="start_date">
                <span class="input-group-text">a</span>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>
        <div class="col-md-3">
            <label for="">Tipo de Salida</label>
            <select name="type" id="type" wire:model.live="type" class="form-control mb-3">
                <option>Seleccionar una opción</option>
                <option value="Entrega ciudadano">Entrega ciudadano</option>
                <option value="Venta">Venta</option>
                <option value="Donación externa">Donación externa</option>
            </select>
        </div>

        @if ($start_date != null or $end_date != null or $type != null)
            <div class="col-md-2">
                <button wire:click="resetFilters" class="btn btn-secondary">Limpiar filtros</button>
            </div>
        @endif

    </div>

    @if ($expenses->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay salidas guardadas en la base de datos!</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Tipo de Salida</th>
                            <th>Concepto</th>
                            <th>Acción</th>
                            <th>Archivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->id }}</td>
                                <td>{{ $expense->created_at->format('Y-m-d') }}</td>
                                <td>{{ $expense->type }}</td>
                                <td>{{ $expense->concept }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('dif.expenses.show', $expense->id) }}"
                                            class="btn btn-sm btn-outline-secondary"><i class='bx bx-edit'></i>
                                            Ver</a>
                                        <a href="{{ route('dif.expenses.edit', $expense->id) }}"
                                            class="btn btn-sm btn-outline-secondary"><i class='bx bx-edit'></i>
                                            Editar</a>
                                        <form method="POST" action="{{ route('dif.expenses.destroy', $expense->id) }}"
                                            style="display: inline-block;">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class='bx bx-trash-alt text-danger'></i> Eliminar
                                            </button>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-link btn-sm"
                                        wire:click="downloadFile('{{ $expense->id }}')">
                                        Descargar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="align-items-center mt-4">
            {{ $expenses->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
