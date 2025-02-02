<div class="navbar navbar-default">
    @if(Sentry::check())
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('/') }}">
                <img style="max-width:100px; margin-top: -4px;" alt="Icil-Icafal PZS"
                     src="{{ asset('img/navbar.png') }}">
            </a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                @if (Sentry::getUser()->hasAccess(['hoja-diaria']))
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="glyphicon glyphicon-file"></i><span> Hoja diaria <b class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/hd/create') }}">Ingresar hoja diaria</a></li>
                            <li><a href="{{ URL::to('/hd') }}">Histórico</a></li>
                        </ul>
                    </li>
                @endif
                @if (Sentry::getUser()->hasAccess(['deposito']))
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="glyphicon glyphicon-oil"></i><span> Centros de acopio <b class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('carga/create') }}">Ingresar carga</a></li>
                            <li><a href="{{ URL::to('/carga') }}">Histórico</a></li>
                            <li><a href="{{ URL::to('r/depositos') }}">Reporte</a></li>
                        </ul>
                    </li>
                @endif
                @if (Sentry::getUser()->hasAccess(['reporte']))
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="glyphicon glyphicon-list-alt"></i><span> Reportes <b
                                        class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/r/param') }}">Consultar trabajos</a></li>
                            @if (Sentry::getUser()->hasAccess(['reporte-avanzado']))
                                <li><a href="{{ URL::to('/r/depositos') }}">Consultar centros de acopio </a></li>
                            @endif
                            @if (Sentry::getUser()->hasAccess(['form2-3-4']))
                                <li class="divider"></li>
                                <li class="dropdown-header">Descargar</li>
                                <li><a href="{{ URL::to('/r/form') }}">Formularios 2-3-4 </a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Sentry::getUser()->hasAccess(['programar']))
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="glyphicon glyphicon-tasks"></i><span> Programar <b
                                        class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/programar') }}">Programar trabajos</a></li>
                            <li><a href="{{ URL::to('/programar/download-app') }}">Descargar Android App</a></li>
                        </ul>
                    </li>
                @endif
                @if (Sentry::getUser()->hasAccess(['mantencion']))
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><i
                                    class="glyphicon glyphicon-wrench"></i><span> Mantención <b
                                        class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/m/sector') }}">Vías</a></li>
                            <li><a href="{{ URL::to('/m/trabajo') }}">Trabajos</a></li>
                            <li><a href="{{ URL::to('/m/material') }}">Materiales</a></li>
                            <li><a href="{{ URL::to('/m/grupo-trabajo') }}">Grupos de trabajo</a></li>
                            <li><a href="{{ URL::to('/m/deposito') }}">Centros de acopio</a></li>
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
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><span><strong> {{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }}
                            </strong><b class="caret"></b></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Manuales</li>
                        @if(Sentry::getUser()->hasAccess(['create-user']))
                            <li><a href="{{ URL::to('/manual/admin') }}" target="_blank">Manual admin</a></li>
                        @endif
                        @if(Sentry::getUser()->hasAccess(['programar']))
                            <li><a href="{{ URL::to('/manual/programar') }}" target="_blank">Manual programar</a></li>
                            <li><a href="{{ URL::to('/manual/android') }}" target="_blank">Manual Android</a></li>
                        @endif
                        <li class="divider"></li>
                        <li class="dropdown-header">Usuario</li>
                        <li><a href="{{ URL::to('profile') }}"><i class="glyphicon glyphicon-user"></i> Perfil</a></li>
                        <li><a href="{{ URL::to('logout') }}"><i class="glyphicon glyphicon-share-alt"></i> Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    @endif
</div>
