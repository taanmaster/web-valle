@extends('layouts.master')
@section('title')Metrica @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') UI Kit @endslot
@slot('title') Popover & Tooltips @endslot
@endcomponent

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Popovers Example</h4>
                <p class="text-muted mb-0">Add small overlay content, like those found in iOS, to any element for housing secondary information.</p>
            </div>
            <!--end card-header-->
            <div class="card-body button-items">
                <button type="button" class="btn btn-de-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                    Popover on top
                </button>

                <button type="button" class="btn btn-de-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                    Popover on right
                </button>

                <button type="button" class="btn btn-de-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                    Popover on bottom
                </button>

                <button type="button" class="btn btn-de-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                    Popover on left
                </button>

                <a tabindex="0" class="btn btn-de-danger" role="button" data-bs-toggle="popover" data-bs-trigger="focus" title="Dismissible popover" data-bs-content="And here's some amazing content. It's very engaging. Right?">Dismissible popover</a>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Bootstrap Tooltips</h4>
                <p class="text-muted mb-0">Hover over the links below to see tooltips:</p>
            </div>
            <!--end card-header-->
            <div class="card-body button-items">
                <button type="button" class="btn btn-de-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                    Tooltip on top
                </button>
                <button type="button" class="btn btn-de-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Tooltip on right">
                    Tooltip on right
                </button>
                <button type="button" class="btn btn-de-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom">
                    Tooltip on bottom
                </button>
                <button type="button" class="btn btn-de-primary" data-bs-toggle="tooltip" data-bs-placement="left" title="Tooltip on left">
                    Tooltip on left
                </button>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

</script>
@endsection
