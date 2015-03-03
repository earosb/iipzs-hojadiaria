@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la edición de un block">
    <meta name="author" content="earosb">
@stop

@section('title')
    Editar: {{ $block->estacion }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>{{ $block->estacion }}
                <a id="dlt" onclick="destroy()" class="text-danger pull-right"><span class="glyphicon glyphicon-trash"></span></a>
            </legend>
            {{ Form::open(array(
                'url'		=>	'/m/block/'.$block->id,
                'method'	=>	'PUT',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                {{-- Sector --}}
                <div class="form-group hidden">
                    <label class="col-sm-2 control-label" for="sector_id">Sector</label>

                    <div>
                        <div class="col-sm-10">
                            <div class="controls">
                                <select name="sector_id" id="sector_id" class="form-control">
                                    <option selected="selected" value="{{ $block->sector_id }}">{{ $block->sector_id }}</option>
                                </select>

                                <p class="text-danger">{{ $errors->first('sector_id') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="estacion">Estación</label>

                    <div class="col-sm-10">
                        <input id="estacion" name="estacion" placeholder="" class="form-control" type="text"
                               required="required" value="{{ $block->estacion }}">

                        <p class="text-danger">{{ $errors->first('estacion') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nro_bien">Nro. Bien</label>

                    <div class="col-sm-10">
                        <input id="nro_bien" name="nro_bien" placeholder="" class="form-control"
                               type="text" required="required" value="{{ $block->nro_bien }}">

                        <p class="text-danger">{{ $errors->first('nro_bien') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_inicio">Km inicio</label>

                    <div class="col-sm-10">
                        <input id="km_inicio" name="km_inicio" placeholder="" class="form-control" type="number"
                               required="required" value="{{ $block->km_inicio }}">

                        <p class="text-danger">{{ $errors->first('km_inicio') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_termino">Km término</label>

                    <div class="col-sm-10">
                        <input id="km_termino" name="km_termino" placeholder="" class="form-control" type="number"
                               required="required" value="{{ $block->km_termino }}">

                        <p class="text-danger">{{ $errors->first('km_termino') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                        {{ Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) }}
                    </div>
                </div>

            </fieldset>
            {{ Form::close() }}

        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        function destroy() {
            if ( confirm("¿Desea borrar el Block?") == true ) {
                if ( confirm("El registro no podrá ser recuperado, ¿Desea continuar?") ) {
                    $.ajax({
                        type: 'delete',
                        url: '/m/block/' + "{{ $block->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        //if ( data.error ) alert("Se produjo un problema el intentar eliminar el Block {{ $block->estacion }}");

                        window.location.replace("{{ URL::to('/m/sector') }}");
                    });
                }
            }
        }
        ;
    </script>
@stop