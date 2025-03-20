<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Valle de Santiago - Checklist de Contratista</title>

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
        <h2 class="section-title">Checklist de Contratista</h2>
        <table>
            <tbody>
                <tr>
                    <th>Código De Programa</th>
                    <td>{{ $checklist->program_code ?? 'N/A' }}</td>
                    <th>Convenio Modificatorio En Tiempo - Inicia</th>
                    <td>{{ $checklist->modification_agreement_time_start ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Nombre Del Programa</th>
                    <td>{{ $checklist->program_name ?? 'N/A' }}</td>
                    <th>Convenio Modificatorio En Tiempo - Termina</th>
                    <td>{{ $checklist->modification_agreement_time_end ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Fuente Del Financiamiento</th>
                    <td>{{ $checklist->funding_source ?? 'N/A' }}</td>
                    <th>Estimado</th>
                    <td>{{ $checklist->estimated ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Partida</th>
                    <td>{{ $checklist->budget_item ?? 'N/A' }}</td>
                    <th>IVA</th>
                    <td>{{ $checklist->iva ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>No. De Obra</th>
                    <td>{{ $checklist->work_number ?? 'N/A' }}</td>
                    <th>Suma</th>
                    <td>{{ $checklist->sum ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Reserva, Doc Pres</th>
                    <td>{{ $checklist->reserve_doc_pres ?? 'N/A' }}</td>
                    <th>Amortización Del Anticipo</th>
                    <td>{{ $checklist->advance_amortization ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>No. De Activo Fijo</th>
                    <td>{{ $checklist->fixed_asset_number ?? 'N/A' }}</td>
                    <th>Subtotal</th>
                    <td>{{ $checklist->subtotal ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Contrato No</th>
                    <td>{{ $checklist->contract_number ?? 'N/A' }}</td>
                    <th>Sanción</th>
                    <td>{{ $checklist->penalty ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Contratista</th>
                    <td>{{ $checklist->contractor->name ?? 'N/A' }}</td>
                    <th>Alcance Neto</th>
                    <td>{{ $checklist->net_scope ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Registro Federal De Contribuyente</th>
                    <td>{{ $checklist->taxpayer_registration ?? 'N/A' }}</td>
                    <th>Subtotal 2</th>
                    <td>{{ $checklist->subtotal_2 ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Modalidad De Adjudicación</th>
                    <td>{{ $checklist->award_method ?? 'N/A' }}</td>
                    <th>IVA 2</th>
                    <td>{{ $checklist->iva_2 ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Con Recursos</th>
                    <td>{{ $checklist->with_resources ? 'Sí' : 'No' }}</td>
                    <th>Total</th>
                    <td>{{ $checklist->total ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Convenio</th>
                    <td>{{ $checklist->agreement ?? 'N/A' }}</td>
                    <th>FAISM 2024 Paga</th>
                    <td>{{ $checklist->faism_2024_pays ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Anexo De Ejecución</th>
                    <td>{{ $checklist->execution_annex ?? 'N/A' }}</td>
                    <th>Estado Paga</th>
                    <td>{{ $checklist->state_pays ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Obra</th>
                    <td>{{ $checklist->work ?? 'N/A' }}</td>
                    <th>Elaborado Por</th>
                    <td>{{ $checklist->prepared_by ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Importe Del Contrato</th>
                    <td>{{ $checklist->contract_amount ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Monto Del Anticipo</th>
                    <td>{{ $checklist->advance_amount ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Fecha De Firma Del Contrato</th>
                    <td>{{ $checklist->contract_signing_date ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Vigencia Contrato - Inicia</th>
                    <td>{{ $checklist->contract_validity_start ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Vigencia Contrato - Termina</th>
                    <td>{{ $checklist->contract_validity_end ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Modificación De La Vigencia - Inicia</th>
                    <td>{{ $checklist->validity_modification_start ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Modificación De La Vigencia - Termina</th>
                    <td>{{ $checklist->validity_modification_end ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Convenio Modificatorio En Monto</th>
                    <td>{{ $checklist->modification_agreement_amount ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Importe</th>
                    <td>{{ $checklist->amount ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <h2 class="section-title">Elementos del Checklist</h2>
        <ul>
            @foreach($checklist->checklist->elements as $element)
                <li>{{ $element->name }}</li>
            @endforeach
        </ul>
    </main>
</body>
</html>