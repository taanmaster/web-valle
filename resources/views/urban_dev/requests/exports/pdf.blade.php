<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Solicitudes de Desarrollo Urbano</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #495057;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #495057;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        
        .filters {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        
        .filters h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #495057;
        }
        
        .filter-item {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 5px;
            font-size: 10px;
        }
        
        .filter-label {
            font-weight: bold;
            color: #495057;
        }
        
        .summary {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #e3f2fd;
            border-radius: 4px;
        }
        
        .summary h3 {
            margin: 0;
            color: #1976d2;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9px;
        }
        
        th {
            background-color: #495057;
            color: white;
            font-weight: bold;
            padding: 6px 4px;
            text-align: center;
            border: 1px solid #333;
            font-size: 8px;
        }
        
        td {
            padding: 4px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
        }
        
        .status-new { background-color: #6c757d; }
        .status-entry { background-color: #0dcaf0; }
        .status-validation { background-color: #fd7e14; }
        .status-requires_correction { background-color: #dc3545; }
        .status-inspection { background-color: #ffc107; color: #000; }
        .status-resolved { background-color: #198754; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            background-color: white;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE SOLICITUDES DE DESARROLLO URBANO</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    @if($appliedFilters)
    <div class="filters">
        <h3>Filtros Aplicados:</h3>
        @foreach($appliedFilters as $key => $value)
            <div class="filter-item">
                <span class="filter-label">{{ $key }}:</span> {{ $value }}
            </div>
        @endforeach
    </div>
    @endif

    <div class="summary">
        <h3>Total de Solicitudes: {{ $requests->count() }}</h3>
    </div>

    @if($requests->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 10%;">Fecha</th>
                    <th style="width: 15%;">Solicitante</th>
                    <th style="width: 15%;">Tipo de Trámite</th>
                    <th style="width: 8%;">Estatus</th>
                    <th style="width: 12%;">Inspector</th>
                    <th style="width: 8%;">F. Entrega</th>
                    <th style="width: 10%;">Tipo Edif.</th>
                    <th style="width: 8%;">F. Pago</th>
                    <th style="width: 9%;">Docs</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                <tr>
                    <td class="text-center">{{ $request->id }}</td>
                    <td class="text-center">{{ $request->created_at->format('d/m/Y') }}</td>
                    <td>{{ $request->user->name ?? 'N/A' }}</td>
                    <td>{{ $request->getRequestTypeLabelAttribute() }}</td>
                    <td class="text-center">
                        <span class="status-badge status-{{ $request->status }}">
                            {{ $request->getStatusLabelAttribute() }}
                        </span>
                    </td>
                    <td>{{ $request->inspector->name ?? 'No asignado' }}</td>
                    <td class="text-center">
                        {{ $request->inspection_start_date ? $request->inspection_start_date->format('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $request->getBuildingTypeLabelAttribute() ?: '-' }}</td>
                    <td class="text-center">
                        {{ $request->payment_date ? $request->payment_date->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center">{{ $request->files->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Resumen por Estado -->
        @php
            $statusCounts = $requests->groupBy('status')->map->count();
        @endphp
        
        @if($statusCounts->count() > 0)
        <div style="margin-top: 30px;">
            <h3 style="color: #495057; font-size: 14px; margin-bottom: 10px;">Resumen por Estado:</h3>
            <table style="width: 50%; font-size: 10px;">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Cantidad</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statusCounts as $status => $count)
                    <tr>
                        <td>
                            @php
                                $statusLabels = [
                                    'new' => 'Nuevo',
                                    'entry' => 'Ingreso',
                                    'validation' => 'Validación',
                                    'requires_correction' => 'Requiere Corrección',
                                    'inspection' => 'Inspección',
                                    'resolved' => 'Resolución'
                                ];
                            @endphp
                            {{ $statusLabels[$status] ?? $status }}
                        </td>
                        <td class="text-center">{{ $count }}</td>
                        <td class="text-center">{{ round(($count / $requests->count()) * 100, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Resumen por Tipo de Trámite -->
        @php
            $typeCounts = $requests->groupBy('request_type')->map->count();
        @endphp
        
        @if($typeCounts->count() > 0)
        <div style="margin-top: 30px;">
            <h3 style="color: #495057; font-size: 14px; margin-bottom: 10px;">Resumen por Tipo de Trámite:</h3>
            <table style="width: 70%; font-size: 10px;">
                <thead>
                    <tr>
                        <th>Tipo de Trámite</th>
                        <th>Cantidad</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($typeCounts as $type => $count)
                    <tr>
                        <td>
                            @php
                                $typeLabels = [
                                    'uso-de-suelo' => 'Licencia de Uso de Suelo',
                                    'constancia-de-factibilidad' => 'Constancia de Factibilidad',
                                    'permiso-de-anuncios' => 'Permiso de Anuncios',
                                    'certificacion-numero-oficial' => 'Certificación de Número Oficial',
                                    'permiso-de-division' => 'Permiso de División',
                                    'uso-de-via-publica' => 'Uso de Vía Pública',
                                    'licencia-de-construccion' => 'Licencia de Construcción',
                                    'permiso-construccion-panteones' => 'Permiso de Construcción en Panteones',
                                ];
                            @endphp
                            {{ $typeLabels[$type] ?? $type }}
                        </td>
                        <td class="text-center">{{ $count }}</td>
                        <td class="text-center">{{ round(($count / $requests->count()) * 100, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    @else
        <div class="no-data">
            <p>No se encontraron solicitudes con los filtros aplicados.</p>
        </div>
    @endif

    <div class="footer">
        Sistema de Gestión Municipal - Desarrollo Urbano | Página <span class="pagenum"></span>
    </div>
</body>
</html>
