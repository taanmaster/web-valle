@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('../jquery-plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Charts @endslot
@slot('title') Morris Charts @endslot
@endcomponent

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Bar Chart</h4>
                <p class="text-muted mb-0">Create bar charts using
                    Morris.Bar(options), where options is an object containing the
                    configuration options.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="morris-bar-example" class="drop-shadow" style="height: 300px"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Donut Chart</h4>
                <p class="text-muted mb-0">This really couldn't be easier. Create
                    a Donut chart using Morris.Donut(options).
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="morris-donut-example" class="drop-shadow" style="height: 300px"></div>
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
                <h4 class="card-title">Area Chart</h4>
                <p class="text-muted mb-0">Create an area chart using
                    Morris.Area(options). Area charts take all the same options as line
                    charts.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="morris-area-example" class="drop-shadow" style="height: 300px"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Line Chart</h4>
                <p class="text-muted mb-0">The public API is terribly simple. It's
                    just one function: Morris.Line (options), where options is an object
                    containing some of the configuration options.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div id="morris-line-example" class="drop-shadow" style="height: 300px"></div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div> <!-- end col -->
</div> <!-- end row -->

<!--  Modal content for the above example -->
<div class="modal modal-rightbar fade" id="MetricaRightbar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalLabel">Appearance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Account Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch1">
                        <label class="form-check-label" for="settings-switch1">Auto updates</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch2" checked>
                        <label class="form-check-label" for="settings-switch2">Location Permission</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch3">
                        <label class="form-check-label" for="settings-switch3">Show offline Contacts</label>
                    </div>
                </div>
                <h6>General Settings</h6>
                <div class="p-2 text-start mt-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch4">
                        <label class="form-check-label" for="settings-switch4">Show me Online</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="settings-switch5" checked>
                        <label class="form-check-label" for="settings-switch5">Status visible to all</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="settings-switch6">
                        <label class="form-check-label" for="settings-switch6">Notifications Popup</label>
                    </div>
                </div>
            </div>
            <!--end modal-body-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
@section('script')
<script src="{{URL::asset('../jquery-plugins/morris/morris.min.js')}}"></script>
<script src="{{URL::asset('../jquery-plugins/morris/raphael-min.js')}}"></script>
<script src="{{URL::asset('assets/pages/jquery.morris.init.js')}}"></script>
<script>
    feather.replace();

    new MetisMenu('.metismenu-plugin');
    new MetisMenu('.metismenu-plugin2');


    function body() {
        const body = document.getElementById("body");
        window.addEventListener("resize", function() {
            if (window.innerWidth > 1200) {
                body.classList.remove("enlarge-menu");
            } else {
                body.classList.add("enlarge-menu");
            }
        });
    }
    document.onreadystatechange = function() {
        if (document.readyState === 'complete') {
            const body = document.getElementById("body");
            if (window.innerWidth > 1200) {
                body.classList.remove("enlarge-menu");
            } else {
                body.classList.add("enlarge-menu");
            }
        }
    }

    // Menu sticky
    function windowScroll() {
        const navbar = document.getElementById("navbar-custom");
        if (
            document.body.scrollTop >= 50 ||
            document.documentElement.scrollTop >= 50
        ) {
            navbar.classList.add("nav-sticky");
        } else {
            navbar.classList.remove("nav-sticky");
        }
    }
    window.addEventListener('scroll', (ev) => {
        ev.preventDefault();
        windowScroll();
    })

</script>
@endsection
