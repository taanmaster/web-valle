@extends('layouts.master')

@section('title')Indicadores de Desarrollo Urbano @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
    @slot('li_1') Intranet @endslot
    @slot('li_2') Desarrollo Urbano @endslot
    @slot('title') Indicadores @endslot
    @endcomponent

    <div class="bg-light p-3 p-lg-4 rounded">
        <!-- Filtro de Fechas -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('urban_dev.kpis.index') }}" class="row g-3 align-items-end">
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
            <!-- Columna Izquierda - Expedientes -->
            <div class="col-lg-6">
                <!-- Total Expedientes -->
                <div class="card shadow-sm mb-3 bg-white">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Total Expedientes</div>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalExpedientes }}</h2>
                    </div>
                </div>

                <!-- Estados de Expedientes -->
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Expedientes Abiertos</div>
                                <h4 class="fw-bold text-primary mb-0">{{ $expedientesAbiertos }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Expedientes Cancelados</div>
                                <h4 class="fw-bold text-danger mb-0">{{ $expedientesCancelados }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Expedientes a Corrección</div>
                                <h4 class="fw-bold text-warning mb-0">{{ $expedientesEnCorreccion }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Expedientes a Cerrados</div>
                                <h4 class="fw-bold text-success mb-0">{{ $expedientesCerrados }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tipos de Licencias -->
                <div class="card bg-light border mb-3">
                    <div class="card-body">
                        <h6 class="fw-semibold text-secondary border-bottom pb-2 mb-3">Tipos de Expediente</h6>
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                                    <span class="text-dark">Licencia de Uso de Suelo</span>
                                    <span class="fs-5 fw-bold text-primary ms-3">{{ $licenciaUsoSuelo }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                                    <span class="text-dark">Constancia de factibilidad</span>
                                    <span class="fs-5 fw-bold text-primary ms-3">{{ $constanciaFactibilidad }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                                    <span class="text-dark">Permiso de anuncios y toldos</span>
                                    <span class="fs-5 fw-bold text-primary ms-3">{{ $permisoAnuncios }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                                    <span class="text-dark">Constancia de alineamiento</span>
                                    <span class="fs-5 fw-bold text-primary ms-3">{{ $constanciaAlineamiento }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                                    <span class="text-dark">Permiso de División</span>
                                    <span class="fs-5 fw-bold text-primary ms-3">{{ $permisoDivision }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                                    <span class="text-dark">Uso de Vía Pública</span>
                                    <span class="fs-5 fw-bold text-primary ms-3">{{ $usoViaPublica }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                                    <span class="text-dark">Licencia de Construcción</span>
                                    <span class="fs-5 fw-bold text-primary ms-3">{{ $licenciaConstruccion }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                                    <span class="text-dark">Permiso de Construcción en Panteones</span>
                                    <span class="fs-5 fw-bold text-primary ms-3">{{ $permisoConstruccionPanteones }}</span>
                                </div>
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

                <!-- Asignación de Expedientes -->
                <div class="card bg-light border mb-3">
                    <div class="card-body" style="min-height: 320px;">
                        <h6 class="fw-semibold text-secondary border-bottom pb-2 mb-3">Asignación de Expedientes</h6>
                        @if($expedientesPorInspector->count() > 0)
                            <div class="text-center mb-3">
                                @foreach($expedientesPorInspector as $index => $item)
                                    @php
                                        $badgeColors = ['primary', 'info', 'success', 'warning'];
                                        $badgeClass = $badgeColors[$index % 4];
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }} bg-opacity-25 text-{{ $badgeClass }} m-1 px-3 py-2">
                                        {{ $item['inspector'] }}: <strong>{{ $item['total'] }}</strong>
                                    </span>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <canvas id="expedientesChart" style="max-width: 250px; max-height: 250px;"></canvas>
                            </div>
                        @else
                            <div class="py-5 text-muted text-center">
                                <i class="fas fa-chart-pie fa-3x opacity-25 mb-3 d-block"></i>
                                <p class="mb-0">No hay expedientes asignados en este período</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Columna Derecha - Citatorios -->
            <div class="col-lg-6">
                <!-- Total Citatorios -->
                <div class="card shadow-sm mb-3 bg-white">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Total Citatorios</div>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalCitatorios }}</h2>
                    </div>
                </div>

                <!-- Estados de Citatorios -->
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Citatorios Abiertos</div>
                                <h4 class="fw-bold text-primary mb-0">{{ $citatoriosAbiertos }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Citatorios Cerrados</div>
                                <h4 class="fw-bold text-success mb-0">{{ $citatoriosCerrados }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light border">
                            <div class="card-body p-3">
                                <div class="small text-muted fw-medium mb-1">Citatorios a Suspensión</div>
                                <h4 class="fw-bold text-warning mb-0">{{ $citatoriosSuspension }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tiempo Promedio Citatorio -->
                <div class="card bg-light border mb-3">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Tiempo promedio de cierre</div>
                        <h4 class="fw-bold text-primary mb-0">{{ $tiempoPromedioCitatorio }} Días</h4>
                    </div>
                </div>

                <!-- Tasa de Suspensión -->
                <div class="card bg-light border mb-3">
                    <div class="card-body">
                        <div class="small text-muted fw-medium mb-1">Tasa de citatorios a suspensión</div>
                        <h4 class="fw-bold text-danger mb-0">{{ $tasaSuspension }}%</h4>
                    </div>
                </div>

                <!-- Citatorios por Inspector -->
                <div class="card bg-light border mb-3">
                    <div class="card-body" style="min-height: 320px;">
                        <h6 class="fw-semibold text-secondary border-bottom pb-2 mb-3">Citatorios por inspector</h6>
                        @if($citatoriosPorInspector->count() > 0)
                            <div class="text-center mb-3">
                                @foreach($citatoriosPorInspector as $index => $item)
                                    @php
                                        $badgeColors = ['primary', 'info', 'success', 'warning'];
                                        $badgeClass = $badgeColors[$index % 4];
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }} bg-opacity-25 text-{{ $badgeClass }} m-1 px-3 py-2">
                                        {{ $item['inspector'] }}: <strong>{{ $item['total'] }}</strong>
                                    </span>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <canvas id="citatoriosChart" style="max-width: 250px; max-height: 250px;"></canvas>
                            </div>
                        @else
                            <div class="py-5 text-muted text-center">
                                <i class="fas fa-chart-pie fa-3x opacity-25 mb-3 d-block"></i>
                                <p class="mb-0">No hay citatorios asignados en este período</p>
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

        // Configuración común para los gráficos
        const commonChartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false // Ocultamos la leyenda ya que tenemos los badges
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed;
                            
                            // Calcular porcentaje
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            label += ' (' + percentage + '%)';
                            
                            return label;
                        }
                    }
                }
            }
        };

        @if($expedientesPorInspector->count() > 0)
        // Datos para el gráfico de Expedientes por Inspector
        const expedientesData = {
            labels: {!! json_encode($expedientesPorInspector->pluck('inspector')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($expedientesPorInspector->pluck('total')->toArray()) !!},
                backgroundColor: chartColors.slice(0, {{ $expedientesPorInspector->count() }}),
                borderColor: chartBorderColors.slice(0, {{ $expedientesPorInspector->count() }}),
                borderWidth: 2
            }]
        };

        // Crear gráfico de Expedientes
        const expedientesCtx = document.getElementById('expedientesChart').getContext('2d');
        const expedientesChart = new Chart(expedientesCtx, {
            type: 'pie',
            data: expedientesData,
            options: commonChartOptions
        });
        @endif

        @if($citatoriosPorInspector->count() > 0)
        // Datos para el gráfico de Citatorios por Inspector
        const citatoriosData = {
            labels: {!! json_encode($citatoriosPorInspector->pluck('inspector')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($citatoriosPorInspector->pluck('total')->toArray()) !!},
                backgroundColor: chartColors.slice(0, {{ $citatoriosPorInspector->count() }}),
                borderColor: chartBorderColors.slice(0, {{ $citatoriosPorInspector->count() }}),
                borderWidth: 2
            }]
        };

        // Crear gráfico de Citatorios
        const citatoriosCtx = document.getElementById('citatoriosChart').getContext('2d');
        const citatoriosChart = new Chart(citatoriosCtx, {
            type: 'pie',
            data: citatoriosData,
            options: commonChartOptions
        });
        @endif
    </script>
    @endpush