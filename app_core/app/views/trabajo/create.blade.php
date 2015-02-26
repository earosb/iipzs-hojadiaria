@extends('layout.landing')

@section('title')
    Nuevo Trabajo
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            {{ Form::open(array(
                'url'		=>	'/m/trabajo/',
                'method'	=>	'post',
                'id' 		=> 	'formTrabajo',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                <legend>Nuevo Trabajo</legend>
                {{-- Nombre --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nombre">Nombre</label>
                    <div class="col-sm-10">
                        <input id="nombre" name="nombre" placeholder="Nombre del trabajo" class="form-control" type="text" >
                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>

                {{-- Trabajo Padre --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="padre">Trabajo Asociado</label>
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
                    <label class="col-sm-2 control-label" for="valor">Valor Unitario (UF)</label>
                    <div class="col-sm-10">
                        <input id="valor" name="valor" placeholder="Valor del Trabajo" class="form-control" type="number" step="0.01" min="0" required="required">
                        <p class="text-danger">{{ $errors->first('valor') }}</p>
                    </div>
                </div>
                {{-- Unidad --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="unidad">Unidad de Medida</label>
                    <div class="col-sm-10">
                        <input id="unidad" name="unidad" placeholder="m3, nro, mlv, etc." class="form-control" type="text" required="required">
                        <p class="text-danger">{{ $errors->first('unidad') }}</p>
                    </div>
                </div>

                {{-- Checkbox esOficial --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="es_oficial">Oficial</label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input name="es_oficial" type="checkbox" value="true">
                                <abbr title="Quiere decir que será incluido en el Form 2-3-4">¿Qué es esto?</abbr>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Radio tipo mantenimiento --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Mantenimiento</label>
                    <div class="col-sm-10">
                        @foreach($tipoMantenimiento as $tMat)
                            <div class="radio">
                                <label>
                                    <input name="tMat" id="tMat{{ $tMat->id }}" value="{{ $tMat->id }}" checked="" type="radio">
                                    {{ $tMat->nombre }}
                                </label>
                            </div>
                        @endforeach
                            <p class="text-danger">{{ $errors->first('tMat') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button id="btn_guardar" name="btn_guardar" class="btn btn-success pull-right">Guardar</button>
                    </div>
                </div>

            </fieldset>
            {{ Form::close() }}

        </div>
    </div>
@stop