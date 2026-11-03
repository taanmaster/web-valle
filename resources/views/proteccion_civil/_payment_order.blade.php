{{-- Entero de pago imprimible (intranet y portal ciudadano). Requiere $case con los campos payment_order_* --}}
<div class="modal-body px-5 pb-5 pc-print-area">
    <div class="d-flex justify-content-between align-items-center border-bottom border-2 pc-border pb-3">
        <div class="d-flex align-items-center gap-3">
            <span class="pc-seal">VS</span>
            <div>
                <p class="pc-eyebrow mb-0">Municipio de Valle de Santiago, Gto.</p>
                <h6 class="mb-0">Coordinación Municipal de Protección Civil</h6>
            </div>
        </div>
        <div class="text-end">
            <small class="text-muted d-block">Entero</small>
            <span class="font-monospace fw-semibold">{{ $case->payment_order_folio }}</span>
        </div>
    </div>

    <h4 class="text-center mt-4 mb-1">ENTERO DE PAGO</h4>
    <p class="text-center text-muted">{{ $case->procedure->name }}</p>

    <p>Se emite el presente entero para el pago de derechos en las oficinas de la Coordinación Municipal de Protección Civil.</p>

    <table class="table table-bordered">
        <tbody>
            <tr><td class="text-muted w-25">Expediente</td><td class="fw-semibold">{{ $case->folio }}</td></tr>
            <tr><td class="text-muted">Contribuyente</td><td class="fw-semibold">{{ $case->applicant_name }}</td></tr>
            <tr><td class="text-muted">Concepto</td><td class="fw-semibold">{{ $case->payment_order_concept }}</td></tr>
            <tr><td class="text-muted">Importe</td><td class="fw-semibold">${{ number_format($case->payment_order_amount, 2) }}</td></tr>
            <tr><td class="text-muted">Fecha de emisión</td><td class="fw-semibold">{{ $case->payment_order_generated_at->format('d/m/Y H:i') }}</td></tr>
        </tbody>
    </table>

    <p class="small">Lugar de pago: Coordinación Municipal de Protección Civil · Av. Juárez 210, Zona Centro, Valle de Santiago, Gto., lunes a viernes de 9:00 a 15:00.</p>
    <p class="small">Valle de Santiago, Gto., a {{ $case->payment_order_generated_at->translatedFormat('j \d\e F \d\e Y') }}.</p>

    <div class="text-center mt-5">
        <div class="border-top w-50 mx-auto pt-2">
            <p class="fw-semibold mb-0">{{ $case->paymentOrderAuthor->name ?? '' }}</p>
            <small class="text-muted">Coordinación Municipal de Protección Civil</small>
        </div>
    </div>
</div>
