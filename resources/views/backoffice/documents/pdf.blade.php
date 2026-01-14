<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Oficio {{ $document->folio }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 11px;
            line-height: 1.4;
        }
        .page {
            width: 100%;
            min-height: 279mm;
            position: relative;
            background-image: url('{{ public_path('images/membrete.jpg') }}');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }
        .content {
            padding: 25px 50px 30px 50px;
            box-sizing: border-box;
        }
        
        /* Dependencia en esquina superior derecha */
        .dependency-header {
            text-align: right;
            margin-bottom: 10px;
        }
        .dependency-name {
            font-weight: bold;
            font-size: 12px;
            color: #333;
            text-transform: uppercase;
        }
        
        /* Información del documento (folio, asunto, fecha) */
        .document-info {
            text-align: right;
            margin-top: 80px;
            margin-bottom: 30px;
        }
        .info-row {
            margin-bottom: 5px;
            font-size: 11px;
            color: #333;
        }
        .info-label {
            font-weight: bold;
        }
        
        /* Destinatario */
        .recipient-section {
            margin: 50px 0 20px 0;
        }
        .recipient-value {
            font-weight: bold;
            font-size: 11px;
            color: #333;
        }
        .recipient-dependency {
            font-size: 10px;
            color: #444;
        }
        
        /* Cuerpo del oficio */
        .body-container {
            margin: 25px 0;
            padding: 10px 0;
        }
        .body-content {
            text-align: justify;
            font-size: 11px;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        
        /* Firma del solicitante */
        .signature-section {
            text-align: center;
            margin-top: 40px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
        }
        .signature-img {
            max-width: 150px;
            max-height: 60px;
            margin-bottom: 5px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 11px;
            color: #333;
            text-transform: uppercase;
        }
        .signature-dependency {
            font-size: 10px;
            color: #444;
        }
        
        /* Sello */
        .stamp-container {
            position: absolute;
            right: 80px;
            bottom: 180px;
        }
        .stamp-img {
            max-width: 100px;
            max-height: 100px;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="content">
            <!-- Dependencia en esquina superior derecha -->
            <div class="dependency-header">
                <div class="dependency-name">{{ $document->dependency->name ?? 'N/A' }}</div>
            </div>

            <!-- Información del documento: Folio, Asunto, Fecha -->
            <div class="document-info">
                <div class="info-row">
                    <span class="info-label">Folio:</span> {{ $document->folio }}
                </div>
                <div class="info-row">
                    <span class="info-label">Asunto:</span> {{ $document->subject }}
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha:</span> {{ $document->issue_date->format('d/m/Y') }}
                </div>
            </div>

            <!-- Destinatario -->
            <div class="recipient-section">
                <div class="recipient-value">{{ $document->sender }}</div>
                @if($document->senderDependency)
                    <div class="recipient-dependency">{{ $document->senderDependency->name }}</div>
                @endif
            </div>

            <!-- Cuerpo del oficio -->
            <div class="body-container">
                <div class="body-content">{{ $document->body }}</div>
            </div>

            <!-- Firma del solicitante -->
            <div class="signature-section">
                <div class="signature-box">
                    @if($document->signature_s3_url)
                        <img src="{{ $document->signature_s3_url }}" class="signature-img" alt="Firma"><br>
                    @endif
                    <div class="signature-name">{{ $document->requester }}</div>
                    @if($document->dependency)
                        <div class="signature-dependency">{{ $document->dependency->name }}</div>
                    @endif
                </div>
            </div>

            <!-- Sello (si existe) -->
            @if($document->stamp_s3_url)
                <div class="stamp-container">
                    <img src="{{ $document->stamp_s3_url }}" class="stamp-img" alt="Sello">
                </div>
            @endif
        </div>
    </div>
</body>
</html>
