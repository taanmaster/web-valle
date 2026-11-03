@php
    $monthStyles = [
        'pagado' => ['Pagado', 'bg-success-subtle border-success'],
        'adeudo' => ['Adeudo', 'bg-danger-subtle border-danger'],
        'por_vencer' => ['Por vencer', 'bg-warning-subtle border-warning'],
        'por_generar' => ['Por generar', 'mk-soft'],
        'no_aplica' => ['Sin alta', 'bg-light text-muted'],
    ];
@endphp
<div>
    {{-- Encabezado --}}
    <div class="card mb-3">
        <div class="card-body bg-danger-subtle bg-opacity-25 rounded-top">
            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                <div>
                    <p class="mk-eyebrow mb-1">Padrón {{ $stall->number }} · {{ $stall->space_label }}</p>
                    <h4 class="mb-1">{{ $stall->tenant_name }}</h4>
                    <span class="badge rounded-pill bg-{{ $stall->payment_status_color }}-subtle text-{{ $stall->payment_status_color }}">{{ $stall->payment_status_label }}</span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" wire:click="$set('showStatement', true)" class="btn btn-outline-secondary btn-sm">Imprimir estado de cuenta</button>
                    @if (in_array($stall->payment_status, ['vencido', 'moroso']))
                        <button type="button" wire:click="$set('showNotice', true)" class="btn btn-outline-secondary btn-sm">Imprimir aviso de adeudo</button>
                    @endif
                    <a href="{{ route('market.stalls.edit', $stall) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
                    @if ($stall->status === 'activo')
                        <button type="button" wire:click="$set('confirmingDeactivate', true)" class="btn btn-outline-danger btn-sm">Dar de baja</button>
                        <a href="{{ route('market.tickets.collect', ['stall' => $stall->id]) }}" class="btn mk-btn btn-sm">Cobrar</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach ([
                    'Teléfono' => $stall->phone, 'Tipo de espacio' => $stall->space_type_label, 'Núm. de espacio' => $stall->space_number,
                    'Pasillo' => $stall->aisle ?: '—', 'Ubicación' => $stall->location, 'Giro' => $stall->business,
                    'Fecha de alta' => $stall->registered_at->format('d/m/Y'), 'Paga desde' => ucfirst($stall->billing_start->translatedFormat('F Y')),
                    'Estatus' => $stall->status === 'baja' ? 'Baja desde '.$stall->deactivated_at->format('d/m/Y') : 'Activo',
                ] as $label => $value)
                    <div class="col-6 col-md-2">
                        <p class="mk-label mb-0">{{ $label }}</p>
                        <p class="mb-0 fw-semibold">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
            <div class="row g-2 mt-2">
                @foreach (['Cuota mensual' => '$'.number_format($stall->rate->monthly_amount, 2), 'Artículo' => $stall->rate->article, 'Inciso' => $stall->rate->subsection, 'Fracción' => $stall->rate->fraction] as $label => $value)
                    <div class="col-md-3">
                        <div class="mk-soft rounded-3 p-2">
                            <p class="mk-label mb-0">{{ $label }}</p>
                            <p class="fw-semibold mb-0">{{ $value }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-5">
            <div @class(['card h-100 mb-0', 'border-success' => $stall->months_owed === 0, 'border-danger' => $stall->months_owed > 0])>
                <div class="card-body">
                    <p class="mk-label mb-0">Adeudo total</p>
                    <h3 @class(['mb-0', 'text-success' => $stall->months_owed === 0, 'text-danger' => $stall->months_owed > 0])>${{ number_format($stall->debt, 2) }}</h3>
                    <small class="text-muted">
                        @if ($stall->months_owed === 0)
                            Al corriente en sus pagos
                        @else
                            {{ $stall->months_owed }} mes(es): {{ collect($stall->unpaid_periods)->map(fn ($p) => ucfirst($p->translatedFormat('M Y')))->implode(', ') }}
                        @endif
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card h-100 mb-0">
                <div class="card-body">
                    <p class="mk-label mb-2">Otros espacios de la misma persona</p>
                    @forelse ($siblings as $sibling)
                        <a href="{{ route('market.stalls.show', $sibling) }}" class="d-flex justify-content-between mk-soft rounded-3 p-2 mb-1 text-dark text-decoration-none">
                            <span>{{ $sibling->number }} · {{ $sibling->space_label }} · {{ $sibling->business }}</span>
                            <span class="badge rounded-pill bg-{{ $sibling->payment_status_color }}-subtle text-{{ $sibling->payment_status_color }}">{{ $sibling->payment_status_label }}</span>
                        </a>
                    @empty
                        <small class="text-muted">No tiene otros espacios registrados con este teléfono.</small>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Estado de cuenta --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Estado de cuenta</h6>
                <select wire:model.live="year" class="form-select form-select-sm w-auto">
                    @foreach ($years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row g-2">
                @foreach ($months as $month)
                    @php [$label, $class] = $monthStyles[$month['state']]; @endphp
                    <div class="col-6 col-md-2">
                        <div class="border rounded-3 p-2 h-100 {{ $class }}">
                            <p class="fw-semibold small mb-0">{{ ucfirst($month['date']->translatedFormat('F')) }}</p>
                            <small class="d-block">{{ $label }}</small>
                            @if ($t = $month['ticket'])
                                <a href="{{ route('market.tickets.show', $t) }}" class="small mk-link d-block">{{ $t->folio_label }}</a>
                                <small class="d-block {{ $t->receipt_s3_url ? 'text-success' : 'text-muted' }}">{{ $t->receipt_s3_url ? '✓ Con recibo' : 'Sin recibo aún' }}</small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Bitácora --}}
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Bitácora de gestiones de cobro</h6>
                <button type="button" wire:click="openNote" class="btn btn-outline-secondary btn-sm">+ Registrar gestión</button>
            </div>
            @forelse ($stall->collectionNotes as $note)
                <div class="border-bottom py-2">
                    <small class="text-muted">{{ $note->date->format('d/m/Y') }} · {{ $note->user->name ?? '' }}</small>
                    <p class="mb-0 small">{{ $note->comment }}</p>
                </div>
            @empty
                <small class="text-muted">Aún no hay gestiones registradas.</small>
            @endforelse
        </div>
    </div>

    @if ($noteStallId)
        @include('livewire.market.stalls._note_modal', ['stall' => $stall])
    @endif

    @if ($confirmingDeactivate)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <div>
                            <h6 class="mb-0 text-white">Dar de baja el espacio</h6>
                            <small>{{ $stall->number }} · {{ $stall->tenant_name }} · {{ $stall->space_label }}</small>
                        </div>
                    </div>
                    <div class="modal-body">El espacio dejará de generar adeudo a partir de hoy. Las boletas emitidas y su historial se conservan.</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('confirmingDeactivate', false)">Cancelar</button>
                        <button type="button" class="btn btn-danger btn-sm" wire:click="deactivate">Dar de baja</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif

    @if ($showStatement || $showNotice)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="d-flex justify-content-end gap-2 p-2 mk-no-print">
                        <button type="button" class="btn mk-btn btn-sm" onclick="window.print()">Imprimir</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('{{ $showStatement ? 'showStatement' : 'showNotice' }}', false)">Cerrar</button>
                    </div>
                    @if ($showStatement)
                        @include('market.stalls._statement', ['stall' => $stall, 'months' => $months, 'year' => $year])
                    @else
                        @include('market.stalls._debt_notice', ['stall' => $stall])
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif
</div>
