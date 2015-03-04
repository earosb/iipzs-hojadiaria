@extends('layout.landing')

@section('meta')
    <meta name="description" content="Paŕametros para la creación de un formulario 2-3-4">
    <meta name="author" content="earosb">
@stop

@section('title')
    Generar formulario 2-3-4
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            {{ Form::open(array(
                'url' 		=>	'r/form',
                'method' 	=>	'post',
                'id'		=>	'formParam',
                'class' 	=> 	'form-horizontal')) }}
            <legend>Generar Formulario 2-3-4</legend>
            <div class="col-md-12">

                {{-- Mes Inicio --}}
                <div class="col-md-3">
                    {{ Form::label('desde', 'Desde', array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::select('desde', trans('form.months'), null, ['class'=>'form-control']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('desde') }}</p>
                </div>

                {{-- Mes Término --}}
                <div class="col-md-3">
                    {{ Form::label('hasta', 'Hasta', array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::select('hasta', trans('form.months'), null, ['class'=>'form-control']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('hasta') }}</p>
                </div>

            </div>
            <div class="col-md-12">
                {{-- Año --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('year', 'Año', array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::selectYear('year', 2015, $year, $year, ['class'=>'form-control']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('year') }}</p>
                </div>

                {{-- Select sector --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('sector', 'Sector', array('class' => 'control-label')) }}
                    <div class="controls">
                        <select name="sector" id="sector" class="form-control">
                            {{--<option selected="selected" value="all"> Todos</option>--}}
                            @foreach($sectores as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-danger">{{ $errors->first('sector') }}</p>
                </div>

            </div>

        </div>

        {{-- Botones --}}
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <div class="btn-group">
                    {{ Form::button('Generar', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
                </div>
            </div>
        </div>

        {{ Form::close() }}

    </div>
    </div>
@stop