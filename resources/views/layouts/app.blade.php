<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://kit.fontawesome.com/767ff093f8.js" crossorigin="anonymous"></script>
    <title>UROKO @isset($title)
            - {{ $title }}
        @endisset</title>


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
    {{-- <script src="//code.jquery.com/jquery.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->

    <link rel="stylesheet" href="{{ asset('template') }}/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('template') }}/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('logo') }}/favicon.png" />

    <link rel='stylesheet' href='{{ asset('lightbox/css/lc_lightbox.min.css') }}' />
    <link rel='stylesheet' href='{{ asset('lightbox/skins/minimal.css') }}' />

</head>

<body>

    <div class="container-scroller">
        @include('layouts/sidebar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts/navbar')
            <div class="main-panel">

                {{ $slot }}
                @include('layouts/footer')
            </div>
        </div>
    </div>

    <script src="{{ asset('template') }}/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('template') }}/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('template') }}/assets/js/off-canvas.js"></script>
    <script src="{{ asset('template') }}/assets/js/hoverable-collapse.js"></script>
    <script src="{{ asset('template') }}/assets/js/misc.js"></script>
    <script src="{{ asset('template') }}/assets/js/settings.js"></script>
    <script src="{{ asset('template') }}/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('template') }}/assets/js/dashboard.js"></script>

    <script src="{{ asset('template') }}/assets/vendors/select2/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script src='{{ asset('lightbox/js/lc_lightbox.lite.min.js') }}' type='text/javascript'></script>
    <script src='{{ asset('lightbox/lib/AlloyFinger/alloy_finger.min.js') }}' type='text/javascript'></script>

    <script>
        lc_lightbox('.mybox', {
            wrap_class: 'lcl_fade_oc',
            gallery: true,
            thumb_attr: 'data-lcl-thumb',
            skin: 'dark',
            // more options here
        });
    </script>
</body>

</html>
