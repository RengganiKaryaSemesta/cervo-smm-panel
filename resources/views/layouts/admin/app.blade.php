<!DOCTYPE html>
<html lang="en" data-menu-color="light" data-topbar-color="light">
<head>
    <meta charset="utf-8">
    <title>
        @isset($title)
            {{ $title }}
        @else
            Arawinds CSR System
        @endisset
    </title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Renggani Karya Semesta" name="description">
    @laravelPWA
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('logo-blue.png') }}">
    <link href="{{ asset('vendor/') }}/assets/css/app.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('vendor/') }}/assets/js/config.js"></script>
    <link href="{{ asset('vendor/') }}/assets/libs/selectize/css/selectize.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    @stack('styles')
    @vite('resources/js/app.js')
</head>

<body>

    <!-- Begin page -->
    <div class="flex wrapper">
        @include('layouts.admin.sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">
            @include('layouts.admin.navbar')
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <script data-navigate-once src="{{ asset('vendor/') }}/assets/libs/jquery/jquery.min.js"></script>
    <script data-navigate-once src="{{ asset('vendor/') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script data-navigate-once src="{{ asset('vendor/') }}/assets/libs/lucide/umd/lucide.min.js"></script>
    <script src="{{ asset('vendor/') }}/assets/libs/@frostui/tailwindcss/frostui.js"></script>
    <script data-navigate-once src="{{ asset('vendor/') }}/assets/js/app.js"></script>
    <script data-navigate-once src="{{ asset('vendor/') }}/assets/libs/selectize/js/standalone/selectize.min.js"></script>
    <script data-navigate-once src="{{ asset('vendor/') }}/assets/libs/chart.js/chart.min.js"></script>
    <script data-navigate-once src="{{ asset('vendor') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script data-navigate-once src="{{ asset('vendor') }}/assets/js/pages/extended-sweetalert.init.js"></script>
</body>

</html>
