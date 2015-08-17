@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la edición de un material a retirar">
    <meta name="author" content="earosb">
@stop

@section('title')
    Editar: {{ $matRet->nombre }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend> {{ $matRet->nombre }}
                <a id="dlt" onclick="destroy()" class="text-danger pull-right"><span
                            class="glyphicon glyphicon-trash"></span></a>
            </legend>
            {{ Form::open(array(
                'url'		=>	'/m/material-retirado/'.$matRet->id,
                'method'	=>	'put',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                {{-- Nombre --}}
                <div class="form-group">
                    {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre', $matRet->nombre, array('placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required')) }}
                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>

                {{-- Checkbox esOficial --}}
                <div id="es_oficial_div" class="form-group">
                    {{ Form::label('es_oficial', 'Form 4', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                @if( $matRet->es_oficial ) <input name="es_oficial" type="checkbox" value="true"
                                                                  checked="checked">
                                @else <input name="es_oficial" type="checkbox" value="true">
                                @endif
                                <abbr title="Quiere decir que será incluido en Formulario 4">¿Qué es
                                    esto?</abbr>
                            </label>
                        </div>
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
            if (confirm("¿Desea borrar el Material?") == true) {
                if (confirm("El registro no podrá ser recuperado, ¿Desea continuar?")) {
                    $.ajax({
                        type: 'delete',
                        url: '/m/material-retirado/' + "{{ $matRet->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        if (data.error) {
                            alert("Se produjo un problema el intentar eliminar el Material {{ $matRet->nombre }}");
                            alert(data.msg);
                        }

                        window.location.replace("{{ URL::to('/m/material') }}");
                    });
                }
            }
        }

    </script>
@stop