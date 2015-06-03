@extends('layout.landing')

@section('meta')
    <meta name="description" content="Parámetros para la creación de un formulario 2-3-4">
    <meta name="author" content="earosb">
@stop

@section('title')
    Generar formulario 2-3-4
@stop

@section('css')
    {{ HTML::style('css/awesome-bootstrap-checkbox.min.css') }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            {{ Form::open(array(
                'url' 		=>	'r/form',
                'method' 	=>	'post',
                'id'		=>	'formParam',
                'class' 	=> 	'form-horizontal')) }}
            <legend>Generar formularios 2-3-4</legend>
            <div class="col-md-12">
                {{-- Mes Inicio --}}
                <div class="col-md-3">
                    {{ Form::label('mes', 'Mes', array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::select('mes', trans('form.months'), null, ['class'=>'form-control', 'onchange'=>'changeMonth(this.value)']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('mes') }}</p>
                </div>
                {{-- Año --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('year', 'Año', array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::selectYear('year', 2015, $year, $year, ['class'=>'form-control']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('year') }}</p>
                </div>
            </div>
            <div class="col-md-12">
                {{-- Select sector --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('sector', 'Sector', array('class' => 'control-label')) }}
                    <div class="controls">
                        <select name="sector" id="sector" class="form-control">
                            @foreach($sectores as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-danger">{{ $errors->first('sector') }}</p>
                </div>
                {{-- Checkbox generadores --}}
                <div class="col-xs-12 col-md-3">
                    <div>
                        {{ Form::label('g', 'Generadores') }}
                    </div>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        {{ Form::checkbox('g', 'true', false, array('id' => 'g')) }}
                        <label for="g"> Descargar generadores </label>
                    </div>
                </div>

            </div>
        </div>

        {{-- Botones --}}
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <div class="btn-group">
                    {{ Form::button('Mantenimiento menor', array('type' => 'submit', 'class' => 'btn btn-primary', 'name' => 'action', 'value' => 'menor')) }}
                </div>
                <div class="btn-group">
                    {{ Form::button('Mantenimiento mayor', array('type' => 'submit', 'class' => 'btn btn-primary', 'name' => 'action', 'value' => 'mayor')) }}
                </div>
            </div>
        </div>

        {{ Form::close() }}

    </div>
    </div>
@stop