<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Weather</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/front/css/app.css" rel="stylesheet" type="text/css">
        <script src="/front/js/app.js"></script>
        <script>
            window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        @yield('javascript')
    </head>
    <body>
        <header>
            <div class="headline">
                <a href="{{ route('front.home') }}">Weather Forecast</a>
            </div>
            <div class="auth-button" style="">
                @if(Auth::check())
                    <a href="{{ route('front.userHistory') }}">History</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="margin-left: 10px;">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @else
                    <a href="{{ route('login') }}">Sign In</a>
                    <a href="{{ route('register') }}" style="margin-left: 10px;">Sign Up</a>
                @endif
            </div>
        </header>
        <main>
            @yield('content')
        </main>
    </body>
</html>
