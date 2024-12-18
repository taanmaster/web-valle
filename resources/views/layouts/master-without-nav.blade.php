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
@yield('body')

<!-- Start content -->
@yield('content')
<!-- content -->

@include('layouts.vendor-scripts')

</body>

</html>
