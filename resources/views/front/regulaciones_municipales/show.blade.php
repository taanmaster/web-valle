@extends('front.layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-body">
                    <h1>REGULACIÓN MUNICIPAL</h1>

                    <h2>{{ $regulation->title }}</h2>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-body">
                    <div class="d-flex">
                        <div class="col-md-4">
                            <h4>Publicación periodico oficial</h4>
                            <p>{{ $regulation->publication_date }}</p>
                        </div>
                        <div class="col-md-4">
                            <h4>Tipo de regulación</h4>
                            <p>{{ $regulation->regulation_type }}</p>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                Tipo de publicación
                            </h4>
                            <p>{{ $regulation->publication_type }}</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        @if ($regulation->ficha)
                            <a href="{{ asset('regulations/' . $regulation->file) }}" target="_blank"
                                class="btn btn-sm btn-secondary" style="max-width: 120px">Ver Ficha</a>
                        @else
                            Sin Ficha
                        @endif

                        @if ($regulation->pdf_file)
                            <a href="{{ asset('regulations/' . $regulation->pdf_file) }}" target="_blank"
                                class="btn btn-sm btn-secondary" style="max-width: 120px">Ver PDF</a>
                        @else
                            Sin PDF
                        @endif

                        @if ($regulation->word_file)
                            <a href="{{ asset('regulations/' . $regulation->word_file) }}" target="_blank"
                                class="btn btn-sm btn-secondary" style="max-width: 120px">Ver Word</a>
                        @else
                            Sin Word
                        @endif
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection
