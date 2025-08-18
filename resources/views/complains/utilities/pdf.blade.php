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

        .logo {
            width: 80px;
        }
    </style>
</head>




<body>

    <table>
        <tr>
            <td rowspan="2" class="center">
                <img src="logo.png" alt="Logo" class="logo">
            </td>
            <td colspan="3" class="center">
                <h2>VALLE DE SANTIAGO</h2>
                <p>Contraloría Municipal</p>
            </td>
        </tr>
        <tr>
            <td class="label">FOLIO</td>
            <td colspan="2"><input type="text"></td>
        </tr>

        <tr>
            <td class="label">NOMBRE</td>
            <td colspan="3"><input type="text"></td>
        </tr>

        <tr>
            <td class="label">DIRECCIÓN</td>
            <td colspan="3"><input type="text"></td>
        </tr>

        <tr>
            <td class="label">TELÉFONO</td>
            <td><input type="text"></td>
            <td class="label">CORREO</td>
            <td><input type="email"></td>
        </tr>

        <tr>
            <td class="label">ASUNTO</td>
            <td colspan="3"><input type="text"></td>
        </tr>

        <tr>
            <td class="label">DESCRIPCIÓN</td>
            <td colspan="3">
                <textarea></textarea>
            </td>
        </tr>

        <tr>
            <td class="label">FECHA DE CREACIÓN</td>
            <td><input type="date"></td>
            <td class="label">PRUEBAS</td>
            <td><input type="text"></td>
        </tr>
    </table>

</body>

</html>
