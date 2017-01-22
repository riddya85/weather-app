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
        <header class="header">
            <div class="headline">
                <a href="{{ route('front.home') }}">Weather Forecast</a>
            </div>
            <div class="user-options">
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
            <span class='open-menu'>
                <div class='burger'>
                    <span class="first"></span>
                    <span class="second"></span>
                    <span class="third"></span>
                </div>
                <div class="cross">
                    <span class="cross_1"></span>
                    <span class="cross_2"></span>
                </div>
            </span>
        </header>
        <ul class="menu-mobile" id="menu">
            @if(Auth::check())
                <li class="menu-mobile__item"><a href="{{ route('front.userHistory') }}">History</a></li>
                <li class="menu-mobile__item"><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="margin-left: 10px;">Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @else
                <li class="menu-mobile__item"><a href="{{ route('login') }}">Sign In</a></li>
                <li class="menu-mobile__item"><a href="{{ route('register') }}" style="margin-left: 10px;">Sign Up</a></li>
            @endif
        </ul>
        <main>
            @yield('content')
        </main>
        <script>
            app.main.init();
        </script>
    </body>
</html>
