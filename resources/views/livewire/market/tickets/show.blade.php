@php $t = $ticket; @endphp
<div>
    {{-- Encabezado --}}
    <div class="card mb-3">
        <div class="card-body bg-danger-subtle bg-opacity-25 d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <p class="mk-eyebrow mb-1">Entero provisional · Serie-folio</p>
                <h4 class="mb-1 d-flex align-items-center gap-2">
                    {{ $t->folio_label }}
                    <span class="badge rounded-pill fs-6 bg-{{ $t->stage_color }}-subtle text-{{ $t->stage_color }}">{{ $t->stage_label }}</span>
                </h4>
                @if ($t->cancelled_at)
                    <small class="text-danger">Boleta cancelada. Motivo: {{ $t->cancel_reason }}. El folio no se reutiliza y el mes vuelve a quedar pendiente en el padrón.</small>
                @endif
            </div>
            <div class="d-flex gap-2">
                <button type="button" wire:click="$set('showPrint', true)" class="btn btn-outline-secondary btn-sm" @disabled($t->cancelled_at)>Imprimir 3 tantos</button>
                @if ($t->stage === 'recibo_listo')
                    <button type="button" wire:click="openDelivery" class="btn btn-info btn-sm">Registrar entrega</button>
                @endif
                @if ($t->can_cancel)
                    <button type="button" wire:click="$set('confirmingCancel', true)" class="btn btn-outline-danger btn-sm">Cancelar boleta</button>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card mb-3">
                <div class="card-header mk-section-header">Datos</div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            'Serie-folio' => $t->folio_label, 'Fecha de emisión' => $t->created_at->format('d/m/Y H:i'), 'Elaboró' => $t->issuer->name ?? '—',
                            'Locatario' => $t->stall->tenant_name, 'Núm. de padrón' => $t->stall->number, 'Giro' => $t->stall->business,
                            'Por uso de' => $t->stall->space_type_label, 'Núm. de espacio' => $t->stall->space_number, 'Periodo pagado' => $t->period_label,
                            'Corte' => $t->cut ? $t->cut->cut_date->format('d/m/Y').' · entregado a Tesorería' : 'Sin corte',
                        ] as $label => $value)
                            <div class="col-md-4">
                                <p class="mk-label mb-0">{{ $label }}</p>
                                <p class="mb-0 fw-semibold">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mk-soft rounded-3 p-3 mt-3">
                        <p class="mk-label mb-0">Importe</p>
                        <p class="fs-4 fw-semibold mb-0">${{ number_format($t->amount, 2) }}</p>
                        <small class="text-muted">{{ \App\Models\MarketTicket::amountInWords($t->amount) }}</small>
                    </div>
                    <div class="row g-2 mt-2">
                        @foreach (['Artículo' => $t->article, 'Inciso' => $t->subsection, 'Fracción' => $t->fraction, 'Ejercicio fiscal' => $t->fiscal_year] as $label => $value)
                            <div class="col-3"><div class="mk-soft rounded-3 p-2"><p class="mk-label mb-0">{{ $label }}</p><p class="fw-semibold mb-0">{{ $value }}</p></div></div>
                        @endforeach
                    </div>
                    <a href="{{ route('market.stalls.show', $t->stall) }}" class="small mk-link d-inline-block mt-3">Ver estado de cuenta del padrón →</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header mk-section-header">Recibo de Tesorería</div>
                <div class="card-body">
                    @if ($t->receipt_s3_url)
                        <div class="d-flex justify-content-between align-items-center mk-soft rounded-3 p-2">
                            <div>
                                <p class="fw-semibold mb-0">{{ $t->receipt_name }}</p>
                                <small class="text-muted">Adjuntado el {{ $t->receipt_attached_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ $t->receipt_s3_url }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm">Ver completo</a>
                                <label class="btn btn-outline-secondary btn-sm mb-0">Reemplazar<input type="file" class="d-none" wire:model="receipt" accept=".pdf,.jpg,.jpeg,.png"></label>
                            </div>
                        </div>
                    @elseif ($t->market_cut_id && ! $t->cancelled_at)
                        <label class="d-block border border-dashed rounded-3 p-4 text-center mb-0">
                            <p class="fw-semibold mb-1">Adjunta aquí el recibo de Tesorería</p>
                            <small class="text-muted d-block mb-2">PDF, JPG o PNG. Normalmente se adjuntan juntos desde el corte del {{ $t->cut->cut_date->format('d/m/Y') }}.</small>
                            <span class="btn mk-btn btn-sm">Seleccionar archivo</span>
                            <input type="file" class="d-none" wire:model="receipt" accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                    @else
                        <small class="text-muted">{{ $t->cancelled_at ? 'La boleta está cancelada.' : 'Se adjunta cuando la boleta entra a un corte y Tesorería emite el recibo.' }}</small>
                    @endif
                    <span wire:loading wire:target="receipt" class="small text-muted">Subiendo...</span>
                    @error('receipt')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card mb-3">
                <div class="card-header mk-section-header">Entrega del recibo</div>
                <div class="card-body">
                    @if ($t->delivered_at)
                        <span class="badge rounded-pill bg-success-subtle text-success mb-2">Entregado</span>
                        <div class="row g-2 small">
                            <div class="col-6"><p class="mk-label mb-0">Fecha de entrega</p>{{ $t->delivered_at->format('d/m/Y') }}</div>
                            <div class="col-6"><p class="mk-label mb-0">Recibió</p>{{ $t->delivered_to }}</div>
                            <div class="col-6"><p class="mk-label mb-0">Entregó</p>{{ $t->deliverer->name ?? '—' }}</div>
                            @if ($t->delivery_proof_s3_url)
                                <div class="col-6"><p class="mk-label mb-0">Acuse</p><a href="{{ $t->delivery_proof_s3_url }}" target="_blank" rel="noopener">Ver foto</a></div>
                            @endif
                            @if ($t->delivery_notes)
                                <div class="col-12"><p class="mk-label mb-0">Observaciones</p>{{ $t->delivery_notes }}</div>
                            @endif
                        </div>
                    @else
                        <span class="badge rounded-pill bg-{{ $t->stage_color }}-subtle text-{{ $t->stage_color }} mb-2">{{ $t->stage === 'recibo_listo' ? 'Por entregar' : 'Pendiente de recibo' }}</span>
                        <small class="d-block text-muted">
                            {{ $t->stage === 'recibo_listo' ? 'Entrégalo cuando el locatario venga; en «Cobrar» se le avisa automáticamente.' : 'Primero se adjunta el recibo de Tesorería.' }}
                        </small>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6>Historial</h6>
                    @foreach ($t->history as [$text, $date, $by])
                        <div class="border-start border-2 ps-3 pb-2">
                            <p class="small mb-0">{{ $text }}</p>
                            <small class="text-muted">{{ $date->format('d/m/Y H:i') }}{{ $by ? ' · '.$by : '' }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if ($confirmingCancel)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" wire:submit="cancel">
                    <div class="modal-header mk-section-header">
                        <div>
                            <h6 class="mb-0 text-white">Cancelar boleta</h6>
                            <small class="text-white-50">{{ $t->folio_label }} · {{ $t->stall->tenant_name }} · {{ $t->period_label }}</small>
                        </div>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Motivo de la cancelación *</label>
                        <textarea wire:model="cancelReason" rows="3" class="form-control" placeholder="Explica por qué se anula la boleta..."></textarea>
                        @error('cancelReason')<small class="text-danger d-block">{{ $message }}</small>@enderror
                        <small class="text-muted">El folio no se reutiliza y el mes vuelve a quedar pendiente en el padrón.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('confirmingCancel', false)">Volver</button>
                        <button type="submit" class="btn btn-danger btn-sm">Cancelar boleta</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif

    @if ($showDelivery)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" wire:submit="deliver">
                    <div class="modal-header bg-info">
                        <div>
                            <h6 class="mb-0">Registrar entrega del recibo</h6>
                            <small>{{ $t->folio_label }} · {{ $t->period_label }} · {{ $t->stall->space_label }}</small>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Fecha de entrega *</label>
                                <input type="date" wire:model="deliveredAt" class="form-control" max="{{ now()->toDateString() }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Entregó</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Recibió * <small class="text-muted">(puede ser otra persona)</small></label>
                                <input type="text" wire:model="deliveredTo" class="form-control">
                                @error('deliveredTo')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Acuse <small class="text-muted">(opcional: foto de la firma o del acuse)</small></label>
                                <input type="file" wire:model="deliveryProof" class="form-control" accept="image/*" capture="environment">
                                @error('deliveryProof')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Observaciones</label>
                                <textarea wire:model="deliveryNotes" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showDelivery', false)">Cancelar</button>
                        <button type="submit" class="btn btn-info btn-sm" wire:loading.attr="disabled">Registrar entrega</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif

    @if ($showPrint)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="d-flex justify-content-end gap-2 p-2 mk-no-print">
                        <button type="button" class="btn mk-btn btn-sm" onclick="window.print()">Imprimir</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showPrint', false)">Cerrar</button>
                    </div>
                    <div class="modal-body mk-print-area">
                        @include('market.tickets._print', ['ticket' => $t])
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif
</div>
