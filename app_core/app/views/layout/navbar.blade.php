<div class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ URL::to('/') }}">Icil-Icafal-PZS</a>
    </div>
    @if(Sentry::check())
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                @if (Sentry::getUser()->hasAccess(['hoja-diaria']))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="glyphicon glyphicon-file"></i><span> Hoja Diaria<b class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/hd/create') }}">Ingresar Hoja Diaria</a></li>
                            <li><a href="{{ URL::to('/hd') }}">Histórico</a></li>
                        </ul>
                    </li>
                @endif
                @if (Sentry::getUser()->hasAccess(['reporte']))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="glyphicon glyphicon-list-alt"></i><span> Reportes <b
                                        class="caret"></b></span></a>
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="glyphicon glyphicon-wrench"></i><span> Mantención <b
                                        class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/m/sector') }}">Vías</a></li>
                            <li><a href="{{ URL::to('/m/trabajo') }}">Trabajos</a></li>
                            <li><a href="{{ URL::to('/m/material') }}">Materiales</a></li>
                            <li><a href="{{ URL::to('/m/grupo-trabajo') }}">Grupos Trabajo</a></li>
                            @if(Sentry::getUser()->hasAccess(['create-user']))
                                <li class="divider"></li>
                                <li><a href="{{ URL::to('/dashboard') }}"><i class="glyphicon glyphicon-user"></i>
                                        <span>Usuarios</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ URL::to('profile') }}">Bienvenido, <strong>{{ Sentry::getUser()->first_name }}</strong></a></li>
                <li><a href="{{ URL::to('logout') }}"><i class="glyphicon glyphicon-share-alt"></i> Salir</a></li>
            </ul>
        </div>
    @endif
</div>
