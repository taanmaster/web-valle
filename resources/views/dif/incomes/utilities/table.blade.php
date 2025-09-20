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
            <label for="">Fuente de Ingreso</label>
            <select name="type" id="type" wire:model.live="type" class="form-control mb-3">
                <option>Seleccionar una opción</option>
                <option value="Entrega ciudadano">Entrega ciudadano</option>
                <option value="Venta">Venta</option>
                <option value="Donación externa">Donación externa</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="">Método de Pago</label>
            <select name="payment_method" id="payment_method" wire:model.live="payment_method"
                class="form-control mb-3">
                <option>Seleccionar una opción</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Transferencia">Transferencia</option>
                <option value="Depósito">Depósito</option>
                <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                <option value="Tarjeta de débito">Tarjeta de débito</option>
            </select>
        </div>

        @if ($start_date != null or $end_date != null or $type != null or $payment_method != null)
            <div class="col-md-2">
                <button wire:click="resetFilters" class="btn btn-secondary">Limpiar filtros</button>
            </div>
        @endif
        <div class="col-md">
            <label for="" class="form-label">Total de Ingreso</label>
            <h5 class="m-0">$ {{ number_format($total_ammount, 2) }}</h5>
        </div>

    </div>

    @if ($incomes->count() == 0)
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
                            <th>Fuente de ingreso</th>
                            <th>Método de pago</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incomes as $income)
                            <tr>
                                <td>{{ $income->type }}</td>
                                <td>{{ $income->payment_method }}</td>
                                <td>{{ $income->concept }}</td>
                                <td>$ {{ number_format($income->ammount, 2) }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('dif.incomes.show', $income->id) }}"
                                            class="btn btn-sm btn-outline-secondary"><i class='bx bx-edit'></i>
                                            Ver</a>
                                        <a href="{{ route('dif.incomes.edit', $income->id) }}"
                                            class="btn btn-sm btn-outline-secondary"><i class='bx bx-edit'></i>
                                            Editar</a>
                                        <form method="POST" action="{{ route('dif.incomes.destroy', $income->id) }}"
                                            style="display: inline-block;">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class='bx bx-trash-alt text-danger'></i> Eliminar
                                            </button>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="align-items-center mt-4">
            {{ $incomes->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
