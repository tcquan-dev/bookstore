<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ backpack_theme_config('html_direction') }}">

<head>
    <link rel="stylesheet" href="{{ url('css/form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    @include(backpack_view('inc.head'))
</head>

<body class="app flex-row align-items-center">

    @yield('header')

    <div class="container">
        @yield('content')
    </div>

    @include('ui.scripts')
</body>

</html>
