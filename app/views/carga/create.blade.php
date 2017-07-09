@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un sector">
    <meta name="author" content="earosb">
@stop

@section('title')
    Nuevo Sector
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            {{ Form::open(['url' => 'm/carga', 'class' => 'form-horizontal', 'id' => 'causaForm']) }}

            <fieldset>

                <legend>Nueva carga</legend>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="tipo">Tipo</label>

                    <div class="col-md-8">
                        <label class="radio-inline"><input type="radio" name="tipo" value="carga" checked>Carga</label>
                        <label class="radio-inline"><input type="radio" name="tipo" value="rect">Rectificación</label>
                        <p class="text-danger">{{ $errors->first('tipo') }}</p>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="fecha">Fecha</label>

                    <div class="col-md-4">
                        <input id="fecha" name="fecha" type="date" class="form-control input-md">
                        <p class="text-danger">{{ $errors->first('fecha') }}</p>
                    </div>
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    <label class="col-md-2 control-label" for="deposito">Depósito</label>

                    <div class="col-md-4">
                        <select name="deposito" id="deposito" class="form-control">
                            @foreach($depositos as $deposito)
                                <option value="{{ $deposito->id }}">{{ $deposito->nombre }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger">{{ $errors->first('deposito') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="material">Material</label>

                    <div class="col-md-4">
                        <select name="material" id="material" class="form-control">
                            @foreach($materiales as $material)
                                <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger">{{ $errors->first('material') }}</p>
                    </div>
                    <label class="col-md-2 control-label" for="cantidad">Cantidad</label>

                    <div class="col-md-4">
                        <input id="cantidad" name="cantidad" type="number" class="form-control input-md">
                        <p class="text-danger">{{ $errors->first('cantidad') }}</p>
                    </div>
                </div>

                {{--<div class="form-group">--}}
                    {{--<label class="col-md-2 control-label" for="cantidad">Cantidad</label>--}}

                    {{--<div class="col-md-10">--}}
                        {{--<input id="cantidad" name="cantidad" type="number" class="form-control input-md">--}}
                        {{--<p class="text-danger">{{ $errors->first('cantidad') }}</p>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group">
                    <label class="col-md-2 control-label" for="obs">Observaciones</label>

                    <div class="col-md-10">
                        {{ Form::textarea('obs', null, ['rows' => '3', 'class' => 'form-control input-md']) }}
                        <p class="text-danger">{{ $errors->first('obs') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                        <button class="btn btn-primary pull-right">Guardar</button>
                    </div>
                </div>

            </fieldset>
            {{ Form::close() }}
        </div>
    </div>
@stop