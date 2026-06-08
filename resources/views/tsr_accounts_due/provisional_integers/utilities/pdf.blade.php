<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Entero Provisional</title>

    <style>
        @page {
            margin: 18mm 12mm 16mm 12mm;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            padding: 0;
            color: #333;
        }

        .header {
            margin-bottom: 10px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header .logo {
            width: 90px;
        }

        .header .title {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .header .meta {
            text-align: right;
            font-size: 11px;
            line-height: 1.4;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
        }

        .receipt-table th,
        .receipt-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .receipt-table th {
            background-color: #f0f0f0;
            font-weight: 600;
        }

        .receipt-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .section-header {
            background-color: #f9f9f9;
            font-weight: 600;
            padding: 10px 16px;
            font-size: 15px;
            border-top: 1px solid #ccc;
        }

        .no-border {
            border: none !important;
        }

        .center {
            text-align: center;
        }

        .text-area {
            padding: 12px 16px;
            font-size: 14px;
            background-color: #fafafa;
            border-radius: 6px;
            border: 1px solid #ddd;
            white-space: pre-line;
        }

        .signature-row td {
            padding-top: 32px;
        }

        input,
        textarea {
            font-size: 14px;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background-color: #f4f4f4;
            width: 100%;
        }

        .small {
            font-size: 13px;
        }

        .footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -10mm;
            text-align: center;
            font-size: 10px;
            color: #4b5563;
        }
    </style>
</head>

<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 22%;"><img src="{{ public_path('front/img/logo-valle.png') }}" class="logo" alt="Logo"></td>
                <td style="width: 53%;">
                    <p class="title">MUNICIPIO DE VALLE DE SANTIAGO, GTO.</p>
                    <div>AYUNTAMIENTO 2024 - 2027</div>
                    <div>TESORERIA MUNICIPAL</div>
                </td>
                <td style="width: 25%;" class="meta">
                    <div>Impreso: {{ ($printedAt ?? now())->format('d/m/Y H:i') }}</div>
                    <div>Usuario: {{ $printedBy ?? 'Sistema' }}</div>
                    <div>Folio: {{ $integer->id }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="receipt-title">Entero provisional</div>

    <table class="receipt-table">
        <tr>
            <th>Dependencia</th>
            <td colspan="3">{{ $integer->dependency_name }}</td>
        </tr>
        <tr>
            <th>Folio</th>
            <td colspan="3">{{ $integer->id }}</td>
        </tr>
        <tr>
            <th>La cantidad de</th>
            <td>{{ $integer->qty_text }}</td>
            <th>Cantidad ($)</th>
            <td>${{ $integer->qty_integer }}</td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td colspan="3">{{ $integer->name }}</td>
        </tr>
        <tr>
            <th>Domicilio</th>
            <td>{{ $integer->address }}</td>
            <th>C.P.</th>
            <td>{{ $integer->zipcode }}</td>
        </tr>
        <tr>
            <th>Con Fundamento</th>
            <td colspan="3">
                <div class="text-area">{{ $integer->basis }}</div>
            </td>
        </tr>
        <tr>
            <th>Por concepto de</th>
            <td colspan="3">
                <div class="text-area">{{ $integer->concept }}</div>
            </td>
        </tr>
        <tr>
            <th>Método de Pago</th>
            <td colspan="3">{{ $integer->payment_method }}</td>
        </tr>
        <tr>
            <th>Estatus</th>
            <td colspan="3">{{ strtoupper($integer->status ?? 'generado') }}</td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td colspan="3">Valle de Santiago, Gto. a
                {{ \Carbon\Carbon::parse($integer->created_at)->format('d/m/Y') }}</td>
        </tr>
        <tr class="signature-row">
            <th>Elaboró</th>
            <td>{{ $integer->created_by }}</td>
            <th>Vo. Bo. Director-Jefe</th>
            <td>{{ $integer->director }}</td>
        </tr>
    </table>

    <div class="footer">
        Documento generado por {{ $printedBy ?? 'Sistema' }}
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font("helvetica", "normal");
            $pdf->page_text(500, 815, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, [0.35,0.35,0.35]);
        }
    </script>
</body>

</html>
