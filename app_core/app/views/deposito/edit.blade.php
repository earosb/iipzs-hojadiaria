@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un centro de acopio/depósito">
    <meta name="author" content="earosb">
@stop

@section('title')
    Nuevo centro de acopio
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>Editar centro de acopio
                <a id="dlt" onclick="destroy()" class="text-danger pull-right"><span
                            class="glyphicon glyphicon-trash"></span></a>
            </legend>
            {{ Form::open([
                'url'		=>	'/m/deposito/'.$deposito->id,
                'method'	=>	'put',
                'class' 	=> 	'form-horizontal']) }}
            <fieldset>
                <div class="form-group">
                    {{ Form::label('nombre', 'Nombre', ['class' => 'col-sm-2 control-label']) }}
                    <div class="col-sm-10">
                        {{ Form::text('nombre', $deposito->nombre, ['placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required']) }}
                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        {{ Form::submit('Guardar', ['class' => 'btn btn-primary pull-right']) }}
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
            if (confirm("¿Desea borrar el registro?")) {
                if (confirm("El registro no podrá ser recuperado, ¿Desea continuar?")) {
                    $.ajax({
                        type: 'delete',
                        url: '/m/deposito/' + "{{ $deposito->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        if (data.error) {
                            alert("Se produjo un problema el intentar eliminar el Deposito: {{ $deposito->nombre }}");
                            alert(data.msg);
                        }
                        window.location.replace("{{ URL::to('/m/deposito') }}");
                    });
                }
            }
        }
    </script>
@stop