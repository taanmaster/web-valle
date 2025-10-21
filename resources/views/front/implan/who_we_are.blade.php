@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.implan.utilities.nav')

        <div class="row align-items-center my-4">
            <div class="col-md-6 d-flex justify-content-center py-4">
                <img src="{{ asset('images/implan/implan-logo.png') }}" alt="" style="width: 280px">
            </div>

            <div class="col-md-6">
                <h1>¿Qué es el IMPLAN?</h1>
                <p>El Instituto Municipal de Planeación de Valle de Santiago (IMPLAN) es un organismo público de carácter técnico que asesora y coadyuva al Ayuntamiento en la planeación del desarrollo integral del municipio. Trabajamos con una visión de largo plazo, fomentando la participación ciudadana y coordinando los instrumentos de planeación que permiten ordenar el territorio, impulsar el desarrollo urbano sustentable y fortalecer la gestión pública. EI IMPLAN integra información estadística y geográfica, diseña metodologias, promueve convenios y establece políticas públicas que aseguren un crecimiento equilibrado, sostenible y participativo para Valle de Santiago.</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <h3 class="mb-3">Misión</h3>
                            <div class="d-flex align-items-center" style="gap: 12px">
                                <img style="height: 80px" src="{{ asset('images/implan/target-1.png') }}" alt="mision">
                                <p class="mb-0">Auxiliar al Ayuntamiento en la planeación integral del municipio, asegurando procesos participativos y técnicos que fortalezcan el desarrollo urbano, social, económico У ambiental de Valle de Santiago. Nuestra misión es coordinar, diseñar y dar seguimiento a los instrumentos de planeación, generando información confiable y promoviendo la corresponsabilidad entre gobierno y sociedad para construir un municipio ordenado, sustentable y resiliente.</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h3 class="mb-3">Visión</h3>
                            <div class="d-flex align-items-center" style="gap: 12px">
                                <img style="height: 80px" src="{{ asset('images/implan/vision-1.png') }}" alt="vision">
                                <p class="mb-0">Ser un instituto técnica, líder  en planeación estratégica municipal, reconocido por su innovación y compromiso con el desarrollo sustentable y ordenado de Valle de Santiago. Aspiramos a consolidanos como un referente en Guanajuato y en México en inversiones materia de planeación se realicen integral, garantizando que las políticas públicas, proyectos e con visión de futuro, justicia social, equilibrio ambiental y participación ciudadana efectiva.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="card">
                <div class="card-body">
                    <h3>Organigrama</h3>

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="text-danger">Escanea nuestro QR y <br> conoce nuestro organigrama</h3>
                        </div>
                        <div class="col-md-6">
                             <img src="{{ asset('images/implan/org_implan_qr.png') }}" alt="" width="100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection
