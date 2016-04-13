@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de una consulta/reporte">
    <meta name="author" content="earosb">
@stop

@section('title')
    Consulta centros de acopio
@stop

@section('css')
    {{ HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css') }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            {{ Form::open([
                'url' 		=>	'r/deposito/result',
                'method' 	=>	'get',
                'id'		=>	'formParam',
                'class' 	=> 	'form-horizontal']) }}
            <legend>Consultar centros de acopio</legend>
            <div class="col-md-12">
                {{-- Fecha Inicio --}}
                <div class="col-md-3">
                    {{ Form::label('fecha_desde', 'Desde', ['class' => 'control-label']) }}
                    <div class="input-group" id="fecha_desde_div">
                        {{ Form::text('fecha_desde', null, ['class'=>'form-control', 'placeholder'=>'Ingrese Fecha', 'id'=>'fecha_desde', 'required' => 'required']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('fecha_desde') }}</p>
                </div>
                {{-- Fecha término --}}
                <div class="col-md-3">
                    {{ Form::label('fecha_hasta', 'Hasta', ['class' => 'control-label']) }}
                    <div class="input-group" id="fecha_hasta_div">
                        {{ Form::text('fecha_hasta', null, ['class'=>'form-control', 'placeholder'=>'Ingrese Fecha', 'id'=>'fecha_hasta', 'required' => 'required']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('fecha_hasta') }}</p>
                </div>

            </div>
            <div class="col-md-12">
                {{-- Select sector
                ===================================================== --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('sector', 'Sector', ['class' => 'control-label']) }}
                    <div class="controls">
                        <select name="sector" id="sector" class="form-control">
                            <option value="all" selected="selected">Todos</option>
                            @foreach($sectores as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-danger">{{ $errors->first('sector') }}</p>
                </div>
                {{-- Select block
                ===================================================== --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('block', 'Block', ['class' => 'control-label']) }}
                    <div class="controls">
                        <select name="block" id="block" class="form-control">
                            <option value="all" selected="selected">Seleccione sector</option>
                        </select>
                    </div>
                    <p class="text-danger">{{ $errors->first('block') }}</p>
                </div>
            </div>
            <div class="col-md-12">
                {{-- Grupo vía
                ===================================================== --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('grupo_via', 'Grupo Vía', ['class' => 'control-label']) }}
                    <div class="controls">
                        <select name="grupo_via" id="grupo_via" class="form-control">
                            <option selected="selected" value="all"> Todos</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->base }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-danger">{{ $errors->first('grupo_via') }}</p>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <div class="btn-group">
                    {{ Form::button('Generar reporte', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>

        {{ Form::close() }}

    </div>
    </div>
@stop

@section('js')
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js') }}
    {{ HTML::script('js/calendar/calendar.min.js') }}
    {{ HTML::script('js/consultas/r.deposito.js') }}
@stop