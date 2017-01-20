<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Weather</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/front/css/app.css" rel="stylesheet" type="text/css">
        <script src="/front/js/app.js"></script>
    </head>
    <body>
        <header>
            <div class="headline">
                <a href="{{ route('front.home') }}">Weather Forecast</a>
            </div>
            <div class="auth-button" style="">
                Login
            </div>
        </header>
        {{--<div class="flex-center position-ref full-height">--}}
            {{--@if (Route::has('login'))--}}
                {{--<div class="top-right links">--}}
                    {{--@if (Auth::check())--}}
                        {{--<a href="{{ url('/home') }}">Home</a>--}}
                    {{--@else--}}
                        {{--<a href="{{ url('/login') }}">Login</a>--}}
                        {{--<a href="{{ url('/register') }}">Register</a>--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--@endif--}}

            {{--<div class="content">--}}
                {{--@yield('content')--}}
            {{--</div>--}}
        {{--</div>--}}
        <main>
            @yield('content')
        </main>
    </body>
</html>
