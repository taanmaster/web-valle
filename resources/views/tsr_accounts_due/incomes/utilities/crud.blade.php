<div>

    @push('stylesheets')
        <style>
            .drop-search {
                top: 120%;
                border-radius: 12px;
                background-color: white;
                box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
                z-index: 5;
                width: 99%;
                display: flex;
                flex-direction: column;
            }

            .concept-search {
                min-height: 200px;
                max-height: 640px;
                height: fit-content;
            }

            .drop-search .btn {
                text-align: left;
            }

            .drop-search .btn:hover {
                background-color: #F2F4FF;
            }

            .accordion-button::after {
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    @endpush

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-file-invoice-dollar fa-2x text-primary"></i>
                        </div>
                        <div>
                            @if ($income != null)
                                @switch($mode)
                                    @case(1)
                                        <h3 class="mb-1 fw-bold">Detalle de ingreso</h3>
                                    @break

                                    @case(2)
                                        <h3 class="mb-1 fw-bold">Editar ingreso</h3>
                                    @break
                                @endswitch
                            @else
                                <h3 class="mb-1 fw-bold">Nuevo ingreso</h3>
                            @endif
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                El ingreso hereda datos del entero provisional y consolida la operación de cobro.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    @if ($mode == 1)
                        <button type="button" class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#receiptModal">
                            Generar Recibo
                        </button>

                        @if ($income->receipts->count() > 0)
                            <span class="badge bg-success me-2">{{ $income->receipts->count() }} recibo(s)</span>
                        @endif
                    @endif
                    <a href="{{ route('account_due_incomes.index') }}" class="btn btn-secondary btn-sm">Regresar</a>
                </div>
            </div>
        </div>
    </div>

    @if (session('message'))
        <div class="alert alert-info border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-lg me-3"></i>
                <div>{{ session('message') }}</div>
            </div>
        </div>
    @endif

    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3"></i>
            <div>
                @if ($mode == 0)
                    Busca el entero por folio y selecciónalo para completar automáticamente el concepto y monto.
                @else
                    Revisa los datos del ingreso antes de generar o imprimir su recibo.
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                @if ($mode == 0)
                    <div class="row m-3">
                        <div class="col-md-12">
                            <label for="typeOfPerson" class="col-form-label">Buscar entero provisional por folio</label>

                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">

                                </span>
                                <input type="number" name="searchFolio" wire:model.live="searchFolio"
                                    class="form-control" @if ($mode == 1) disabled @endif
                                    placeholder="Buscar por número de Folio">
                            </div>

                            <div
                                class="position-absolute drop-search p-3 pt-1 @if ($searchFolio == null) d-none @endif">
                                <!-- Cities dependent select menu... -->

                                <label for="provisional_integer_id" class="col-form-label mb-1">Enteros
                                    provisionales</label>

                                @php
                                    $integers = \App\Models\TsrAccountDueProvisionalInteger::where(
                                        'id',
                                        'like',
                                        '%' . $searchFolio . '%',
                                    )->get();
                                @endphp

                                @if ($integers->count() > 0)
                                    @foreach ($integers as $integer)
                                        <button type="button" wire:click="selectInteger({{ $integer->id }})"
                                            class="btn">
                                            {{ $integer->id }}
                                        </button>
                                    @endforeach
                                @else
                                    <p>No existe</p>
                                @endif
                            </div>

                            <small class="text-muted d-block mt-2">
                                El concepto y la cantidad se toman del entero provisional seleccionado.
                            </small>
                        </div>
                    </div>
                @endif

                @if (false && $mode == 0)
                    <div class="row align-items-center m-3">
                        <div class="col-md-12">
                            <label for="name" class="col-form-label">Buscar

                                @switch($concept_type)
                                    @case('Costos')
                                        Tarifa y costo
                                    @break;
                                    @case('Ley')
                                        Ley de Ingresos
                                    @break;
                                    @case('Disposiciones')
                                        Disposición administrativa
                                    @break;
                                @endswitch

                                para concepto

                            </label>
                            <input type="text" name="searchConcept" wire:model.live="searchConcept"
                                class="form-control" @if ($folio == null) disabled @endif
                                placeholder="Buscar por nombre">
                            <div
                                class="position-absolute drop-search concept-search p-3 pt-4 @if ($searchConcept == null) d-none @endif">
                                <div class="container overflow-auto">
                                    @switch($concept_type)
                                        @case('Costos')
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <h4>Tarifas y costos de ingresos</h4>
                                                </div>
                                            </div>

                                            @if ($rates != null)
                                                <div class="table-responsive px-3">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Sección</th>
                                                                <th>Número</th>
                                                                <th>Tipo</th>
                                                                <th>Concepto/Descripción</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($rates as $rate)
                                                                <tr>
                                                                    <td>
                                                                        <button type="button"
                                                                            wire:click="selectConcept('{{ $rate->section }}')"
                                                                            class="btn btn-sm btn-primary">
                                                                            Seleccionar
                                                                        </button>
                                                                    </td>
                                                                    <td>
                                                                        {{ $rate->section }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $rate->order_number }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $rate->type }}
                                                                    </td>
                                                                    <td>
                                                                        @switch($rate->type)
                                                                            @case('Tarifa/Costo')
                                                                                {{ $rate->concept }}
                                                                            @break

                                                                            @case('Informativo')
                                                                                {{ $rate->description }}
                                                                            @break
                                                                        @endswitch
                                                                    </td>
                                                                    <td>
                                                                        {{ $rate->cost ?? 'N/A' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        @break

                                        @case('Ley')
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <h4>Ley de Ingresos</h4>
                                                </div>
                                            </div>

                                            @if ($concepts != null)
                                                <div class="table-responsive px-3">
                                                    <table class="table table-striped table-hover">
                                                        <thead class="">
                                                            <tr>
                                                                <th></th>
                                                                <th>CRI</th>
                                                                <th>Concepto</th>
                                                                <th>Tipo</th>
                                                                <th>Entidad</th>
                                                                <th>Ley</th>
                                                                <th>Ingreso estimado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($concepts as $concept)
                                                                <tr>
                                                                    <td>
                                                                        <button type="button"
                                                                            wire:click="selectConcept('{{ $concept->concept }}')"
                                                                            class="btn btn-sm btn-primary">
                                                                            Seleccionar
                                                                        </button>
                                                                    </td>
                                                                    <td>
                                                                        {{ $concept->CRI }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $concept->concept }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $concept->income->type }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $concept->income->entity }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $concept->income->law }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $concept->estimated_income }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        @break

                                        @case('Disposiciones')
                                            <div class="row">
                                                <div class="col">
                                                    <h4>Disposiciones Administrativas de Recaudación</h4>
                                                </div>
                                            </div>

                                            @if ($variants != null)
                                                <div class="table-responsive px-3">
                                                    <table class="table table-striped table-hover">
                                                        <thead class="">
                                                            <tr>
                                                                <th></th>
                                                                <th>Nombre de Variante</th>
                                                                <th>Sección</th>
                                                                <th>Artículo</th>
                                                                <th>Fracción</th>
                                                                <th>
                                                                    Cláusula
                                                                </th>
                                                                <th>Tarifa</th>
                                                                <th>Unidades</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($variants as $variant)
                                                                <tr>
                                                                    <td>
                                                                        <button type="button"
                                                                            wire:click="selectConcept('{{ $variant->name }}')"
                                                                            class="btn btn-sm btn-primary">
                                                                            Seleccionar
                                                                        </button>
                                                                    </td>
                                                                    <td>
                                                                        <strong>
                                                                            {{ $variant->name }}
                                                                        </strong>
                                                                    </td>
                                                                    <td>
                                                                        {{ $variant->clause->fraction->article->section->name ?? 'N/A' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $variant->clause->fraction->article->name ?? 'N/A' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $variant->clause->fraction->fraction ?? 'N/A' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $variant->clause->clause ?? 'N/A' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $variant->units }}
                                                                    </td>

                                                                    @php
                                                                        $numero_str = $variant->quote;
                                                                        $numero = (float) $numero_str; // Convertir el string a float
                                                                    @endphp

                                                                    <td>
                                                                        {{ number_format($numero, 2) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        @break

                                    @endswitch
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

                <div class="row m-3">
                    <div class="col-2">
                        <label for="basis">Fundamento</label>
                    </div>
                    <div class="col">
                        <input type="text" name="basis" wire:model="basis" class="form-control" disabled>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="name" class="col-form-label">Concepto</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="concept" wire:model.live="concept" class="form-control" disabled>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="name" class="col-form-label">Departamento</label>
                    </div>
                    <div class="col-md">
                        <input type="text" name="department" wire:model="department" class="form-control" disabled>
                    </div>
                </div>


                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="folio" class="col-form-label">Folio</label>
                            </div>
                            <div class="col-md position-relative">
                                <input type="number" name="folio" wire:model="folio" class="form-control"
                                    @if ($mode == 1) disabled @endif disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="qty_integer" class="col-form-label">Cantidad</label>
                            </div>
                            <div class="col-md">
                                <input type="number" name="qty_integer" wire:model="qty_integer"
                                    class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-1">
                        <label for="person" class="col-form-label">Persona</label>
                    </div>
                    <div class="col">
                        <input type="text" disabled wire:model="name" name="person" class="form-control">
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="rcf_curpo" class="col-form-label">RFC/CURP</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="rfc_curp" wire:model="rfc_curp" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="type_of_person" class="col-form-label">Tipo de persona</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="type_of_person" wire:model="type_of_person"
                                    class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="address" class="col-form-label">Domicilio</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="address" wire:model="address" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="zipcode" class="col-form-label">Código Postal</label>
                            </div>
                            <div class="col-md">
                                <input type="number" name="zipcode" wire:model="zipcode" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="created_date" class="col-form-label">Fecha de alta</label>
                            </div>
                            <div class="col-md">
                                <input type="date" name="created_date" wire:model="created_date"
                                    class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label for="code" class="col-form-label">Clave única de la cuenta</label>
                            </div>
                            <div class="col-md">
                                <input type="text" name="code" wire:model="code" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-2">
                        <label for="observations">Observaciones</label>
                    </div>
                    <div class="col">
                        <textarea name="observations" id="observations" class="form-control" wire:model="observations"
                            @if ($mode == 1) disabled @endif></textarea>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-2">
                        <label for="work">Obra</label>
                    </div>
                    <div class="col">
                        <input type="text" name="work" wire:model="work" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-2">
                        <label for="locality">Localidad</label>
                    </div>
                    <div class="col">
                        <input type="text" name="locality" wire:model="locality" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                @if ($mode != 1)
                    <div class="m-3 d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('account_due_incomes.index') }}"
                            class="btn btn-secondary btn-sm">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i> Guardar datos
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @if ($mode == 1 && $income->receipts->count() > 0)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-receipt text-primary me-2"></i> Recibos asociados
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold"># Recibo</th>
                                <th class="fw-semibold">Fecha y hora</th>
                                <th class="fw-semibold">Usuario de caja</th>
                                <th class="fw-semibold">Caja</th>
                                <th class="fw-semibold">Ingreso</th>
                                <th class="fw-semibold">Cuenta</th>
                                <th class="fw-semibold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($income->receipts->sortByDesc('created_at') as $receipt)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $receipt->id }}</span></td>
                                    <td>{{ $receipt->created_at->format('d/m/Y h:m') }}</td>
                                    <td>{{ $receipt->cashier_user }}</td>
                                    <td>{{ $receipt->cashier }}</td>

                                    @php
                                        $value = (int) $receipt->qty_integer;
                                    @endphp

                                    <td>${{ number_format($value, 2) }}</td>
                                    <td>{{ $receipt->account }}</td>
                                    <td class="text-center">
                                        @if ($receipt->total_cash > 0)
                                            <a href="{{ route('account_due_incomes.close', $receipt->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Imprimir recibo" aria-label="Imprimir recibo">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning border-0 shadow-sm mt-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                <div>No hay recibo generado para este ingreso.</div>
            </div>
        </div>
    @endif

    @if ($mode == 1)
        <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="receiptModalLabel">Generar Recibo de Pago</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:tsr_accounts_due.incomes_receipts.crud :mode="0" :income="$income" />
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row"></div>
</div>
