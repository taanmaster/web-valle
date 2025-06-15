<div>

    @push('stylesheets')
        <style>
            .btn-step {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .btn-step .num {
                padding: 6px 12px;
                border-radius: 6px;
                border: 1px solid rgb(201, 201, 201);
                background: white;
                color: black;
            }

            .btn-step:hover {
                cursor: pointer;
            }

            .btn-step.active {
                font-weight: 600;
            }

            .btn-step.active .num {
                color: white;
                background: rgb(26, 125, 218);
                border-color: rgb(26, 125, 218);
            }
        </style>
    @endpush

    <div class="row m-3 align-items-center">
        <div class="col">
            <h3>Recibo de pago</h3>
        </div>
        <div class="col-md-4">
            <label for="date">Fecha</label>
            <input type="date" disabled wire:model="created_date" name="created_date" class="form-control">
        </div>
    </div>

    <div class="d-flex mx-3 my-4" style="gap: 32px">
        <div wire:click="changeStep('1')" class="btn-step @if ($step == 1) active @endif">
            <div class="num">1</div>
            Información general
        </div>

        <div wire:click="changeStep('2')" class="btn-step @if ($step == 2) active @endif">
            <div class="num">2</div>
            Ingresos
        </div>

        <div wire:click="changeStep('3')" class="btn-step @if ($step == 3) active @endif">
            <div class="num">3</div>
            Comprobación de Ingreso
        </div>
    </div>

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <!-- Paso 1 -->
        @if ($step == 1)
            <div class="row m-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-2">
                            <label for="cashier_user" class="col-form-label">Usuario de Caja</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" wire:model="cashier_user">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-2">
                            <label for="cashier" class="col-form-label">Caja</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" wire:model="cashier">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-4">
                            <label for="qty_text" class="col-form-label">Ingreso</label>
                        </div>
                        <div class="col">
                            <input type="text" name="qty_text" wire:model="qty_text" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="number" name="qty_integer" wire:model="qty_integer" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="row justify-content-end m-3">
                <button type="button" wire:click="changeStep('2')" class="btn btn-outline-secondary btn-sm"
                    style="width: fit-content">Siguiente</button>
            </div>
        @endif

        <!-- Paso 2 -->
        @if ($step == 2)
            <div class="row m-3">
                <div class="col-2">
                    <label for="">Ingreso en efectivo</label>
                </div>
                <div class="col-4 d-flex align-items-center" style="gap: 12px">

                    @if ($total_value > 0)
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" wire:model="total_value" class="form-control" disabled>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Editar
                        </button>
                    @else
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Agregar Ingreso
                        </button>
                    @endif
                </div>
            </div>

            <div class="row m-3">
                <div class="col-2">
                    <label for="">Ingreso en tarjeta</label>
                </div>
                <div class="col-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="number" name="total_card" wire:model="total_card" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="row m-3">
                <div class="col-2">
                    <label for="">Ingreso en vouchers</label>
                </div>
                <div class="col-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="number" name="total_check" wire:model="total_check" class="form-control"
                            required>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between m-3">
                <button type="button" wire:click="changeStep('1')" class="btn btn-outline-secondary btn-sm"
                    style="width: fit-content">Anterior</button>
                <button type="button" wire:click="changeStep('3')" class="btn btn-outline-secondary btn-sm"
                    style="width: fit-content">Siguiente</button>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ingreso en efectivo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @foreach ($denominaciones as $valor => $cantidad)
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="denominaciones.{{ $valor }}" class="mb-2">Cantidad de
                                            ${{ number_format($valor, 2) }}:</label>
                                        <input type="number" wire:model.defer="denominaciones.{{ $valor }}"
                                            id="denominaciones.{{ $valor }}" min="0" value="0"
                                            class="form-control">
                                    </div>
                                @endforeach
                            </div>

                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label for="">Firma y Nombre de cajera</label>
                                    <input type="text" wire:model="denominations_cashier" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Firma y Nombre de depositante</label>
                                    <input type="text" wire:model="denominations_payed" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" wire:click="calcularTotal"
                                data-bs-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Paso 3 -->
        @if ($step == 3)
            <div class="row m-3">
                <h4 class="mb-4">Comprobación de ingreso</h4>
                <div class="col-md-6">
                    <label for="" class="">Ingreso a cuenta</label>
                    <input type="text" class="form-control" wire:model="account">
                </div>

                @if ($mode != 0)
                    <div class="col-md-6">
                        <label for="">Total Ingreso</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="number" name="total" wire:model="total" class="form-control" required>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row justify-content-between m-3">
                <button type="button" wire:click="changeStep('2')" class="btn btn-outline-secondary btn-sm"
                    style="width: fit-content">Anterior</button>
                <button type="submit" class="btn btn-primary btn-sm" style="width: fit-content">Guardar</button>
            </div>
        @endif
    </form>
</div>
