@extends('layout.landing')

@section('title')
    Icil-icafal - Iniciar Sesión
@stop

<style type="text/css">
	.well.login-box {
	    width:300px;
	    margin:0 auto;
	}
	.well.login-box legend {
	  font-size:26px;
	  text-align:center;
	  font-weight:300;
	}
	.well.login-box input[type="text"] {
	  border-color:#ddd;
	  border-radius:0;
	}
</style>

@section('content')

	<div class="row">
        <div class="col-md-12">
            <div class="well login-box">
                <form action="{{URL::to('/login')}}" method="POST">
                    <legend>Iniciar Sesión</legend>
                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input value='' id="username" placeholder="Ingrese usuario" type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" value='' placeholder="Ingrese contraseña" type="password" class="form-control" />
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-success btn-login-submit" value="Ingresar" />
                    </div>
                    <div class="form-group">
                        <a href="">Olvidé mi contraseña</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop