<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo a Multipagos BanBajío...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background: #f5f5f5;
            color: #333;
        }
        .spinner {
            width: 48px; height: 48px;
            border: 5px solid #ccc;
            border-top-color: #7b2d8b;
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
            margin-bottom: 1.2rem;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        p { font-size: 1rem; color: #555; }
    </style>
</head>
<body>
    <div class="spinner"></div>
    <p>Redirigiendo al portal de pago de <strong>BanBajío</strong>, por favor espere&hellip;</p>

    {{-- Formulario oculto que se auto-envía al portal de Multipagos Bajío --}}
    <form id="bajio-form" method="POST" action="{{ $multipagosUrl }}">
        <input type="hidden" name="cl_folio"      value="{{ $clFolio }}">
        <input type="hidden" name="cl_referencia" value="{{ $clRef }}">
        <input type="hidden" name="dl_monto"      value="{{ $dlMonto }}">
        <input type="hidden" name="servicio"      value="{{ $servicio }}">
        <input type="hidden" name="cl_concepto"   value="{{ $clConcepto }}">
        <input type="hidden" name="hash"          value="{{ $hash }}">
    </form>

    <script>
        document.getElementById('bajio-form').submit();
    </script>
</body>
</html>
