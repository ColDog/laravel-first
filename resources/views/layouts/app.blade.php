<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laravel Basic Project Management</title>
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
                <li><a href="/">One</a></li>
                <li><a href="/">One</a></li>
                <li><a href="/">One</a></li>
                <li><a href="/">One</a></li>
            </ul>
        </div>
    </div>
</nav>


<main class="container-fluid">
    @yield('content')
</main>

</body>
</html>