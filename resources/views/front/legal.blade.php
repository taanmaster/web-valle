@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-normal">
                <div>
                    <h1 class="mb-0">{!! $text->title ?? 'Texto Legal Informativo' !!}</h1>
                    <p><small>Última actualización: {{ $text->updated_at }}</small></p>
                </div>
                
                {!! $text->description !!}
            </div>
        </div>
    </div>
</div>
@endsection