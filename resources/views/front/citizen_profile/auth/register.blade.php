@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card card-image card-alignment-bottom wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-3.jpg') }}" alt="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow wow fadeInUp mb-0">
                <div class="card-body bg-secondary text-white">
                    <h4 class="mb-0">
                        <ion-icon name="person-outline"></ion-icon> Registro de Ciudadano
                    </h4>
                    <p class="mb-0 small">Crea tu cuenta para acceder a los servicios ciudadanos</p>
                </div>
                
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Campo oculto para asignar rol ciudadano -->
                        <input type="hidden" name="user_type" value="citizen">

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="name" class="form-label">
                                    <ion-icon name="person-outline"></ion-icon> Nombre Completo <span class="text-danger text-sm">*</span>
                                </label>
                                <input id="name" type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autocomplete="name" 
                                       autofocus
                                       placeholder="Ingresa tu nombre completo">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="email" class="form-label">
                                    <ion-icon name="mail-outline"></ion-icon> Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email"
                                       placeholder="ejemplo@correo.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label">
                                    <ion-icon name="lock-closed-outline"></ion-icon> Contraseña <span class="text-danger">*</span>
                                </label>
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Mínimo 8 caracteres">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label">
                                    <ion-icon name="lock-closed-outline"></ion-icon> Confirmar Contraseña <span class="text-danger">*</span>
                                </label>
                                <input id="password_confirmation" type="password" 
                                       class="form-control" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Repite tu contraseña">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-group mb-2">
                                <label for="rfc_name">Captcha <span class="text-danger">*</span></label>

                                <div class="captcha">
                                    <span class="me-2">{!! captcha_img('flat') !!}</span>
                                    <button type="button" class="btn btn-danger btn-sm reload" id="reload">&#x21bb; Cambiar captcha</button>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <input type="text" class="form-control custom-form-control @error('captcha') is-invalid @enderror" placeholder="Caracteres del captcha" name="captcha" required>

                                @error('captcha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    Al crear una cuenta ciudadana acepto los términos y condiciones y el 
                                    aviso de privacidad <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg py-3 d-flex align-items-center justify-content-center gap-2">
                                <ion-icon name="person-add-outline"></ion-icon> Crear Cuenta Ciudadana
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">
                                ¿Ya tienes cuenta? 
                                <a href="{{ route('login') }}" class="text-primary">Inicia sesión aquí</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="text-center mt-4 wow fadeInUp">
                <div class="alert alert-info">
                    <i class="bx bx-info-circle"></i>
                    <strong>¿Necesitas ayuda?</strong><br>
                    Contacta a soporte ciudadano: <a href="mailto:comunicacion.social@valledesantiago.gob.mx">comunicacion.social@valledesantiago.gob.mx</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validación adicional en el frontend
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmPassword.setCustomValidity('');
            }
        }

        password.addEventListener('change', validatePassword);
        confirmPassword.addEventListener('keyup', validatePassword);
    });
</script>

<!-- Captcha Reload -->
<script>
    $('.reload').on('click', function(){
        event.preventDefault();            
        $.ajax({
            type: 'GET',
            url: "{{ route('reload.captcha') }}",
            success: function(response){
                console.log(response);
                $('.captcha span').html(response.captcha);
            },
            error: function(response){
                $('#registerBtn').attr('disabled', true);
            }
        });
    });
</script>
@endpush