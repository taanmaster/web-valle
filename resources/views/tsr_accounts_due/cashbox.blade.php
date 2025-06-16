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

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center justify-content-between mb-4">
                <div class="col text-start">
                    <a href="{{ route('account_due_incomes.index') }}" class="btn btn-primary">Añadir Ingreso</a>
                </div>


                <div class="col-2 text-end">
                    <a href="{{ route('account_due.daily') }}" class="btn btn-sm btn-secondary">Exportar reporte
                        diario</a>
                </div>
                <div class="col-2 text-end">
                    <a href="{{ route('account_due.report') }}" class="btn btn-sm btn-secondary">Exportar reporte
                        personalizado</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3">
                        <div class="card-header">
                            <h4 class="card-title">Registro de operaciones</h4>
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Folio</th>
                                            <th>Monto</th>
                                            <th>Usuario</th>
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
                    <div class="card p-3">
                        <div class="card-header">
                            <h4 class="card-title">Operaciones</h4>
                        </div><!--end card-header-->
                        <div class="card-body">
                            <canvas id="barChart" style="height: 100%"></canvas>
                        </div><!--end card-body-->
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ct = document.getElementById('barChart');

            new Chart(ct, {
                type: 'bar',
                data: {
                    labels: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    datasets: [{
                        data: [12, 19, 3, 5, 2, 3],
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
