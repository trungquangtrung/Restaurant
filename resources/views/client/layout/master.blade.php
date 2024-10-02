<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

    <!-- title -->
    <title>Restaurant</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('client_asset/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/font-awesome.min.css') }}" type="text/css">

</head>

<body>
 
    @include('client.blocks.header')

    @include('client.blocks.hero')
    @yield('content')

    @include('client.blocks.footer')

    <script src="{{ asset('client_asset/js/jquery-1.11.3.min.js') }}"></script>

    <script src="{{ asset('client_asset/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.countdown.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.isotope-3.0.6.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/waypoints.js') }}"></script>
    <script src="{{ asset('client_asset/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/sticker.js') }}"></script>
    <script src="{{ asset('client_asset/js/main.js') }}"></script>

    @yield('my-js')
</body>

</html>
