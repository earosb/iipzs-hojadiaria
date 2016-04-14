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
                {{-- Depósitos
                ===================================================== --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('centro_de_acopio', 'Centro de acopio', ['class' => 'control-label']) }}
                    <div class="controls">
                        <select name="centro_de_acopio" id="centro_de_acopio" class="form-control">
                            @foreach($depositos as $deposito)
                                <option value="{{ $deposito->id }}">{{ $deposito->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-danger">{{ $errors->first('centro_de_acopio') }}</p>
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