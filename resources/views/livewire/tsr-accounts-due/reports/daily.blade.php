<div>
    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row mb-4 align-items-center">
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

            <div class="col text-end">
                <button class="btn btn-sm btn-outline-secondary" type="submit">Exportar</button>
            </div>
        </div>
    </form>

    @foreach ($incomes as $concepto => $incomes)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Concepto de cobro</th>
                        <th>Importe</th>
                        <th>Descuento</th>
                        <th>Ingreso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h4>
                                {{ $concepto }}
                            </h4>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @php
                        $total_columna_1 = 0; // Acumulador para la primera columna
                        $total_columna_2 = 0; // Acumulador para la segunda columna
                        $total_columna_3 = 0; // Acumulador para la tercera columna
                    @endphp

                    @forelse($incomes as $income)
                        <tr>
                            <td>
                                {{ $income->income->concept }}
                            </td>

                            @php
                                $value = (int) $income->qty_integer; // Sumar a la primera columna

                                $total_columna_1 += $value; // Sumar a la primera columna
                            @endphp

                            <td>$ {{ number_format($total_columna_1, 2) }}</td>

                            <td>N/A</td>

                            @php
                                $value2 = (int) $income->qty_integer; // Sumar a la primera columna

                                $total_columna_3 += $value2; // Sumar a la tercera columna
                            @endphp
                            <td>$ {{ number_format($total_columna_3, 2) }}</td>

                        </tr>
                    @empty
                        <li>No hay resultados para este concepto.</li>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>Total de {{ $concepto }}</strong></td>
                        <td><strong>$ {{ number_format($total_columna_1, 2) }}</strong></td>
                        <td></td>
                        <td><strong>$ {{ number_format($total_columna_3, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach
</div>
