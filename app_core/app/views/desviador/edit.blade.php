@extends('layout.landing')

@section('title')
    Nuevo Desviador
@stop

@section('meta')
    <meta name="description" content="Formulario para la edición de un desviador">
    <meta name="author" content="earosb">
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>{{ $desviador->nombre }}
                <a id="dlt" onclick="destroy()" class="text-danger pull-right"><span class="glyphicon glyphicon-trash"></span></a>
            </legend>
            {{ Form::open(array(
                    'url'		=>	'm/desviador/'.$desviador->id,
                    'method'	=>	'put',
                    'class' 	=> 	'form-horizontal')) }}
            <fieldset>
                {{-- Nombre Desviador --}}
                <div class="form-group">
                    {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre', $desviador->nombre, array('placeholder' => 'Nombre Desviador', 'class' => 'form-control')) }}
                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>
                {{-- Ubicación Desviador --}}
                <div class="form-group">
                    {{ Form::label('km_inicio', 'Ubicación', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        {{ Form::number('km_inicio', $desviador->km_inicio, array('placeholder' => 'Kilómetro de ubicación', 'class' => 'form-control' )) }}
                        <p class="text-danger">{{ $errors->first('km_inicio') }}</p>
                    </div>
                </div>
                {{-- Sector Desviador --}}
                <div class="form-group">
                    {{ Form::label('sector', 'Sector', array('class' => 'col-sm-2 control-label')) }}
                    <div>
                        <div class="col-sm-10">
                            <div class="controls">
                                <select name="sector" id="sector" class="form-control">
                                    <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                    @foreach($sectores as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                    @endforeach
                                </select>

                                <p class="text-danger">{{ $errors->first('sector') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Block Desviador --}}
                <div class="form-group">
                    {{ Form::label('block', 'Block', array('class' => 'col-sm-2 control-label')) }}
                    <div>
                        <div class="col-sm-10">
                            <div class="controls">
                                <select name="block" id="block" class="form-control">
                                    <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                </select>

                                <p class="text-danger">{{ $errors->first('block') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10r">
                    {{Form::submit('Guardar', array('class'=>'btn btn-success pull-right'))}}
                </div>
            </fieldset>
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            {{-- Carga los blocks en modal Form Desviador --}}
            $('#sector').on('change', function (e) {
                e.preventDefault();
                var sector_id = e.target.value;
                ajaxBlocks(sector_id, '#block');
            });
        });
        function destroy() {
            if ( confirm("¿Desea borrar el Desviador?") == true ) {
                if ( confirm("El registro no podrá ser recuperado, ¿Desea continuar?") ) {
                    $.ajax({
                        type: 'delete',
                        url: '/m/desviador/' + "{{ $desviador->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        if ( data.error ) alert("Se produjo un problema el intentar eliminar el Desviador {{ $desviador->nombre }}");

                        window.location.replace("{{ URL::to('/m/block/'.$desviador->block_id) }}");
                    });
                }
            }
        }
        ;
    </script>
    {{ HTML::script('js/ajaxBlocks.js') }}
@stop