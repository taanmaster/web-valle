@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Tesorería
        @endslot
        @slot('title')
            Detalle del Proveedor
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <!-- Información del proveedor -->
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>#{{ $supplier->id }} - {{ $supplier->name }}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>RFC:</strong> {{ $supplier->rfc ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $supplier->email ?? 'N/A' }}</p>
                            <p><strong>Teléfono:</strong> {{ $supplier->phone ?? 'N/A' }}</p>
                            <p><strong>Cuenta Bancaria:</strong></p>
                            <ul>
                                <li><strong>Nombre:</strong> {{ $supplier->account_name ?? 'N/A' }}</li>
                                <li><strong>Número:</strong> {{ $supplier->account_number ?? 'N/A' }}</li>
                                <li><strong>Banco:</strong> {{ $supplier->bank_name ?? 'N/A' }}</li>
                            </ul>
                        </div>
                        <div class="card-footer text-muted">
                            <small>Creado: {{ $supplier->created_at }}</small><br>
                            <small>Actualizado: {{ $supplier->updated_at }}</small>
                            <div class="btn-group mt-4" role="group">
                                <a href="{{ route('treasury_account_payable_suppliers.edit', $supplier->id) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit"></i> Editar
                                </a>
                                <form method="POST"
                                    action="{{ route('treasury_account_payable_suppliers.destroy', $supplier->id) }}"
                                    style="display: inline-block;">
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

                <!-- Listado de checklists -->
                <div class="col-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Checklists del Proveedor</h5>
                            <a href="{{ route('supplier_checklists.create', $supplier->id) }}"
                                class="btn btn-sm btn-primary flex-grow-0" style="min-width: 200px">
                                <i class="bx bx-plus"></i> Crear Nueva Cuenta por Pagar
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($supplier->checklists->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Folio</th>
                                                <th>Fecha Recibido</th>
                                                <th>Fecha Devolución</th>
                                                <th>Dependencia</th>
                                                <th>No. Factura</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($supplier->checklists as $checklist)
                                                <tr>
                                                    <td>{{ $checklist->id }}</td>
                                                    <td>{{ $checklist->folio ?? 'N/A' }}</td>
                                                    <td>{{ $checklist->received_at ?? 'N/A' }}</td>
                                                    <td>{{ $checklist->return_date ?? 'N/A' }}</td>
                                                    <td>{{ $checklist->dependency_name ?? 'N/A' }}</td>
                                                    <td>{{ $checklist->invoice_number ?? 'N/A' }}</td>
                                                    <td>{{ $checklist->status }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('supplier_checklists.show', [$supplier->id, $checklist->id]) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="bx bx-show-alt"></i> Ver
                                                            </a>
                                                            <a href="{{ route('supplier_checklists.edit', [$supplier->id, $checklist->id]) }}"
                                                                class="btn btn-sm btn-outline-secondary">
                                                                <i class="bx bx-edit"></i> Editar
                                                            </a>
                                                            <form method="POST"
                                                                action="{{ route('supplier_checklists.destroy', [$supplier->id, $checklist->id]) }}"
                                                                style="display: inline-block;">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger">
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
                                    <h5>No hay checklists de cuentas por pagar asociados a este proveedor.</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($supplier->logs->count() > 0)
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Historial</h5>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Nuevo Estado</th>
                                                <th>Descripción</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($supplier->logs as $log)
                                                <tr>
                                                    <td>{{ $log->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        @switch($log->status)
                                                            @case('active')
                                                                <span class="badge bg-success">Activo</span>
                                                            @break

                                                            @case('inactive')
                                                                <span class="badge bg-danger">Inactivo</span>
                                                            @break

                                                            @case('payed')
                                                                <span class="badge bg-warning">Pagado</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td>{{ $log->description }}</td>

                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-sm btn-outline-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalEditLog{{ $log->id }}">
                                                                <i class="bx bx-edit"></i> Editar comentario
                                                            </a>
                                                            <form action="{{ route('suppliers_logs.destroy', $log->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger">
                                                                    <i class="bx bx-trash-alt"></i> Eliminar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <!-- Modal para editar el log -->
                                                <div class="modal fade" id="modalEditLog{{ $log->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="modalEditLogLabel{{ $log->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-dark">
                                                                <h5 class="modal-title text-white"
                                                                    id="modalEditLogLabel{{ $log->id }}">Editar
                                                                    Comentario
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('suppliers_logs.update', $log->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="description"
                                                                            class="form-label">Descripción</label>
                                                                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $log->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-primary">Guardar
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
