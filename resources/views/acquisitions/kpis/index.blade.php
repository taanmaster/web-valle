@extends('layouts.master')

@section('title')Indicadores de Adquisiciones @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
    @slot('li_1') Intranet @endslot
    @slot('li_2') Adquisiciones @endslot
    @slot('title') Indicadores @endslot
    @endcomponent

    <div class="bg-light p-3 p-lg-4 rounded">
        <!-- Filtro de Fechas -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('acquisitions.kpis.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt text-primary me-1"></i> Fecha Inicio
                        </label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ $startDate }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt text-primary me-1"></i> Fecha Final
                        </label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ $endDate }}" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Filtrar Indicadores
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Columna Izquierda - Proveedores -->
            <div class="col-lg-6">
                <!-- Total Proveedores -->
                <div class="card shadow-sm mb-3 bg-white">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Total Proveedores</div>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalProveedores }}</h2>
                    </div>
                </div>

                <!-- Padrones -->
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Padrones Reactivados</div>
                                <h4 class="fw-bold text-warning mb-0">{{ $padronesReactivados }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Padrones próximos a vencer</div>
                                <h4 class="fw-bold text-warning mb-0">{{ $padronesProximosVencer }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tiempo Promedio -->
                <div class="card bg-light border mb-3">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Tiempo promedio de solicitud a Padrón activo</div>
                        <h4 class="fw-bold text-primary mb-0">{{ $tiempoPromedioActivacion }} Días</h4>
                    </div>
                </div>

                <!-- Estados de Alta -->
                <div class="row g-3 mb-3">
                    <div class="col-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Solicitud</div>
                                <h4 class="fw-bold text-secondary mb-0">{{ $altaSolicitud }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Validación</div>
                                <h4 class="fw-bold text-info mb-0">{{ $altaValidacion }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Aprobación</div>
                                <h4 class="fw-bold text-primary mb-0">{{ $altaAprobacion }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Pago Pendiente</div>
                                <h4 class="fw-bold text-warning mb-0">{{ $altaPagoPendiente }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Padrón Activo</div>
                                <h4 class="fw-bold text-success mb-0">{{ $altaPadronActivo }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Padrón Inactivo</div>
                                <h4 class="fw-bold text-danger mb-0">{{ $altaPadronInactivo }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha - Licitaciones -->
            <div class="col-lg-6">
                <!-- Total Licitaciones -->
                <div class="card shadow-sm mb-3 bg-white">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Total Licitaciones</div>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalLicitaciones }}</h2>
                    </div>
                </div>

                <!-- Estados de Licitaciones -->
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Contratos Cerrados</div>
                                <h4 class="fw-bold text-success mb-0">{{ $contratosCerrados }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Licitaciones Adjudicadas</div>
                                <h4 class="fw-bold text-warning mb-0">{{ $licitacionesAdjudicadas }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Licitaciones con Contrato</div>
                                <h4 class="fw-bold text-primary mb-0">{{ $licitacionesConContrato }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Contratos en Entregables</div>
                                <h4 class="fw-bold text-info mb-0">{{ $contratosEntregables }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tiempo Promedio -->
                <div class="card bg-light border mb-3">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Tiempo promedio de cierre</div>
                        <h4 class="fw-bold text-primary mb-0">{{ $tiempoPromedioCierre }} Días</h4>
                    </div>
                </div>

                <!-- Licitaciones Nuevas -->
                <div class="card bg-light border mb-3">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Licitaciones Nuevas</div>
                        <h4 class="fw-bold text-secondary mb-0">{{ $licitacionesNuevas }}</h4>
                    </div>
                </div>

                <!-- Licitaciones por Dependencia -->
                <div class="card bg-light border mb-3">
                    <div class="card-body" style="min-height: 320px;">
                        <h6 class="fw-semibold text-secondary border-bottom pb-2 mb-3">Licitaciones por dependencia</h6>
                        @if($licitacionesPorDependencia->count() > 0)
                            <div class="text-center mb-3">
                                @foreach($licitacionesPorDependencia as $index => $item)
                                    @php
                                        $badgeColors = ['primary', 'info', 'success', 'warning'];
                                        $badgeClass = $badgeColors[$index % 4];
                                        $shortDependency = \Str::limit($item->dependency_name, 20);
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }} bg-opacity-25 text-{{ $badgeClass }} m-1 px-3 py-2" 
                                          title="{{ $item->dependency_name }}">
                                        {{ $shortDependency }}: <strong>{{ $item->total }}</strong>
                                    </span>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <canvas id="dependenciasChart" style="max-width: 250px; max-height: 250px;"></canvas>
                            </div>
                        @else
                            <div class="py-5 text-muted text-center">
                                <i class="fas fa-chart-pie fa-3x opacity-25 mb-3 d-block"></i>
                                <p class="mb-0">No hay licitaciones asignadas a dependencias en este período</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Chart.js -->
    <script src="{{ asset('assets/plugins/chartjs/chart.js') }}"></script>
    
    <script>
        // Validación de fechas
        document.getElementById('start_date').addEventListener('change', function() {
            document.getElementById('end_date').min = this.value;
        });
        
        document.getElementById('end_date').addEventListener('change', function() {
            document.getElementById('start_date').max = this.value;
        });

        // Colores para los gráficos (Bootstrap 5 colors)
        const chartColors = [
            'rgba(13, 110, 253, 0.8)',   // primary
            'rgba(13, 202, 240, 0.8)',   // info
            'rgba(25, 135, 84, 0.8)',    // success
            'rgba(255, 193, 7, 0.8)',    // warning
            'rgba(220, 53, 69, 0.8)',    // danger
            'rgba(108, 117, 125, 0.8)',  // secondary
            'rgba(102, 16, 242, 0.8)',   // indigo
            'rgba(214, 51, 132, 0.8)',   // pink
        ];

        const chartBorderColors = [
            'rgba(13, 110, 253, 1)',
            'rgba(13, 202, 240, 1)',
            'rgba(25, 135, 84, 1)',
            'rgba(255, 193, 7, 1)',
            'rgba(220, 53, 69, 1)',
            'rgba(108, 117, 125, 1)',
            'rgba(102, 16, 242, 1)',
            'rgba(214, 51, 132, 1)',
        ];

        @if($licitacionesPorDependencia->count() > 0)
        // Gráfico de Licitaciones por Dependencia
        const dependenciasCtx = document.getElementById('dependenciasChart');
        if (dependenciasCtx) {
            const dependenciasData = {
                labels: {!! json_encode($licitacionesPorDependencia->pluck('dependency_name')->map(function($dep) {
                    return \Str::limit($dep, 30);
                })) !!},
                datasets: [{
                    data: {!! json_encode($licitacionesPorDependencia->pluck('total')) !!},
                    backgroundColor: chartColors.slice(0, {{ $licitacionesPorDependencia->count() }}),
                    borderColor: chartBorderColors.slice(0, {{ $licitacionesPorDependencia->count() }}),
                    borderWidth: 2
                }]
            };

            new Chart(dependenciasCtx, {
                type: 'pie',
                data: dependenciasData,
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
        @endif
    </script>
@endpush
