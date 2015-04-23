@extends('layout.landing')

@section('title')
    Nuevo Desvío
@stop

@section('meta')
    <meta name="description" content="Formulario para la creación de un desvío">
    <meta name="author" content="earosb">
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>Nuevo Desvío</legend>
            {{ Form::open(array(
                'url'		=>	'm/desvio',
                'method'	=>	'post',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>
                {{-- Nombre Desvío --}}
                <div id="nombre_div" class="form-group">
                    {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre', null, array('placeholder' => 'Nombre Desvío', 'class' => 'form-control', 'required' => 'required')) }}
                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>
                {{-- Sector Desvío --}}
                <div id="selectsectorDesvio_div" class="form-group">
                    {{ Form::label('selectsectorDesvio', 'Sector', array('class' => 'col-sm-2 control-label')) }}
                    <div>
                        <div class="col-sm-10">
                            <div class="controls">
                                <select name="selectsectorDesvio" id="selectsectorDesvio" class="form-control">
                                    <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                    @foreach($sectores as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                    @endforeach
                                </select>

                                <div class="help-block" id="selectsectorDesvio_error"></div>
                                <p class="text-danger">{{ $errors->first('nombre') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Block Desvío --}}
                <div id="selectblockDesvio_div" class="form-group">
                    {{ Form::label('selectblockDesvio', 'Block', array('class' => 'col-sm-2 control-label')) }}
                    <div>
                        <div class="col-sm-10">
                            <div class="controls">
                                <select name="selectblockDesvio" id="selectblockDesvio" class="form-control">
                                    <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                </select>

                                <div class="help-block" id="selectblockDesvio_error"></div>
                                <p class="text-danger">{{ $errors->first('selectblockDesvio') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Desviador Norte --}}
                <div id="selectdesviador_norte_div" class="form-group">
                    {{ Form::label('selectdesviador_norte', 'Desviador Norte', array('class' => 'col-sm-2 control-label')) }}
                    <div>
                        <div class="col-sm-10">
                            <div class="controls">
                                {{ Form::select('selectdesviador_norte', [], null, [ 'class' => 'form-control', 'id'=>'selectdesviador_norte', 'disabled']) }}
                                <div class="help-block" id="selectdesviador_norte_error"></div>
                                <p class="text-danger">{{ $errors->first('selectdesviador_norte') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Desviador Sur --}}
                <div id="selectdesviador_sur_div" class="form-group">
                    {{ Form::label('selectdesviador_sur', 'Desviador Sur', array('class' => 'col-sm-2 control-label')) }}
                    <div>
                        <div class="col-sm-10">
                            <div class="controls">
                                {{ Form::select('selectdesviador_sur', [], null, [ 'class' => 'form-control', 'id'=>'selectdesviador_sur', 'disabled']) }}
                                <div class="help-block" id="selectdesviador_sur_error"></div>
                                <div class="help-block" id="selectdesviador_sur_error"></div>
                                <p class="text-danger">{{ $errors->first('selectdesviador_sur') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    {{Form::submit('Guardar', array('class'=>'btn btn-primary pull-right'))}}
                </div>
            </fieldset>
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            {{-- Carga los blocks en modal Form Desvío --}}
            $('#selectsectorDesvio').on('change', function (e) {
                e.preventDefault();
                var sector_id = e.target.value;
                ajaxBlocks(sector_id, '#selectblockDesvio');
            });
        });
    </script>
    {{ HTML::script('js/ajaxBlocks.js') }}
    {{--{{ HTML::script('js/min/1425396779231.min.js') }}--}}

    {{--{{ HTML::script('js/hd/modal/formDesvio.js') }}--}}
    {{ HTML::script('js/min/1424470502889.min.js') }}
@stop