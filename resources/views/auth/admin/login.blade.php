@extends('layouts.master-without-nav')
@section('title')
    Metrica
@endsection
@section('content')
@section('body')

    <body id="body" class="auth-page"
        style="background-image: url('assets/images/p-1.png'); background-size: cover; background-position: center center;">
    @endsection

    <!-- Log In page -->
    <div class="container-md">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 auth-header-box">
                                    <div class="text-center p-3 text-white">
                                        <a href="index" class="logo logo-admin">
                                            <img src="{{ URL::asset('assets/images/logo-sm.png') }}" height="50"
                                                alt="logo" class="auth-logo">
                                        </a>
                                        <h1 style="color: white">Inicio de Sesión Municipio</h1>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="mb-4">
                                            <label for="email" class="form-label">
                                                <ion-icon name="mail-outline"></ion-icon> Correo Electrónico <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                                placeholder="ejemplo@correo.com">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="password" class="form-label">
                                                <ion-icon name="lock-closed-outline"></ion-icon> Contraseña <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password"
                                                placeholder="Tu contraseña">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    Recordar mi cuenta
                                                </label>
                                            </div>
                                        </div>

                                        <div class="d-grid mb-3">
                                            <button type="submit"
                                                class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2 py-3">
                                                <ion-icon name="log-in-outline"></ion-icon> Iniciar Sesión
                                            </button>
                                        </div>

                                        <div class="text-center">
                                            <p class="text-muted small mb-0">
                                                ¿Olvidaste tu contraseña? Solicita una actualización con administración
                                                de sistemas.
                                            </p>
                                        </div>
                                    </form>
                                </div>
                                <!--end card-body-->
                                <div class="card-body bg-light-alt text-center">
                                    &copy;
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script> Valle de Santiago
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-body-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->

@endsection
