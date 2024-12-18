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

<body data-layout="horizontal">

    <!-- Begin page -->
    <div class="layout-wrapper">
        @include('layouts.horizontal-nav')

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->

        <div class="main-content">
            <div class="page-content">
                <!-- Start content -->
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- content -->
            </div>

            @include('layouts.footer')
        </div>
        <!-- End main content here  -->
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
