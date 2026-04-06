<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('metaTitle')</title>
    <meta name="description" content="@yield('metaDescription')">
    <meta name="keywords" content="@yield('metaKeywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/admin_mobile.css') }}" media="screen and (max-width: 767px)">
</head>
<body>
{{--    @include('admin.layouts.header')--}}
    <div class="row">
        <div class="col-md-auto">
            @include('admin.layouts.leftMenu')
        </div>
        <div class="col">
            @yield('content')
        </div>
    </div>
</body>
</html>

@include('admin.layouts.modalView')
