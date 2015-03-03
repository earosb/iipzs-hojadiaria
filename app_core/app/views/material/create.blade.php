@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un material a colocar">
    <meta name="author" content="earosb" >
@stop

@section('title')
    Nuevo Material
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>Nuevo Material</legend>
            {{ Form::open(array(
                'url'		=>	'/m/material/',
                'method'	=>	'post',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                {{-- Nombre --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nombre">Nombre</label>

                    <div class="col-sm-10">
                        <input id="nombre" name="nombre" placeholder="Nombre estación" class="form-control" type="text" required="required">

                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>
                {{-- Valor --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="valor">Valor Unitario (UF)</label>

                    <div class="col-sm-10">
                        <input id="valor" name="valor" placeholder="Valor" class="form-control" type="number" min="0" step="0.01" required="required">

                        <p class="text-danger">{{ $errors->first('valor') }}</p>
                    </div>
                </div>
                {{-- Proveedor --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="proveedor">Proveedor</label>

                    <div class="col-sm-10">
                        <input id="proveedor" name="proveedor" placeholder="Proveedor" class="form-control" type="text" required="required">

                        <p class="text-danger">{{ $errors->first('proveedor') }}</p>
                    </div>
                </div>
                {{-- Unidad --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="unidad">Unidad</label>

                    <div class="col-sm-10">
                        <input id="unidad" name="unidad" placeholder="Unidad" class="form-control" type="text" required="required">

                        <p class="text-danger">{{ $errors->first('unidad') }}</p>
                    </div>
                </div>

                {{-- Checkbox esOficial --}}
                <div id="es_oficial_div" class="form-group">
                    {{ Form::label('es_oficial', 'Form 2-3-4', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('es_oficial', 'true'); }}
                                <abbr title="Quiere decir que será incluido en los Formularios 2-3-4">¿Qué es esto?</abbr>
                            </label>
                        </div>
                    </div>
                </div>

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