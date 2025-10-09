@extends('layouts.master')
@section('title')Intranet @endsection

@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('title') Agregar Trabajador @endslot
@endcomponent

<style>
    .profile-upload-section {
        background: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        position: sticky;
        top: 20px;
    }
    
    .profile-preview {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #dee2e6;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        margin-top: 15px;
    }
    
    .upload-btn {
        border: 2px solid #0d6efd;
        color: #0d6efd;
        background-color: white;
        padding: 10px 25px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .upload-btn:hover {
        background-color: #0d6efd;
        color: white;
    }
    
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }
    
    .form-section {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #0d6efd;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-section-title i {
        font-size: 20px;
        color: #0d6efd;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Agregar Nuevo Trabajador</h4>
            </div>
            <div class="box-body">
                <form method="POST" action="{{ route('urban_dev.workers.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Columna Izquierda: Foto de Perfil -->
                        <div class="col-lg-3 col-md-4">
                            <div class="profile-upload-section">
                                <h5 class="mb-3 text-dark"><i class="fas fa-camera me-2"></i>Foto de Perfil</h5>
                                <img id="preview" src="{{ asset('img/avatar-placeholder.png') }}" alt="Preview" class="profile-preview">
                                
                                <div class="upload-btn-wrapper">
                                    <button type="button" class="upload-btn">
                                        <i class='fas fa-cloud-upload-alt me-2'></i> Seleccionar Foto
                                    </button>
                                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" onchange="previewImage(event)">
                                </div>
                                
                                <p class="mt-3 mb-0 text-muted" style="font-size: 12px;">
                                    Tamaño máximo: 5MB<br>
                                    Formatos: JPG, PNG, GIF
                                </p>
                            </div>
                        </div>

                        <!-- Columna Derecha: Formulario -->
                        <div class="col-lg-9 col-md-8">

                        <!-- Columna Derecha: Formulario -->
                        <div class="col-lg-9 col-md-8">
                            <!-- Información Personal -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class='fas fa-user'></i>
                                    <span>Información Personal</span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nombre(s) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Ej. Juan Carlos">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">Apellido(s) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required placeholder="Ej. García López">
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="employee_number" class="form-label">No. Empleado <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('employee_number') is-invalid @enderror" id="employee_number" name="employee_number" value="{{ old('employee_number') }}" required placeholder="Ej. EMP-2025-001">
                                        @error('employee_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="position" class="form-label">Puesto/Cargo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}" required placeholder="Ej. Inspector de Obra">
                                        @error('position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Clasificación -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class='fas fa-building'></i>
                                    <span>Clasificación y Dependencia</span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="dependency_category" class="form-label">Dependencia <span class="text-danger">*</span></label>
                                        <select class="form-control @error('dependency_category') is-invalid @enderror" id="dependency_category" name="dependency_category" required onchange="toggleSubcategory()">
                                            <option value="">Seleccionar...</option>
                                            <option value="Desarrollo Urbano" {{ old('dependency_category') == 'Desarrollo Urbano' ? 'selected' : '' }}>Desarrollo Urbano</option>
                                            <option value="Fiscalización" {{ old('dependency_category') == 'Fiscalización' ? 'selected' : '' }}>Fiscalización</option>
                                        </select>
                                        @error('dependency_category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3" id="subcategory_container" style="display: none;">
                                        <label for="dependency_subcategory" class="form-label">Tipo <span class="text-danger">*</span></label>
                                        <select class="form-control @error('dependency_subcategory') is-invalid @enderror" id="dependency_subcategory" name="dependency_subcategory">
                                            <option value="">Seleccionar...</option>
                                            <option value="Inspector" {{ old('dependency_subcategory') == 'Inspector' ? 'selected' : '' }}>Inspector</option>
                                            <option value="Perito" {{ old('dependency_subcategory') == 'Perito' ? 'selected' : '' }}>Perito</option>
                                        </select>
                                        @error('dependency_subcategory')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Credencial -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class='fas fa-id-card'></i>
                                    <span>Información de Credencial</span>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="issue_date" class="form-label">Fecha de Expedición <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" value="{{ old('issue_date') }}" required>
                                        @error('issue_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validity_date_start" class="form-label">Vigencia Inicio <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('validity_date_start') is-invalid @enderror" id="validity_date_start" name="validity_date_start" value="{{ old('validity_date_start') }}" required>
                                        @error('validity_date_start')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="validity_date_end" class="form-label">Vigencia Fin</label>
                                        <input type="date" class="form-control @error('validity_date_end') is-invalid @enderror" id="validity_date_end" name="validity_date_end" value="{{ old('validity_date_end') }}">
                                        @error('validity_date_end')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Opcional: dejar vacío si no tiene fecha de fin</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Credenciales de Usuario (solo para Inspectores) -->
                            <div class="form-section" id="user_credentials_section" style="display: none;">
                                <div class="form-section-title">
                                    <i class='fas fa-lock'></i>
                                    <span>Credenciales de Acceso al Sistema</span>
                                </div>

                                <div class="alert alert-info mb-3" id="user_credentials_alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Los inspectores requieren credenciales para acceder al sistema y gestionar solicitudes.
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="ejemplo@correo.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Mínimo 4 caracteres">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Mínimo 4 caracteres</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="row mt-4">
                                <div class="col-md-12 d-flex gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save me-2"></i> Guardar Trabajador
                                    </button>
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times me-2"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    function toggleSubcategory() {
        const category = document.getElementById('dependency_category').value;
        const subcategoryContainer = document.getElementById('subcategory_container');
        const subcategory = document.getElementById('dependency_subcategory');
        
        if (category === 'Desarrollo Urbano') {
            subcategoryContainer.style.display = 'block';
            checkInspectorSelected();
        } else {
            subcategoryContainer.style.display = 'none';
            hideUserCredentials();
            subcategory.value = '';
        }
    }

    function checkInspectorSelected() {
        const subcategory = document.getElementById('dependency_subcategory').value;
        
        if (subcategory === 'Inspector') {
            showUserCredentials();
        } else {
            hideUserCredentials();
        }
    }

    function showUserCredentials() {
        document.getElementById('user_credentials_section').style.display = 'block';
        document.getElementById('email').required = true;
        document.getElementById('password').required = true;
    }

    function hideUserCredentials() {
        document.getElementById('user_credentials_section').style.display = 'none';
        document.getElementById('email').required = false;
        document.getElementById('password').required = false;
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
    }

    // Event listener para subcategoría
    document.getElementById('dependency_subcategory').addEventListener('change', checkInspectorSelected);

    // Ejecutar al cargar la página para mantener estado con old()
    document.addEventListener('DOMContentLoaded', function() {
        toggleSubcategory();
    });
</script>

@endsection
