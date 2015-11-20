<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laravel Basic Project Management</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    {!! HTML::style('css/app.css') !!}
    {!! HTML::script('js/bootstrap.min.js') !!}
</head>

<body>
<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name  }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="divider"></li>
                            <li>{!! HTML::link('auth/logout', 'Logout') !!}</li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>


<main class="container-fluid">
    @yield('content')
</main>

</body>
</html>