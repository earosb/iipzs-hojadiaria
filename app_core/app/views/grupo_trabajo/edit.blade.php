@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la edición de un grupo de trabajo">
    <meta name="author" content="earosb" >
@stop

@section('title')
    Editar: {{ $grupo->base }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend> {{ $grupo->base }}
                <a id="dlt" onclick="destroy()" class="text-danger pull-right"><span class="glyphicon glyphicon-trash"></span></a>
            </legend>
            {{ Form::open(array(
                'url'		=>	'/m/grupo-trabajo/'.$grupo->id,
                'method'	=>	'put',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                {{-- Base --}}
                <div class="form-group">
                    {{ Form::label('base', 'Base', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                    {{ Form::text('base', $grupo->base, array('placeholder' => 'Base', 'class' => 'form-control', 'required' => 'required')) }}
                        <p class="text-danger">{{ $errors->first('base') }}</p>
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