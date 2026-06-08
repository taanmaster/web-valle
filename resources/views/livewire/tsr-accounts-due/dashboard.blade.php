<div>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-chart-line fa-2x text-primary"></i>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">
                        <i class="fas fa-coins text-primary me-2"></i> Dashboard de Cuentas por Cobrar
                    </h3>
                    <p class="text-muted mb-0">
                        <i class="fas fa-clipboard-list me-1"></i>
                        Revisa indicadores, actividad de cobro y movimientos recientes del módulo.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>
                Ajusta el rango de fechas para actualizar gráficas y totales del periodo que deseas analizar.
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Fecha desde:</label>
                    <input type="date" class="form-control" wire:model.live="start_date">
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Fecha hasta:</label>
                    <input type="date" class="form-control" wire:model.live="end_date">
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light border-0">
                    <h4 class="card-title">Estados de cuenta</h4>
                </div>
                <div class="card-body">
                    <canvas id="lineChart" width="1809" height="600"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light border-0">
                    <h4 class="card-title">Ingresos</h4>
                </div>
                <div class="card-body">
                    <canvas id="barChart" class="h-100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-center">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-primary mb-1">{{ $activeAccounts }}</h2>
                    <small class="text-muted">Cuentas activas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-warning mb-1">--</h2>
                    <small class="text-muted">Contribuyentes con adeudo</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <h2 class="fw-bold text-success mb-1">${{ number_format($total, 2) }}</h2>
                    <small class="text-muted">Monto total</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <h4 class="fw-bold text-danger mb-1">--</h4>
                            <small class="text-muted">Vencido</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <h4 class="fw-bold text-warning mb-1">--</h4>
                            <small class="text-muted">Próx. vencer</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <h4 class="fw-bold text-success mb-1">--</h4>
                            <small class="text-muted">Cobrado</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="row mb-3 justify-content-between align-items-center">
                    <div class="col-md-4">
                        <select name="selectDependency" id="selectDependency" wire:model.live="selectDependency"
                            class="form-select">
                            <option value="">Todas las dependencias</option>
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency->name }}">{{ $dependency->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select name="selectConcept" id="selectConcept" wire:model.live="selectConcept"
                            class="form-select">
                            <option value="">Todos los conceptos</option>
                            @foreach ($concepts as $concept)
                                <option value="{{ $concept }}">{{ $concept }}</option>
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
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Folio</th>
                                <th class="fw-semibold">Fecha</th>
                                <th class="fw-semibold">Monto</th>
                                <th class="fw-semibold">Nombre de contribuyente</th>
                                <th class="fw-semibold">Concepto de cobro</th>
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
            <div class="card border-0 shadow-sm p-3 h-100">
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
                    <table class="table table-hover align-middle">
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
            <div class="card border-0 shadow-sm p-3">
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
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Folio</th>
                                <th class="fw-semibold">Fecha</th>
                                <th class="fw-semibold">Monto</th>
                                <th class="fw-semibold">Nombre de contribuyente</th>
                                <th class="fw-semibold">Concepto de cobro</th>
                                <th class="fw-semibold">Medio de pago</th>
                                <th class="fw-semibold">Asignación</th>
                                <th class="fw-semibold">Recibido por</th>
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
                                            <p>Cheque</p>
                                        @endif
                                        @if (($income->total_transfer ?? 0) > 0)
                                            <p>Transferencia</p>
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
