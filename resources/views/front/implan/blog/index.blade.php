@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.implan.utilities.nav')

        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Planos temáticos</h2>
            </div>
            <div class="col-md-6">
                <h2>Capas</h2>
            </div>
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection
