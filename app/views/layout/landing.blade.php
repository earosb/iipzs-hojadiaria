<!doctype html>
<html lang="es">
	<head>
	    <meta charset="UTF-8">
	    <title>@yield('title')</title>

	    {{ HTML::style('css/bootstrap.min.css') }}
	    {{ HTML::style('css/landing.css') }}

	    {{-- yield para agregar css opcionales de cada página --}}
	    @yield('css')

	</head>
	<body >
		<!-- Navbar 
		================================== -->
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
		      <li class="active"><a href="{{ URL::to('/trabajos/create') }}">Ingresar trabajos</a></li>
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
		</div><!-- Fin Navbar -->

		<!-- Container 
		================================== -->
		<div class="container">
			@yield('alert')
			@yield('content')
	    </div><!-- Container -->

	    <!-- Footer 
		================================== -->
		<div class="footer">
			@yield('footer')
		</div><!-- Footer -->

		{{ HTML::script('js/jquery-1.11.2.min.js') }}
		{{ HTML::script('js/bootstrap.min.js') }}

		{{-- yield para agregar scripts opcionales de cada página --}}
		@yield('js')

	</body>
</html>