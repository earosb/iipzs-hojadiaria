@extends('layout.landing')

@section('title')
    Editar: {{ $grupo->base }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend> {{ $grupo->base }}
                <a id="dlt" onclick="destroy()" class="glyphicon glyphicon-trash pull-right"></a>
            </legend>
            {{ Form::open(array(
                'url'		=>	'/m/grupo-trabajo/'.$grupo->id,
                'method'	=>	'put',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                {{-- Base --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="base">Base</label>

                    <div class="col-sm-10">
                        <input id="base" name="base" placeholder="Base estación" class="form-control" type="text" required="required"
                               value="{{ $grupo->base }}">

                        <p class="text-danger">{{ $errors->first('base') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                        {{ Form::submit('Guardar', array('class' => 'btn btn-success pull-right')) }}
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
            if ( confirm("¿Desea borrar el Grupo?") == true ) {
                if ( confirm("El registro no podrá ser recuperado, ¿Desea continuar?") ) {
                    $.ajax({
                        type: 'delete',
                        url: '/m/grupo-trabajo/' + "{{ $grupo->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        if ( data.error ) alert("Se produjo un problema el intentar eliminar el Grupo: {{ $grupo->base }}");

                        window.location.replace("{{ URL::to('/m/grupo-trabajo') }}");
                    });
                }
            }
        };
    </script>
@stop