@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Cuentas por cobrar
        @endslot
        @slot('title')
            Control de cajas
        @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-cash-register fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">
                                    <i class="fas fa-cash-register text-primary me-2"></i> Control de Cajas
                                </h3>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    Monitorea operaciones, registra corte diario de denominaciones y exporta reportes.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <a href="{{ route('account_due_incomes.index') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Añadir Ingreso
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-lg me-3"></i>
                <div>
                    Usa el botón de corte diario para capturar denominaciones y firma de responsables al cierre.
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-end gap-2 flex-wrap">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#dailyCutModal">
                        <i class="fas fa-calculator me-2"></i> Corte diario (denominaciones)
                    </button>
                    <a href="{{ route('account_due.daily') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-file-pdf me-2"></i> Reporte diario
                    </a>
                    <a href="{{ route('account_due.report') }}" class="btn btn-secondary">
                        <i class="fas fa-file-export me-2"></i> Reporte personalizado
                    </a>
                </div>
            </div>
        </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-lg me-3"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (!empty($latestDailyCut))
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-3"><strong>Último corte:</strong> {{ $latestDailyCut->cut_date->format('d/m/Y') }}</div>
                            <div class="col-md-3"><strong>Caja:</strong> {{ $latestDailyCut->cashier ?: 'N/A' }}</div>
                            <div class="col-md-3"><strong>Usuario:</strong> {{ $latestDailyCut->cashier_user ?: 'N/A' }}</div>
                            <div class="col-md-3"><strong>Total efectivo:</strong> $ {{ number_format($latestDailyCut->total_cash, 2) }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light border-0">
                            <h4 class="card-title">Registro de operaciones</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold">Fecha</th>
                                            <th class="fw-semibold">Folio</th>
                                            <th class="fw-semibold">Monto</th>
                                            <th class="fw-semibold">Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($receipts as $receipt)
                                            <tr>
                                                <td>{{ $receipt->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $receipt->id }}</td>
                                                <td>$ {{ number_format($receipt->total, 2) }}</td>
                                                <td>{{ $receipt->cashier_user }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light border-0">
                            <h4 class="card-title">Operaciones</h4>
                        </div>
                        <div class="card-body p-4">
                            <canvas id="barChart" class="h-100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="modal fade" id="dailyCutModal" tabindex="-1" aria-labelledby="dailyCutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form method="POST" action="{{ route('account_due.cashbox.daily_cut') }}" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="dailyCutModalLabel">Corte diario de denominaciones</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-lg me-3"></i>
                            <div>Captura la cantidad por denominación. El sistema calcula automáticamente el total de efectivo.</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Fecha de corte</label>
                            <input type="date" name="cut_date" class="form-control" value="{{ now()->format('Y-m-d') }}"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. caja</label>
                            <input type="text" name="cashier" class="form-control"
                                value="{{ old('cashier', auth()->user()->cashier ?? '') }}" placeholder="Ej. Caja 1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Usuario de caja</label>
                            <input type="text" name="cashier_user" class="form-control"
                                value="{{ old('cashier_user', auth()->user()->name ?? '') }}">
                        </div>
                    </div>

                    <div class="row">
                        @php
                            $denominations = [1000, 500, 200, 100, 50, 20, 10, 5, 2, 1, 0.5];
                        @endphp
                        @foreach ($denominations as $denomination)
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Cantidad de ${{ number_format($denomination, 2) }}</label>
                                <input type="number" name="denominations[{{ $denomination }}]" class="form-control"
                                    min="0" step="1" value="0">
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Firma y nombre de cajera</label>
                            <input type="text" name="denominations_cashier" class="form-control"
                                value="{{ old('denominations_cashier') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Firma y nombre de depositante</label>
                            <input type="text" name="denominations_payed" class="form-control"
                                value="{{ old('denominations_payed') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar corte</button>
                </div>
            </form>
        </div>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ct = document.getElementById('barChart');

            new Chart(ct, {
                type: 'bar',
                data: {
                    labels: ['Lu', 'Ma', 'Mie', 'Ju', 'Vi', 'Sa', 'Do'],
                    datasets: [{
                        label: 'Recibos',
                        data: @json($values),
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
        </script>
    @endpush
@endsection
