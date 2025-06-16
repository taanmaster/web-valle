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

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Recibo</th>
                    <th>Fecha y hora</th>
                    <th>Contribuyente</th>
                    <th>Concepto de cobro</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_columna_1 = 0;
                @endphp
                @foreach ($incomes as $income)
                    <tr>
                        <td>{{ $income->id }}</td>
                        <td>{{ $income->created_at->format('d/m/Y h:m') }}</td>
                        <td>{{ $income->income->name }}</td>
                        <td>{{ $income->income->concept }}</td>

                        @php
                            $total_columna_1 += $income->qty_integer; // Sumar a la primera columna
                        @endphp

                        <td>$ {{ number_format($income->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Total de la página:</strong></td>
                    <td>
                        ${{ number_format($total_columna_1, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
