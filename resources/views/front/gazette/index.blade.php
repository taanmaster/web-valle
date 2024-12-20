@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-body">
                <h2>Gaceta Municipal</h2>

                @foreach($gazettes as $gazette)
                <a href="{{ route('gazette.detail', $gazette->slug) }}">{{ $gazette->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection