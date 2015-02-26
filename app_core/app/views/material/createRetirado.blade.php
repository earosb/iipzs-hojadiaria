@extends('layout.landing')

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
                    <label class="col-sm-2 control-label" for="nombre">Nombre</label>

                    <div class="col-sm-10">
                        <input id="nombre" name="nombre" placeholder="Nombre" class="form-control" type="text" required="required">

                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>

                {{-- Clase --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="clase">Clase</label>

                    <div class="col-sm-10">
                        <input id="clase" name="clase" placeholder="Clase" class="form-control" type="text" required="required">

                        <p class="text-danger">{{ $errors->first('clase') }}</p>
                    </div>
                </div>

                {{-- Checkbox esOficial --}}
                <div id="es_oficial_div" class="form-group">
                    {{ Form::label('es_oficial', 'Oficial', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('es_oficial', 'true'); }}
                                <abbr title="Quiere decir que será incluido en el Form 2-3-4">¿Qué es esto?</abbr>
                            </label>
                        </div>
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
    </div>

@stop