<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            padding: 20px;
            color: #333;
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
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
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
    </style>
</head>

<body>
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
</body>

</html>
