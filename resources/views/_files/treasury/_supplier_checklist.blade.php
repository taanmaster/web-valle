<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Valle de Santiago - Checklist de Proveedor</title>

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
            margin-top: 3.4cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 2cm;
            background:#fff;
        }

        *, ::after, ::before {
            box-sizing: border-box;
        }

        .logo{
            width: 100px;
        }

        .col-6{
            width:50%;
        }

        .col-3{
            width:22.5%;
        }

        h3{
            margin-bottom: 0px;
        }
        
        .list-unstyled{
            list-style: none;
            margin: 0px;
            padding: 0px;
        }

        .mb-5{
            margin-bottom: 1.5rem !important;
        }

        .mt-5{
            margin-top: 1.5rem !important;
        }

        .text-uppercase{
            text-transform: uppercase;
        }

        .txt-white{
            color: white;
        }

        .title-top{
            font-weight:bold;
            margin: 0px;
            padding-right:5px;
        }

        .push-up{
            font-size:8px;
            margin-bottom:0px;
        }

        .page-break {
            page-break-after: always;
        }
        
        header {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            z-index: 2;
            height:125px;
        }
         
        main{
        }
        
        .page-indicator p{
            margin-bottom: 0px;
            opacity:.5;
            margin-top: 20px;
            font-size: 10px;
            font-weight: bold;

            border-top: 1px solid rgba(0,0,0,.4);
            padding-top:10px;
        }

        .date-wrap{
            float:right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
    </style>

</head>
<body>
    <header>
        <table style="width: 100%;" class="letter-top" cellpadding="10">
            <tbody>
                <tr>
                    <td class="col-6"><img class="logo" src="{{ public_path('front/img/logo-valle.png') }}" alt="Valle de Santiago"></td>
                    <td class="col-6" style="text-align:right">
                        <div class="date-wrap">
                            <div class="line-contain">
                                <p>VALLE DE SANTIAGO, GTO. A {{ Carbon\Carbon::now()->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </header>
    
    <main>
        <h2 class="section-title">Checklist de Proveedor</h2>
        <table>
            <tbody>
                <tr>
                    <th>Folio</th>
                    <td>{{ $checklist->folio ?? 'N/A' }}</td>
                    <th>Dependencia</th>
                    <td>{{ $checklist->dependency_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Fecha Recibido</th>
                    <td>{{ $checklist->received_at ?? 'N/A' }}</td>
                    <th>Departamento Solicitante</th>
                    <td>{{ $checklist->requesting_department ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Fecha Devolución</th>
                    <td>{{ $checklist->return_date ?? 'N/A' }}</td>
                    <th>Proveedor</th>
                    <td>{{ $checklist->supplier->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>No. Factura</th>
                    <td>{{ $checklist->invoice_number ?? 'N/A' }}</td>
                    <th>No. Proveedor</th>
                    <td>{{ $checklist->supplier_number ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <h2 class="section-title">Elementos del Checklist</h2>
        <ul>
            @foreach($checklist->elements as $element)
                <li>{{ $element->name }}</li>
            @endforeach
        </ul>

        <h2 class="section-title">Autorizaciones</h2>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checklist->authorizations as $authorization)
                <tr>
                    <td>{{ $authorization->folio ?? 'N/A' }}</td>
                    <td>{{ $authorization->title }}</td>
                    <td>{{ $authorization->type }}</td>
                    <td>{{ $authorization->amount ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>