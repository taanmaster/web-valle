@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-body">
                <h2>Bienvenido a la v.alpha1.0.0 de Portal Valle de Santiago</h2>
                <hr>
                <h3>Accesos de Prueba:</h3>

                <p class="mb-0">Correo: webmaster@valle.com</p>
                <p>Contraseña: valle12345</p>

                <p class="mb-0">Correo: admin@valle.com</p>
                <p>Contraseña: valle12345</p>

                <p class="mb-0">Correo: ciudadano@valle.com</p>
                <p>Contraseña: valle12345</p>

                <hr>
                @guest
                <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
                @else
                <div class="alert alert-success">Inicio de sesión correcto. Da click en el botón inferior para acceder al portal.</div>
                <a href="{{ URL('/helpdesk-index') }}" class="btn btn-primary">Acceder al panel</a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection