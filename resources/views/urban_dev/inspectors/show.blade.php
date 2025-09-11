@extends('layouts.master')
@section('title')Inspector - {{ $inspector->name }} @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('li_3') Inspectores @endslot
@slot('title') {{ $inspector->name }} @endslot
@endcomponent

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bx bx-user me-2"></i>Información del Inspector
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo:</label>
                            <p class="form-control-plaintext">{{ $inspector->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico:</label>
                            <p class="form-control-plaintext">{{ $inspector->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Estado:</label>
                            <p class="form-control-plaintext">
                                @if($inspector->email_verified_at)
                                    <span class="badge bg-success">
                                        <i class="bx bx-check"></i> Verificado
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bx bx-time"></i> Pendiente de verificación
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Fecha de Registro:</label>
                            <p class="form-control-plaintext">{{ $inspector->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Última Actualización:</label>
                            <p class="form-control-plaintext">{{ $inspector->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bx bx-shield me-2"></i>Roles y Permisos
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Roles Asignados:</label>
                    <div>
                        @if($inspector->roles->count() > 0)
                            @foreach($inspector->roles as $role)
                                <span class="badge bg-success me-1">{{ $role->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">Sin roles asignados</span>
                        @endif
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Permisos:</label>
                    <div>
                        @if($inspector->getAllPermissions()->count() > 0)
                            @foreach($inspector->getAllPermissions() as $permission)
                                <span class="badge bg-info me-1 mb-1">{{ $permission->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">Sin permisos específicos</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bx bx-cog me-2"></i>Acciones
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="javascript:void(0)" onclick="openEditInspectorModal({
                        id: {{ $inspector->id }},
                        name: '{{ $inspector->name }}',
                        email: '{{ $inspector->email }}'
                    })" class="btn btn-success">
                        <i class="bx bx-edit me-2"></i>Editar Inspector
                    </a>
                    
                    <a href="{{ route('urban_dev.inspectors.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-2"></i>Volver a Lista
                    </a>
                    
                    <form action="{{ route('urban_dev.inspectors.destroy', $inspector->id) }}" method="POST" class="mt-2">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('¿Estás seguro de eliminar este inspector?')">
                            <i class="bx bx-trash me-2"></i>Eliminar Inspector
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Inspector -->
<div id="modalEditInspector" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Inspector</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editInspectorForm" method="POST" action="">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editInspectorName" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="editInspectorName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editInspectorEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="editInspectorEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editInspectorPassword" class="form-label">Contraseña (Dejar vacío para mantener)</label>
                        <input type="password" class="form-control" id="editInspectorPassword" name="password">
                    </div>
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-2"></i>
                        <strong>Rol:</strong> Este usuario mantendrá automáticamente el rol de "Inspector".
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditInspectorModal(inspector) {
        const form = document.getElementById('editInspectorForm');
        form.action = `{{ route('urban_dev.inspectors.update', '') }}/${inspector.id}`;
        document.getElementById('editInspectorName').value = inspector.name;
        document.getElementById('editInspectorEmail').value = inspector.email;
        new bootstrap.Modal(document.getElementById('modalEditInspector')).show();
    }
</script>

@endsection
