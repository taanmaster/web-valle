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
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            color: #333;
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
    </style>
</head>

<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src="{{ asset('front/img/logo-valle.png') }}" alt="" style="height: 150px">
            </td>
            <td class="w-half">
                <h2>Recibo oficial</h2>
            </td>
        </tr>
    </table>

    <table class="w-full">
        <tr>
            <td class="w-half">
                {{ $receipt->created_at->format('Y-m-d') }}
            </td>
            <td class="w-half">
                <h2>Recibo de ingreso</h2>
            </td>
        </tr>
    </table>

    <div class="margin-top">
        <table>
            <thead>
                <tr>
                    <th>Denominación</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $denominaciones = json_decode($receipt->denominations, true) ?? [];
                    $total_value = 0;
                @endphp

                @foreach ($denominaciones as $valor => $cantidad)
                    @if ($cantidad > 0)
                        @php
                            $total = $valor * $cantidad;
                            $total_value += $total;
                        @endphp
                        <tr>
                            <td>{{ $valor }}</td>
                            <td>{{ $cantidad }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td></td>
                    <td><strong>{{ $total_value }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 50px">


        <table>
            <tbody>
                <tr>
                    <td style="text-align: center">
                        Firma y nombre de cajero
                        <br>
                        <strong>{{ $receipt->cashier_user }}</strong>
                    </td>
                    <td style="text-align: center">
                        Firma y nombre de depositante
                        <br>
                        <strong>{{ $receipt->income->name }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <table class="w-full">
        <tr>
            <td class="w-half">
                <h2>MUNICIPIO DE VALLE DE SANTIAGO, GTO.</h2>
                <h3>AYUNTAMIENTO 2024 - 2027</h3>
            </td>
            <td class="w-half">

            </td>
        </tr>
    </table>
</body>

</html>
