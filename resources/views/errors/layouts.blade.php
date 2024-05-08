<!doctype html>
<html lang="en">

<head>
    <title>@yield('title')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Styles -->
    <style>
        body {
            margin: 0;
            line-height: 1.15;
            font-family: Nunito, sans-serif;
        }

        .title {
            font-size: 8.5rem;
        }

        .purple-divider {
            border-top: 0.25rem solid #a779e9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-4">
                <div class="title">
                    @yield('code')
                </div>
                <div class="purple-divider w-25"></div>
                <p class="text-secondary display-6 my-3">
                    @yield('message')
                </p>
                <a href="{{ app('router')->has('home') ? route('home') : url('/') }}">
                    <button class="btn btn-primary text-light fw-bold text-uppercase py-3 px-4 rounded">
                        {{ __('Go Home') }}
                    </button>
                </a>
            </div>
            <div class="col-8">
                @yield('image')
            </div>
        </div>
    </div>
</body>

</html>