<!doctype html>
<html lang="vie">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.0.10/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('style-lib')
    @yield('styles')
</head>
<body>
<div id="main_wrapper">
    @include('partials.navigation')


    <div style="margin-left: 450px; height: 100vh">
        @yield('content')
    </div>
</div>

<script src="https://unpkg.com/flowbite@1.4.2/dist/flowbite.js"></script>
@yield('scripts')

</body>
</html>
