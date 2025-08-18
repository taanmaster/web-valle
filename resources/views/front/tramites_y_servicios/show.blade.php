@extends('front.layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-body">
                    <h1>TRÁMITES Y SERVICIOS</h1>

                    <h2>{{ $request->name }}</h2>
                    <h5>{{ $request->dependency_name }}</h5>


                    <div class="my-4">
                        <h4>Descripción</h4>
                        <p>{{ $request->description }}</p>
                    </div>

                    <div class="my-4">
                        <h4>Requisitos</h4>
                        <p>{{ $request->requirements }}</p>
                    </div>

                    <div class="my-4">
                        <h4>Costo</h4>
                        <p>$ {{ $request->cost }}</p>
                    </div>

                    <div class="d-flex align-items-center">
                        @if ($regulation->steps_filename)
                            <a href="{{ asset('requests/' . $regulation->steps_filename) }}" target="_blank"
                                class="btn btn-sm btn-secondary" style="max-width: 120px">Pasos para realizar el trámite en
                                línea</a>
                        @else
                            Sin Documento
                        @endif

                        @if ($regulation->procedure_filename)
                            <a href="{{ asset('requests/' . $regulation->procedure_filename) }}" target="_blank"
                                class="btn btn-sm btn-secondary" style="max-width: 120px">Descargar Ficha del trámite</a>
                        @else
                            Sin Ficha del trámite
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
