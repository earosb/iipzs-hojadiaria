{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 23-02-15
 * Time: 18:53
--}}

@extends('layout.landing')

@section('title')
    Nuevo Block
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>Nuevo Block</legend>
            {{ Form::open(array(
                'url'		=>	'/m/block/',
                'method'	=>	'post',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>


                <div class="form-group">
                    <label class="col-sm-2 control-label" for="estacion">Estación</label>

                    <div class="col-sm-10">
                        <input id="estacion" name="estacion" placeholder="" class="form-control" type="text"
                               required="required" placeholder="">

                        <p class="text-danger">{{ $errors->first('estacion') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nro_bien">Nro. Bien</label>

                    <div class="col-sm-10">
                        <input id="nro_bien" name="nro_bien" placeholder="" class="form-control"
                               type="text" required="required" placeholder="">

                        <p class="text-danger">{{ $errors->first('nro_bien') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_inicio">Km inicio</label>

                    <div class="col-sm-10">
                        <input id="km_inicio" name="km_inicio" placeholder="" class="form-control" type="number"
                               required="required" placeholder="">

                        <p class="text-danger">{{ $errors->first('km_inicio') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_termino">Km término</label>

                    <div class="col-sm-10">
                        <input id="km_termino" name="km_termino" placeholder="" class="form-control" type="number"
                               required="required" placeholder="">

                        <p class="text-danger">{{ $errors->first('km_termino') }}</p>
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