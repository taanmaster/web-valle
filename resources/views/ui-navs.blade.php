@extends('layouts.master')
@section('title')Metrica @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') UI Kit @endslot
@slot('title') Navs @endslot
@endcomponent

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Base Nav</h4>
                <p class="text-muted mb-0">Navigation available in Bootstrap share general markup and styles, from the base <code>.nav</code> class to the active and disabled states.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nav Tabs</h4>
                <p class="text-muted mb-0">Takes the basic nav from above and adds the <code class="highlighter-rouge">.nav-tabs</code> class to generate a tabbed interface.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nav Justified</h4>
                <p class="text-muted mb-0">For equal-width elements, use <code class="highlighter-rouge">.nav-justified</code>.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <nav class="nav nav-pills nav-justified">
                    <a class="nav-item nav-link active" href="#">Active</a>
                    <a class="nav-item nav-link" href="#">Much longer nav link</a>
                    <a class="nav-item nav-link" href="#">Link</a>
                    <a class="nav-item nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </nav>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nav Pills</h4>
                <p class="text-muted mb-0">Takes the basic nav from above and adds the <code class="highlighter-rouge">.nav-pills</code> class to generate a tabbed interface.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nav Tabs With Dropdowns</h4>
                <p class="text-muted mb-0">Add dropdown menus with a little extra HTML and the dropdowns JavaScript plugin.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            Dropdown
                            <i class="mdi mdi-chevron-down"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nav Pills With Dropdowns</h4>
                <p class="text-muted mb-0">Add dropdown menus with a little extra HTML and the dropdowns JavaScript plugin.</p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            Dropdown
                            <i class="mdi mdi-chevron-down"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection