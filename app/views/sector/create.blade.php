@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un sector">
    <meta name="author" content="earosb">
@stop

@section('title')
    Nuevo Sector
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            {{ Form::open(array(
                'url'		=>	'/m/sector/',
                'method'	=>	'post',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                <legend>Nuevo Sector</legend>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nombre">Nombre</label>

                    <div class="col-sm-10">
                        <input id="nombre" name="nombre" placeholder="" class="form-control" type="text"
                               required="required">

                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="estacion_inicio">Estación inicio</label>

                    <div class="col-sm-10">
                        <input id="estacion_inicio" name="estacion_inicio" placeholder="" class="form-control"
                               type="text" required="required">

                        <p class="text-danger">{{ $errors->first('estacion_inicio') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="estacion_termino">Estación término</label>

                    <div class="col-sm-10">
                        <input id="estacion_termino" name="estacion_termino" placeholder="" class="form-control"
                               type="text" required="required">

                        <p class="text-danger">{{ $errors->first('estacion_termino') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_inicio">Km inicio</label>

                    <div class="col-sm-10">
                        <input id="km_inicio" name="km_inicio" placeholder="" class="form-control" type="number"
                               required="required">

                        <p class="text-danger">{{ $errors->first('km_inicio') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_termino">Km término</label>

                    <div class="col-sm-10">
                        <input id="km_termino" name="km_termino" placeholder="" class="form-control" type="number"
                               required="required">

                        <p class="text-danger">{{ $errors->first('km_termino') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                        <button id="btn_guardar" name="btn_guardar" class="btn btn-primary pull-right">Guardar</button>
                    </div>
                </div>

            </fieldset>
            {{ Form::close() }}

        </div>
    </div>
@stop