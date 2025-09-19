<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Salida - {{ $folio }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 18px;
            color: #7f8c8d;
            font-weight: normal;
        }
        
        .header .subtitle {
            margin: 10px 0 0 0;
            font-size: 14px;
            color: #95a5a6;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 8px 10px;
            border-bottom: 1px dotted #bdc3c7;
            vertical-align: top;
        }
        
        .info-label {
            font-weight: bold;
            color: #2c3e50;
            width: 25%;
        }
        
        .info-value {
            color: #34495e;
            width: 25%;
        }
        
        .concept-section {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 25px;
        }
        
        .concept-title {
            font-weight: bold;
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        
        .concept-item {
            margin: 5px 0;
            color: #495057;
        }
        
        .amounts-section {
            background-color: #ffffff;
            border: 2px solid #3498db;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 25px;
        }
        
        .amount-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .amount-label {
            font-weight: bold;
            color: #2c3e50;
        }
        
        .amount-value {
            font-weight: bold;
            color: #27ae60;
        }
        
        .total-row {
            border-top: 2px solid #3498db;
            padding-top: 8px;
            margin-top: 15px;
        }
        
        .total-row .amount-label,
        .total-row .amount-value {
            font-size: 16px;
            color: #2c3e50;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #bdc3c7;
            padding-top: 15px;
        }
        
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 40%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 11px;
            color: #7f8c8d;
        }
        
        .folio-box {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(52, 152, 219, 0.1);
            z-index: -1;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="watermark">DIF MEDICAMENTOS</div>
    
    <div class="folio-box">
        FOLIO: {{ $folio }}
    </div>
    
    <div class="header">
        <h1>SISTEMA DIF</h1>
        <h2>RECIBO DE SALIDA DE MEDICAMENTOS</h2>
        <div class="subtitle">Control de Inventario Farmacéutico</div>
    </div>
    
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="info-label">Fecha de Salida:</td>
                <td class="info-value">{{ $fecha_salida }}</td>
                <td class="info-label">Folio:</td>
                <td class="info-value">{{ $folio }}</td>
            </tr>
            <tr>
                <td class="info-label">Beneficiario:</td>
                <td class="info-value">{{ $beneficiario }}</td>
                <td class="info-label">Fecha de Emisión:</td>
                <td class="info-value">{{ $fecha_generacion }}</td>
            </tr>
        </table>
    </div>
    
    <div class="concept-section">
        <div class="concept-title">CONCEPTO DEL MEDICAMENTO</div>
        
        <div class="concept-item">
            <strong>Medicamento:</strong> {{ $concepto['medicamento'] }}
        </div>
        
        <div class="concept-item">
            <strong>Variante:</strong> {{ $concepto['variante'] }}
        </div>
        
        <div class="concept-item">
            <strong>Código SKU:</strong> <code style="background-color: #ecf0f1; padding: 2px 6px; border-radius: 3px;">{{ $concepto['sku'] }}</code>
        </div>
    </div>
    
    <div class="amounts-section">
        <div class="amount-row">
            <div class="amount-label">Cantidad:</div>
            <div class="amount-value">{{ number_format($cantidad, 0) }} unidades</div>
        </div>
        
        <div class="amount-row">
            <div class="amount-label">Precio Unitario:</div>
            <div class="amount-value">${{ number_format($precio_unitario, 2) }}</div>
        </div>
        
        <div class="amount-row total-row">
            <div class="amount-label">VALOR TOTAL:</div>
            <div class="amount-value">${{ number_format($subtotal, 2) }}</div>
        </div>
    </div>
    
    <div class="footer">
        <div>
            <strong>Sistema DIF - Control de Inventario de Medicamentos</strong><br>
            Este documento es una constancia de la salida de medicamentos del inventario.<br>
            Generado automáticamente el {{ $fecha_generacion }}
        </div>
    </div>
</body>
</html>
