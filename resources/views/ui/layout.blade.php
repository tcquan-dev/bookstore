<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BookStore</title>
    @include('ui.styles')
</head>

<body>
    @include('ui.main_header')
    <div class="container">
        @yield('content')
    </div>
    @include('ui.main_footer')
    @include('ui.scripts')
</body>

</html>
