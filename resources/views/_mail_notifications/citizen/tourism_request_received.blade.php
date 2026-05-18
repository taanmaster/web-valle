{{-- Modelo: TourismThirdPartyRequest --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibimos tu solicitud de apoyo — Folio {{ $folio }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #1a1a18;
            background: #f4f1eb;
        }
        .wrapper {
            max-width: 600px;
            margin: 32px auto;
            background: #ffffff;
            border: 1px solid #d8d2c6;
        }
        .email-header {
            background: #1a3a2a;
            padding: 24px 32px;
            border-bottom: 4px solid #c84b2f;
        }
        .email-header img { width: 80px; display: block; }
        .email-header .dept {
            color: #a8c4b0;
            font-size: 11px;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .email-encabezado {
            background: #e8f0eb;
            border-left: 4px solid #1a3a2a;
            padding: 16px 32px;
            font-size: 17px;
            font-weight: 600;
            color: #1a3a2a;
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
            border-bottom: 1px solid #e8e4de;
        }
        .data-table td:first-child {
            font-weight: 600;
            color: #1a3a2a;
            width: 44%;
            background: #f4f1eb;
        }
        .status-badge {
            display: inline-block;
            background: #e8f0eb;
            color: #1a3a2a;
            border: 1px solid #a8c4b0;
            font-size: 12px;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 2px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .email-footer {
            background: #1a3a2a;
            padding: 18px 32px;
            font-size: 12px;
            color: #a8c4b0;
            line-height: 1.5;
        }
        .email-footer strong { color: #ffffff; }
        .email-footer em { display: block; margin-top: 6px; color: #7a9a85; }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="email-header">
            <img src="{{ asset('front/img/logo-valle.png') }}" alt="H. Ayuntamiento de Valle de Santiago">
            <p class="dept">Dirección de Turismo</p>
        </div>

        <div class="email-encabezado">
            Solicitud registrada correctamente
        </div>

        <div class="email-body">
            <p>Hola, <strong>{{ $nombre_ciudadano }}</strong>.</p>
            <p>Hemos recibido tu solicitud de apoyo a la Dirección de Turismo del Municipio de Valle de Santiago.</p>

            <table class="data-table">
                <tr>
                    <td>Folio</td>
                    <td>{{ $folio }}</td>
                </tr>
                <tr>
                    <td>Fecha de registro</td>
                    <td>{{ $fecha_registro }}</td>
                </tr>
                <tr>
                    <td>Estatus</td>
                    <td><span class="status-badge">En revisión</span></td>
                </tr>
            </table>

            <p>Nuestro equipo revisará tu solicitud y te contactará.</p>
        </div>

        <div class="email-footer">
            <strong>H. Ayuntamiento de Valle de Santiago, Guanajuato</strong> | Dirección de Turismo
            <em>Este es un mensaje automático. Por favor no respondas directamente a este correo.</em>
        </div>
    </div>
</body>
</html>
