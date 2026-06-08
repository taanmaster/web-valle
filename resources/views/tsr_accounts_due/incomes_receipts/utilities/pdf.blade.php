<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo Oficial</title>

    <style>
        @page {
            margin: 20mm 12mm 18mm 12mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        .header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header td {
            vertical-align: top;
        }

        .logo {
            width: 120px;
        }

        .municipio {
            font-size: 18px;
            font-weight: bold;
            line-height: 1.2;
            margin: 0;
        }

        .submunicipio {
            font-size: 12px;
            color: #374151;
            margin-top: 2px;
        }

        .meta {
            text-align: right;
            font-size: 11px;
            line-height: 1.45;
        }

        .ticket {
            border: 1px solid #d1d5db;
            padding: 12px;
        }

        .row {
            display: table;
            width: 100%;
        }

        .row .col {
            display: table-cell;
            vertical-align: top;
        }

        .mb-8 {
            margin-bottom: 8px;
        }

        .mb-12 {
            margin-bottom: 12px;
        }

        .label {
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 2px;
        }

        .value {
            font-weight: bold;
            font-size: 12px;
        }

        .line {
            border-top: 1px dashed #9ca3af;
            margin: 10px 0;
        }

        .concepto {
            border: 1px solid #d1d5db;
            padding: 8px;
            min-height: 58px;
        }

        .importe {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }

        .amount-words {
            text-align: center;
            font-style: italic;
            margin: 10px 0;
        }

        .footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -12mm;
            font-size: 10px;
            color: #4b5563;
            text-align: center;
        }

        .sat {
            border: 1px solid #d1d5db;
            padding: 8px;
            font-size: 10px;
            text-align: center;
            min-height: 82px;
        }
    </style>
</head>

<body>
    @php
        $income = $receipt->income;
        $amountText = $receipt->qty_text ?: ($income->qty_text ?? '');
    @endphp

    <table class="header">
        <tr>
            <td style="width: 22%;">
                <img src="{{ public_path('front/img/logo-valle.png') }}" class="logo" alt="Logo Valle">
            </td>
            <td style="width: 48%;">
                <p class="municipio">VALLE DE SANTIAGO</p>
                <p class="submunicipio">Municipio de Valle de Santiago, Gto.</p>
                <p class="submunicipio">Ayuntamiento 2024 - 2027</p>
            </td>
            <td style="width: 30%;" class="meta">
                <div><strong>{{ str_pad((string) $receipt->id, 6, '0', STR_PAD_LEFT) }}</strong></div>
                <div>RECIBO OFICIAL</div>
                <div>Fecha: {{ $receipt->created_at->format('d/m/Y') }}</div>
                <div>Folio: {{ $receipt->id }}</div>
                <div>Entero: {{ $income->folio ?? 'N/A' }}</div>
            </td>
        </tr>
    </table>

    <div class="ticket">
        <div class="row mb-8">
            <div class="col" style="width: 75%;">
                <div class="label">Contribuyente</div>
                <div class="value">{{ $income->name ?? 'N/A' }}</div>
            </div>
            <div class="col" style="width: 25%; text-align:right;">
                <div class="label">Importe</div>
                <div class="importe">${{ number_format((float) ($receipt->total ?? 0), 2) }}</div>
            </div>
        </div>

        <div class="row mb-8">
            <div class="col" style="width: 100%;">
                <div class="label">Concepto</div>
                <div class="concepto">{{ $income->concept ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="row mb-8">
            <div class="col" style="width: 100%;">
                <div class="label">Observaciones</div>
                <div>{{ $income->observations ?: 'Sin observaciones.' }}</div>
            </div>
        </div>

        <div class="amount-words">({{ $amountText }})</div>

        <div class="line"></div>

        <div class="row">
            <div class="col" style="width: 72%;">
                <div class="label">Reg. de caja</div>
                <div>Folio {{ $income->folio ?? 'N/A' }} - Caja {{ $receipt->cashier ?: 'N/A' }}</div>
            </div>
            <div class="col" style="width: 28%; text-align:right;">
                <div class="label">Total</div>
                <div class="value">${{ number_format((float) ($receipt->total ?? 0), 2) }}</div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col" style="width: 72%;">
                <div class="label">Usuario de caja</div>
                <div>{{ $receipt->cashier_user ?: 'N/A' }}</div>
            </div>
            <div class="col" style="width: 28%;">
                <div class="sat">
                    PALACIO MUNICIPAL S/N<br>
                    TEL: (456) 64 300 59<br>
                    VALLE DE SANTIAGO, GTO<br>
                    RFC MVS850101ST5
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        Impreso: {{ ($printedAt ?? now())->format('d/m/Y H:i') }} | Usuario: {{ $printedBy ?? 'Sistema' }}
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font("helvetica", "normal");
            $pdf->page_text(500, 815, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, [0.35,0.35,0.35]);
        }
    </script>
</body>

</html>
