<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title') - Icil Icafal PZS S.A.
    </title>
    {{ HTML::style('//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/yeti/bootstrap.min.css') }}
    {{ HTML::style('css/alertify.core.css') }}
    {{ HTML::style('css/alertify.default.css') }}
    {{ HTML::style('css/landing.min.css') }}

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
                @if (Sentry::getUser()->hasAccess(['reporte']))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Reportes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/r/param') }}">Consultar Trabajos</a></li>
                            @if (Sentry::getUser()->hasAccess(['reporte-avanzado']))
                                {{--<li class="divider"></li>--}}
                                {{--<li class="dropdown-header">Para descargar</li>--}}
                                {{--<li><a href="#">Formulario 2 - 3 - 4</a></li>--}}
                            @endif
                        </ul>
                    </li>
                @endif
                    @if (Sentry::getUser()->hasAccess(['mantencion']))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Reportes <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ URL::to('/m/param') }}">Vías</a></li>
                                <li><a href="{{ URL::to('/m/param') }}">Trabajos</a></li>
                                <li><a href="{{ URL::to('/m/param') }}">Materiales</a></li>
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

@if(Sentry::check())
    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright © 2014 Icil Icafal Proyecto Zona Sur S.A. Todos los Derechos Reservados.</p>
            {{-- <p class="text-muted">Copyright © 2014 Icil Icafal Proyecto Zona Sur S.A. Todos los Derechos Reservados.
                Contacto a <a href="mailto:earosb@icafal.cl" target="_top">earosb@icafal.cl</a></p> --}}
        </div>
    </footer>
@endif

</body>
</html>