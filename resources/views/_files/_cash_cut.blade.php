<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Valle de Santiago</title>

    <style>
        /** 
            Set the margins of the page to 0, so the footer and the header
            can be of the full height and width !
            **/
        @page {
            margin: 1cm 1cm;
        }

        /** Define now the real margins of every page in the PDF **/        
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
        <h2 class="text-info" style="text-align: right;">ASUNTO: AUTORIZACIÓN</h2>

        <h3 style="margin-bottom: 0px;">LIC. NOMBRE DEL SECRETARIO PARTICULAR</h3>
        <h3 style="margin-bottom: 0px; margin-top: 0;">SECRETARIO PARTICULAR</h3>
        <h3 style="margin-top: 0; margin-bottom:60px;">PRESENTE:</h3>

        @php
            $totalQty = 0;
        @endphp
        @foreach($financial_supports as $financial_support)
            @php
                $totalQty += $financial_support->qty;
            @endphp
        @endforeach                           

        <p>Por medio del presente, y en atención al oficio número SPMV/018/2024, de fecha {{ Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }} suscrito por el Lic. Alberto Reyna Bravo, Secretario Particular, consistente en la solicitud de apoyo de CC. {{ $financial_supports->count() }} PETICIONARIOS con folio 018; de conformidad con las facultades previstas por los artículos 1°, 2° y 4° demás relativos a los Lineamientos de la Secretaría Particular y Despacho del Presidente, para la entrega de apoyos económicos, materiales y ayudas sociales a la población en general del Municipio de Valle de Santiago, Guanajuato y artículos 1°, fracción III, 5°, 10°, 17°, 23° y demás relativos de los Lineamientos de Racionalidad, Austeridad y Disciplina Presupuestaria de la Administración Pública Municipal de Valle de Santiago, Gto., OTÓRGUESE EL APOYO SOLICITADO POR LA CANTIDAD DE ${{ number_format($totalQty, 2) }}; SE ANEXA RELACIÓN DE LO QUE RECIBE CADA UNO DE LOS BENEFICIARIOS previo el cumplimiento de los requisitos y trámites previstos en los lineamientos antes señalados.</p>
        <p>Sin otro particular, quedo de Usted como su atento y seguro servidor.</p>

        <p>"{{ Carbon\Carbon::now()->format('Y') }}, 200 Años de Grandeza: Guanajuato como Entidad Federativa, Libre y Soberana" "Bicentenario de la Instalación de la Excelentísima Diputación Provincial de Guanajuato, 1822-1824"</p>
        
        <h3 style="margin-top: 50px;">ATENTAMENTE:</h3>

        <div style="margin-top: 50px;margin-bottom:60px;">
            <p style="margin-bottom: 0;">LIC. ISRAEL MOSQUEDA GASCA:</p>
            <p style="margin-top: 0;">PRESIDENTE MUNICIPAL DE VALLE DE SANTIAGO, GUANAJUATO</p>
        </div>

        <hr>

        <h3 style="margin-top: 30px; margin-bottom:40px">APOYOS ECONÓMICOS:</h3>

        <table class="table" style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
            <thead class="thead-light" style="background-color: #f8f9fa;">
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">Folio</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Nombre del Beneficiario</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Cantidad del Apoyo</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Número de Recibo</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Tipo de Apoyo</th>
            </tr>
            </thead>
        
            <tbody>
            @php
                $totalQty = 0;
            @endphp
            @foreach($financial_supports as $financial_support)
            @php
                $totalQty += $financial_support->qty;
            @endphp
            <tr>
                <th scope="row" style="border: 1px solid #ddd; padding: 8px;">#{{ $financial_support->int_num }}</th>
                <td style="border: 1px solid #ddd; padding: 8px;">
                {{ $financial_support->citizen->name }} {{ $financial_support->citizen->first_name }} {{ $financial_support->citizen->last_name }}
                </td>
                <td style="border: 1px solid #ddd; padding: 8px;">${{ number_format($financial_support->qty,2) }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $financial_support->receipt_num }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $financial_support->type->name }}</td>
            </tr>
            @endforeach                           
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" style="border: 1px solid #ddd; padding: 8px;"><strong>TOTAL</strong></td>
                <td style="border: 1px solid #ddd; padding: 8px;"><strong>${{ number_format($totalQty, 2) }}</strong></td>
                <td colspan="2" style="border: 1px solid #ddd; padding: 8px;"></td>
            </tr>
            </tfoot>
        </table>

        <h3 style="margin-top: 50px;">ATENTAMENTE:</h3>

        <div style="margin-top: 50px;">
            <p style="margin-bottom: 0;">LIC. ISRAEL MOSQUEDA GASCA:</p>
            <p style="margin-top: 0;">PRESIDENTE MUNICIPAL DE VALLE DE SANTIAGO, GUANAJUATO</p>
        </div>
    </main>
</body>
</html>


