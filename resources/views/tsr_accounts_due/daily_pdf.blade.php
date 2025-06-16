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
            margin: 0;
            padding: 12px;
            background-color: #f8f9fa;
        }

        .table-responsive {
            margin-bottom: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            page-break-inside: avoid;
            /* Evitar que la tabla se divida en páginas */
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #551312;
            color: white;
        }

        h4 {
            margin: 0;
        }

        tfoot tr {
            font-weight: bold;
            background-color: #e9ecef;
        }

        @media print {
            body {
                margin: 0;
                padding: 10mm;
            }

            .table-responsive {
                margin: 0;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    @foreach ($incomes as $concepto => $incomes)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Concepto de cobro</th>
                        <th>Importe</th>
                        <th>Descuento</th>
                        <th>Ingreso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h4>
                                {{ $concepto }}
                            </h4>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @php
                        $total_columna_1 = 0; // Acumulador para la primera columna
                        $total_columna_2 = 0; // Acumulador para la segunda columna
                        $total_columna_3 = 0; // Acumulador para la tercera columna
                    @endphp

                    @forelse($incomes as $income)
                        <tr>
                            <td>
                                {{ $income->income->concept }}
                            </td>

                            @php
                                $value = (int) $income->qty_integer; // Sumar a la primera columna

                                $total_columna_1 += $value; // Sumar a la primera columna
                            @endphp

                            <td>$ {{ number_format($total_columna_1, 2) }}</td>

                            <td>N/A</td>

                            @php
                                $value2 = (int) $income->qty_integer; // Sumar a la primera columna

                                $total_columna_3 += $value2; // Sumar a la tercera columna
                            @endphp
                            <td>$ {{ number_format($total_columna_3, 2) }}</td>

                        </tr>
                    @empty
                        <li>No hay resultados para este concepto.</li>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>Total de {{ $concepto }}</strong></td>
                        <td><strong>$ {{ number_format($total_columna_1, 2) }}</strong></td>
                        <td></td>
                        <td><strong>$ {{ number_format($total_columna_3, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach
</body>

</html>
