<!doctype html>
<html>

<head>
    <meta charset="utf-8">

    <title> @yield('title')| - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    @include('layouts.head-css')
</head>

<body id="body" onload="body()" class="">
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
                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('layouts.footer')

        <a href="javascript:void(0)" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    </div>
    <!-- END wrapper -->

    <!-- right sidebar file here  -->
    @include('layouts.right-sidebar')
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

    @include('layouts.vendor-scripts')
</body>

</html>
