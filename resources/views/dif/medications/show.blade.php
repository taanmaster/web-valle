@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Medicamento: {{ $medication->generic_name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $medication->generic_name }}</h5>

                        <p class="card-text"><strong>Nombre comercial:</strong> {{ $medication->commercial_name ?? 'N/A' }}</p>

                        <div class="mb-3">
                            @if($medication->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </div>

                        @if($medication->description)
                            <p class="card-text"><strong>Descripción:</strong></p>
                            <p class="card-text">{{ $medication->description }}</p>
                        @endif

                        @if($medication->formula)
                            <p class="card-text"><strong>Fórmula:</strong></p>
                            <p class="card-text">{{ $medication->formula }}</p>
                        @endif

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Metadatos</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $medication->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $medication->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>


                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.medications.edit', $medication->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.medications.destroy', $medication->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este medicamento?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.medications.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Variantes</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createVariantModal">
                            <i class="fas fa-plus"></i> Agregar Variante
                        </button>
                    </div>

                    <div class="card-body">
                        @if(isset($medication->variants) && $medication->variants->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Presentación</th>
                                            <th>Vía de administración</th>
                                            <th>Precio</th>
                                            <th>Cantidad en inventario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($medication->variants as $variant)
                                            <tr>
                                                <td>
                                                    <strong>{{ $variant->name }}</strong><br>
                                                    <small class="text-muted">
                                                        {{ $variant->type ?? 'N/A' }}
                                                        @if($variant->type_num)
                                                            - {{ $variant->type_num }}
                                                        @endif
                                                        @if($variant->type_dosage)
                                                            {{ $variant->type_dosage }}
                                                        @endif
                                                    </small><br>
                                                    <small class="text-muted">SKU: <code>{{ $variant->sku }}</code></small>
                                                </td>
                                                <td>{{ $variant->use_type ?? 'N/A' }}</td>
                                                <td>
                                                    @if($variant->price)
                                                        ${{ number_format($variant->price, 2) }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $stockStatus = $variant->getStockStatus();
                                                        $currentStock = $variant->getCurrentStock();
                                                    @endphp
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="fw-bold">{{ $currentStock }}</span>
                                                        <span class="badge {{ $stockStatus['badge_class'] }}">
                                                            {{ $stockStatus['label'] }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}" class="btn btn-sm btn-success" title="Registrar Movimiento">
                                                            <i class="fas fa-exchange-alt"></i>
                                                        </a>
                                                        <a href="{{ route('dif.medication_variants.show', $variant->id) }}" class="btn btn-sm btn-info" title="Ver Variante">Ver</a>
                                                        <a href="{{ route('dif.medication_variants.edit', $variant->id) }}" class="btn btn-sm btn-secondary" title="Editar Variante">Editar</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No hay variantes registradas.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>Historial y Notas</h5>

                            <div class="text-end">
                                <a href="javascript:void(0)" class="btn btn-primary d-block">Crear Nota Manual</a>
                            </div>
                        </div>

                        <!-- Modal: Crear Nota Manual -->
                        <div class="modal fade" id="createManualNoteModal" tabindex="-1" aria-labelledby="createManualNoteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('create.manual.notification') }}">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createManualNoteModalLabel">Crear Nota Manual</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="model_id" value="{{ $medication->id }}">
                                            <input type="hidden" name="type" value="medication">
                                            <input type="hidden" name="model_action" value="update">
                                            <input type="hidden" name="data" value="creó una nota interna">

                                            <div class="mb-3">
                                                <label class="form-label">Nota</label>
                                                <textarea name="note" class="form-control" rows="4" placeholder="Detalle de la nota"></textarea>
                                            </div>

                                            <small>La nota se asocia directamente a tu perfil y al registro del elemento padre.</small>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Crear Nota</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal: Crear Variante -->
                        <div class="modal fade" id="createVariantModal" tabindex="-1" aria-labelledby="createVariantModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('dif.medication_variants.store') }}">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createVariantModalLabel">Crear Nueva Variante</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="medication_id" value="{{ $medication->id }}">
                                            <input type="hidden" name="redirect_to_medication" value="1">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="variant_name" class="form-label">Nombre de la Variante <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="variant_name" name="name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="variant_sku" class="form-label">SKU <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="variant_sku" name="sku" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="variant_price" class="form-label">Precio</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control" id="variant_price" name="price" step="0.01" min="0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="variant_type" class="form-label">Presentación</label>
                                                        <select class="form-select" id="variant_type" name="type">
                                                            <option value="">Seleccionar...</option>
                                                            <option value="Tableta">Tableta</option>
                                                            <option value="Cápsula">Cápsula</option>
                                                            <option value="Píldora">Píldora</option>
                                                            <option value="Supositorio">Supositorio</option>
                                                            <option value="Jarabe">Jarabe</option>
                                                            <option value="Gotas">Gotas</option>
                                                            <option value="Crema">Crema</option>
                                                            <option value="Gel">Gel</option>
                                                            <option value="Pomada">Pomada</option>
                                                            <option value="Spray">Spray</option>
                                                            <option value="Parche">Parche</option>
                                                            <option value="Inyectable">Inyectable</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="variant_type_num" class="form-label">Concentración (Cantidad de Medida)</label>
                                                        <input type="text" class="form-control" id="variant_type_num" name="type_num" placeholder="ej. 30, 500">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="variant_type_dosage" class="form-label">Unidad de Medida</label>
                                                        <select class="form-select" id="variant_type_dosage" name="type_dosage">
                                                            <option value="">Seleccionar...</option>
                                                            <option value="mg">mg (miligramos)</option>
                                                            <option value="g">g (gramos)</option>
                                                            <option value="ml">ml (mililitros)</option>
                                                            <option value="l">l (litros)</option>
                                                            <option value="mcg">mcg (microgramos)</option>
                                                            <option value="UI">UI (Unidades Internacionales)</option>
                                                            <option value="%">% (porcentaje)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="variant_use_type" class="form-label">Vía de Administración</label>
                                                <select class="form-select" id="variant_use_type" name="use_type">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="Oral">Oral</option>
                                                    <option value="Tópica">Tópica</option>
                                                    <option value="Oftálmica">Oftálmica</option>
                                                    <option value="Ótica">Ótica</option>
                                                    <option value="Inyectable">Inyectable</option>
                                                    <option value="Intravenosa">Intravenosa</option>
                                                    <option value="Intramuscular">Intramuscular</option>
                                                    <option value="Subcutánea">Subcutánea</option>
                                                    <option value="Rectal">Rectal</option>
                                                    <option value="Vaginal">Vaginal</option>
                                                    <option value="Nasal">Nasal</option>
                                                    <option value="Inhalatoria">Inhalatoria</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Crear Variante</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Script: abrir modal desde el botón "Crear Nota Manual" -->
                        <!-- Script: abrir modal desde el botón "Crear Nota Manual" -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                // Script para abrir modal de notas
                                document.querySelectorAll('a').forEach(function (el) {
                                    if (el.textContent.trim() === 'Crear Nota Manual') {
                                        el.addEventListener('click', function (e) {
                                            e.preventDefault();
                                            new bootstrap.Modal(document.getElementById('createManualNoteModal')).show();
                                        });
                                    }
                                });

                                // Script para generar SKU automáticamente
                                const variantNameInput = document.getElementById('variant_name');
                                const variantSkuInput = document.getElementById('variant_sku');
                                
                                if (variantNameInput && variantSkuInput) {
                                    variantNameInput.addEventListener('input', function() {
                                        const name = this.value;
                                        if (name && !variantSkuInput.value) {
                                            // Generar SKU basado en el nombre del medicamento y la variante
                                            const medicationName = '{{ Str::slug($medication->generic_name, '-') }}';
                                            const variantSlug = name.toLowerCase()
                                                .replace(/[^a-z0-9\s]/g, '')
                                                .replace(/\s+/g, '-')
                                                .substring(0, 20);
                                            const randomSuffix = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                                            const sku = `${medicationName}-${variantSlug}-${randomSuffix}`.toUpperCase();
                                            variantSkuInput.value = sku;
                                        }
                                    });
                                }
                            });
                        </script>                        <hr>
                        <div class="table-responsive mb-0" >
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Acción</th>
                                        <th>Información</th>
                                        <th>Nota</th>
                                        <th>Fecha y Hora</th>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>
                                            @switch($log->model_action)
                                                @case('destroy')
                                                    <i class='bx bx-minus-circle'></i> Eliminación
                                                    @break
                                    
                                                @case('update')
                                                    <i class='bx bxs-edit'></i> Actualización
                                                    @break
                        
                                                @case('create')
                                                    <i class='bx bx-check-square' ></i> Creación
                                                    @break
                                    
                                                @default
                                                    <i class='bx bx-bell' ></i> Notificación
                                            @endswitch
                                        </td>
                                        <td>{{ $log->user->name ?? 'Invitado' }} {{ $log->data }}</td>
                                        <td>{{ $log->note ?? 'n/a' }}</td>
                                        <td class="text-muted"><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y H:i a') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
