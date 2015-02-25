{{--
* Created by PhpStorm.
* User: earosb
* Date: 25-02-15
* Time: 11:26
--}}

@extends('layout.landing')

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
                    <input id="first_name" name="first_name" class="form-control" type="text" required="required" disabled="disabled"
                           value="{{ Sentry::getUser()->first_name }}">

                    <p class="text-danger">{{ $errors->first('first_name') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="last_name">Apellido</label>

                <div class="col-sm-10">
                    <input id="last_name" name="last_name" class="form-control" type="text" required="required" disabled="disabled" value="{{ Sentry::getUser()->last_name }}">

                    <p class="text-danger">{{ $errors->first('last_name') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="username">Usuario</label>

                <div class="col-sm-10">
                    <input id="username" name="username" class="form-control" type="text" required="required" disabled="disabled" value="{{ Sentry::getUser()->username }}">

                    <p class="text-danger">{{ $errors->first('username') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="email">Email</label>

                <div class="col-sm-10">
                    <input id="email" name="email" class="form-control" type="email" required="required" disabled="disabled" value="{{ Sentry::getUser()->email }}">

                    <p class="text-danger">{{ $errors->first('email') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="password">Contraseña</label>

                <div class="col-sm-10">
                    <input id="password" name="password" placeholder="Contraseña" class="form-control" type="password" required="required">

                    <p class="text-danger">{{ $errors->first('password') }}</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="password_confirmation">Corfirmar contraseña</label>

                <div class="col-sm-10">
                    <input id="password_confirmation" name="password_confirmation" placeholder="Corfirmar Contraseña" class="form-control" type="password" required="required">

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
    <div class="col-xs-12 col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Información</div>
            <div class="panel-body">

                <label>Registro</label>

                <p>{{ Sentry::getUser()->created_at }}</p>

                <label>Última modificación</label>

                <p>{{ Sentry::getUser()->updated_at }}</p>

                <label>Último acceso</label>

                <p>{{ Sentry::getUser()->last_login }}</p>

                {{--<label>Dirección Ip</label>--}}

                {{--<p>{{ $throttle->ip_address }}</p>--}}

            </div>
        </div>
    </div>

@stop