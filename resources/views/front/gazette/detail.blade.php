@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-body">
                <h2>{{ $gazette->name }}</h2>
                <hr>

                @foreach($gazette->files as $file)
                <p>Archivo #{{ $file->id }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection