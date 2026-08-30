<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8">

    <title>Truck Dispatch</title>



    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/animation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/styles.css')}}">



    <!-- Font -->
    <link rel="stylesheet" href="font/fonts.css">

    <!-- Icon -->
    <link rel="stylesheet" href="icon/style.css">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="https://www.ambedkariti.com/assets/img/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="https://www.ambedkariti.com/assets/img/favicon.png">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>

    <!-- #wrapper -->
    <div id="wrapper">
        <!-- #page -->
        <div id="page" class="">
            <!-- layout-wrap -->
            <div class="layout-wrap">

                @include('components.top-header')
                @include('components.sidebar')
                @yield('content')
                @include('components.copyright')
            </div>
        </div>
    </div>




    <script src="{{ url ('js/default-theme.js')}}"></script>
    <script src="{{ url ('js/jquery.min.js')}}"></script>
    <script src="{{ url ('js/bootstrap.min.js')}}"></script>
    <script src="{{ url ('js/bootstrap-select.min.js')}}"></script>
    <script src="{{ url ('js/zoom.js')}}"></script>
    <script src="{{ url ('js/morris.min.js')}}"></script>
    <script src="{{ url ('js/raphael.min.js')}}"></script>
    <script src="{{ url ('js/morris.js')}}"></script>
    <script src="{{ url ('js/jvectormap.min.js')}}"></script>
    <script src="{{ url ('js/jvectormap-us-lcc.js')}}"></script>
    <script src="{{ url ('js/jvectormap-data.js')}}"></script>
    <script src="{{ url ('js/jvectormap.js')}}"></script>
    <script src="{{ url ('js/apexcharts/apexcharts.js')}}"></script>
    <script src="{{ url ('js/apexcharts/line-chart-1.js')}}"></script>
    <script src="{{ url ('js/apexcharts/line-chart-2.js')}}"></script>
    <script src="{{ url ('js/apexcharts/line-chart-3.js')}}"></script>
    <script src="{{ url ('js/apexcharts/line-chart-4.js')}}"></script>
    <script src="{{ url ('js/apexcharts/line-chart-7.js')}}"></script>
    <script src="{{ url ('js/switcher.js')}}"></script>
    <script defer src="{{ url ('js/theme-settings.js')}}"></script>
    <script src="{{ url ('js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')

</body>


</html>
