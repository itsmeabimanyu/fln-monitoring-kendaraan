<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link
    rel="shortcut icon"
    type="image/png"
    href="{{ asset('assets/images/logos/favicon.png') }}"
    />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <title>Monitoring Kendaraan</title>
    <!-- jvectormap  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    {{-- <script src="{{ asset('assets/js/htmx.min.js') }}"></script> --}}
    <!-- Load Pusher dan Echo dari CDN -->
    <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
    <script src="{{ asset('assets/js/echo.iife.min.js') }}"></script>
</head>