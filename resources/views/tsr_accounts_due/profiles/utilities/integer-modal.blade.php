<div>
    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="dependency_name" class="col-form-label">Dependencia*</label>
                        <select name="dependency_name" id="dependency_name" wire:model="dependency_name" class="form-select" required @if ($integer != null) disabled @endif>
                            <option selected>Seleccionar dependencia</option>
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <div class="card pb-4 pt-3">
                            <div class="container-fluid">
                                @if ($integer != null)
                                    <div class="row mb-3">
                                        <div class="col"></div>
                                        <div class="col-md-4">
                                            <label for="code" class="col-form-label">Folio</label>
                                            <input @if ($integer != null) disabled @endif type="text" name="folio" wire:model="folio" class="form-control" disabled>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="qty_text" class="col-form-label">La cantidad de</label>
                                            </div>
                                            <div class="col">
                                                <input @if ($integer != null) disabled @endif type="text" name="qty_text" wire:model="qty_text" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input @if ($integer != null) disabled @endif type="number" name="qty_integer" wire:model="qty_integer" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-2">
                                        <label for="name" class="col-form-label">Nombre</label>
                                    </div>
                                    <div class="col">
                                        <input @if ($integer != null) disabled @endif type="text" name="name" wire:model="name" class="form-control" required disabled>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="address" class="col-form-label">Domicilio</label>
                                            </div>
                                            <div class="col">
                                                <input @if ($integer != null) disabled @endif type="text" name="address" wire:model="address" class="form-control" required disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="zipcode" class="col-form-label" >C.P</label>
                                            </div>
                                            <div class="col">
                                                <input @if ($integer != null) disabled @endif type="text" name="zipcode" wire:model="zipcode" class="form-control" required disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="basis" class="col-form-label">Con Fundamento</label>
                                    <div class="form-check">
                                        <input @if ($integer != null) disabled @endif class="form-check-input" type="radio" name="basis" wire:model="basis" id="basis1" value="Ley de Ingresos">
                                        <label class="form-check-label" for="basis1">
                                            Ley de Ingresos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input @if ($integer != null) disabled @endif class="form-check-input" type="radio" name="basis" wire:model="basis" id="basis2" value="Disposiciones Administrativas">
                                        <label class="form-check-label" for="basis1">
                                            Disposiciones Administrativas
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input @if ($integer != null) disabled @endif class="form-check-input" type="radio" name="basis" wire:model="basis" id="basis3" value="Otros">
                                        <label class="form-check-label" for="basis1">
                                            Otros
                                        </label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-2">
                                        <label for="concept" class="col-form-label">Por concepto de:</label>
                                    </div>
                                    <div class="col">
                                        <textarea name="concept" id="" wire:model="concept" class="form-control" required @if ($integer != null) disabled @endif>
                                            {{ $concept }}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-2">
                                        <label for="payment_method" class="col-form-label">Método de Pago</label>
                                    </div>
                                    <div class="col">
                                        <select name="payment_method" id="payment_method" wire:model="payment_method" class="form-select" @if ($integer != null) disabled @endif>
                                            <option selected>Seleccionar método de pago</option>
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                                            <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                                            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                                            <option value="Banco">Banco</option>
                                            <option value="Ventanilla">Ventanilla</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label for="payment_date" class="col-form-label">Valle de Santiago, Gto. A</label>
                                    </div>
                                    <div class="col-4">
                                        <input disabled type="date" name="payment_date" wire:model="payment_date" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="created_by" class="col-form-label">Elaboro</label>
                                            </div>
                                            <div class="col">
                                                <input @if ($integer != null) disabled @endif type="text" name="created_by" wire:model="created_by" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                <label for="director" class="col-form-label">Vo. Bo. Director-Jefe</label>
                                            </div>
                                            <div class="col">
                                                <input @if ($integer != null) disabled @endif type="text" name="director" wire:model="director" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($integer == null)
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        @endif
    </form>
</div>
