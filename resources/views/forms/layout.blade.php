<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ backpack_theme_config('html_direction') }}">

<head>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
  @include(backpack_view('inc.head'))
</head>

<body class="app flex-row align-items-center">

  @yield('header')

  <div class="container">
    @yield('content')
  </div>

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))
  @include(backpack_view('inc.theme_scripts'))

  @yield('after_scripts')
  @stack('after_scripts')

</body>

</html>