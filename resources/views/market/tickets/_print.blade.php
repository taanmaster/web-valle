{{-- Boleta impresa en 3 tantos (Locatario, Mercado, Tesorería) en una hoja carta. Requiere $ticket con stall e issuer --}}
@php $months = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC']; @endphp
<div class="mk-page-break">
    @foreach (['Locatario', 'Mercado', 'Tesorería'] as $copy)
        <div class="border rounded-3 p-3 mb-2 small">
            <div class="d-flex justify-content-between">
                <div class="d-flex gap-2 align-items-center">
                    <span class="mk-seal">VS</span>
                    <div>
                        <p class="mb-0 fw-semibold">Municipio de Valle de Santiago, Gto.</p>
                        <p class="mb-0 fw-bold mk-link">ENTERO PROVISIONAL PARA PAGO</p>
                        <p class="mb-0 text-muted">Mercado Municipal</p>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge mk-btn text-uppercase">{{ $copy }}</span>
                    <p class="mb-0 text-muted">Serie {{ $ticket->series }} · Folio</p>
                    <p class="mb-0 fw-bold fs-5 mk-link">{{ str_pad($ticket->folio, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <p class="mb-1">La cantidad de: <strong class="fs-6">${{ number_format($ticket->amount, 2) }}</strong> ({{ \App\Models\MarketTicket::amountInWords($ticket->amount) }})</p>
            <div class="row">
                <div class="col-7">
                    <p class="mk-label mb-0">Datos personales</p>
                    <p class="mb-0">Nombre: <strong>{{ $ticket->stall->tenant_name }}</strong></p>
                    <p class="mb-0">Núm. de padrón: <strong>{{ $ticket->stall->number }}</strong> · Giro: <strong>{{ $ticket->stall->business }}</strong></p>
                </div>
                <div class="col-5">
                    <p class="mk-label mb-0">Concepto</p>
                    <p class="mb-0">
                        Por uso de:
                        @foreach (\App\Models\MarketRate::SPACE_TYPES as $key => $label)
                            [{{ $ticket->stall->space_type === $key ? 'X' : ' ' }}] {{ $label }}
                        @endforeach
                    </p>
                    <p class="mb-0">Núm. de espacio: <strong>{{ $ticket->stall->space_number }}</strong></p>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-1 align-items-center my-1">
                <span class="mk-label mb-0 me-1">Periodo</span>
                @foreach ($months as $i => $m)
                    <span @class(['border rounded px-1', 'mk-month active' => $ticket->period->month === $i + 1])>{{ $m }}</span>
                @endforeach
                <span class="ms-2">Año: <strong>{{ $ticket->period->year }}</strong></span>
            </div>
            <p class="mb-2 fw-semibold">ART. {{ $ticket->article }} INC. {{ $ticket->subsection }} FRAC. {{ $ticket->fraction }} DE LAS DISPOSICIONES ADMINISTRATIVAS DEL EJERCICIO FISCAL {{ $ticket->fiscal_year }}</p>
            <div class="d-flex justify-content-between align-items-end mt-3">
                <span>Valle de Santiago, Gto. a {{ $ticket->created_at->format('d/m/Y') }}</span>
                <span class="border-top px-4 text-center">Elaboró: {{ $ticket->issuer->name ?? '' }}</span>
                <span class="border-top px-4 text-center">Vo.Bo. Director/Jefe y sello</span>
            </div>
        </div>
    @endforeach
</div>
