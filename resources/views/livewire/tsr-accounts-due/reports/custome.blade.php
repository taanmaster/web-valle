<div>
    @push('stylesheets')
        <style>
            .drop-search {
                top: 90%;
                border-radius: 12px;
                background-color: white;
                box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
                z-index: 5;
                width: 99%;
                display: flex;
                flex-direction: column;
            }

            .concept-search {
                min-height: 200px;
                max-height: 640px;
                height: fit-content;
            }

            .drop-search .btn {
                text-align: left;
            }

            .drop-search .btn:hover {
                background-color: #F2F4FF;
            }

            .accordion-button::after {
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    @endpush

    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row mb-4">
            <div class="col-md-3">
                <label for="">No. de caja</label>
                <select name="cashier" id="" wire:model.change="cashier" class="form-control">
                    @foreach ($cashiers as $cashier)
                        <option value="{{ $cashier }}">{{ $cashier }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="">Cajero</label>
                <select name="cashier_user" id="cashier_user" class="form-control" wire:model.change="cashier_user">
                    @foreach ($userCashiers as $user)
                        <option value="{{ $user }}">{{ $user }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md">
                <label for="">Rango de fechas</label>
                <div class="input-group mb-3">
                    <input type="date" class="form-control" wire:model.live="start_date">
                    <span class="input-group-text">a</span>
                    <input type="date" class="form-control" wire:model.live="end_date">
                </div>
            </div>

            <div class="col-md">
                <label for="">Cuenta bancaria</label>
                <select name="account" id="account" wire:model.change="account" class="form-control">
                    @foreach ($bankAccounts as $account)
                        <option value="{{ $account }}">{{ $account }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md position-relative">
                <label for="">Método de pago</label>
                <div class="form-control d-flex" style="height: 32px; gap:12px" wire:click="showDrop = true">
                    @foreach ($selectedMethods as $method)
                        <p>{{ $method }}</p>
                    @endforeach
                </div>

                <div class="position-absolute drop-search p-3" wire:show="showDrop">
                    <button type="button" wire:click="selectMethod('Tarjeta')"
                        class="btn mb-2 {{ in_array('Tarjeta', $selectedMethods) ? 'btn-primary' : 'btn-link' }}">
                        Tarjeta
                    </button>
                    <button type="button" wire:click="selectMethod('Voucher')"
                        class="btn mb-2 {{ in_array('Voucher', $selectedMethods) ? 'btn-primary' : 'btn-link' }}">
                        Voucher
                    </button>
                    <button type="button" wire:click="selectMethod('Efectivo')"
                        class="btn mb-2 {{ in_array('Efectivo', $selectedMethods) ? 'btn-primary' : 'btn-link' }}">
                        Efectivo
                    </button>

                </div>
            </div>

            {{--
            <div class="col-md">
                <label for="">Ordenar...</label>
                <input type="text" class="form-control" wire:model.live="bank">
            </div>
             --}}

            <div class="col-md text-end">
                <button class="btn btn-sm btn-outline-secondary" type="submit">Exportar</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Recibo</th>
                    <th>Fecha y hora</th>
                    <th>Contribuyente</th>
                    <th>Concepto de cobro</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_columna_1 = 0;
                @endphp
                @foreach ($incomes as $income)
                    <tr>
                        <td>{{ $income->id }}</td>
                        <td>{{ $income->created_at->format('d/m/Y h:m') }}</td>
                        <td>{{ $income->income->name }}</td>
                        <td>{{ $income->income->concept }}</td>

                        @php
                            $total_columna_1 += $income->qty_integer; // Sumar a la primera columna
                        @endphp

                        <td>$ {{ number_format($income->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Total de la página:</strong></td>
                    <td>
                        ${{ number_format($total_columna_1, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
