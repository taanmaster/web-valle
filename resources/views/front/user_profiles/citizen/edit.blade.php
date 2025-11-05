@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <h5 class="mb-4">
                            <i class="bx bx-edit"></i> Editar Perfil
                        </h5>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('citizen.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Información Personal -->
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">
                                        <i class="bx bx-user"></i> Información Personal
                                    </h6>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre Completo *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo Electrónico *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                            required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone', $citizen->phone ?? '') }}"
                                            placeholder="10 dígitos">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="curp" class="form-label">CURP</label>
                                        <input type="text" class="form-control @error('curp') is-invalid @enderror"
                                            id="curp" name="curp"
                                            value="{{ old('curp', $citizen->curp ?? '') }}" placeholder="18 caracteres"
                                            maxlength="18">
                                        @error('curp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cambio de Contraseña -->
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">
                                        <i class="bx bx-lock"></i> Seguridad
                                    </h6>

                                    <div class="alert alert-info">
                                        <small>
                                            <i class="bx bx-info-circle"></i>
                                            Deja los campos de contraseña vacíos si no deseas cambiarla.
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Contraseña Actual</label>
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Nueva Contraseña</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirmar Nueva
                                            Contraseña</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('citizen.profile.index') }}" class="btn btn-outline-secondary">
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
    </div>

    <style>
        .avatar {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-lg {
            width: 4rem;
            height: 4rem;
        }

        .avatar-initial {
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
@endsection
