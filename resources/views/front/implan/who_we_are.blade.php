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
                <p>Participa, consulta y conoce los proyecto que transforman nuestra ciudad.</p>
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
                                <p class="mb-0">Participa, consulta y conoce los proyectos <br> que transforman nuestra
                                    ciudad</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h3 class="mb-3">Visión</h3>
                            <div class="d-flex align-items-center" style="gap: 12px">
                                <img style="height: 80px" src="{{ asset('images/implan/vision-1.png') }}" alt="vision">
                                <p class="mb-0">Participa, consulta y conoce los proyectos <br> que transforman nuestra
                                    ciudad</p>
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

                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-body text-center" style="background: #3CADFF; color:white;">
                                <h3>CUERPO TÉCNICO DEL IMPLAN</h3>
                                <h5>Organigrama</h5>
                                <br>
                                <p>Municipio de Valle de Santiago, Gto. 2024</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-body text-center" style="background:black; color:white">
                                <h4 class="mb-0">Director General</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="card card-body text-center" style="background: #757575; color:white">
                                <h4 class="mb-0">Coordinación de planeación estratégica y gestión</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-body text-center" style="background: #4BB027; color:white">
                                <h4 class="mb-0">Coordinación Administrativa</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <div class="card card-body p-2" style="background: #65D675; color:white">
                                <p class="mb-0">Jefatura de participación ciudadana y
                                    comunicación social</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card card-body p-2" style="background: #65D675; color:white">
                                <p class="mb-0">Jefatura de información estadística y
                                    geográfica</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card card-body p-2" style="background: #65D675; color:white">
                                <p class="mb-0">Jefatura de desarollo urbano y
                                    ordenamiento ecológico territorial</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card card-body p-2" style="background: #65D675; color:white">
                                <p class="mb-0">Jefatura Jurídica</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection
