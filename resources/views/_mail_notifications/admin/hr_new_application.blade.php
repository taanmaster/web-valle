{{-- Modelo: HRApplication --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva postulación recibida — Folio {{ $folio }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #1a1a18;
            background: #eae8e4;
        }
        .wrapper {
            max-width: 600px;
            margin: 32px auto;
            background: #ffffff;
            border: 1px solid #c8c4bc;
        }
        .email-header {
            background: #2c2c2a;
            padding: 24px 32px;
            border-bottom: 4px solid #c84b2f;
        }
        .email-header img { width: 80px; display: block; }
        .email-header .dept {
            color: #9a9890;
            font-size: 11px;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .email-encabezado {
            background: #f0ede8;
            border-left: 4px solid #2c2c2a;
            padding: 16px 32px;
            font-size: 17px;
            font-weight: 600;
            color: #2c2c2a;
        }
        .email-body {
            padding: 28px 32px;
            font-size: 14px;
            color: #1a1a18;
        }
        .email-body p { margin-bottom: 14px; }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 20px;
            font-size: 13px;
        }
        .data-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #e0dcd6;
        }
        .data-table td:first-child {
            font-weight: 600;
            color: #2c2c2a;
            width: 44%;
            background: #f0ede8;
        }
        .email-footer {
            background: #2c2c2a;
            padding: 18px 32px;
            font-size: 12px;
            color: #9a9890;
            line-height: 1.5;
        }
        .email-footer strong { color: #ffffff; }
        .email-footer em { display: block; margin-top: 6px; color: #72706a; }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="email-header">
            <img src="{{ asset('front/img/logo-valle.png') }}" alt="H. Ayuntamiento de Valle de Santiago">
            <p class="dept">Sistema de Gestión — Dirección de Recursos Humanos</p>
        </div>

        <div class="email-encabezado">
            Nueva solicitud de empleo
        </div>

        <div class="email-body">
            <p>Hola, <strong>{{ $nombre_servidor }}</strong>.</p>
            <p>Se ha registrado una nueva postulación en el sistema de Recursos Humanos.</p>

            <table class="data-table">
                <tr>
                    <td>Folio</td>
                    <td>{{ $folio }}</td>
                </tr>
                <tr>
                    <td>Candidato</td>
                    <td>{{ $nombre_ciudadano }}</td>
                </tr>
                <tr>
                    <td>Plaza o área solicitada</td>
                    <td>{{ $plaza_area }}</td>
                </tr>
            </table>

            <p>Accede al sistema para revisar el expediente del candidato y registrar tu evaluación.</p>
        </div>

        <div class="email-footer">
            <strong>Sistema de Gestión Municipal — Valle de Santiago, Guanajuato</strong>
            <em>Este mensaje es confidencial y está dirigido exclusivamente al personal autorizado.</em>
        </div>

    </div>
</body>
</html>
