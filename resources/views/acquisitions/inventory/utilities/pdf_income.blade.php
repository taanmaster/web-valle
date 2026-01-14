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
            font-size: 14px
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

        .logo {
            width: 80px;
        }
    </style>
</head>




<body>

    <table>
        <tr>
            <td rowspan="2" class="center">
                <img class="logo" src="{{ public_path('front/img/logo-valle.png') }}" alt="Valle de Santiago">
            </td>
            <td colspan="3" class="center">
                <h2>VALLE DE SANTIAGO</h2>
                <p>{{ $movement->type }} de Inventario</p>
            </td>
        </tr>
        @foreach ($movement->items as $item)
            <tr>
                <td class="label">SKU</td>
                <td colspan="2"><input type="text" value="{{ $item->material->sku }}"></td>
            </tr>
            <tr>
                <td class="label">Cantidad</td>
                <td colspan="3"><input type="text" value="{{ $item->quantity }}"></td>
            </tr>
            <tr>
                <td class="label">Nombre</td>
                <td><input type="text" value="{{ $item->material->title }}"></td>
                <td class="label">Categoría</td>
                <td>
                    <p>{{ $item->material->category }}</p>
                </td>
            </tr>
            <tr>
                <td class="label">Dependencia</td>
                <td colspan="3">
                    <p>{{ $item->material->dependency_name }}</p>
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="label">Proveedor</td>
            <td colspan="3">
                <p>{{ $movement->supplier->owner_name }}</p>
            </td>
        </tr>
    </table>

</body>

</html>
