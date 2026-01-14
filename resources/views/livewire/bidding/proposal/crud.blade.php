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

    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Nueva Propuesta/Cotización</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="POST" wire:submit="save" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="row">
                @if ($newSupplier == true)
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
                                class="form-control @error('name') is-invalid @enderror" wire:model="name"
                                placeholder="Ingresa tu nombre completo">

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
                                    <input class="form-check-input" type="radio" id="person_type_fisica"
                                        value="fisica" wire:model="person_type">
                                    <label class="form-check-label" for="person_type_fisica">
                                        Persona Física
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="person_type_moral" value="moral"
                                        wire:model="person_type">
                                    <label class="form-check-label" for="person_type_moral">
                                        Persona Moral
                                    </label>
                                </div>

                            </div>
                        </div>

                        {{-- Nombre de la empresa --}}
                        <div class="col-md-12 mb-4" id="company_name_container" style="display: none;">
                            <label for="company_name" class="form-label">
                                <ion-icon name="business-outline"></ion-icon> Nombre de la Empresa <span
                                    class="text-danger">*</span>
                            </label>

                            <input id="company_name" type="text"
                                class="form-control @error('company_name') is-invalid @enderror"
                                wire:model="company_name" placeholder="Ingresa el nombre de la empresa">

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
                                class="form-control @error('email') is-invalid @enderror" wire:model="email"
                                placeholder="ejemplo@correo.com">

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
                                class="form-control @error('password') is-invalid @enderror" wire:model="password"
                                placeholder="Mínimo 8 caracteres">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirmar password --}}
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label">
                                <ion-icon name="lock-closed-outline"></ion-icon> Confirmar Contraseña <span
                                    class="text-danger">*</span>
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
                        <button type="button" class="btn btn-secondary" wire:click="cancelSupplier">Volver</button>
                        <button class="btn btn-primary" wire:click="saveSupplier" type="button">Guardar
                            proveedor</button>
                    </div>
                @else
                    <div class="col-md">

                        <div class="row">

                            <h4>Información de Proveedor</h4>

                            <div class="col-md-2">
                                <label for="worker_id" class="col-form-label" required>Proveedor</label>
                            </div>
                            <div class="col-md">
                                <div class="input-group">
                                    @if ($selectedSupplier != null)
                                        <div class="d-flex w-100">
                                            <input type="text" name="supplier_name" wire:model="supplier_name"
                                                class="form-control" @if ($mode == 1) disabled @endif
                                                placeholder="Nombre completo" disabled>
                                            <button type="button" wire:click="clearSupplier"
                                                class="btn btn-link btn-sm @if ($mode == 1) d-none @endif">Limpiar</button>
                                        </div>
                                    @else
                                        <input type="text" name="searchSupplier" wire:model.live="searchSupplier"
                                            class="form-control" placeholder="Buscar por nombre">
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
                                            <button type="button" wire:click="selectSupplier({{ $supplier->id }})"
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

                        @if ($selectedSupplier != null)
                            <div class="row my-4">
                                <div class="col-md-6">
                                    <label for="provisional_integer_id" class="col-form-label">No. Proveedor</label>
                                    <p>{{ $supplier_num }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Tipo de Proveedor</label>
                                    @switch($supplier_type)
                                        @case('fisica')
                                            <p>Persona física</p>
                                        @break

                                        @case('moral')
                                            <p>Persona moral</p>
                                        @break
                                    @endswitch
                                </div>
                            </div>


                            <div class="row my-4">
                                <h4>Cotización y/o Propuesta</h4>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Nombre del documento *</label>
                                    </div>
                                    <div class="col-md">
                                        <input type="text" name="file_name" id="file_name" wire:model="file_name"
                                            @if ($mode == 1) disabled @endif class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Archivo *</label>
                                    </div>
                                    <div class="col-md">
                                        <input type="file" name="file" id="file" wire:model="file"
                                            @if ($mode == 1) disabled @endif class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @if ($newSupplier != true)
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar
                    Propuesta</button>
            </div>
        @endif
    </form>


</div>
