@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un material a retirar">
    <meta name="author" content="earosb">
@stop

@section('title')
    Nuevo Material Retirado
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>Nuevo Material Retirado</legend>
            {{ Form::open(array(
                'url'		=>	'/m/material-retirado',
                'method'	=>	'post',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>
                {{-- Nombre --}}
                <div class="form-group">
                    {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre', null, array('placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required')) }}
                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>
                {{-- Checkbox esOficial --}}
                <div id="es_oficial_div" class="form-group">
                    {{ Form::label('es_oficial', 'Form 4', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('es_oficial', 'true'); }}
                                <abbr title="Quiere decir que será incluido en Formulario 4">¿Qué es esto?</abbr>
                            </label>
                        </div>
                    </div>
                </div>
                {{-- Orden en formulario 4 --}}
                <div class="form-group">
                    {{ Form::label('orden', 'Orden en form. 4', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        {{ Form::number('orden', null, array('class' => 'form-control', 'placeholder' => 'Orden en formulario 4', 'min' => '0')) }}
                        <p class="text-danger">{{ $errors->first('orden') }}</p>
                    </div>
                </div>
                {{-- Submit --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                        {{ Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) }}
                    </div>
                </div>

            </fieldset>
            {{ Form::close() }}

        </div>
    </div>

@stop