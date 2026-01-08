<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valle de Santiago - Recibo Predial {{ $propertyTax->folio }}</title>

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

        .receipt-section {
            margin-bottom: 20px;
        }

        .signature-box {
            margin-top: 50px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 60%;
            margin: 0 auto;
            margin-top: 50px;
            padding-top: 5px;
        }

        .footer-note {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            font-size: 9px;
            color: #6c757d;
            text-align: center;
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

        .status-paid {
            background: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .status-pending {
            background: #ffc107;
            color: #212529;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .status-overdue {
            background: #dc3545;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- PÁGINA 1: ESTADO DE CUENTA -->
    <div class="page">
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

        @if($propertyTax->payment_status == 'pagado')
            <div class="status-paid">
                ✓ RECIBO PAGADO
            </div>
        @elseif($propertyTax->payment_status == 'vencido')
            <div class="status-overdue">
                ⚠ RECIBO VENCIDO
            </div>
        @else
            <div class="status-pending">
                ⏱ PAGO PENDIENTE
            </div>
        @endif

        <!-- Información del Recibo -->
        <div class="receipt-section">
            <h2>Información del Recibo</h2>
            <div class="info-box">
                <div class="grid-2">
                    <div>
                        <div class="info-row">
                            <div class="info-label">Folio:</div>
                            <div class="info-value"><strong>{{ $propertyTax->folio ?? 'N/A' }}</strong></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Año Fiscal:</div>
                            <div class="info-value">{{ $propertyTax->tax_year }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Bimestre:</div>
                            <div class="info-value">{{ $propertyTax->bimonthly_period }}° Bimestre</div>
                        </div>
                    </div>
                    <div>
                        <div class="info-row">
                            <div class="info-label">Tipo de Cuota:</div>
                            <div class="info-value">
                                <span class="badge badge-info">
                                    {{ $propertyTax->cuota_type == 'cuota_minima' ? 'Cuota Mínima' : 'Cuota Normal' }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Fecha de Emisión:</div>
                            <div class="info-value">{{ $propertyTax->issue_date ? $propertyTax->issue_date->format('d/m/Y') : '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Fecha de Pago:</div>
                            <div class="info-value">{{ $propertyTax->payment_date ? $propertyTax->payment_date->format('d/m/Y') : 'PENDIENTE' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Contribuyente -->
        <div class="receipt-section">
            <h2>Datos del Contribuyente</h2>
            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Nombre del Contribuyente:</div>
                    <div class="info-value"><strong>{{ $propertyTax->property->taxpayer_name ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Cuenta Catastral:</div>
                    <div class="info-value"><strong>{{ $propertyTax->property->location_account ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ubicación del Predio:</div>
                    <div class="info-value">
                        {{ $propertyTax->property->street }} {{ $propertyTax->property->street_num }}
                        @if($propertyTax->property->int_num)
                            Int. {{ $propertyTax->property->int_num }},
                        @endif
                        {{ $propertyTax->property->suburb }}
                    </div>
                </div>
                @if($propertyTax->property->reference)
                    <div class="info-row">
                        <div class="info-label">Referencia:</div>
                        <div class="info-value">{{ $propertyTax->property->reference }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Valores del Predio -->
        <div class="receipt-section">
            <h2>Valores del Predio</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th class="text-right">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Valor del Predio</td>
                        <td class="text-right">${{ number_format($propertyTax->property_value ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Pago Bimestral</td>
                        <td class="text-right">${{ number_format($propertyTax->bimonthly_payment ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Tasa Aplicada</td>
                        <td class="text-right">{{ $propertyTax->tax_rate ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Desglose de Conceptos -->
        <div class="receipt-section">
            <h2>Desglose de Conceptos</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th class="text-right">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Cuenta Corriente (Cve.)</strong></td>
                        <td class="text-right">${{ number_format($propertyTax->current_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Movimientos/Rezagos (Mov.)</strong></td>
                        <td class="text-right">${{ number_format($propertyTax->arrears_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Efectos</strong></td>
                        <td class="text-right">${{ number_format($propertyTax->effects ?? 0, 2) }}</td>
                    </tr>
                    @if($propertyTax->arrears_period)
                    <tr>
                        <td><strong>Periodo de Rezago</strong></td>
                        <td class="text-right">{{ $propertyTax->arrears_period }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Periodo Corriente</strong></td>
                        <td class="text-right">${{ number_format($propertyTax->current_period_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Rezago</strong></td>
                        <td class="text-right">${{ number_format($propertyTax->total_arrears ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Cuenta Corriente</strong></td>
                        <td class="text-right">${{ number_format($propertyTax->current_account ?? 0, 2) }}</td>
                    </tr>
                    <tr style="background: #f8f9fa;">
                        <td><strong>SUBTOTAL IMPUESTO PREDIAL</strong></td>
                        <td class="text-right"><strong>${{ number_format($propertyTax->property_tax_total ?? 0, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Descuentos y Recargos -->
        @if($propertyTax->discount || $propertyTax->surcharges || $propertyTax->surcharges_discount || $propertyTax->execution_expenses_discount)
        <div class="receipt-section">
            <h2>Descuentos y Recargos</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th class="text-right">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @if($propertyTax->discount)
                    <tr>
                        <td><strong>Descuento</strong></td>
                        <td class="text-right" style="color: #28a745;">-${{ number_format($propertyTax->discount, 2) }}</td>
                    </tr>
                    @endif
                    @if($propertyTax->surcharges)
                    <tr>
                        <td><strong>Recargos</strong></td>
                        <td class="text-right" style="color: #dc3545;">${{ number_format($propertyTax->surcharges, 2) }}</td>
                    </tr>
                    @endif
                    @if($propertyTax->surcharges_discount)
                    <tr>
                        <td><strong>Descuento en Recargos</strong></td>
                        <td class="text-right" style="color: #28a745;">-${{ number_format($propertyTax->surcharges_discount, 2) }}</td>
                    </tr>
                    @endif
                    @if($propertyTax->execution_expenses_discount)
                    <tr>
                        <td><strong>Descuento en Gastos de Ejecución</strong></td>
                        <td class="text-right" style="color: #28a745;">-${{ number_format($propertyTax->execution_expenses_discount, 2) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @endif

        <!-- Total a Pagar -->
        <div class="total-box">
            <div class="grid-2">
                <div>
                    <div class="total-label">TOTAL A PAGAR:</div>
                    @if($propertyTax->total_payment_text)
                        <p class="text-muted" style="margin: 5px 0;">{{ $propertyTax->total_payment_text }}</p>
                    @endif
                </div>
                <div>
                    <div class="total-amount">${{ number_format($propertyTax->total_payment ?? 0, 2) }}</div>
                </div>
            </div>
        </div>

        @if($propertyTax->bank_reference)
        <div class="info-box mt-20">
            <div class="info-row">
                <div class="info-label">Referencia Bancaria:</div>
                <div class="info-value"><strong>{{ $propertyTax->bank_reference }}</strong></div>
            </div>
        </div>
        @endif

        @if($propertyTax->notes)
        <div class="receipt-section">
            <h3>Notas Adicionales:</h3>
            <div class="info-box">
                <p style="margin: 0;">{{ $propertyTax->notes }}</p>
            </div>
        </div>
        @endif

        <div class="footer-note">
            <p>Este documento es un estado de cuenta del impuesto predial. Para cualquier aclaración, favor de acudir a las oficinas de la Tesorería Municipal.</p>
            <p>H. Ayuntamiento de Valle de Santiago | Tesorería Municipal | Tel: (456) 647 0100</p>
        </div>
    </div>

    <!-- SALTO DE PÁGINA -->
    <div class="page-break"></div>

    <!-- PÁGINA 2: RECIBO DE PAGO -->
    <div class="page">
        <!-- Encabezado -->
        <table class="header-table">
            <tr>
                <td style="width: 30%;">
                    <img class="logo" src="{{ public_path('front/img/logo-valle.png') }}" alt="Valle de Santiago">
                </td>
                <td style="width: 40%; text-align: center;">
                    <h3 style="margin: 0;">H. AYUNTAMIENTO DE VALLE DE SANTIAGO</h3>
                    <p style="margin: 5px 0; font-size: 10px;">TESORERÍA MUNICIPAL</p>
                    <p style="margin: 5px 0; font-size: 10px;">RECIBO OFICIAL DE PAGO</p>
                </td>
                <td style="width: 30%; text-align: right;">
                    <p style="margin: 0; font-size: 10px;"><strong>Folio:</strong></p>
                    <h3 style="margin: 5px 0;">{{ $propertyTax->folio ?? 'N/A' }}</h3>
                </td>
            </tr>
        </table>

        <h1>RECIBO DE PAGO - IMPUESTO PREDIAL</h1>

        @if($propertyTax->payment_status == 'pagado')
            <div class="status-paid">
                ✓ PAGADO - {{ $propertyTax->payment_date ? $propertyTax->payment_date->format('d/m/Y') : '' }}
            </div>
        @endif

        <!-- Datos Generales del Recibo -->
        <div class="receipt-section">
            <h2>Datos Generales</h2>
            <div class="info-box">
                <div class="grid-2">
                    <div>
                        <div class="info-row">
                            <div class="info-label">Folio:</div>
                            <div class="info-value"><strong>{{ $propertyTax->folio ?? 'N/A' }}</strong></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Año:</div>
                            <div class="info-value">{{ $propertyTax->tax_year }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Bimestre:</div>
                            <div class="info-value">{{ $propertyTax->bimonthly_period }}°</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tipo de Cuota:</div>
                            <div class="info-value">{{ $propertyTax->cuota_type == 'cuota_minima' ? 'Cuota Mínima' : 'Cuota Normal' }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="info-row">
                            <div class="info-label">Estado:</div>
                            <div class="info-value">
                                @if($propertyTax->payment_status == 'pagado')
                                    <span class="badge badge-success">PAGADO</span>
                                @elseif($propertyTax->payment_status == 'vencido')
                                    <span class="badge badge-danger">VENCIDO</span>
                                @else
                                    <span class="badge badge-warning">PENDIENTE</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Fecha Emisión:</div>
                            <div class="info-value">{{ $propertyTax->issue_date ? $propertyTax->issue_date->format('d/m/Y') : '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Fecha Pago:</div>
                            <div class="info-value">{{ $propertyTax->payment_date ? $propertyTax->payment_date->format('d/m/Y') : '-' }}</div>
                        </div>
                        @if($propertyTax->bank_reference)
                        <div class="info-row">
                            <div class="info-label">Referencia:</div>
                            <div class="info-value">{{ $propertyTax->bank_reference }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contribuyente y Predio -->
        <div class="receipt-section">
            <h2>Contribuyente y Predio</h2>
            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Contribuyente:</div>
                    <div class="info-value"><strong>{{ $propertyTax->property->taxpayer_name ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Cuenta Catastral:</div>
                    <div class="info-value"><strong>{{ $propertyTax->property->location_account ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Dirección:</div>
                    <div class="info-value">
                        {{ $propertyTax->property->street }} {{ $propertyTax->property->street_num }}
                        @if($propertyTax->property->int_num)
                            Int. {{ $propertyTax->property->int_num }},
                        @endif
                        {{ $propertyTax->property->suburb }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de Pago -->
        <div class="receipt-section">
            <h2>Resumen de Pago</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 70%;">Concepto</th>
                        <th class="text-right" style="width: 30%;">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Impuesto Predial ({{ $propertyTax->tax_year }} - {{ $propertyTax->bimonthly_period }}° Bimestre)</td>
                        <td class="text-right">${{ number_format($propertyTax->property_tax_total ?? 0, 2) }}</td>
                    </tr>
                    @if($propertyTax->discount)
                    <tr>
                        <td>Descuento Aplicado</td>
                        <td class="text-right" style="color: #28a745;">-${{ number_format($propertyTax->discount, 2) }}</td>
                    </tr>
                    @endif
                    @if($propertyTax->surcharges)
                    <tr>
                        <td>Recargos</td>
                        <td class="text-right" style="color: #dc3545;">${{ number_format($propertyTax->surcharges, 2) }}</td>
                    </tr>
                    @endif
                    @if($propertyTax->surcharges_discount)
                    <tr>
                        <td>Descuento en Recargos</td>
                        <td class="text-right" style="color: #28a745;">-${{ number_format($propertyTax->surcharges_discount, 2) }}</td>
                    </tr>
                    @endif
                    @if($propertyTax->execution_expenses_discount)
                    <tr>
                        <td>Descuento en Gastos de Ejecución</td>
                        <td class="text-right" style="color: #28a745;">-${{ number_format($propertyTax->execution_expenses_discount, 2) }}</td>
                    </tr>
                    @endif
                    <tr style="background: #d4edda; font-weight: bold; font-size: 13px;">
                        <td><strong>TOTAL PAGADO</strong></td>
                        <td class="text-right" style="color: #28a745;"><strong>${{ number_format($propertyTax->total_payment ?? 0, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Cantidad con Letra -->
        @if($propertyTax->total_payment_text)
        <div class="info-box">
            <div class="info-row">
                <div class="info-label">Cantidad con Letra:</div>
                <div class="info-value"><strong>{{ strtoupper($propertyTax->total_payment_text) }}</strong></div>
            </div>
        </div>
        @endif

        <!-- Desglose Detallado -->
        <div class="receipt-section">
            <h3>Desglose Detallado</h3>
            <table class="data-table" style="font-size: 10px;">
                <tbody>
                    <tr>
                        <td style="width: 50%;">Cuenta Corriente (Cve.)</td>
                        <td class="text-right" style="width: 50%;">${{ number_format($propertyTax->current_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Movimientos/Rezagos (Mov.)</td>
                        <td class="text-right">${{ number_format($propertyTax->arrears_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Efectos</td>
                        <td class="text-right">${{ number_format($propertyTax->effects ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Periodo Corriente</td>
                        <td class="text-right">${{ number_format($propertyTax->current_period_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Total Rezago</td>
                        <td class="text-right">${{ number_format($propertyTax->total_arrears ?? 0, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Firma -->
        <div class="signature-box">
            <div class="signature-line">
                <p><strong>Firma del Cajero</strong></p>
            </div>
        </div>

        <!-- Notas al Pie -->
        <div class="footer-note">
            <p><strong>IMPORTANTE:</strong> Este recibo es válido únicamente con el sello oficial de la Tesorería Municipal.</p>
            <p>Conserve este comprobante para cualquier aclaración posterior.</p>
            <p>Para más información visite nuestras oficinas o llame al (456) 647 0100</p>
            <p style="margin-top: 10px; font-size: 8px;">Recibo generado electrónicamente el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
