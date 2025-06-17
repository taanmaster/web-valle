<div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="">Rango de fechas</label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" wire:model.live="start_date">
                <span class="input-group-text">a</span>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>
    </div>



    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-title">Estados de cuenta</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <canvas id="lineChart" width="1809" height="600"></canvas>
                </div><!--end card-body-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-title">Ingresos</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <canvas id="barChart" style="height: 100%"></canvas>
                </div><!--end card-body-->
            </div>
        </div>
    </div>

    <div class="row align-items-center">
        <div class="col-md-3">
            <div class="card text-center">
                <h2>{{ $activeAccounts }}</h2>
                <h4>Cuentas activas</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <h2>--</h2>
                <h4>Contribuyentes con adeudo</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <h2>${{ number_format($total, 2) }}</h2>
                <h4>Monto en total</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <h4>--</h4>
                        <h6>Vencido</h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <h4>--</h4>
                        <h6>Próx. Vencer</h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <h4>--</h4>
                        <h6>Cobrado</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card p-3 h-100">
                <div class="row mb-3 justify-content-between align-items-center">
                    <div class="col-md-4">
                        <select name="selectDependency" id="selectDependency" wire:model.live="selectDependency"
                            class="form-select">
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3 text-end">
                        <a href="{{ route('account_due_incomes.index') }}" class="btn btn-link btn-sm">
                            Ver todos
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Nombre de contribuyente</th>
                                <th>Concepto de cobro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ingresos as $ingreso)
                                <tr>
                                    <td>{{ $ingreso->id }}</td>
                                    <td>{{ $ingreso->created_at->format('d/m/Y') }}</td>
                                    @php
                                        $monto = (int) $ingreso->qty_integer; // Conversión de string a int
                                    @endphp
                                    <td>{{ number_format($monto, 2) }}</td>
                                    <td>{{ $ingreso->name }}</td>
                                    <td>{{ $ingreso->concept }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <div class="row mb-3 justify-content-between align-items-center">
                    <div class="col-md-3">
                        <h4>Actividad</h4>
                    </div>

                    <div class="col-3 text-end">
                        <a href="{{ route('account_due_income_receipts.index') }}" class="btn btn-link btn-sm">
                            Ver todos
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tbody>
                            @foreach ($incomes as $income)
                                <tr>
                                    <td>{{ $income->cashier_user }} creo un recibo por cobrar</td>
                                    <td>{{ $income->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="row mb-3 justify-content-between align-items-center">
                    <div class="col-md-3">
                        <h4>Ingresos</h4>
                    </div>

                    <div class="col-3 text-end">
                        <a href="{{ route('account_due_provisional_integers.index') }}" class="btn btn-link btn-sm">
                            Ver todos
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Nombre de contribuyente</th>
                                <th>Concepto de cobro</th>
                                <th>Medio de pago</th>
                                <th>Asignación</th>
                                <th>Recibido por</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomes as $income)
                                <tr>
                                    <td>{{ $income->id }}</td>
                                    <td>{{ $income->created_at->format('d/m/Y') }}</td>
                                    @php
                                        $monto = (int) $income->qty_integer; // Conversión de string a int
                                    @endphp
                                    <td>{{ number_format($monto, 2) }}</td>
                                    <td>{{ $income->income->name }}</td>
                                    <td>{{ $income->income->concept }}</td>
                                    <td>
                                        @if ($income->total_cash > 0)
                                            <p>Efectivo</p>
                                        @endif
                                        @if ($income->total_card > 0)
                                            <p>Tarjeta</p>
                                        @endif
                                        @if ($income->total_check > 0)
                                            <p>Voucher</p>
                                        @endif
                                    </td>
                                    <td>{{ $income->income->department }}</td>
                                    <td>{{ $income->cashier }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



        <script>
            const ctx = document.getElementById('lineChart');

            var dataFromPHP = <?php echo $jsonData; ?>;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: '{{ implode(', ', $weekDays) }}',
                    datasets: [{
                        label: 'Estados de cuenta',
                        data: [],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ct = document.getElementById('barChart');

            new Chart(ct, {
                type: 'bar',
                data: {
                    datasets: [{
                        label: 'Ingresos de cobro por día',
                        data: dataFromPHP // Usar los datos desde PHP
                    }],
                    labels: dataFromPHP.map(item => item.x) // Extraer las etiquetas (días)
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush


</div>
