<div>
    @if ($saved && !$editing)
        {{-- ---------- Estado: formato ya guardado (solo lectura) ---------- --}}
        <div class="alert alert-success d-flex align-items-center justify-content-between flex-wrap gap-2">
            <span>
                <ion-icon name="checkmark-circle-outline"></ion-icon>
                El formato único de solicitud ya fue llenado y guardado.
            </span>
            <button type="button" class="btn btn-sm btn-outline-success" wire:click="startEditing">
                <ion-icon name="create-outline"></ion-icon> Editar formato
            </button>
        </div>

        <div class="card border-0 bg-light">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Tipo de persona</small>
                        <strong>{{ $data['tipo_persona'] === 'moral' ? 'Persona Moral' : 'Persona Física' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Cuenta predial</small>
                        <strong>{{ $data['predio_cuenta_predial'] ?: '—' }}</strong>
                    </div>
                    @if ($request->format && $request->format->croquis_url)
                        <div class="col-md-6">
                            <small class="text-muted d-block">Croquis</small>
                            <a href="{{ $request->format->croquis_url }}" target="_blank">Ver croquis</a>
                        </div>
                    @endif
                    @if ($request->format && $request->format->signature_applicant_url)
                        <div class="col-md-6">
                            <small class="text-muted d-block">Firma del solicitante</small>
                            <img src="{{ $request->format->signature_applicant_url }}" alt="Firma"
                                style="max-height: 60px; border: 1px solid #dee2e6; border-radius: 6px; background:#fff;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        {{-- ---------- Estado: formulario ---------- --}}
        <form wire:submit.prevent="save" class="format-form">
            @if (session('format_saved'))
                <div class="alert alert-success">{{ session('format_saved') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ion-icon name="alert-circle-outline"></ion-icon>
                    Revisa los campos marcados: faltan datos por completar.
                </div>
            @endif

            {{-- Tipo de trámite (solo Uso de Suelo) --}}
            @if ($formatType === 'uso-de-suelo')
                <div class="format-section-header">Tipo de trámite</div>
                <div class="format-box">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="tt_uso_suelo" value="uso-suelo"
                            wire:model="data.tipo_tramite">
                        <label class="form-check-label" for="tt_uso_suelo">Permiso de Uso de Suelo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="tt_num_oficial" value="num-oficial"
                            wire:model="data.tipo_tramite">
                        <label class="form-check-label" for="tt_num_oficial">Certificación de Número Oficial</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="tt_alineamiento" value="alineamiento"
                            wire:model="data.tipo_tramite">
                        <label class="form-check-label" for="tt_alineamiento">Constancia de Alineamiento</label>
                    </div>
                    @error('data.tipo_tramite')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            {{-- 1. Datos generales del solicitante --}}
            <div class="format-section-header">1. Datos generales del solicitante</div>
            <div class="format-box">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="tp_fisica" value="fisica"
                                    wire:model="data.tipo_persona">
                                <label class="form-check-label" for="tp_fisica">Persona Física</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="tp_moral" value="moral"
                                    wire:model="data.tipo_persona">
                                <label class="form-check-label" for="tp_moral">Persona Moral</label>
                            </div>
                        </div>
                        @error('data.tipo_persona')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">En su condición de <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="cond_sol" value="solicitante"
                                    wire:model="data.condicion">
                                <label class="form-check-label" for="cond_sol">Solicitante</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="cond_ter" value="tercero"
                                    wire:model="data.condicion">
                                <label class="form-check-label" for="cond_ter">Tercero interesado</label>
                            </div>
                        </div>
                        @error('data.condicion')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Persona Física --}}
                <div class="format-subheader">Datos para la Persona Física (llenar solo en caso de ser Persona Física)
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control @error('data.pf_primer_apellido') is-invalid @enderror"
                            wire:model="data.pf_primer_apellido">
                        @error('data.pf_primer_apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" wire:model="data.pf_segundo_apellido">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombres</label>
                        <input type="text" class="form-control @error('data.pf_nombres') is-invalid @enderror"
                            wire:model="data.pf_nombres">
                        @error('data.pf_nombres')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($formatType === 'uso-de-suelo')
                        <div class="col-md-4">
                            <label class="form-label">CURP</label>
                            <input type="text" class="form-control @error('data.pf_curp') is-invalid @enderror"
                                wire:model="data.pf_curp">
                            @error('data.pf_curp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="col-md-4">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control @error('data.pf_correo') is-invalid @enderror"
                            wire:model="data.pf_correo">
                        @error('data.pf_correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('data.pf_telefono') is-invalid @enderror"
                            wire:model="data.pf_telefono">
                        @error('data.pf_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Persona Moral --}}
                <div class="format-subheader">Datos para la Persona Moral (llenar solo en caso de ser Persona Moral)
                </div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Razón Social</label>
                        <input type="text" class="form-control @error('data.pm_razon_social') is-invalid @enderror"
                            wire:model="data.pm_razon_social">
                        @error('data.pm_razon_social')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">RFC</label>
                        <input type="text" class="form-control @error('data.pm_rfc') is-invalid @enderror"
                            wire:model="data.pm_rfc">
                        @error('data.pm_rfc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Representante legal --}}
                <div class="format-subheader">Datos del Representante Legal</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control @error('data.rl_primer_apellido') is-invalid @enderror"
                            wire:model="data.rl_primer_apellido">
                        @error('data.rl_primer_apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" wire:model="data.rl_segundo_apellido">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombres</label>
                        <input type="text" class="form-control @error('data.rl_nombres') is-invalid @enderror"
                            wire:model="data.rl_nombres">
                        @error('data.rl_nombres')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">RFC</label>
                        <input type="text" class="form-control @error('data.rl_rfc') is-invalid @enderror"
                            wire:model="data.rl_rfc">
                        @error('data.rl_rfc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control @error('data.rl_correo') is-invalid @enderror"
                            wire:model="data.rl_correo">
                        @error('data.rl_correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('data.rl_telefono') is-invalid @enderror"
                            wire:model="data.rl_telefono">
                        @error('data.rl_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 2. Domicilio para recibir notificaciones --}}
            <div class="format-section-header">2. Domicilio para recibir notificaciones</div>
            <div class="format-box">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Calle</label>
                        <input type="text" class="form-control @error('data.dom_calle') is-invalid @enderror"
                            wire:model="data.dom_calle">
                        @error('data.dom_calle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Número Ext</label>
                        <input type="text" class="form-control @error('data.dom_num_ext') is-invalid @enderror"
                            wire:model="data.dom_num_ext">
                        @error('data.dom_num_ext')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Número Int</label>
                        <input type="text" class="form-control" wire:model="data.dom_num_int">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Colonia</label>
                        <input type="text" class="form-control @error('data.dom_colonia') is-invalid @enderror"
                            wire:model="data.dom_colonia">
                        @error('data.dom_colonia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">CP</label>
                        <input type="text" class="form-control @error('data.dom_cp') is-invalid @enderror"
                            wire:model="data.dom_cp">
                        @error('data.dom_cp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ciudad</label>
                        <input type="text" class="form-control @error('data.dom_ciudad') is-invalid @enderror"
                            wire:model="data.dom_ciudad">
                        @error('data.dom_ciudad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <input type="text" class="form-control @error('data.dom_estado') is-invalid @enderror"
                            wire:model="data.dom_estado">
                        @error('data.dom_estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 3. Datos del propietario del predio --}}
            <div class="format-section-header">3. Datos del propietario del predio</div>
            <div class="format-box">
                <label class="form-label">El propietario es <span class="text-danger">*</span></label>
                <div class="d-flex gap-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="prop_fisica" value="fisica"
                            wire:model="data.prop_tipo">
                        <label class="form-check-label" for="prop_fisica">Persona Física</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="prop_moral" value="moral"
                            wire:model="data.prop_tipo">
                        <label class="form-check-label" for="prop_moral">Persona Moral</label>
                    </div>
                </div>
                @error('data.prop_tipo')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                <div class="format-subheader">Si el propietario es Persona Física favor de indicar</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Primer Apellido</label>
                        <input type="text"
                            class="form-control @error('data.prop_pf_primer_apellido') is-invalid @enderror"
                            wire:model="data.prop_pf_primer_apellido">
                        @error('data.prop_pf_primer_apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" wire:model="data.prop_pf_segundo_apellido">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombres</label>
                        <input type="text" class="form-control @error('data.prop_pf_nombres') is-invalid @enderror"
                            wire:model="data.prop_pf_nombres">
                        @error('data.prop_pf_nombres')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="format-subheader">Si el propietario es Persona Moral favor de indicar</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Razón Social</label>
                        <input type="text" class="form-control @error('data.prop_pm_razon_social') is-invalid @enderror"
                            wire:model="data.prop_pm_razon_social">
                        @error('data.prop_pm_razon_social')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 4. Datos del predio --}}
            <div class="format-section-header">4. Datos del predio</div>
            <div class="format-box">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Número de cuenta predial</label>
                        <input type="text"
                            class="form-control @error('data.predio_cuenta_predial') is-invalid @enderror"
                            wire:model="data.predio_cuenta_predial">
                        @error('data.predio_cuenta_predial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Calle</label>
                        <input type="text" class="form-control @error('data.predio_calle') is-invalid @enderror"
                            wire:model="data.predio_calle">
                        @error('data.predio_calle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Número Ext</label>
                        <input type="text" class="form-control @error('data.predio_num_ext') is-invalid @enderror"
                            wire:model="data.predio_num_ext">
                        @error('data.predio_num_ext')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Número Int</label>
                        <input type="text" class="form-control" wire:model="data.predio_num_int">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Colonia</label>
                        <input type="text" class="form-control @error('data.predio_colonia') is-invalid @enderror"
                            wire:model="data.predio_colonia">
                        @error('data.predio_colonia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">CP</label>
                        <input type="text" class="form-control @error('data.predio_cp') is-invalid @enderror"
                            wire:model="data.predio_cp">
                        @error('data.predio_cp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Superficie del predio</label>
                        <input type="text" class="form-control @error('data.predio_superficie') is-invalid @enderror"
                            wire:model="data.predio_superficie">
                        @error('data.predio_superficie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Croquis --}}
                <div class="mt-3">
                    <label class="form-label">Favor de adjuntar un croquis de localización del predio (puede ser una
                        captura de Google Maps)</label>
                    <input type="file" class="form-control @error('croquis') is-invalid @enderror" wire:model="croquis"
                        accept=".jpg,.jpeg,.png,.webp,.pdf">
                    <small class="text-muted d-block mt-1">Formatos aceptados: JPG, PNG, WEBP o PDF (máx. 10 MB).</small>
                    <div wire:loading wire:target="croquis" class="text-muted small mt-1">Cargando archivo...</div>
                    @error('croquis')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if ($croquis)
                        @if (str_contains($croquis->getMimeType(), 'image'))
                            <img src="{{ $croquis->temporaryUrl() }}" alt="Croquis" class="mt-2 rounded border"
                                style="max-height: 160px;">
                        @else
                            <div class="mt-2 text-muted">
                                <ion-icon name="document-text-outline"></ion-icon>
                                {{ $croquis->getClientOriginalName() }}
                            </div>
                        @endif
                    @elseif ($request->format && $request->format->croquis_url)
                        <div class="mt-2">
                            <a href="{{ $request->format->croquis_url }}" target="_blank">Ver croquis actual</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 5. Sección específica por tipo de formato --}}
            @if ($formatType === 'uso-de-suelo')
                <div class="format-section-header">5. Datos del giro solicitado</div>
                <div class="format-box">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Giro Solicitado</label>
                            <input type="text" class="form-control @error('data.giro_solicitado') is-invalid @enderror"
                                wire:model="data.giro_solicitado">
                            @error('data.giro_solicitado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Superficie a ocupar del predio</label>
                            <input type="text"
                                class="form-control @error('data.giro_superficie_ocupar') is-invalid @enderror"
                                wire:model="data.giro_superficie_ocupar">
                            @error('data.giro_superficie_ocupar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Denominación Comercial</label>
                            <input type="text"
                                class="form-control @error('data.giro_denominacion_comercial') is-invalid @enderror"
                                wire:model="data.giro_denominacion_comercial">
                            @error('data.giro_denominacion_comercial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @elseif ($formatType === 'licencia-de-construccion')
                <div class="format-section-header">5. Datos de la construcción</div>
                <div class="format-box">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Tipo de construcción a realizar</label>
                            <input type="text"
                                class="form-control @error('data.construccion_tipo') is-invalid @enderror"
                                wire:model="data.construccion_tipo">
                            @error('data.construccion_tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="format-subheader">Según sea su necesidad de construcción por favor indicar</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Metros cuadrados de construcción</label>
                            <input type="text" class="form-control @error('data.construccion_m2') is-invalid @enderror"
                                wire:model="data.construccion_m2">
                            @error('data.construccion_m2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Metros lineales de construcción</label>
                            <input type="text" class="form-control" wire:model="data.construccion_ml">
                        </div>
                    </div>

                    <div class="format-subheader">Datos del Perito Responsable de Obra</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Primer Apellido</label>
                            <input type="text"
                                class="form-control @error('data.perito_primer_apellido') is-invalid @enderror"
                                wire:model="data.perito_primer_apellido">
                            @error('data.perito_primer_apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" wire:model="data.perito_segundo_apellido">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nombres</label>
                            <input type="text" class="form-control @error('data.perito_nombres') is-invalid @enderror"
                                wire:model="data.perito_nombres">
                            @error('data.perito_nombres')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. Registro en el Padrón Municipal</label>
                            <input type="text"
                                class="form-control @error('data.perito_registro_padron') is-invalid @enderror"
                                wire:model="data.perito_registro_padron">
                            @error('data.perito_registro_padron')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email"
                                class="form-control @error('data.perito_correo') is-invalid @enderror"
                                wire:model="data.perito_correo">
                            @error('data.perito_correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono</label>
                            <input type="text"
                                class="form-control @error('data.perito_telefono') is-invalid @enderror"
                                wire:model="data.perito_telefono">
                            @error('data.perito_telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            {{-- Firmas --}}
            <div class="format-section-header">Firmas</div>
            <div class="format-box">
                <div class="row g-4">
                    <div class="col-md-{{ $formatType === 'licencia-de-construccion' ? '6' : '12' }}">
                        <label class="form-label d-block">Firma del Solicitante <span class="text-danger">*</span></label>
                        <div wire:ignore x-data="signaturePad(@js($signatureApplicant), 'signatureApplicant')"
                            x-init="init()">
                            <canvas x-ref="canvas" class="signature-canvas"></canvas>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-1" @click="clear()">
                                <ion-icon name="refresh-outline"></ion-icon> Limpiar
                            </button>
                        </div>
                        @error('signatureApplicant')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($formatType === 'licencia-de-construccion')
                        <div class="col-md-6">
                            <label class="form-label d-block">Firma del Perito <span class="text-danger">*</span></label>
                            <div wire:ignore x-data="signaturePad(@js($signaturePerito), 'signaturePerito')"
                                x-init="init()">
                                <canvas x-ref="canvas" class="signature-canvas"></canvas>
                                <button type="button" class="btn btn-sm btn-outline-secondary mt-1" @click="clear()">
                                    <ion-icon name="refresh-outline"></ion-icon> Limpiar
                                </button>
                            </div>
                            @error('signaturePerito')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                @if ($saved)
                    <button type="button" class="btn btn-outline-secondary" wire:click="$set('editing', false)">
                        Cancelar
                    </button>
                @endif
                <button type="submit" class="btn btn-warning px-4" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">
                        <ion-icon name="save-outline"></ion-icon> Guardar formato
                    </span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>
        </form>
    @endif

    @once
        <style>
            .format-form .format-section-header {
                background: #4d8f8b;
                color: #fff;
                font-weight: 600;
                padding: 10px 16px;
                border-radius: 8px;
                margin: 18px 0 10px;
            }

            .format-form .format-subheader {
                background: #a9cecb;
                color: #1f3d3b;
                font-weight: 600;
                font-size: 0.9rem;
                padding: 6px 12px;
                border-radius: 6px;
                margin: 16px 0 10px;
            }

            .format-form .format-box {
                background: #fff;
                border: 1px solid #e2e8e7;
                border-radius: 10px;
                padding: 16px;
            }

            .signature-canvas {
                width: 100%;
                height: 140px;
                border: 1px solid #cbd5d4;
                border-radius: 10px;
                background: #f4faf9;
                touch-action: none;
                cursor: crosshair;
            }
        </style>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('signaturePad', (initial, wireProp) => ({
                    ctx: null,
                    drawing: false,
                    hasContent: false,
                    wireProp,
                    savedData: initial || '',
                    _w: 0,
                    _h: 0,
                    init() {
                        const canvas = this.$refs.canvas;

                        // Dimensionar el canvas cuando tenga tamaño real (puede iniciar oculto).
                        this.setup();
                        this._ro = new ResizeObserver(() => this.setup());
                        this._ro.observe(canvas);

                        const pos = (e) => {
                            const r = canvas.getBoundingClientRect();
                            const point = e.touches ? e.touches[0] : e;
                            return {
                                x: point.clientX - r.left,
                                y: point.clientY - r.top
                            };
                        };

                        const start = (e) => {
                            if (!this.ctx) return;
                            e.preventDefault();
                            this.drawing = true;
                            const p = pos(e);
                            this.ctx.beginPath();
                            this.ctx.moveTo(p.x, p.y);
                        };
                        const move = (e) => {
                            if (!this.drawing || !this.ctx) return;
                            e.preventDefault();
                            const p = pos(e);
                            this.ctx.lineTo(p.x, p.y);
                            this.ctx.stroke();
                            this.hasContent = true;
                        };
                        const end = () => {
                            if (!this.drawing) return;
                            this.drawing = false;
                            this.sync();
                        };

                        canvas.addEventListener('mousedown', start);
                        canvas.addEventListener('mousemove', move);
                        window.addEventListener('mouseup', end);
                        canvas.addEventListener('touchstart', start, {
                            passive: false
                        });
                        canvas.addEventListener('touchmove', move, {
                            passive: false
                        });
                        canvas.addEventListener('touchend', end);
                    },
                    // (Re)configura el lienzo cuando obtiene dimensiones visibles.
                    setup() {
                        const canvas = this.$refs.canvas;
                        const rect = canvas.getBoundingClientRect();
                        if (rect.width === 0 || rect.height === 0) return; // aún oculto
                        if (this._w === rect.width && this._h === rect.height) return; // sin cambios
                        this._w = rect.width;
                        this._h = rect.height;

                        const ratio = window.devicePixelRatio || 1;
                        canvas.width = rect.width * ratio;
                        canvas.height = rect.height * ratio;
                        this.ctx = canvas.getContext('2d');
                        this.ctx.scale(ratio, ratio);
                        this.ctx.lineWidth = 2;
                        this.ctx.lineCap = 'round';
                        this.ctx.strokeStyle = '#1f2937';

                        // Redibujar firma existente (al editar)
                        if (this.savedData) {
                            const img = new Image();
                            img.onload = () => this.ctx.drawImage(img, 0, 0, rect.width, rect.height);
                            img.src = this.savedData;
                            this.hasContent = true;
                        }
                    },
                    sync() {
                        if (this.hasContent && this.ctx) {
                            this.$wire.set(this.wireProp, this.$refs.canvas.toDataURL('image/png'));
                        }
                    },
                    clear() {
                        if (this.ctx) {
                            this.ctx.clearRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
                        }
                        this.savedData = '';
                        this.hasContent = false;
                        this.$wire.set(this.wireProp, '');
                    },
                }));
            });
        </script>
    @endonce
</div>
