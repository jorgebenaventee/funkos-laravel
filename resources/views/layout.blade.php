<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
    @vite('resources/css/app.css')
</head>
<body>
@include('header')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-[500px] m-auto p-4">
        @include('flash::message')
    </div>
    @yield('content')
</div>
@include('footer')
</body>
</html>
