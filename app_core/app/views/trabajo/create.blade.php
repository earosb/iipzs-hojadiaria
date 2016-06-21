@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un trabajo">
    <meta name="author" content="earosb">
@stop

@section('title')
    Nuevo Trabajo
@stop

@section('content')
    <div class="row">

        {{ Form::open(array(
            'url'		=>	'/m/trabajo/',
            'method'	=>	'post',
            'id' 		=> 	'formTrabajo',
            'class' 	=> 	'form-horizontal')) }}
        <legend>Nuevo Trabajo</legend>

        <div class="col-xs-12 col-md-6">
            {{-- Nombre --}}
            <div class="form-group">
                {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    {{ Form::text('nombre', null, array('placeholder' => 'Nombre del trabajo', 'class' => 'form-control', 'required' => 'required')) }}
                    <p class="text-danger">{{ $errors->first('nombre') }}</p>
                </div>
            </div>

            {{-- Trabajo Padre --}}
            <div class="form-group">
                {{ Form::label('padre', 'Trabajo Asociado', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    <select name="padre" class="form-control">
                        <option selected="selected" value="none">Ninguno</option>
                        @foreach($tipoMantenimiento as $tMat)
                            <optgroup label="{{ $tMat->nombre }}">
                                @foreach($tMat->trabajos as $trabajo)
                                    <option value="{{ $trabajo->id }}">{{ $trabajo->nombre }}
                                        [{{ $trabajo->unidad }}]
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>

                    <p class="text-danger">{{ $errors->first('padre') }}</p>
                </div>
            </div>
            {{-- Valor --}}
            <div class="form-group">
                {{ Form::label('valor', 'Valor Unitario (UF)', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    {{ Form::number('valor', null, array('class' => 'form-control', 'placeholder' => 'Valor del Trabajo', 'min' => '0', 'step' => '0.01', 'required' => 'required')) }}
                    <p class="text-danger">{{ $errors->first('valor') }}</p>
                </div>
            </div>

            {{-- Unidad --}}
            <div class="form-group">
                {{ Form::label('unidad', 'Unidad de Medida', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    {{ Form::text('unidad', null, array('placeholder' => 'm3, nro, mlv, etc.', 'class' => 'form-control', 'required' => 'required')) }}
                    <p class="text-danger">{{ $errors->first('unidad') }}</p>
                </div>
            </div>

            {{-- Checkbox esOficial --}}
            <div class="form-group">
                {{ Form::label('es_oficial', 'Form 2', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('es_oficial', 'true') }}
                            <abbr title="Quiere decir que será incluido en Formulario 2">¿Qué es
                                esto? </abbr>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Orden --}}
            <div class="form-group">
                {{ Form::label('orden', 'Orden en form. 2', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    {{ Form::number('orden', 0, array('class' => 'form-control', 'placeholder' => 'Orden en formulario 2', 'min' => '0', 'step' => '0', 'required' => 'required')) }}
                    <p class="text-danger">{{ $errors->first('orden') }}</p>
                </div>
            </div>

            {{-- Radio tipo mantenimiento --}}
            <div class="form-group">
                {{ Form::label('tMat', 'Mantenimiento', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    @foreach($tipoMantenimiento as $tMat)
                        <div class="radio">
                            <label>
                                {{ Form::radio('tMat', $tMat->id) }}
                                {{ $tMat->nombre }}
                            </label>
                        </div>
                    @endforeach
                    <p class="text-danger">{{ $errors->first('tMat') }}</p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    {{ Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) }}
                </div>
            </div>

        </div>
        {{-- Checkboxes Materiales Asociados --}}
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Materiales Asociados </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            @foreach($materiales as $material)
                                <div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('materiales['.$material->id.']', $material->id, false) }}
                                        <p>{{ $material->nombre }}</p>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ Form::close() }}

    </div>
@stop