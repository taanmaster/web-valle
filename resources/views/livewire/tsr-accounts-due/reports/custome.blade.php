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

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-chart-pie fa-2x text-primary"></i>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">
                        <i class="fas fa-file-export text-primary me-2"></i> Reporte Personalizado de Caja
                    </h3>
                    <p class="text-muted mb-0">
                        <i class="fas fa-clipboard-list me-1"></i>
                        Construye reportes por fecha, caja, dependencia, método de pago y cuenta bancaria.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>Selecciona uno o varios métodos de pago y exporta para obtener un corte específico de operación.</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row g-3 mb-3">
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
                        <select name="dependency_name" wire:model.change="dependency_name" class="form-select">
                            <option value="">Todas</option>
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency }}">{{ $dependency }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Concepto:</label>
                        <select name="concept" wire:model.change="concept" class="form-select">
                            <option value="">Todos</option>
                            @foreach ($concepts as $concept)
                                <option value="{{ $concept }}">{{ $concept }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 align-items-end">
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Fecha desde:</label>
                        <input type="date" class="form-control" wire:model.live="start_date">
                    </div>

                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Fecha hasta:</label>
                        <input type="date" class="form-control" wire:model.live="end_date">
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label fw-semibold">Cuenta bancaria:</label>
                        <select name="account" id="account" wire:model.change="account" class="form-select">
                            @foreach ($bankAccounts as $account)
                                <option value="{{ $account }}">{{ $account }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 position-relative">
                        <label class="form-label fw-semibold">Método de pago:</label>
                        <div class="form-control d-flex align-items-center gap-2" wire:click="showDrop = true">
                            @foreach ($selectedMethods as $method)
                                <span class="badge bg-primary">{{ $method }}</span>
                            @endforeach
                        </div>

                        <div class="position-absolute drop-search p-3" wire:show="showDrop">
                            <button type="button" wire:click="selectMethod('Tarjeta')"
                                class="btn mb-2 {{ in_array('Tarjeta', $selectedMethods) ? 'btn-primary' : 'btn-link' }}">
                                Tarjeta
                            </button>
                            <button type="button" wire:click="selectMethod('Cheque')"
                                class="btn mb-2 {{ in_array('Cheque', $selectedMethods) ? 'btn-primary' : 'btn-link' }}">
                                Cheque
                            </button>
                            <button type="button" wire:click="selectMethod('Efectivo')"
                                class="btn mb-2 {{ in_array('Efectivo', $selectedMethods) ? 'btn-primary' : 'btn-link' }}">
                                Efectivo
                            </button>
                            <button type="button" wire:click="selectMethod('Transferencia')"
                                class="btn mb-2 {{ in_array('Transferencia', $selectedMethods) ? 'btn-primary' : 'btn-link' }}">
                                Transferencia
                            </button>

                        </div>
                    </div>

                    <div class="col-lg-1 text-end">
                        <button class="btn btn-outline-secondary btn-sm" type="submit">Exportar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Recibo</th>
                            <th class="fw-semibold">Fecha y hora</th>
                            <th class="fw-semibold">Contribuyente</th>
                            <th class="fw-semibold">Concepto de cobro</th>
                            <th class="fw-semibold">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_columna_1 = 0;
                        @endphp
                        @foreach ($incomes as $income)
                            <tr>
                                <td><span class="badge bg-primary">{{ $income->id }}</span></td>
                                <td>{{ $income->created_at->format('d/m/Y h:m') }}</td>
                                <td>{{ $income->income->name }}</td>
                                <td>{{ $income->income->concept }}</td>

                                @php
                                    $total_columna_1 += $income->qty_integer;
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
                            <td><strong>${{ number_format($total_columna_1, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
