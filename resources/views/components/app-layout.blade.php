<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://kit.fontawesome.com/767ff093f8.js" crossorigin="anonymous"></script>
    {{-- <link rel="icon" type="image/png/x-icon" href=""> --}}
    <title>PETSOP @isset($title)
            - {{ $title }}
        @endisset</title>
    
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('template')}}/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{asset('template')}}/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('template')}}/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="{{asset('template')}}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{asset('template')}}/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="{{asset('template')}}/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('template')}}/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('template')}}/assets/images/favicon.png" />

</head>

<body>

    <div class="container-scroller">
        @include('layouts/sidebar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts/navbar')
            {{ $slot }}
            @include('layouts/footer')
        </div>
    </div>

    <script src="{{asset('template')}}/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('template')}}/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="{{asset('template')}}/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="{{asset('template')}}/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="{{asset('template')}}/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="{{asset('template')}}/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('template')}}/assets/js/off-canvas.js"></script>
    <script src="{{asset('template')}}/assets/js/hoverable-collapse.js"></script>
    <script src="{{asset('template')}}/assets/js/misc.js"></script>
    <script src="{{asset('template')}}/assets/js/settings.js"></script>
    <script src="{{asset('template')}}/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{asset('template')}}/assets/js/dashboard.js"></script>
    <script>
    </script>
</body>

</html>
