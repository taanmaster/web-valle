<!doctype html>
<html>

<head>
    <meta charset="utf-8">

    <title>Valle de Santiago | - Intranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Valle de Santiago Intranet" name="description" />
    <meta content="Valle" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    @livewireStyles

    @include('layouts.head-css')
</head>

<body id="body" class="">
    @include('layouts.left-sidebar-tab')
    @include('layouts.topbar')

    <!-- Begin page -->
    <div class="page-wrapper">

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->

        <div class="page-content-tab">
            <!-- Start content -->
            <div class="container-fluid">
                @include('layouts.utilities._messages')
                @yield('content')

            </div> <!-- content -->
        </div>
        @include('layouts.footer')

        <a href="javascript:void(0)" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

    </div>
    <!-- END wrapper -->

    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

    @livewireScripts
    @include('layouts.vendor-scripts')
</body>

</html>
