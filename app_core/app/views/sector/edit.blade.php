@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la edición de un sector">
    <meta name="author" content="earosb" >
@stop

@section('title')
    Editar: {{ $sector->nombre }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>{{ $sector->nombre }}
                <a id="dlt" onclick="destroy()" class="text-danger pull-right"><span class="glyphicon glyphicon-trash"></span></a>
            </legend>
            {{ Form::open(array(
                'url'		=>	'/m/sector/'.$sector->id,
                'method'	=>	'PUT',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>


                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nombre">Nombre</label>

                    <div class="col-sm-10">
                        <input id="nombre" name="nombre" placeholder="" class="form-control" type="text"
                               required="required" value="{{ $sector->nombre }}">

                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="estacion_inicio">Estación inicio</label>

                    <div class="col-sm-10">
                        <input id="estacion_inicio" name="estacion_inicio" placeholder="" class="form-control"
                               type="text" required="required" value="{{ $sector->estacion_inicio }}">

                        <p class="text-danger">{{ $errors->first('estacion_inicio') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="estacion_termino">Estación término</label>

                    <div class="col-sm-10">
                        <input id="estacion_termino" name="estacion_termino" placeholder="" class="form-control"
                               type="text" required="required" value="{{ $sector->estacion_termino }}">

                        <p class="text-danger">{{ $errors->first('estacion_termino') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_inicio">Km inicio</label>

                    <div class="col-sm-10">
                        <input id="km_inicio" name="km_inicio" placeholder="" class="form-control" type="number"
                               required="required" value="{{ $sector->km_inicio }}">

                        <p class="text-danger">{{ $errors->first('km_inicio') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="km_termino">Km término</label>

                    <div class="col-sm-10">
                        <input id="km_termino" name="km_termino" placeholder="" class="form-control" type="number"
                               required="required" value="{{ $sector->km_termino }}">

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
            if ( confirm("¿Desea borrar el sector?") == true ) {
                if ( confirm("El registro no podrá ser recuperado, ¿Desea continuar?") ) {
                    $.ajax({
                        type: 'delete',
                        url: '/m/sector/' + "{{ $sector->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        if ( data.error ) alert("Se produjo un problema el intentar eliminar el Sector {{ $sector->nombre }}");

                        window.location.replace("{{ URL::to('/m/sector') }}");
                    });
                }
            }
        }
        ;

    </script>
@stop