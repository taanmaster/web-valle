<div>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-calendar-day fa-2x text-primary"></i>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">
                        <i class="fas fa-chart-bar text-primary me-2"></i> Reporte Diario de Caja
                    </h3>
                    <p class="text-muted mb-0">
                        <i class="fas fa-clipboard-list me-1"></i>
                        Filtra por caja, cajero, dependencia y concepto para exportar corte diario en PDF o Excel.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>Configura los filtros y después exporta el reporte diario en el formato que necesites.</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row g-3 align-items-end">
                    <div class="col-lg-2">
                        <label class="form-label fw-semibold">No. de caja:</label>
                        <select name="cashier" wire:model.change="cashier" class="form-select">
                            @foreach ($cashiers as $cashier)
                                <option value="{{ $cashier }}">{{ $cashier }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label fw-semibold">Cajero:</label>
                        <select name="cashier_user" id="cashier_user" class="form-select" wire:model.change="cashier_user">
                            @foreach ($userCashiers as $user)
                                <option value="{{ $user }}">{{ $user }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Dependencia:</label>
                        <select name="dependency_name" class="form-select" wire:model.change="dependency_name">
                            <option value="">Todas</option>
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency }}">{{ $dependency }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Concepto:</label>
                        <select name="concept" class="form-select" wire:model.change="concept">
                            <option value="">Todos</option>
                            @foreach ($concepts as $concept)
                                <option value="{{ $concept }}">{{ $concept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 text-end">
                        <button class="btn btn-outline-secondary btn-sm me-2" type="submit">Exportar PDF</button>
                        <button class="btn btn-success btn-sm" type="button" wire:click="exportExcel">Exportar Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @foreach ($incomes as $concepto => $incomes)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0 fw-semibold">{{ $concepto }}</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Concepto de cobro</th>
                                <th class="fw-semibold">Importe</th>
                                <th class="fw-semibold">Descuento</th>
                                <th class="fw-semibold">Ingreso</th>
                            </tr>
                        </thead>
                        <tbody>

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
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay resultados para este concepto.</td>
                        </tr>
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
            </div>
        </div>
    @endforeach
</div>
