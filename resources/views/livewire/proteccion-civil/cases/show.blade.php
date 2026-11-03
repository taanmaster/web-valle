<div>
    {{-- Encabezado --}}
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-start gap-3">
            <div>
                <a href="{{ $canManage ? route('proteccion_civil.cases.index') : route('proteccion_civil.inspections.index') }}" class="pc-link small">
                    <i class="ti ti-arrow-left"></i> {{ $canManage ? 'Bandeja' : 'Mis inspecciones' }}
                </a>
                <h4 class="mb-1 d-flex align-items-center gap-2">
                    {{ $case->folio }}
                    <span class="badge rounded-pill fs-6 bg-{{ $case->status_color }}-subtle text-{{ $case->status_color }}">{{ $case->status_label }}</span>
                    @if ($validity = $case->validity)
                        <span class="badge rounded-pill fs-6 bg-{{ $validity[1] }}-subtle text-{{ $validity[1] }}"><i class="ti ti-point-filled"></i>{{ str_replace(' d', ' días', $validity[0]) }}</span>
                    @endif
                </h4>
                <p class="mb-0"><strong>{{ $case->applicant_name }}</strong> <span class="text-muted">· {{ $case->person_type_label }}</span></p>
                <p class="text-muted mb-2">{{ $case->procedure->type_label }} · {{ $case->procedure->name }}</p>
                <div class="d-flex flex-wrap gap-1">
                    <span class="badge rounded-pill border text-dark fw-normal">Origen: {{ $case->origin_label }}</span>
                    <span class="badge rounded-pill border text-dark fw-normal">Solicitud: {{ ($case->submitted_at ?? $case->created_at)->format('d/m/Y H:i') }}</span>
                    <span class="badge rounded-pill border text-dark fw-normal">{{ $case->days_in_status }} días en el estatus</span>
                    @if ($responsible)
                        <span class="badge rounded-pill border text-dark fw-normal">Responsable: {{ $responsible }}</span>
                    @endif
                    @unless ($case->user_id)
                        <span class="badge rounded-pill border text-dark fw-normal">Sin cuenta en línea</span>
                    @endunless
                    @if ($case->email)
                        <span class="badge rounded-pill border text-dark fw-normal">{{ $case->email }}</span>
                    @endif
                    <span class="badge rounded-pill border text-dark fw-normal">Tel. {{ $case->phone }}</span>
                </div>
            </div>
            <div class="text-end">
                <button type="button" class="btn pc-btn" wire:click="openStatusModal" @disabled(! $canManage || $isClosed)>Cambiar estatus</button>
                @if ($isClosed)
                    <small class="d-block text-muted mt-1">Expediente cerrado.</small>
                @elseif (! $canManage)
                    <small class="d-block text-muted mt-1">Sólo el consultor cambia el estatus.</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Documentos por requisito --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <h6 class="mb-0">Documentos por requisito</h6>
                        <small class="text-muted">{{ $summary }}</small>
                    </div>

                    @foreach ($documents as $i => $doc)
                        <div class="py-2 border-bottom" wire:key="doc-{{ $doc->id }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-semibold mb-1">
                                        {{ $i + 1 }}. {{ $doc->name }}
                                        @if ($doc->is_required)<span class="text-danger">*</span>@endif
                                    </p>
                                    <span class="badge rounded-pill border text-dark fw-normal">{{ $doc->formats_label }}</span>
                                    @if ($doc->requires_original)
                                        <span class="badge rounded-pill border text-dark fw-normal">Requiere original</span>
                                    @endif
                                    @if ($doc->added_after_start)
                                        <span class="badge rounded-pill bg-primary-subtle text-primary fw-normal">Requisito agregado después de iniciar este trámite</span>
                                    @endif
                                </div>
                                <span class="badge rounded-pill bg-{{ $doc->status_color }}-subtle text-{{ $doc->status_color }}">{{ $doc->status_label }}</span>
                            </div>

                            @if ($version = $doc->versions->first())
                                <div class="bg-light border rounded-3 p-2 mt-2 d-flex justify-content-between align-items-center gap-2">
                                    <div class="d-flex align-items-center gap-2 text-truncate">
                                        <span class="badge bg-dark">v{{ $version->version }}</span>
                                        <div class="text-truncate">
                                            <a href="{{ $version->s3_url }}" target="_blank" rel="noopener" class="fw-semibold text-dark">{{ $version->filename }}</a>
                                            <small class="d-block text-muted">{{ $version->size_label }} · {{ $version->created_at->format('d/m/Y H:i') }} · subido por {{ $version->uploader_label }}</small>
                                        </div>
                                    </div>
                                    @if ($canManage && ($doc->status === 'por_revisar' || ($doc->status === 'rechazado' && $case->status === 'en_revision')))
                                        <div class="d-flex gap-1 flex-shrink-0">
                                            <button type="button" class="btn btn-success btn-sm" wire:click="accept({{ $doc->id }})">Aceptar</button>
                                            @if ($doc->status === 'por_revisar')
                                                <button type="button" class="btn btn-outline-danger btn-sm" wire:click="startReject({{ $doc->id }})">Rechazar</button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                @if ($doc->versions->count() > 1)
                                    <small class="text-muted">
                                        Versiones anteriores:
                                        @foreach ($doc->versions->skip(1) as $old)
                                            <a href="{{ $old->s3_url }}" target="_blank" rel="noopener" class="text-muted">v{{ $old->version }}</a>@if (! $loop->last), @endif
                                        @endforeach
                                    </small>
                                @endif
                            @endif

                            @if ($doc->status === 'rechazado' && $doc->rejection_reason)
                                <small class="d-block text-danger mt-1">Motivo del rechazo: {{ $doc->rejection_reason }}</small>
                            @endif

                            @if ($canManage)
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <label class="pc-link small text-decoration-underline mb-0">
                                        {{ $doc->versions->isEmpty() ? 'Subir documento recibido' : 'Subir nueva versión' }}
                                        <input type="file" class="d-none" wire:model="uploads.{{ $doc->id }}"
                                            accept="{{ collect($doc->formats)->map(fn ($f) => '.'.$f)->implode(',') }}">
                                    </label>
                                    <span wire:loading wire:target="uploads.{{ $doc->id }}" class="small text-muted">Subiendo...</span>
                                    @if ($doc->requires_original)
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" id="orig-{{ $doc->id }}"
                                                wire:click="toggleOriginal({{ $doc->id }})" @checked($doc->original_received)>
                                            <label class="form-check-label small" for="orig-{{ $doc->id }}">Original recibido</label>
                                        </div>
                                    @endif
                                </div>
                                @error('uploads.'.$doc->id)<small class="text-danger">{{ $message }}</small>@enderror
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Inspección --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-1">
                        <h6 class="mb-0">Inspección</h6>
                        @if ($canManage && (! $inspection || $inspection->result !== 'pendiente'))
                            <button type="button" class="btn btn-warning btn-sm text-uppercase" wire:click="openInspectionModal" @disabled(! $canSchedule)>
                                Agendar inspección
                            </button>
                        @endif
                    </div>

                    @if (! $inspection)
                        <small class="text-muted">Se habilita la programación al cambiar el estatus a «Inspección programada», después de recibir la documentación original.</small>
                    @else
                        <div class="row g-3 mt-1">
                            <div class="col-md-4">
                                <p class="pc-label mb-0">Fecha programada</p>
                                <p class="mb-0">{{ $inspection->scheduled_at->format('d/m/Y · H:i') }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="pc-label mb-0">Inspector</p>
                                <p class="mb-0">{{ $inspection->inspector->name ?? '—' }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="pc-label mb-0">Resultado</p>
                                <p class="mb-0 fw-semibold text-{{ $inspection->result_color }}">{{ $inspection->result_label }}</p>
                            </div>
                        </div>

                        @if ($inspection->result === 'pendiente')
                            @if ($inspection->inspector_id === auth()->id() || $canManage)
                                <form wire:submit="saveInspectionResult" class="border-top pt-3 mt-3">
                                    <h6 class="small fw-semibold">Registrar resultado de la inspección</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="pc-label">Fecha de la visita *</label>
                                            <input type="date" wire:model="visitDate" class="form-control">
                                            @error('visitDate')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pc-label d-block">Resultado *</label>
                                            @foreach (['sin_observaciones', 'con_observaciones', 'no_procede'] as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" wire:model="result" value="{{ $option }}" id="res-{{ $option }}">
                                                    <label class="form-check-label small" for="res-{{ $option }}">{{ \App\Models\CivilProtectionInspection::RESULTS[$option][0] }}</label>
                                                </div>
                                            @endforeach
                                            @error('result')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="pc-label">Observaciones</label>
                                            <textarea wire:model="observations" rows="3" class="form-control"></textarea>
                                            @error('observations')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="col-12 d-flex flex-wrap gap-2">
                                            <label class="btn btn-outline-secondary btn-sm mb-0">
                                                <i class="ti ti-camera"></i> Agregar fotos ({{ count($photos) }})
                                                <input type="file" class="d-none" wire:model="photos" accept="image/*" multiple>
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm mb-0">
                                                <i class="ti ti-file-text"></i> {{ $act ? $act->getClientOriginalName() : 'Adjuntar acta (PDF)' }}
                                                <input type="file" class="d-none" wire:model="act" accept=".pdf">
                                            </label>
                                            <span wire:loading wire:target="photos,act" class="small text-muted align-self-center">Subiendo...</span>
                                        </div>
                                        @error('photos.*')<small class="text-danger">{{ $message }}</small>@enderror
                                        @error('act')<small class="text-danger">{{ $message }}</small>@enderror
                                        <div class="col-12">
                                            <button type="submit" class="btn pc-btn btn-sm" wire:loading.attr="disabled">Guardar resultado</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <small class="text-muted">Pendiente de registro por el inspector.</small>
                            @endif
                        @else
                            <div class="border-top pt-2 mt-3">
                                <small class="text-muted d-block">Visita realizada el {{ $inspection->visit_date?->format('d/m/Y') }}</small>
                                @if ($inspection->observations)
                                    <p class="small mb-2">{{ $inspection->observations }}</p>
                                @endif
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($inspection->photos ?? [] as $photo)
                                        <a href="{{ $photo['url'] }}" target="_blank" rel="noopener" class="badge border text-dark fw-normal"><i class="ti ti-photo"></i> {{ $photo['name'] }}</a>
                                    @endforeach
                                    @if ($inspection->act_s3_url)
                                        <a href="{{ $inspection->act_s3_url }}" target="_blank" rel="noopener" class="badge border text-dark fw-normal"><i class="ti ti-file-text"></i> {{ $inspection->act_name }}</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Entero --}}
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="mb-1">Entero</h6>
                    @if ($case->payment_order_folio)
                        <div class="bg-light border rounded-3 p-3 mt-2 d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <p class="font-monospace fw-semibold mb-0">{{ $case->payment_order_folio }}</p>
                                <small class="d-block">{{ $case->payment_order_concept }}</small>
                                <small class="text-muted">Generado {{ $case->payment_order_generated_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <span class="fw-semibold">${{ number_format($case->payment_order_amount, 2) }}</span>
                                {{-- Con el pago confirmado, "Ver entero" abre el recibo adjunto --}}
                                @if ($case->payment_receipt_s3_url)
                                    <a href="{{ $case->payment_receipt_s3_url }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm">Ver entero</a>
                                @else
                                    <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showPaymentOrder', true)">Ver entero</button>
                                @endif
                            </div>
                        </div>

                        @if ($case->payment_confirmed_at)
                            <small class="d-block text-success mt-2">
                                <i class="ti ti-check"></i> Pago confirmado el {{ ($case->payment_date ?? $case->payment_confirmed_at)->format('d/m/Y') }} · recibo {{ $case->payment_receipt_name }}
                            </small>
                        @elseif ($canManage && $case->status === 'entero_generado')
                            <form wire:submit="confirmPayment" class="mt-3">
                                <p class="small fw-semibold mb-1">Confirmar pago</p>
                                <label class="pc-label">Fecha de pago *</label>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <input type="date" wire:model="paymentDate" class="form-control w-auto" max="{{ now()->toDateString() }}">
                                    <label class="btn btn-outline-secondary btn-sm mb-0">
                                        <i class="ti ti-paperclip"></i> {{ $paymentReceipt ? $paymentReceipt->getClientOriginalName() : 'Adjuntar recibo' }}
                                        <input type="file" class="d-none" wire:model="paymentReceipt" accept=".pdf,.jpg,.jpeg,.png">
                                    </label>
                                    <button type="submit" class="btn btn-success btn-sm" wire:loading.attr="disabled">Confirmar pago</button>
                                </div>
                                @error('paymentDate')<small class="text-danger d-block">{{ $message }}</small>@enderror
                                @error('paymentReceipt')<small class="text-danger d-block">{{ $message }}</small>@enderror
                            </form>
                        @endif
                    @elseif ($canGeneratePaymentOrder)
                        <form wire:submit="generatePaymentOrder" class="mt-2">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <p class="pc-label mb-0">Número</p>
                                    <p class="font-monospace fw-semibold mb-0">{{ $case->payment_order_folio_preview }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="pc-label">Monto *</label>
                                    <input type="number" step="0.01" min="0" wire:model="paymentAmount" class="form-control form-control-sm" placeholder="0.00">
                                    @error('paymentAmount')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="pc-label">Concepto *</label>
                                    <input type="text" wire:model="paymentConcept" class="form-control form-control-sm">
                                    @error('paymentConcept')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="pc-label">Nota al ciudadano *</label>
                                    <textarea wire:model="paymentNote" rows="2" class="form-control form-control-sm"></textarea>
                                    @error('paymentNote')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn pc-btn btn-sm">Generar entero</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <small class="text-muted">Se genera cuando la inspección resulta sin observaciones.</small>
                    @endif
                </div>
            </div>

            {{-- Documento emitido --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-1">Documento emitido</h6>
                    @if ($case->document_number)
                        <div class="row g-3 mt-1">
                            <div class="col-6 col-md-3">
                                <p class="pc-label mb-0">Número</p>
                                <p class="font-monospace fw-semibold mb-0">{{ $case->document_number }}</p>
                            </div>
                            <div class="col-6 col-md-3">
                                <p class="pc-label mb-0">Emisión</p>
                                <p class="mb-0">{{ $case->issued_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-6 col-md-3">
                                <p class="pc-label mb-0">Caducidad</p>
                                <p class="mb-0">{{ $case->expires_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-6 col-md-3">
                                <p class="pc-label mb-0">Vigencia</p>
                                @if ($validity = $case->validity)
                                    <p class="mb-0 fw-semibold text-{{ $validity[1] }}"><i class="ti ti-point-filled"></i>{{ str_replace(' d', ' días', $validity[0]) }}</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ $case->document_s3_url }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm mt-3">
                            Ver PDF firmado · {{ $case->document_name }}
                        </a>
                    @elseif ($canManage && $case->status === 'pago_confirmado')
                        <form wire:submit="issueDocument" class="mt-2">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <p class="pc-label mb-0">Número de {{ $case->procedure->type === 'permit' ? 'permiso' : 'opinión' }}</p>
                                    <p class="font-monospace fw-semibold mb-0">{{ $nextDocumentNumber }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="pc-label">Fecha de emisión *</label>
                                    <input type="date" wire:model.live="issueDate" class="form-control form-control-sm" max="{{ now()->toDateString() }}">
                                    @error('issueDate')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-4">
                                    <p class="pc-label mb-0">Fecha de caducidad</p>
                                    <p class="mb-0">{{ $issueExpires?->format('d/m/Y') }} · {{ $case->procedure->validity_days }} días</p>
                                </div>
                                <div class="col-12 d-flex flex-wrap gap-2">
                                    <label class="btn btn-outline-secondary btn-sm mb-0">
                                        <i class="ti ti-paperclip"></i> {{ $signedDocument ? $signedDocument->getClientOriginalName() : 'Subir PDF firmado *' }}
                                        <input type="file" class="d-none" wire:model="signedDocument" accept=".pdf">
                                    </label>
                                    <button type="submit" class="btn pc-btn btn-sm" wire:loading.attr="disabled">Emitir y subir al expediente</button>
                                </div>
                                @error('signedDocument')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </form>
                    @else
                        <small class="text-muted">Se emite cuando el pago está confirmado.</small>
                    @endif
                </div>
            </div>
        </div>

        {{-- Línea de tiempo --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Línea de tiempo</h5>
                    @foreach ($case->logs as $log)
                        <div class="pc-timeline-item">
                            <span class="pc-timeline-dot bg-{{ $log->status_color }}"></span>
                            <p class="fw-semibold mb-0">{{ $log->status_label }}</p>
                            <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i') }} · {{ $log->user->name ?? 'Sistema' }}</small>
                            @if ($log->note)
                                <p class="small mb-0">{{ $log->note }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: rechazar documento --}}
    @if ($rejectingId)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" wire:submit="reject">
                    <div class="modal-body">
                        <h5>Rechazar documento</h5>
                        <p class="small text-muted">El motivo se mostrará al ciudadano para que lo corrija.</p>
                        <label class="pc-label">Motivo del rechazo *</label>
                        <textarea wire:model="rejectionReason" rows="3" class="form-control"></textarea>
                        @error('rejectionReason')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('rejectingId', null)">Cancelar</button>
                        <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif

    {{-- Modal: cambiar estatus --}}
    @if ($showStatusModal)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" wire:submit="changeStatus">
                    <div class="modal-body">
                        <h5>Cambiar estatus</h5>
                        <p class="small text-muted">Al guardar se registra en la línea de tiempo y se notifica al ciudadano. Entero, pago y emisión se capturan en su sección del expediente.</p>
                        <label class="pc-label">Nuevo estatus *</label>
                        <select wire:model="newStatus" class="form-select mb-1">
                            <option value="">Selecciona...</option>
                            @foreach (\App\Models\CivilProtectionCase::STATUSES as $key => [$number, $label])
                                @continue($key === $case->status || in_array($key, \App\Livewire\ProteccionCivil\Cases\Show::SECTION_STATUSES))
                                <option value="{{ $key }}">{{ $number ? $number.'. ' : '' }}{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('newStatus')<small class="text-danger d-block">{{ $message }}</small>@enderror
                        <label class="pc-label mt-3">Mensaje al ciudadano · opcional</label>
                        <textarea wire:model="statusNote" rows="3" class="form-control" placeholder="Si lo dejas vacío se envía un aviso genérico del cambio de estatus."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showStatusModal', false)">Cancelar</button>
                        <button type="submit" class="btn pc-btn btn-sm">Guardar estatus</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif

    {{-- Modal: entero de pago (imprimible) --}}
    @if ($showPaymentOrder && $case->payment_order_folio)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="d-flex justify-content-end gap-2 p-2 pc-no-print">
                        <button type="button" class="btn pc-btn btn-sm" onclick="window.print()">Imprimir o guardar PDF</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showPaymentOrder', false)">Cerrar</button>
                    </div>
                    @include('proteccion_civil._payment_order')
                </div>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif

    {{-- Modal: agendar inspección --}}
    @if ($showInspectionModal)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" wire:submit="scheduleInspection">
                    <div class="modal-body">
                        <h5>Agendar inspección</h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="pc-label">Fecha *</label>
                                <input type="date" wire:model="inspectionDate" class="form-control" min="{{ now()->toDateString() }}">
                                @error('inspectionDate')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-6">
                                <label class="pc-label">Hora *</label>
                                <input type="time" wire:model="inspectionTime" class="form-control">
                                @error('inspectionTime')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label class="pc-label">Inspector *</label>
                                <select wire:model="inspectorId" class="form-select">
                                    <option value="">Selecciona...</option>
                                    @foreach ($inspectors as $inspector)
                                        <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                    @endforeach
                                </select>
                                @if ($inspectors->isEmpty())
                                    <small class="text-muted">No hay usuarios con el rol inspector_proteccion_civil.</small>
                                @endif
                                @error('inspectorId')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label class="pc-label">Nota para el ciudadano · opcional</label>
                                <textarea wire:model="inspectionNote" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="$set('showInspectionModal', false)">Cancelar</button>
                        <button type="submit" class="btn btn-warning btn-sm text-uppercase">Agendar inspección</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-backdrop show"></div>
    @endif
</div>
