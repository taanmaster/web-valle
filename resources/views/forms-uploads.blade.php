@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('assets/plugins/uppy/uppy.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Forms @endslot
@slot('title') Uploads @endslot
@endcomponent

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Custom File Upload</h4>
                <p class="text-muted mb-0">Your so fresh input file — Default version</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="d-grid">
                    <p class="text-muted">Upload your blog image here, Please click "Upload Image" Button.</p>
                    <div class="preview-box d-block justify-content-center rounded shadow overflow-hidden bg-light p-1"></div>
                    <input type="file" id="input-file" name="input-file" accept="image/*" onchange={handleChange()} hidden />
                    <label class="btn-upload btn btn-primary mt-4" for="input-file">Upload Image</label>
                </div>

            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Uppy File Upload</h4>
                <p class="text-muted mb-0">You can add a default value</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="drag-drop-area"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="d-none" id="tpl">
    <div class="card mt-1 mb-0 shadow-none border dropzone-previews">
        <div class="p-2">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                </div>
                <div class="col pl-0">
                    <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                    <p class="mb-0" data-dz-size></p>
                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>

                </div>
                <div class="col-auto">
                    <!-- Button -->
                    <a class="btn btn-link btn-lg text-muted" data-dz-remove>
                        <i class="dripicons-cross"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{URL::asset('assets/plugins/uppy/uppy.min.js')}}"></script>
<script src="{{URL::asset('assets/pages/file-upload.init.js')}}"></script>
@endsection
