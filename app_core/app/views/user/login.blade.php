@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de login">
    <meta name="author" content="earosb" >
@stop

@section('title')
    Iniciar Sesión
@stop

<style type="text/css">
    .well.login-box {
        width: 300px;
        margin: 0 auto;
    }

    .well.login-box legend {
        font-size: 26px;
        text-align: center;
        font-weight: 300;
    }

    .well.login-box input[type="text"] {
        border-color: #ddd;
        border-radius: 0;
    }
</style>

@section('content')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="well login-box">
                {{ Form::open(array('url' => 'login')) }}
                <legend>{{ trans('form.signin'); }}</legend>
                @if($errors->has('login'))
                    <div class="alert alert-dismissable alert-danger">
                        {{--<button type="button" class="close" data-dismiss="alert">×</button>--}}
                        <p><strong>{{ $errors->first('login', ':message') }}</strong></p>
                    </div>
                @endif
                <div class="form-group">
                    {{ Form::label('username', trans('form.username')) }}
                    {{ Form::text('username', '', array('class' => 'form-control', 'placeholder' => 'Ingrese Usuario', 'required' => 'required')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('password', trans('form.password')) }}
                    {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Ingrese Contraseña', 'required' => 'required')) }}
                </div>
                {{--<div class="form-group">
                    {{ HTML::link('/', trans('form.password_lost')) }}
                </div>--}}
                <div class="form-group text-center">
                    {{ Form::submit(trans('form.signin'), array('class'=>'btn btn-success btn-login-submit')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop