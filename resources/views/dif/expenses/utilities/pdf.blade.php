<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
            font-size: 14px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 0;
            padding: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        th {
            background-color: #551312;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .margin-top {
            margin-top: 20px;
        }

        .w-half {
            width: 50%;
        }

        .logo {
            width: 80px;
        }

        .label {
            font-weight: bold;
            background-color: #f7f7f7;
        }

        .value {
            display: block;
            padding: 4px 0;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td rowspan="2" class="center" style="text-align:center;">
                <img class="logo" src="{{ public_path('front/img/logo-valle.png') }}" alt="Valle de Santiago">
            </td>
            <td colspan="3" class="center">
                <h2>VALLE DE SANTIAGO</h2>
            </td>
        </tr>
        <tr>
            <td class="label">FOLIO</td>
            <td colspan="2"><span class="value">{{ $expense->id }}</span></td>
        </tr>
        <tr>
            <td class="label">Fecha de Salida</td>
            <td colspan="2">
                <span class="value">{{ \Carbon\Carbon::parse($expense->created_at)->format('d/m/Y') }}</span>
            </td>
        </tr>
        <tr>
            <td class="label">Beneficiario</td>
            <td colspan="3"><span class="value">{{ $expense->recipient }}</span></td>
        </tr>
        <tr>
            <td class="label">Concepto</td>
            <td colspan="3"><span class="value">{{ $expense->concept }}</span></td>
        </tr>
        <tr>
            <td class="label">Precio Unitario</td>
            <td colspan="3"><span class="value">{{ number_format($expense->ammount, 2) }}</span></td>
        </tr>
        <tr>
            <td class="label">Importe</td>
            <td colspan="3"><span class="value">{{ number_format($expense->value, 2) }}</span></td>
        </tr>
    </table>

</body>

</html>
