
@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.contraloria.utilities._nav')

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-8.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Contraloría Interna Municipal</p>
                        <h1 class="display-2 mb-0">Aviso de Privacidad</h1>
                    </div>
                </div>
            </div>
        </div>

         <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp">

                                        <p>El H. Ayuntamiento de Valle de Santiago, Guanajuato, por medio de su Contraloría Municipal, quienes tienen su domicilio el ubicado en Palacio Municipal S/N de la zona centro, de esta ciudad, C.P. 38400, son los responsables del tratamiento de los datos personales que nos proporciona, los cuales serán protegidos conforme a lo dispuesto por la Ley de Protección de Datos Personales en Posesión de los Sujetos Obligados para el estado de Guanajuato y demás normatividad aplicable.

Los datos personales que nos proporciones servirán para informarle sobre el inicio y la conclusión de la atención ciudadana, para fines estadísticos y, en su caso para solicitar la información adicional que nos permita brindarte una mejor atención. Estos datos tendrán carácter confidencial y no podrán cederse a otra instancia, salvo que otorgue expresamente su consentimiento, o en los casos que prevé el artículo 17 de la Ley de Protección de Datos Personales para el Estado de Guanajuato.

Conforme a lo dispuesto en la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados para el Estado de Guanajuato, los responsables deberán dar a conocer el aviso de privacidad correspondiente, y los datos personales podrán ser recabados en las formas establecidas en los articulos 3 fracciones I, VII y VIII; 34, 35, 36, 37, 38, 40 y 42.
Así como, de conformidad con lo dispuesto por la Constitución Política de los Estados Unidos Mexicanos, en el artículo 6 y la Constitución Política para el Estado de Guanajuato, en su artículo 14, inciso b facción III.

En cuanto a la transferencia de datos personales, el fundamento se encuentra en los artículos 96, 97, 98, 99, 100 y 101 de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados para el Estado de Guanajuato.

¿Qué datos personales solicitamos?

Al momento de ingresar al portal web del ayuntamiento para llevar a cabo su denuncia, solicitamos lo siguiente:
Nombre completo.
Domicilio.
Teléfono.
Correo electrónico.
Datos sensibles.

Le informamos que NO captamos información de carácter sensible de acuerdo a lo establecido en la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados para el Estado de Guanajuato.
</p>
                </div>
            </div>
        </div>

        @include('front.contraloria.utilities._footer')
    </div>
@endsection

@push('styles')

@endpush

@push('scripts')

@endpush
