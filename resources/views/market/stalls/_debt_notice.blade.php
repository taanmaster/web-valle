{{-- Aviso de adeudo imprimible. Requiere $stall con rate y activeTickets --}}
@php $periods = $stall->unpaid_periods; $total = $stall->debt; @endphp
<div class="modal-body px-5 pb-5 mk-print-area">
    <div class="d-flex align-items-center gap-3 border-bottom border-2 mk-border pb-3">
        <span class="mk-seal">VS</span>
        <div>
            <p class="mk-eyebrow mb-0">Municipio de Valle de Santiago, Gto.</p>
            <h5 class="mb-0">Aviso de adeudo · Mercado Municipal</h5>
        </div>
    </div>
    <p class="text-end small mt-3">Valle de Santiago, Gto., a {{ now()->translatedFormat('j \d\e F \d\e Y') }}.</p>
    <p class="mb-0 fw-semibold">C. {{ $stall->tenant_name }}</p>
    <p class="small mb-0">Núm. de padrón {{ $stall->number }} · {{ $stall->space_label }} · {{ $stall->location }}</p>
    <p class="fw-semibold">P R E S E N T E.</p>
    <p class="small">Por medio del presente le informamos que, de acuerdo con nuestros registros, el espacio a su cargo en el Mercado Municipal presenta un adeudo por concepto de uso de espacio ({{ $stall->rate->legal_basis }}) correspondiente a los siguientes periodos:</p>
    <table class="table table-sm">
        <thead class="table-light"><tr><th>Periodo</th><th class="text-end">Importe</th></tr></thead>
        <tbody>
            @foreach ($periods as $period)
                <tr><td>{{ ucfirst($period->translatedFormat('F Y')) }}</td><td class="text-end">${{ number_format($stall->rate->monthly_amount, 2) }}</td></tr>
            @endforeach
            <tr class="fw-semibold"><td>Total adeudado</td><td class="text-end">${{ number_format($total, 2) }}</td></tr>
        </tbody>
    </table>
    <p class="small fw-semibold">({{ \App\Models\MarketTicket::amountInWords($total) }})</p>
    <p class="small">Le invitamos a regularizar su situación acudiendo a la Administración del Mercado Municipal en un plazo no mayor a cinco días hábiles. Si ya realizó el pago, le pedimos presentar su comprobante para actualizar su estado de cuenta.</p>
    <div class="text-center mt-5">
        <div class="border-top w-50 mx-auto pt-2 small">Administración del Mercado Municipal</div>
    </div>
</div>
