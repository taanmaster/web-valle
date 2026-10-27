{{-- Estado de cuenta imprimible del año. Requiere $stall, $months y $year --}}
<div class="modal-body px-5 pb-5 mk-print-area">
    <div class="d-flex justify-content-between align-items-center border-bottom border-2 mk-border pb-3">
        <div class="d-flex align-items-center gap-3">
            <span class="mk-seal">VS</span>
            <div>
                <p class="mk-eyebrow mb-0">Municipio de Valle de Santiago, Gto. · Mercado Municipal</p>
                <h5 class="mb-0">Estado de cuenta {{ $year }}</h5>
            </div>
        </div>
        <small class="text-muted">Emitido el {{ now()->format('d/m/Y') }}</small>
    </div>
    <div class="row small mt-3">
        <div class="col-6">
            <p class="mb-0">Locatario: <strong>{{ $stall->tenant_name }}</strong></p>
            <p class="mb-0">Espacio: <strong>{{ $stall->space_label }}</strong>{{ $stall->aisle ? ' · Pasillo '.$stall->aisle : '' }} · {{ $stall->location }}</p>
            <p class="mb-0">Cuota mensual: <strong>${{ number_format($stall->rate->monthly_amount, 2) }}</strong></p>
        </div>
        <div class="col-6">
            <p class="mb-0">Núm. de padrón: <strong>{{ $stall->number }}</strong></p>
            <p class="mb-0">Giro: <strong>{{ $stall->business }}</strong></p>
            <p class="mb-0">Fundamento: <strong>{{ $stall->rate->legal_basis }}</strong></p>
        </div>
    </div>
    <table class="table table-sm mt-3">
        <thead class="table-light"><tr><th>Mes</th><th>Estatus</th><th>Folio</th><th>Fecha de pago</th><th class="text-end">Importe</th></tr></thead>
        <tbody>
            @foreach ($months as $month)
                @php $t = $month['ticket']; @endphp
                <tr>
                    <td>{{ ucfirst($month['date']->translatedFormat('F')) }}</td>
                    <td>{{ ['pagado' => 'Pagado', 'adeudo' => 'Adeudo', 'por_vencer' => 'Por vencer', 'por_generar' => 'Por generar', 'no_aplica' => '—'][$month['state']] }}</td>
                    <td>{{ $t?->folio_label ?? '—' }}</td>
                    <td>{{ $t?->created_at->format('d/m/Y') ?? '—' }}</td>
                    <td class="text-end">{{ $t ? '$'.number_format($t->amount, 2) : (in_array($month['state'], ['adeudo', 'por_vencer']) ? '$'.number_format($stall->rate->monthly_amount, 2) : '—') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="text-end">Adeudo total a la fecha: <strong>${{ number_format($stall->debt, 2) }}</strong> <small class="text-muted">({{ $stall->months_owed }} meses)</small></p>
</div>
