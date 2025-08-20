@extends('layouts.master')

@section('title')Editar Rol @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Configuraciones @endslot
        @slot('li_3') <a href="{{ route('roles.index') }}">Roles</a> @endslot
        @slot('title') Editar: {{ $role->name }} @endslot
    @endcomponent

    @include('layouts.utilities._messages')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Editar Rol: {{ $role->name }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre del Rol</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $role->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="guard_name" class="form-label">Guard Name</label>
                                <select id="guard_name" class="form-control @error('guard_name') is-invalid @enderror" name="guard_name" required>
                                    <option value="web" {{ old('guard_name', $role->guard_name) == 'web' ? 'selected' : '' }}>Web</option>
                                    <option value="api" {{ old('guard_name', $role->guard_name) == 'api' ? 'selected' : '' }}>API</option>
                                </select>
                                @error('guard_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="mb-3">Permisos Asignados</h6>
                            <hr>
                            
                            @if($permissions->count() > 0)
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                       value="{{ $permission->name }}" id="permission_{{ $permission->id }}"
                                                       {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPermissions()">
                                        Seleccionar Todos
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllPermissions()">
                                        Deseleccionar Todos
                                    </button>
                                </div>
                            @else
                                <p class="text-muted">No hay permisos disponibles en el sistema.</p>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    function selectAllPermissions() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = true);
    }

    function deselectAllPermissions() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = false);
    }
</script>
@endsection
