<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($income != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver ingreso</h2>
                            @break

                            @case(2)
                                <h2>Editar ingreso</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nuevo ingreso</h2>
                    @endif
                </div>
            </div>
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="type" class="col-form-label">Fuente de Ingreso</label>
                            </div>
                            <div class="col-md">
                                <select name="type" id="type" wire:model="type"
                                    @if ($mode == 1) disabled @endif class="form-control">
                                    <option>Seleccionar una opción</option>
                                    <option value="Ventas">Ventas</option>
                                    <option value="Asistencia social">Asistencia social</option>
                                    <option value="Talleres">Talleres</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if ($mode == 1)
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="created_at" class="col-form-label">Fecha de Ingreso</label>
                                </div>
                                <div class="col-md">
                                    <input type="date" name="created_at"
                                        value="{{ $income->created_at->format('Y-m-d') }}" class="form-control"
                                        disabled>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="ammount" class="col-form-label">Monto de Ingreso</label>
                            </div>
                            <div class="col-md">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" aria-label="Monto" name="ammount"
                                        wire:model="ammount" @if ($mode == 1) disabled @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="payment_method" class="col-form-label">Método de pago</label>
                            </div>
                            <div class="col-md">
                                <select name="payment_method" id="payment_method" wire:model="payment_method"
                                    @if ($mode == 1) disabled @endif class="form-control">
                                    <option>Seleccionar una opción</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Depósito">Depósito</option>
                                    <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                                    <option value="Tarjeta de débito">Tarjeta de débito</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="client" class="col-form-label">Cliente o Entidad</label>
                    </div>
                    <div class="col-md">
                        <input type="text" class="form-control mb-0" name="client" wire:model="client"
                            placeholder="Nombre Completo" @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="concept" class="col-form-label">Concepto</label>
                    </div>
                    <div class="col-md">
                        <input type="text" class="form-control mb-0" name="concept" wire:model="concept"
                            placeholder="Nombre Completo" @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('dif.incomes.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>
                    @if ($mode != 1)
                        <button type="submit" style="max-width: 110px" class="btn btn-dark btn-sm">Guardar
                            datos</button>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>
