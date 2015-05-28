@extends('layout.landing')

@section('meta')
    <meta name="description" content="Paŕametros para la creación de un formulario 2-3-4">
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
                    {{ Form::label('desde', 'Desde', array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::select('desde', trans('form.months'), null, ['class'=>'form-control', 'onchange'=>'changeMonth(this.value)']) }}
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

            {{-- Checkboxes tipo de vía --}}
            <div class="col-md-12">
                <div class="col-xs-12 col-md-3">
                    <div>
                        {{ Form::label('') }}
                    </div>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        {{ Form::checkbox('generador', 'true', false, array('id' => 'generador')) }}
                        <label for="generador"> Descargar Generadores </label>
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

@section('js')
    {{-- Cambia el mes en 'select hasta' al seleccionar algo en 'select desde' --}}
    <script>
        function changeMonth(val) {
            document.getElementById("hasta").value = val;
        }
    </script>
@stop