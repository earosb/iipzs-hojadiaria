@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un centro de acopio/depósito">
    <meta name="author" content="earosb">
@stop

@section('title')
    Nuevo centro de acopio
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>Nuevo centro de acopio</legend>
            {{ Form::open([
                'url'		=>	'/m/deposito',
                'method'	=>	'post',
                'class' 	=> 	'form-horizontal']) }}
            <fieldset>
                <div class="form-group">
                    {{ Form::label('nombre', 'Nombre', ['class' => 'col-sm-2 control-label']) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre', null, array('placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required')) }}
                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                        {{ Form::submit('Guardar', ['class' => 'btn btn-primary pull-right']) }}
                    </div>
                </div>

            </fieldset>
            {{ Form::close() }}

        </div>
    </div>

@stop