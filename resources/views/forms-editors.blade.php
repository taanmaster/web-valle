@extends('layouts.master')
@section('title')Metrica @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Forms @endslot
@slot('title') Editor @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">TinyMCE Editor</h4>
                <p class="text-muted mb-0">Bootstrap-wysihtml5 is a javascript
                    plugin that makes it easy to create simple, beautiful wysiwyg editors
                    with the help of wysihtml5 and Twitter Bootstrap.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <form method="post">
                    <textarea id="basic-conf">Hello, World!</textarea>
                </form>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<script src="{{URL::asset('assets/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{URL::asset('assets/pages/form-editor.init.js')}}"></script>
@endsection
