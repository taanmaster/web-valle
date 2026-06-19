<div class="row layout-spacing">
    <div class="main-content">

        <div class="mb-4">
            @if ($panteon !== null)
                @switch($mode)
                    @case(1)
                        <h4 class="fw-bold">VER REGISTRO</h4>
                    @break
                    @case(2)
                        <h4 class="fw-bold">EDITAR REGISTRO</h4>
                    @break
                    @default
                        <h4 class="fw-bold">NUEVO REGISTRO</h4>
                @endswitch
            @else
                <h4 class="fw-bold">NUEVO REGISTRO</h4>
            @endif
        </div>

        <form wire:submit.prevent="save" enctype="multipart/form-data">
            @csrf

            {{-- DATOS ADMINISTRATIVOS --}}
            <h6 class="fw-bold text-uppercase mb-2">Datos Administrativos</h6>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Entero</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('entero') is-invalid @enderror"
                                    wire:model="entero" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('entero') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Folio</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('folio') is-invalid @enderror"
                                    wire:model="folio" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('folio') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                wire:model="fecha" @if($mode === 1) disabled @endif>
                            @error('fecha') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Comprobante PDF</label>
                            @if ($mode === 1 && $comprobante_pdf)
                                <div>
                                    <a href="{{ Storage::url('panteones/comprobantes/' . $comprobante_pdf) }}"
                                        target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="bx bx-file-pdf"></i> Ver comprobante
                                    </a>
                                </div>
                            @else
                                <input type="file" class="form-control @error('comprobante_pdf') is-invalid @enderror"
                                    wire:model="comprobante_pdf" accept=".pdf" @if($mode === 1) disabled @endif>
                                @error('comprobante_pdf') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                @if ($comprobante_pdf && is_string($comprobante_pdf))
                                    <small class="text-muted">Archivo actual: {{ $comprobante_pdf }}</small>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- DATOS DEL SOLICITANTE --}}
            <h6 class="fw-bold text-uppercase mb-2">Datos del Solicitante</h6>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nombre del solicitante</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('nombre_solicitante') is-invalid @enderror"
                                    wire:model="nombre_solicitante" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('nombre_solicitante') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nombre del finado</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('nombre_finado') is-invalid @enderror"
                                    wire:model="nombre_finado" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('nombre_finado') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Domicilio</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('domicilio') is-invalid @enderror"
                                    wire:model="domicilio" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('domicilio') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Localidad</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('localidad') is-invalid @enderror"
                                    wire:model="localidad" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('localidad') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- FUNDAMENTO LEGAL --}}
            <h6 class="fw-bold text-uppercase mb-2">Fundamento Legal</h6>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex gap-4 flex-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="fundamento_legal"
                                value="Ley de Ingresos" id="fl_ley" @if($mode === 1) disabled @endif>
                            <label class="form-check-label" for="fl_ley">Ley de Ingresos</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="fundamento_legal"
                                value="Disposiciones Administrativas" id="fl_disp" @if($mode === 1) disabled @endif>
                            <label class="form-check-label" for="fl_disp">Disposiciones Administrativas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="fundamento_legal"
                                value="Otros" id="fl_otros" @if($mode === 1) disabled @endif>
                            <label class="form-check-label" for="fl_otros">Otros</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONCEPTO DE PAGO --}}
            <h6 class="fw-bold text-uppercase mb-2">Concepto de Pago</h6>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Concepto</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('concepto') is-invalid @enderror"
                                    wire:model="concepto" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('concepto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Tipo</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('tipo') is-invalid @enderror"
                                    wire:model="tipo" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('tipo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Zona</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('zona') is-invalid @enderror"
                                    wire:model="zona" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('zona') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('observaciones') is-invalid @enderror"
                                    wire:model="observaciones" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('observaciones') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- UBICACIÓN DEL PANTEÓN --}}
            <h6 class="fw-bold text-uppercase mb-2">Ubicación del Panteón</h6>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Panteón</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('panteon_nombre') is-invalid @enderror"
                                    wire:model="panteon_nombre" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('panteon_nombre') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Sección</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('seccion') is-invalid @enderror"
                                    wire:model="seccion" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('seccion') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Bloque</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('bloque') is-invalid @enderror"
                                    wire:model="bloque" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('bloque') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Manzana</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('manzana') is-invalid @enderror"
                                    wire:model="manzana" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('manzana') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Terreno</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('terreno') is-invalid @enderror"
                                    wire:model="terreno" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('terreno') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- REFERENCIA NORMATIVA --}}
            <h6 class="fw-bold text-uppercase mb-2">Referencia Normativa</h6>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Art</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('ref_art') is-invalid @enderror"
                                    wire:model="ref_art" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('ref_art') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Frac</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('ref_frac') is-invalid @enderror"
                                    wire:model="ref_frac" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('ref_frac') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Inc</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('ref_inc') is-invalid @enderror"
                                    wire:model="ref_inc" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('ref_inc') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Num</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('ref_num') is-invalid @enderror"
                                    wire:model="ref_num" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('ref_num') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- MONTO A PAGAR --}}
            <h6 class="fw-bold text-uppercase mb-2">Monto a Pagar</h6>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Monto (Cantidad)</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('monto') is-invalid @enderror"
                                    wire:model="monto" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('monto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Cantidad con letra</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('cantidad_letra') is-invalid @enderror"
                                    wire:model="cantidad_letra" @if($mode === 1) disabled @endif>
                                <span class="input-group-text"><i class="bx bx-pencil"></i></span>
                            </div>
                            @error('cantidad_letra') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            @if ($mode !== 1)
                <div class="d-flex justify-content-center mt-4 mb-5">
                    <button type="submit" class="btn px-5 py-2 fw-bold"
                        style="background-color: #F5C842; border: none; min-width: 200px; border-radius: 6px;">
                        Guardar
                    </button>
                </div>
            @else
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('panteones.admin.edit', $panteon->id) }}" class="btn btn-primary me-2">
                        <i class="bx bx-edit"></i> Editar
                    </a>
                    <a href="{{ route('panteones.admin.index') }}" class="btn btn-secondary">
                        Volver
                    </a>
                </div>
            @endif

        </form>
    </div>
</div>
