@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.implan.utilities.nav')

        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <img src="" alt="">
            </div>

            <div class="col-md-6">
                <h1>¿Qué es el IMPLAN?</h1>
                <p>Participa, consulta y conoce los proyecto que transforman nuestra ciudad.</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Misión</h3>
                        </div>
                        <div class="col-md-6">
                            <h3>Visión</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="card">
                <div class="card-body">
                    <h3>Organigrama</h3>
                </div>
            </div>
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection
