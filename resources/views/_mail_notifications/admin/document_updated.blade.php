{{-- Modelo: DocumentCertificate / IdentificationCertificate --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos actualizados — Folio {{ $folio }}</title>
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
        .status-badge-old {
            display: inline-block;
            background: #fdf0eb;
            color: #8b3a1a;
            border: 1px solid #e8b89a;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 2px;
            text-transform: uppercase;
        }
        .status-badge-new {
            display: inline-block;
            background: #f0ede8;
            color: #2c2c2a;
            border: 1px solid #c8c4bc;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 2px;
            text-transform: uppercase;
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
            <p class="dept">Sistema de Gestión — Secretaría de Ayuntamiento</p>
        </div>

        <div class="email-encabezado">
            El ciudadano actualizó su documentación
        </div>

        <div class="email-body">
            <p>Hola, <strong>{{ $nombre_servidor }}</strong>.</p>
            <p>El ciudadano <strong>{{ $nombre_ciudadano }}</strong> ha enviado documentos actualizados para la solicitud con folio <strong>{{ $folio }}</strong>.</p>

            <table class="data-table">
                <tr>
                    <td>Folio</td>
                    <td>{{ $folio }}</td>
                </tr>
                <tr>
                    <td>Tipo de trámite</td>
                    <td>{{ $tipo_constancia }}</td>
                </tr>
                <tr>
                    <td>Fecha de actualización</td>
                    <td>{{ $fecha_actualizacion }}</td>
                </tr>
                <tr>
                    <td>Documentos actualizados</td>
                    <td>{{ $lista_documentos_actualizados }}</td>
                </tr>
                <tr>
                    <td>Estatus anterior</td>
                    <td><span class="status-badge-old">Rechazado</span></td>
                </tr>
                <tr>
                    <td>Estatus actual</td>
                    <td><span class="status-badge-new">Pendiente de revisión</span></td>
                </tr>
            </table>

            <p>Por favor revisa los nuevos documentos y registra tu resolución.</p>
        </div>

        <div class="email-footer">
            <strong>Sistema de Gestión Municipal — Valle de Santiago, Guanajuato</strong>
            <em>Este mensaje es confidencial y está dirigido exclusivamente al personal autorizado.</em>
        </div>

    </div>
</body>
</html>
