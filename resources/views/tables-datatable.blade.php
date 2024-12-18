@extends('layouts.master')
@section('title')Metrica @endsection
@section('css')
<link href="{{URL::asset('assets/plugins/tabulator/bootstrap/tabulator_bootstrap4.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Metrica @endslot
@slot('li_2') Tables @endslot
@slot('title') Datatables @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pagination </h4>
                <p class="text-muted mb-0">Tabulator allows you to paginate your data. simply set the pagination property to true.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="table-responsive">
                    <div id="datatable-1"></div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Responsive Layout Collapsed List</h4>
                <p class="text-muted mb-0">By setting the responsiveLayout option to "collapse",
                    the table will automatically collapse columns that
                    don't fit on the table into a list of column titles and values.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="table-responsive">
                    <div id="datatable-2"></div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Menus and Download Table Data</h4>
                <p class="text-muted mb-0">
                    Tabulator provides several different options for adding menues to your table and
                    tabulator allows you to download the table data as a file directly from your browser, no server needed.
                </p>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="table-responsive">
                    <div class="mb-2">
                        <button class="btn btn-outline-primary btn-sm mb-1 mb-xl-0" id="download-csv">Download CSV</button>
                        <button class="btn btn-outline-primary btn-sm mb-1 mb-xl-0" id="download-json">Download JSON</button>
                        <button class="btn btn-outline-primary btn-sm mb-1 mb-xl-0" id="download-xlsx">Download XLSX</button>
                        <button class="btn btn-outline-primary btn-sm mb-1 mb-xl-0" id="download-pdf">Download PDF</button>
                        <button class="btn btn-outline-primary btn-sm mb-1 mb-xl-0" id="download-html">Download HTML</button>
                    </div>
                    <div id="datatable-3"></div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<script src="{{URL::asset('assets/plugins/tabulator/tabulator.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/tabulator/jspdf.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/tabulator/xlsx.full.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/tabulator/jspdf.plugin.autotable.js')}}"></script>
<script src="{{URL::asset('assets/pages/datatable.init.js')}}"></script>
@endsection
