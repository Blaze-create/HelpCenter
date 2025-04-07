<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
    <script src="https://kit.fontawesome.com/e785ddfc20.js" crossorigin="anonymous"></script>
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
</head>

<body>
    @yield('content')
</body>
</html>
