<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Valle de Santiago - Checklist de Proveedor</title>

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
        
    </main>
</body>
</html>

