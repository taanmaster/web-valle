@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Documentos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('transparency_documents.update', $transparency_document->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
