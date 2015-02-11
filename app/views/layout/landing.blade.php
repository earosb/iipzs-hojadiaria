<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title')
    </title>
    {{ HTML::style('//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/yeti/bootstrap.min.css') }}
    {{ HTML::style('css/alertify.core.css') }}
    {{ HTML::style('css/alertify.default.css') }}
    {{-- yield para agregar css en cada página --}}
    @yield('css')
</head>
<body>
{{-- Navbar
===================================================== --}}
<div class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ URL::to('/') }}">Icafal App</a>
    </div>
    @if(Sentry::check())
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                @if (Sentry::getUser()->hasAccess(['hoja-diaria']))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hoja Diaria <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/hd/create') }}">Ingresar Hoja Diaria</a></li>
                            <li><a href="{{ URL::to('/hd') }}">Histórico</a></li>
                        </ul>
                    </li>
                @endif
                @if (Sentry::getUser()->hasAccess(['consultas']))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultas <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Consultar Trabajos</a></li>
                            @if (Sentry::getUser()->hasAccess(['consultas-avanzadas']))
                                <li><a href="#">Consultas Avanzadas</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Sentry::getUser()->hasAccess(['reportes']))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Formulario 2 - 3 - 4</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Dropdown header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Sentry::getUser()->first_name }} <b
                                class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Modificar datos</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('logout') }}">Salir</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    @endif
</div>
{{-- Container
===================================================== --}}
<div class="container-fluid">
    <div id="msg_success" class="alert alert-dismissable alert-success" style="display:none;">
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
    <div id="msg_error" class="alert alert-dismissable alert-danger" style="display:none;">
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
    @yield('content')
</div>
{{-- Footer
===================================================== --}}
<div class="footer">
    @yield('footer')
</div>
{{-- Archivos js --}}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js') }}
{{ HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js') }}
{{ HTML::script('js/alertify.min.js') }}

{{-- yield para agregar scripts en cada página --}}
@yield('js')

{{-- Modals --}}
@yield('modals')
</body>
</html>