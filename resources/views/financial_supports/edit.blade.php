@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Documentos @endslot
@slot('title') Apoyos Económicos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('financial_supports.update', $financial_support->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
    
                    </form>
                </div>
                
            </div>

        </div>
    </div>
</div>
@endsection
