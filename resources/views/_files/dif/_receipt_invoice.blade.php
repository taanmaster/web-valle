<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valle de Santiago - Recibo de Pago DIF</title>

    <style>
        @page {
            margin: 1cm 1cm;
        }

        body {
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
            font-size: 12px;
            font-weight: 400;
            line-height: 1.5;
            color: #1f3129;
            text-align: left;
            padding: 0;
            margin-top: 1cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 1cm;
            background:#fff;
        }

        *, ::after, ::before {
            box-sizing: border-box;
        }

        .logo{
            width: 80px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header-table td {
            vertical-align: top;
            padding: 10px;
        }

        .receipt-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2c5aa0;
            margin: 20px 0;
            text-transform: uppercase;
        }

        .receipt-number {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #666;
            margin-bottom: 20px;
        }

        .info-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #333;
        }

        .info-value {
            color: #666;
        }

        .concepts-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .concepts-table th,
        .concepts-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .concepts-table th {
            background-color: #2c5aa0;
            color: white;
            font-weight: bold;
        }

        .concepts-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .totals-section {
            float: right;
            width: 300px;
            margin: 20px 0;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }

        .totals-table .total-label {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .totals-table .total-amount {
            text-align: right;
            font-weight: bold;
        }

        .final-total {
            background-color: #2c5aa0 !important;
            color: white !important;
            font-size: 16px;
        }

        .payment-info {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #2c5aa0;
        }

        .signature-section {
            margin-top: 60px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 250px;
            margin: 40px auto 10px;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 15%;">
                <img class="logo" src="{{ public_path('front/img/logo-valle.png') }}" alt="Valle de Santiago">
            </td>
            <td style="width: 70%; text-align: center;">
                <h2 style="margin: 0; color: #2c5aa0;">SISTEMA DIF VALLE DE SANTIAGO</h2>
                <p style="margin: 5px 0 0 0; color: #666;">Dirección de Asistencia Social</p>
            </td>
            <td style="width: 15%; text-align: right;">
                <p style="margin: 0; font-size: 10px; color: #666;">
                    Fecha: {{ $receipt->receipt_date->format('d/m/Y') }}
                </p>
            </td>
        </tr>
    </table>

    <div class="receipt-title">Recibo de Pago</div>
    <div class="receipt-number">No. {{ $receipt->receipt_num }}</div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Paciente:</span>
            <span class="info-value">{{ $receipt->patient->name ?? 'N/A' }} {{ $receipt->patient->first_name ?? '' }} {{ $receipt->patient->last_name ?? '' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Doctor:</span>
            <span class="info-value">{{ $receipt->doctor->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Especialidad:</span>
            <span class="info-value">{{ $receipt->doctor->specialty->name ?? 'N/A' }}</span>
        </div>
        @if($receipt->appointment)
        <div class="info-row">
            <span class="info-label">Cita:</span>
            <span class="info-value">{{ $receipt->appointment }}</span>
        </div>
        @endif
        @if($receipt->location)
        <div class="info-row">
            <span class="info-label">Ubicación:</span>
            <span class="info-value">{{ $receipt->location }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">Estado:</span>
            <span class="info-value">
                @switch($receipt->status)
                    @case('pending')
                        <span class="status-badge status-pending">Pendiente</span>
                        @break
                    @case('completed')
                        <span class="status-badge status-completed">Completado</span>
                        @break
                    @case('cancelled')
                        <span class="status-badge status-cancelled">Cancelado</span>
                        @break
                @endswitch
            </span>
        </div>
    </div>

    <table class="concepts-table">
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Descripción</th>
                <th style="text-align: right;">Importe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipt->paymentConcepts as $concept)
            <tr>
                <td>{{ $concept->name }}</td>
                <td>{{ $concept->description ?? 'N/A' }}</td>
                <td style="text-align: right;">${{ number_format($concept->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix">
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="total-label">Subtotal:</td>
                    <td class="total-amount">${{ number_format($receipt->subtotal, 2) }}</td>
                </tr>
                @if($receipt->discount > 0)
                <tr>
                    <td class="total-label">Descuento:</td>
                    <td class="total-amount">-${{ number_format($receipt->discount, 2) }}</td>
                </tr>
                @endif
                <tr class="final-total">
                    <td class="total-label">Total:</td>
                    <td class="total-amount">${{ number_format($receipt->total, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="payment-info">
        <div class="info-row">
            <span class="info-label">Método de Pago:</span>
            <span class="info-value">
                @switch($receipt->payment_method)
                    @case('cash')
                        Efectivo
                        @break
                    @case('card')
                        Tarjeta
                        @break
                    @case('transfer')
                        Transferencia
                        @break
                    @case('check')
                        Cheque
                        @break
                    @default
                        {{ $receipt->payment_method }}
                @endswitch
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Expedido por:</span>
            <span class="info-value">{{ $receipt->issued_by }}</span>
        </div>
    </div>

    <div class="signature-section">
        <div class="signature-line"></div>
        <p>Firma del Paciente</p>
        <p style="margin-top: 30px; font-size: 10px; color: #666;">
            Este recibo es válido como comprobante de pago de servicios médicos del DIF
        </p>
    </div>

    <div class="footer">
        <p>Sistema DIF Valle de Santiago - Recibo generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
