@extends('layout.landing')

@section('meta')
    <meta name="description" content="Perfil de usuario, formulario de edición">
    <meta name="author" content="earosb">
@stop

@section('title')
    Perfil
@stop

@section('content')
    <legend>Perfil</legend>
    <div class="col-xs-12 col-md-6">
        {{ Form::open(array(
            'url'		=>	'/profile',
            'method'	=>	'post',
            'class' 	=> 	'form-horizontal')) }}
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="first_name">Nombre</label>

                <div class="col-sm-10">
                    <input id="first_name" name="first_name" class="form-control" type="text" required="required"
                           disabled="disabled"
                           value="{{ Sentry::getUser()->first_name }}">

                    <p class="text-danger">{{ $errors->first('first_name') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="last_name">Apellido</label>

                <div class="col-sm-10">
                    <input id="last_name" name="last_name" class="form-control" type="text" required="required"
                           disabled="disabled"
                           value="{{ Sentry::getUser()->last_name }}">

                    <p class="text-danger">{{ $errors->first('last_name') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="username">Usuario</label>

                <div class="col-sm-10">
                    <input id="username" name="username" class="form-control" type="text" required="required"
                           disabled="disabled"
                           value="{{ Sentry::getUser()->username }}">

                    <p class="text-danger">{{ $errors->first('username') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="email">Email</label>

                <div class="col-sm-10">
                    <input id="email" name="email" class="form-control" type="email" required="required"
                           disabled="disabled"
                           value="{{ Sentry::getUser()->email }}">

                    <p class="text-danger">{{ $errors->first('email') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="password">Nueva contraseña</label>

                <div class="col-sm-10">
                    <input id="password" name="password" placeholder="Contraseña" class="form-control" type="password"
                           required="required">

                    <p class="text-danger">{{ $errors->first('password') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="password_confirmation">Confirmar contraseña</label>

                <div class="col-sm-10">
                    <input id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña"
                           class="form-control"
                           type="password" required="required">

                    <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"></label>

                <div class="col-sm-10">
                    {{ Form::submit('Guardar', array('class' => 'btn btn-success pull-right')) }}
                </div>
            </div>

        </fieldset>
        {{ Form::close() }}

    </div>
@stop