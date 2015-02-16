{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 12-02-15
 * Time: 14:11
--}}

@extends('layout.landing')

@section('title')
    Consultas
@stop

@section('css')
    {{ HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css') }}
    {{ HTML::style('css/awesome-bootstrap-checkbox.min.css') }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            {{ Form::open(array(
                'url' 		=>	's',
                'method' 	=>	'get',
                'id'		=>	'formParam',
                'class' 	=> 	'form-horizontal')) }}
            <legend>Consultar Trabajos</legend>
            <div class="col-md-12">

                {{-- Fecha Inicio --}}
                <div class="col-md-3">
                    {{ Form::label('desde', 'Desde', array('class' => 'control-label')) }}
                    <div class="input-group" id="desde_div">
                        {{ Form::text('desde', null, ['class'=>'form-control', 'placeholder'=>'Ingrese Fecha', 'id'=>'desde', 'required' => 'required']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('desde') }}</p>
                </div>

                {{-- Fecha termino --}}
                <div class="col-md-3">
                    {{ Form::label('hasta', 'Hasta', array('class' => 'control-label')) }}
                    <div class="input-group" id="hasta_div">
                        {{ Form::text('hasta', null, ['class'=>'form-control', 'placeholder'=>'Ingrese Fecha', 'id'=>'hasta', 'required' => 'required']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('hasta') }}</p>
                </div>

            </div>
            <div class="col-md-12">
                {{-- Select sector
                ===================================================== --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('sector', 'Sector', array('class' => 'control-label')) }}
                    <div class="controls">
                        <select name="sector" id="sector" class="form-control">
                            {{--<option selected="selected" disabled="disabled"> Seleccione un Sector</option>--}}
                            <option selected="selected" value="all"> Todos</option>
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
                    {{ Form::label('block', 'Block', array('class' => 'control-label')) }}
                    <div class="controls">
                        <select name="block" id="block" class="form-control">
                            <option selected="selected" disabled="disabled"> Seleccione Block</option>
                        </select>
                    </div>
                    <p class="text-danger">{{ $errors->first('block') }}</p>
                </div>
            </div>

            {{-- Inputs kms--}}
            <div class="col-md-12">
                {{-- Km Inicio --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('km_inicio', 'Km Inicio', array('class' => 'control-label')) }}
                    {{--{{ Form::text('km_inicio', 498800, array('placeholder' => 'Kilómetro Inicio', 'class' => 'form-control')) }}--}}
                    <div class="input-group">
                        <span class="input-group-addon">Desde</span>
                        {{ Form::number('km_inicio', 498800, array('step' => '100', 'min' => '498800', 'class' => 'form-control', 'required' => 'required')) }}
                    </div>
                    <p class="text-danger">{{ $errors->first('km_inicio') }}</p>
                </div>
                {{-- Km Termino --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('km_termino', 'Km Término', array('class' => 'control-label')) }}
                    <div class="input-group">
                        <span class="input-group-addon">Hasta</span>
                        {{ Form::number('km_termino', 1066000, array('step' => '100', 'max' => '1066000', 'class' => 'form-control', 'required' => 'required')) }}
                    </div>
                    <p class="text-danger">{{ $errors->first('km_termino') }}</p>
                </div>
            </div>
            {{-- Opciones Avanzadas --}}
            @if (Sentry::getUser()->hasAccess(['consultas-avanzadas']))
                <div class="col-md-12">
                    {{-- Grupo Vía --}}
                    <div class="col-xs-12 col-md-3">
                        {{ Form::label('grupo_via', 'Grupo Vía', array('class' => 'control-label')) }}
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
                    {{-- Checkboxes tipo de vía --}}
                    <div class="col-xs-12 col-md-3">
                        <div>
                            {{ Form::label('tipo_via[]', 'Tipo de Vía') }}
                        </div>
                        <div class="checkbox checkbox-primary checkbox-inline">
                            {{ Form::checkbox('tipo_via[0]', 'true', true, array('id' => 'tipo_via[0]', 'disabled' => 'disabled')) }}
                            <label for="tipo_via[0]"> Vía Principal </label>
                        </div>
                        <div class="checkbox checkbox-primary checkbox-inline">
                            {{ Form::checkbox('tipo_via[1]', 'true', true, array('id' => 'tipo_via[1]', 'disabled' => 'disabled')) }}
                            <label for="tipo_via[1]"> Desvíos </label>
                        </div>
                        <div class="checkbox checkbox-primary checkbox-inline">
                            {{ Form::checkbox('tipo_via[2]', 'true', true, array('id' => 'tipo_via[2]', 'disabled' => 'disabled')) }}
                            <label for="tipo_via[2]"> Desviadores </label>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Botones --}}
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                @if (Sentry::getUser()->hasAccess(['consultas-avanzadas']))
                    <div class="btn-group">
                        {{ Form::button('Resumido', array('type' => 'submit', 'name' => 'action', 'value' => 'resumido', 'class' => 'btn btn-primary')) }}
                    </div>
                @endif
                <div class="btn-group">
                    {{ Form::button('Detallado', array('type' => 'submit', 'name' => 'action', 'value' => 'detallado', 'class' => 'btn btn-primary')) }}
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
    {{ HTML::script('js/consultas/param.js') }}
@stop