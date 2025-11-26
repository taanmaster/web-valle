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
    <div class="row layout-spacing">
        <form method="POST" wire:submit="save" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="main-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-header">
                                <h5 class="card-title">Material o Servicio</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="material" class="form-label">Materio y/o Servicio</label>
                                    <select name="material" id="material" wire:model.live="materialId"
                                        class="form-control" @if (request()->route('id')) disabled @endif>
                                        <option selected>Selecciona una opción</option>
                                        @foreach ($materials as $mat)
                                            <option value="{{ $mat->id }}">{{ $mat->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if ($material != null)
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h5 class="card-title">Estado</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active"
                                                name="is_active" @if ($material->is_active == 1) checked @endif
                                                disabled>
                                            <label class="form-check-label" for="is_active">Activo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2">
                                <div class="card-header">
                                    <h5 class="card-title">Organización</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Categoría</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $material->category }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="dependency_name" class="form-label">Dependencia</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $material->dependency_name }}">
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <div class="col-md-2">
                                            <label for="worker_id" class="col-form-label" required>Proveedor</label>
                                        </div>
                                        <div class="col-md">
                                            <div class="input-group">
                                                @if ($selectedSupplier != null)
                                                    <div class="d-flex w-100">
                                                        <input type="text" name="supplier_name"
                                                            wire:model="supplier_name" class="form-control"
                                                            @if ($mode == 1) disabled @endif
                                                            placeholder="Nombre completo" disabled>
                                                        <button type="button" wire:click="clearSupplier"
                                                            class="btn btn-link btn-sm @if ($mode == 1) d-none @endif">Limpiar</button>
                                                    </div>
                                                @else
                                                    <input type="text" name="searchSupplier"
                                                        wire:model.live="searchSupplier" class="form-control"
                                                        placeholder="Buscar por nombre">
                                                @endif
                                            </div>

                                            <div class="position-absolute drop-search p-3 pt-1 @if ($searchSupplier == null) d-none @endif"
                                                style="max-height: 400px; overflow:scroll;">
                                                <!-- Cities dependent select menu... -->

                                                <label for="provisional_integer_id"
                                                    class="col-form-label mb-1">Proveedores</label>

                                                @php
                                                    $suppliers = \App\Models\Supplier::where(
                                                        'owner_name',
                                                        'like',
                                                        '%' . $searchSupplier . '%',
                                                    )
                                                        ->orWhere('business_name', 'like', '%' . $searchSupplier . '%')
                                                        ->get();
                                                @endphp

                                                @if ($suppliers->count() > 0)
                                                    @foreach ($suppliers as $supplier)
                                                        <button type="button"
                                                            wire:click="selectSupplier({{ $supplier->id }})"
                                                            class="btn">
                                                            {{ $supplier->owner_name }} - {{ $supplier->business_name }}
                                                        </button>
                                                    @endforeach
                                                @else
                                                    <button class="btn btn-sm btn-link" type="button"
                                                        wire:click="createSupplier">
                                                        <i class="fas fa-plus"></i> Crear proveedor
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Registrar Movimiento de Inventario</h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="movement_type" class="form-label">Tipo de Movimiento <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="movement_type" name="movement_type" required
                                                wire:model.live="type" @if ($material == null) disabled @endif
                                                @if ($mode == 1) disabled @endif>
                                                <option>Seleccionar...</option>
                                                <option value="Entrada">
                                                    <i class="fas fa-arrow-down text-success"></i> Entrada (Recepción)
                                                </option>
                                                <option value="Salida">
                                                    <i class="fas fa-arrow-up text-danger"></i> Salida (Entrega)
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Cantidad <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="quantity"
                                                name="quantity" wire:model="quantity" required
                                                @if ($mode == 1) disabled @endif
                                                @if ($material == null) disabled @endif
                                                @if ($material != null && $type == 'Salida') max="{{ $material->current_stock }}" @endif
                                                @if ($material != null && $type == 'Entrada') min="1" @endif>
                                            @if ($material != null && $type == 'Salida')
                                                <small>{{ $material->current_stock }} disponible</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @switch($type)
                                    @case('Entrada')
                                        <h4>Formato de Recepción</h4>
                                        <div class="row my-3">
                                            <div class="col-md-12">
                                                <label for="description" class="form-label">Descripción de
                                                    solicitud</label>
                                                <textarea @if ($mode == 1) disabled @endif class="form-control" name="description"
                                                    wire:model="description" id="description" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <button type="button" wire:click="inFile"
                                                    class="w-100 btn btn-outline-secondary btn-sm">Formato
                                                    de
                                                    recepción</button>
                                            </div>
                                            <div class="col-md-8">
                                                <div>
                                                    <label for="reception_file" class="form-label">Subir formato de
                                                        recepción</label>
                                                    <input type="file" class="form-control" id="reception_file"
                                                        name="reception_file" wire:model="reception_file"
                                                        @if ($mode == 1) disabled @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <h4>Validación de Calidad</h4>
                                        <div class="mb-4">
                                            <label for="validation" class="form-label">Escribe aquí resultado de validación de
                                                calidad</label>
                                            <textarea @if ($mode == 1) disabled @endif class="form-control" name="validation"
                                                wire:model="validation" id="validation" rows="3"></textarea>
                                        </div>
                                    @break

                                    @case('Salida')
                                        <h4>Solicitud de Material o Servicio</h4>
                                        <div class="row my-3">
                                            <div class="col-md-12">
                                                <label for="description_exit" class="form-label">Descripción de
                                                    solicitud</label>
                                                <textarea @if ($mode == 1) disabled @endif class="form-control" name="description_exit"
                                                    wire:model="description_exit" id="description_exit" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="my-2">
                                            <label for="request_file" class="form-label">Subir Oficio de
                                                solicitud</label>
                                            <input type="file" class="form-control" id="request_file" name="request_file"
                                                wire:model="request_file" @if ($mode == 1) disabled @endif>
                                        </div>
                                        <h4>Aprobación de salida</h4>
                                        <div class="my-2">
                                            <label for="approval_file" class="form-label">Subir aprovación de
                                                salida</label>
                                            <input type="file" class="form-control" id="approval_file"
                                                name="approval_file" wire:model="approval_file"
                                                @if ($mode == 1) disabled @endif>
                                        </div>
                                        <h4>Destino</h4>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="destiny" class="form-label">Destino</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="destiny" id="destiny"
                                                    wire:model="destiny" @if ($mode == 1) disabled @endif>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="responsable" class="form-label">Responsable</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="responsable"
                                                    id="responsable" wire:model="responsable"
                                                    @if ($mode == 1) disabled @endif>
                                            </div>
                                        </div>
                                    @break
                                @endswitch

                                <div class="d-flex gap-2">
                                    @if ($mode != 1)
                                        <button type="submit" class="btn btn-primary"
                                            @if ($material == null) disabled @endif>Registrar
                                            Movimiento</button>
                                    @endif

                                    @if (request()->route('id'))
                                        <a href="{{ url()->previous() }}" class="btn btn-outline-danger">Cancelar</a>
                                    @else
                                        <a href="{{ route('acquisitions.inventory.index') }}"
                                            class="btn btn-outline-danger">Cancelar</a>
                                    @endif


                                </div>

                            </div>
                        </div>
                    </div>

                    @if ($newSupplier == true)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Crear nuevo Proveedor</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Campo oculto para asignar rol -->
                                    <input type="hidden" wire:model="user_type" value="supplier">

                                    {{-- FORMULARIO PROVEEDOR --}}
                                    <div class="row">

                                        {{-- Nombre completo --}}
                                        <div class="col-md-12 mb-4">
                                            <label for="name" class="form-label">
                                                <ion-icon name="person-outline"></ion-icon> Nombre Completo <span
                                                    class="text-danger">*</span>
                                            </label>

                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                wire:model="name" placeholder="Ingresa tu nombre completo">

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Tipo de persona --}}
                                        <div class="col-md-12 mb-4">
                                            <label class="form-label">
                                                <ion-icon name="people-outline"></ion-icon> Me registro como <span
                                                    class="text-danger">*</span>
                                            </label>

                                            <div class="d-flex gap-4">

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        id="person_type_fisica" value="fisica"
                                                        wire:model="person_type">
                                                    <label class="form-check-label" for="person_type_fisica">
                                                        Persona Física
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        id="person_type_moral" value="moral"
                                                        wire:model="person_type">
                                                    <label class="form-check-label" for="person_type_moral">
                                                        Persona Moral
                                                    </label>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- Nombre de la empresa --}}
                                        <div class="col-md-12 mb-4" id="company_name_container"
                                            style="display: none;">
                                            <label for="company_name" class="form-label">
                                                <ion-icon name="business-outline"></ion-icon> Nombre de la Empresa
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input id="company_name" type="text"
                                                class="form-control @error('company_name') is-invalid @enderror"
                                                wire:model="company_name"
                                                placeholder="Ingresa el nombre de la empresa">

                                            @error('company_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-12 mb-4">
                                            <label for="email" class="form-label">
                                                <ion-icon name="mail-outline"></ion-icon> Correo Electrónico <span
                                                    class="text-danger">*</span>
                                            </label>

                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                wire:model="email" placeholder="ejemplo@correo.com">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Password --}}
                                        <div class="col-md-6 mb-4">
                                            <label for="password" class="form-label">
                                                <ion-icon name="lock-closed-outline"></ion-icon> Contraseña <span
                                                    class="text-danger">*</span>
                                            </label>

                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                wire:model="password" placeholder="Mínimo 8 caracteres">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Confirmar password --}}
                                        <div class="col-md-6 mb-4">
                                            <label for="password_confirmation" class="form-label">
                                                <ion-icon name="lock-closed-outline"></ion-icon> Confirmar Contraseña
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input id="password_confirmation" type="password" class="form-control"
                                                wire:model="password_confirmation" placeholder="Repite tu contraseña">
                                        </div>

                                        {{-- Padrón --}}
                                        <div class="col-md-12 mb-4">
                                            <label class="form-label">
                                                <ion-icon name="document-text-outline"></ion-icon> Mi registro es <span
                                                    class="text-danger">*</span>
                                            </label>

                                            <div class="d-flex gap-4">

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="padron_con"
                                                        value="con_padron" wire:model="padron_status">
                                                    <label class="form-check-label" for="padron_con">
                                                        Proveedor con Padrón
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="padron_sin"
                                                        value="sin_padron" wire:model="padron_status">
                                                    <label class="form-check-label" for="padron_sin">
                                                        Proveedor sin Padrón
                                                    </label>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            wire:click="cancelSupplier">Volver</button>
                                        <button class="btn btn-primary" wire:click="saveSupplier"
                                            type="button">Guardar
                                            proveedor</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>

</div>
