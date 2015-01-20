<!doctype html>
<html lang="es_Cl">
	<head>
	    <meta charset="UTF-8">
	    <title>@yield('title')</title>

	    {{-- HTML::style('css/bootstrap.cosmo.min.css') --}}
	    {{ HTML::style('css/bootstrap.yeti.min.css') }}

	    {{-- yield para agregar css en cada página --}}
	    @yield('css')

	</head>
	<body >

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
		  <div class="navbar-collapse collapse navbar-responsive-collapse">
		    <ul class="nav navbar-nav">
		      <li><a href="{{ URL::to('/hd/create') }}">Ingresar Hoja Diaria</a></li>
		      <li><a href="#">Consultar trabajos</a></li>
		      <li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
		        <ul class="dropdown-menu">
		          <li><a href="#">Reporte Oficial EFE</a></li>
		          <li><a href="#">Another action</a></li>
		          <li><a href="#">Something else here</a></li>
		          <li class="divider"></li>
		          <li class="dropdown-header">Dropdown header</li>
		          <li><a href="#">Separated link</a></li>
		          <li><a href="#">One more separated link</a></li>
		        </ul>
		      </li>
		    </ul>
		    <ul class="nav navbar-nav navbar-right">
		      <li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuario <b class="caret"></b></a>
		        <ul class="dropdown-menu">
		          <li><a href="#">Cambiar contraseña</a></li>
		          <li class="divider"></li>
		          <li><a href="#">Salir</a></li>
		        </ul>
		      </li>
		    </ul>
		  </div>
		</div>

		{{-- Container
			===================================================== --}}
		<div class="container-fluid">
			@yield('alert')
			@yield('content')
	    </div>

	    {{-- Modals
			===================================================== --}}
			@yield('modals')

	    {{-- Footer
			===================================================== --}}
		<div class="footer">
			@yield('footer')
		</div>

		{{ HTML::script('js/jquery-1.11.2.min.js') }}
		{{ HTML::script('js/bootstrap.min.js') }}

		{{-- yield para agregar scripts en cada página --}}
		@yield('js')

	</body>
</html>