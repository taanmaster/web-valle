@extends('front.layouts.app')

@section('content')
    <div class="content">
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Trámites y Servicios</h2>
                        <p>
                            Trámites y Servicios: Tu Gobierno a un Clic en Valle de Santiago
                            <br><br>
                            ¡Bienvenido a la sección donde la gestión municipal se simplifica para ti! En la Administración
                            Municipal de Valle de Santiago, Guanajuato, estamos comprometidos con tu comodidad y el acceso
                            ágil a la información y los servicios que necesitas.
                            <br><br>
                            Aquí encontrarás una guía clara y detallada de los trámites y servicios que ponemos a tu
                            disposición. Desde permisos y licencias hasta pagos y solicitudes, nuestro objetivo es brindarte
                            una experiencia sencilla y transparente. Navega por las diferentes categorías o utiliza nuestro
                            buscador para encontrar rápidamente lo que necesitas, con requisitos, pasos a seguir y horarios
                            de atención al alcance de tu mano.
                            Estamos trabajando constantemente para mejorar y digitalizar nuestros procesos, acercando el
                            gobierno a tu hogar o negocio. ¡Valle de Santiago, Un Valle de Todos!
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-normal">
                    <div class="card-content w-100">
                        <livewire:service-requests.table :mode="1" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
