@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un block">
    <meta name="author" content="earosb" >
@stop

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

                {{-- Sector --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="sector_id">Sector</label>

                    <div>
                        <div class="col-sm-10">
                            <div class="controls">
                                <select name="sector_id" id="sector_id" class="form-control">
                                    <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                    @foreach($sectores as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                    @endforeach
                                </select>

                                <p class="text-danger">{{ $errors->first('sector_id') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="estacion">Estación</label>

                    <div class="col-sm-10">
                        <input id="estacion" name="estacion" placeholder="Nombre estación" class="form-control" type="text" required="required">

                        <p class="text-danger">{{ $errors->first('estacion') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nro_bien">Nro. Bien</label>

                    <div class="col-sm-10">
                        <input id="nro_bien" name="nro_bien" placeholder="Número de bien" class="form-control"
                               type="text" required="required" >

                        <p class="text-danger">{{ $errors->first('nro_bien') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_inicio">Km inicio</label>

                    <div class="col-sm-10">
                        <input id="km_inicio" name="km_inicio" placeholder="Kilómetro de inicio" class="form-control" type="number"
                               required="required" min="0">

                        <p class="text-danger">{{ $errors->first('km_inicio') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_termino">Km término</label>

                    <div class="col-sm-10">
                        <input id="km_termino" name="km_termino" placeholder="Kilómetro de término" class="form-control" type="number"
                               required="required" min="0">

                        <p class="text-danger">{{ $errors->first('km_termino') }}</p>
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