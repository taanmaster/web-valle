<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valle de Santiago - Estado de Cuenta {{ $property->location_account }}</title>

    <style>
        @page {
            margin: 1cm 1cm;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 11px;
            font-weight: 400;
            line-height: 1.4;
            color: #1f3129;
            padding: 0;
            margin: 0;
            background: #fff;
        }

        *, ::after, ::before {
            box-sizing: border-box;
        }

        .logo {
            width: 100px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #2c5f2d;
            padding-bottom: 10px;
        }

        .header-table td {
            vertical-align: top;
            padding: 5px;
        }

        .page-break {
            page-break-after: always;
        }

        h1, h2, h3, h4 {
            margin: 10px 0;
            color: #2c5f2d;
        }

        h1 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 16px;
            border-bottom: 2px solid #2c5f2d;
            padding-bottom: 5px;
            margin-top: 20px;
        }

        h3 {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .info-label {
            display: table-cell;
            width: 40%;
            font-weight: bold;
            color: #495057;
        }

        .info-value {
            display: table-cell;
            width: 60%;
            color: #212529;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .data-table th {
            background: #2c5f2d;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: 600;
        }

        .data-table td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
        }

        .data-table tr:last-child td {
            border-bottom: 2px solid #2c5f2d;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 600;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .badge-info {
            background: #17a2b8;
            color: white;
        }

        .total-box {
            background: #d4edda;
            border: 2px solid #28a745;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            text-align: right;
        }

        .total-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
        }

        .text-muted {
            color: #6c757d;
            font-size: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .grid-2 {
            display: table;
            width: 100%;
        }

        .grid-2 > div {
            display: table-cell;
            width: 50%;
            padding: 5px;
        }

        .footer-note {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            font-size: 9px;
            color: #6c757d;
            text-align: center;
        }

        .year-section {
            margin-bottom: 30px;
        }

        .year-title {
            background: #2c5f2d;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .summary-table td {
            padding: 5px 10px;
            border: 1px solid #dee2e6;
        }

        .summary-table .label {
            font-weight: bold;
            background: #f8f9fa;
        }

        .summary-total {
            background: #28a745;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .grand-total-box {
            background: #2c5f2d;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 30px;
        }

        .grand-total-box h2 {
            color: white;
            margin: 0;
            border: none;
        }

        .grand-total-amount {
            font-size: 28px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <table class="header-table">
        <tr>
            <td style="width: 30%;">
                <img class="logo" src="{{ public_path('front/img/logo-valle.png') }}" alt="Valle de Santiago">
            </td>
            <td style="width: 40%; text-align: center;">
                <h3 style="margin: 0;">H. AYUNTAMIENTO DE VALLE DE SANTIAGO</h3>
                <p style="margin: 5px 0; font-size: 10px;">TESORERÍA MUNICIPAL</p>
                <p style="margin: 5px 0; font-size: 10px;">Guanajuato, México</p>
            </td>
            <td style="width: 30%; text-align: right;">
                <p style="margin: 0; font-size: 10px;"><strong>Fecha de impresión:</strong></p>
                <p style="margin: 0; font-size: 10px;">{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
            </td>
        </tr>
    </table>

    <h1>ESTADO DE CUENTA - IMPUESTO PREDIAL</h1>

    <!-- Información del Contribuyente -->
    <div class="info-box">
        <div class="grid-2">
            <div>
                <div class="info-row">
                    <div class="info-label">Contribuyente:</div>
                    <div class="info-value"><strong>{{ $property->taxpayer_name ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tipo:</div>
                    <div class="info-value">{{ $property->taxpayer_type ? ucfirst($property->taxpayer_type) : 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Teléfono:</div>
                    <div class="info-value">{{ $property->taxpayer_phone ?? 'N/A' }}</div>
                </div>
            </div>
            <div>
                <div class="info-row">
                    <div class="info-label">Cuenta Catastral:</div>
                    <div class="info-value"><strong>{{ $property->location_account ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ubicación:</div>
                    <div class="info-value">
                        {{ $property->street }} {{ $property->street_num }}
                        @if($property->int_num) Int. {{ $property->int_num }} @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Colonia:</div>
                    <div class="info-value">{{ $property->suburb ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Predio -->
    <h2>Información del Predio</h2>
    <div class="info-box">
        <div class="grid-2">
            <div>
                <div class="info-row">
                    <div class="info-label">Superficie Terreno:</div>
                    <div class="info-value">{{ $property->location_surface ? number_format($property->location_surface, 2) . ' m²' : 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Superficie Construida:</div>
                    <div class="info-value">{{ $property->location_surface_built ? number_format($property->location_surface_built, 2) . ' m²' : 'N/A' }}</div>
                </div>
            </div>
            <div>
                <div class="info-row">
                    <div class="info-label">Valor Catastral:</div>
                    <div class="info-value"><strong>${{ $property->location_law_value ? number_format($property->location_law_value, 2) : 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tipo de Cuota:</div>
                    <div class="info-value">
                        @if($property->cuota_type == 'cuota_minima')
                            <span class="badge badge-info">Cuota Mínima</span>
                        @else
                            <span class="badge badge-warning">Cuota Normal</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $grandTotalPendiente = 0;
        $grandTotalPagado = 0;
    @endphp

    @if($years->count() > 0)
        <!-- Estado de Cuenta por Año -->
        <h2>Detalle por Año</h2>
        
        @foreach($years as $year)
            @php
                $receiptsYear = $property->propertyTaxes->where('tax_year', $year)->sortBy('bimonthly_period');
                $totalRecargos = $receiptsYear->sum('surcharge_amount');
                $totalDescuentos = $receiptsYear->sum('discount_amount');
                $totalSubtotal = $receiptsYear->sum('subtotal');
                $totalAPagar = $receiptsYear->sum('total_payment');
                
                $totalPagadoYear = $receiptsYear->where('payment_status', 'pagado')->sum('total_payment');
                $totalPendienteYear = $receiptsYear->where('payment_status', '!=', 'pagado')->sum('total_payment');
                
                $grandTotalPendiente += $totalPendienteYear;
                $grandTotalPagado += $totalPagadoYear;
            @endphp

            <div class="year-section">
                <div class="year-title">
                    <strong>AÑO {{ $year }}</strong>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="text-center">Bimestre</th>
                            <th class="text-center">Folio</th>
                            <th class="text-center">Estado</th>
                            <th class="text-right">Subtotal</th>
                            <th class="text-right">Recargos</th>
                            <th class="text-right">Descuentos</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receiptsYear as $receipt)
                            <tr>
                                <td class="text-center">{{ $receipt->bimonthly_period }}°</td>
                                <td class="text-center">{{ $receipt->folio ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if($receipt->payment_status == 'pagado')
                                        <span class="badge badge-success">Pagado</span>
                                    @elseif($receipt->payment_status == 'vencido')
                                        <span class="badge badge-danger">Vencido</span>
                                    @else
                                        <span class="badge badge-warning">Pendiente</span>
                                    @endif
                                </td>
                                <td class="text-right">${{ number_format($receipt->subtotal ?? 0, 2) }}</td>
                                <td class="text-right">${{ number_format($receipt->surcharge_amount ?? 0, 2) }}</td>
                                <td class="text-right">${{ number_format($receipt->discount_amount ?? 0, 2) }}</td>
                                <td class="text-right"><strong>${{ number_format($receipt->total_payment ?? 0, 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Resumen del año -->
                <table class="summary-table">
                    <tr>
                        <td class="label" style="width: 25%;">Subtotal:</td>
                        <td class="text-right" style="width: 25%;">${{ number_format($totalSubtotal, 2) }}</td>
                        <td class="label" style="width: 25%;">Recargos:</td>
                        <td class="text-right" style="width: 25%;">${{ number_format($totalRecargos, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Descuentos:</td>
                        <td class="text-right">${{ number_format($totalDescuentos, 2) }}</td>
                        <td class="label">Total Año {{ $year }}:</td>
                        <td class="text-right summary-total">${{ number_format($totalAPagar, 2) }}</td>
                    </tr>
                </table>
            </div>
        @endforeach

        <!-- Resumen General -->
        <div class="total-box">
            <div class="grid-2">
                <div>
                    <p><strong>Total Pagado:</strong> ${{ number_format($grandTotalPagado, 2) }}</p>
                    <p><strong>Total Recibos:</strong> {{ $property->propertyTaxes->count() }}</p>
                </div>
                <div>
                    <p class="total-label">TOTAL PENDIENTE DE PAGO:</p>
                    <p class="total-amount">${{ number_format($grandTotalPendiente, 2) }}</p>
                </div>
            </div>
        </div>

    @else
        <div class="info-box text-center">
            <p>No hay recibos registrados para esta propiedad.</p>
        </div>
    @endif

    <!-- Estadísticas -->
    <h2>Resumen Estadístico</h2>
    <div class="info-box">
        <div class="grid-2">
            <div>
                <div class="info-row">
                    <div class="info-label">Total de Recibos:</div>
                    <div class="info-value"><strong>{{ $property->propertyTaxes->count() }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Recibos Pagados:</div>
                    <div class="info-value"><span class="badge badge-success">{{ $property->propertyTaxes->where('payment_status', 'pagado')->count() }}</span></div>
                </div>
            </div>
            <div>
                <div class="info-row">
                    <div class="info-label">Recibos Pendientes:</div>
                    <div class="info-value"><span class="badge badge-warning">{{ $property->propertyTaxes->where('payment_status', 'pendiente')->count() }}</span></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Recibos Vencidos:</div>
                    <div class="info-value"><span class="badge badge-danger">{{ $property->propertyTaxes->where('payment_status', 'vencido')->count() }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-note">
        <p>Este documento es un estado de cuenta del impuesto predial. Para cualquier aclaración, favor de acudir a las oficinas de la Tesorería Municipal.</p>
        <p>H. Ayuntamiento de Valle de Santiago | Tesorería Municipal | Tel: (456) 647 0100</p>
        <p style="margin-top: 10px; font-size: 8px;">Documento generado electrónicamente el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
