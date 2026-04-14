{{-- Login original de Laravel (desactivado) --}}
{{-- ... --}}

@extends('front.layouts.app')

@section('content')
    @php
        $hasPendingBooking = session()->has('pending_booking');
        $esMunicipio = request('tipo') === 'municipio';
        $loginTitulo = $esMunicipio ? 'Inicio de Sesión Municipio' : 'Inicio de Sesión Ciudadano';
        $loginImagen = $esMunicipio ? 'front/img/placeholder-4.jpg' : 'front/img/placeholder-3.jpg';
    @endphp

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-image card-alignment-bottom wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset($loginImagen) }}" alt="">
                </div>
            </div>
            <div class="col-md-5">
                <div class="card wow fadeInUp mb-0 shadow">
                    <div class="card-body bg-secondary text-white">
                        <h4 class="mb-0">
                            <ion-icon name="log-in-outline"></ion-icon> {{ $loginTitulo }}
                        </h4>
                        <p class="small mb-0">Accede a tu cuenta para utilizar los servicios municipales</p>
                    </div>

                    <div class="card-body p-4">
                        {{-- Alerta de cita pendiente --}}
                        @if ($hasPendingBooking)
                            <div class="alert alert-info border-0 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <ion-icon name="calendar-outline" class="me-2" style="font-size: 1.4rem;"></ion-icon>
                                    <div>
                                        <strong>Tienes una cita pendiente por confirmar.</strong><br>
                                        <small>Inicia sesión para completar tu reservación.</small>
                                    </div>
                                </div>
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
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" placeholder="Tu contraseña">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
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
                                @unless ($esMunicipio)
                                <p class="mb-2">
                                    ¿No tienes cuenta?
                                    <a href="{{ route('register') }}" class="text-primary fw-semibold">Regístrate aquí</a>
                                </p>
                                @endunless
                                <p class="text-muted small mb-0">
                                    ¿Olvidaste tu contraseña? Solicita una actualización con administración de sistemas.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="wow fadeInUp mt-4 text-center">
                    <div class="alert alert-info">
                        <ion-icon name="information-circle-outline"></ion-icon>
                        <strong>¿Necesitas ayuda?</strong><br>
                        Contacta a soporte: <a
                            href="mailto:comunicacion.social@valledesantiago.gob.mx">comunicacion.social@valledesantiago.gob.mx</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
