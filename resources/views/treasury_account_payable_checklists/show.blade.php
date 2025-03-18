@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Detalle del Checklist @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <!-- Información general del checklist -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5>#{{ $checklist->id }} - {{ $checklist->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Descripción:</strong> {{ $checklist->description ?? 'N/A' }}</p>
                        <p><strong>Estado:</strong> 
                            @if($checklist->status === 'active')
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Creado: {{ $checklist->created_at }}</small><br>
                        <small>Actualizado: {{ $checklist->updated_at }}</small>
                        <div class="btn-group mt-4" role="group">
                            <a href="{{ route('treasury_account_payable_checklists.edit', $checklist->id) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-edit"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('treasury_account_payable_checklists.destroy', $checklist->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Elementos del checklist -->
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Elementos del Checklist</h5>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreateElement" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus"></i> Agregar Elemento
                        </a>
                    </div>
                    <div class="card-body">
                        @if($checklist->elements->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Orden</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($checklist->elements as $element)
                                    <tr>
                                        <td>{{ $element->id }}</td>
                                        <td>{{ $element->name }}</td>
                                        <td>{{ $element->description ?? 'N/A' }}</td>
                                        <td>{{ $element->order ?? 'N/A' }}</td>
                                        <td>
                                            @if($element->status === 'active')
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-outline-secondary btn-edit-element" data-element="{{ json_encode($element) }}">
                                                    <i class="bx bx-edit"></i> Editar
                                                </a>

                                                <form method="POST" action="{{ route('checklist_elements.destroy', $element->id) }}" style="display: inline-block;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bx bx-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center my-4">
                            <h5>No hay elementos asociados a este checklist.</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar un nuevo elemento -->
<div class="modal fade" id="modalCreateElement" tabindex="-1" role="dialog" aria-labelledby="modalCreateElementLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreateElementLabel">Agregar Elemento al Checklist</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('checklist_elements.store') }}">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="order" class="form-label">Orden <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="number" class="form-control" id="order" name="order">
                        </div>
                        <input type="hidden" name="checklist_id" value="{{ $checklist->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar Elemento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar un elemento -->
<div class="modal fade" id="modalEditElement" tabindex="-1" role="dialog" aria-labelledby="modalEditElementLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalEditElementLabel">Editar Elemento del Checklist</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editElementForm" method="POST" action="">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="edit_description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="edit_order" class="form-label">Orden <span class="text-info tx-12">(Opcional)</span></label>
                            <input type="number" class="form-control" id="edit_order" name="order">
                        </div>
                        <input type="hidden" id="edit_checklist_id" name="checklist_id" value="{{ $checklist->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script para abrir el modal de edición con los datos del elemento
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit-element');
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const element = JSON.parse(this.getAttribute('data-element'));
                const form = document.getElementById('editElementForm');
                form.action = `/checklist_elements/${element.id}`; // Ruta dinámica para el controlador
                document.getElementById('edit_name').value = element.name;
                document.getElementById('edit_description').value = element.description || '';
                document.getElementById('edit_order').value = element.order || '';
                new bootstrap.Modal(document.getElementById('modalEditElement')).show();
            });
        });
    });
</script>
@endsection