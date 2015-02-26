@extends('layout.landing')

@section('title')
    Editar: {{ $material->nombre }}
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend> {{ $material->nombre }}
                <a id="dlt" onclick="destroy()" class="glyphicon glyphicon-trash pull-right"></a>
            </legend>
            {{ Form::open(array(
                'url'		=>	'/m/material/'.$material->id,
                'method'	=>	'put',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                {{-- Nombre --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nombre">Nombre</label>

                    <div class="col-sm-10">
                        <input id="nombre" name="nombre" placeholder="Nombre estación" class="form-control" type="text" required="required"
                               value="{{ $material->nombre }}">

                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>
                {{-- Valor --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="valor">Valor Unitario (UF)</label>

                    <div class="col-sm-10">
                        <input id="valor" name="valor" placeholder="Valor" class="form-control" type="number" min="0" step="0.01" required="required"
                               value="{{ $material->valor }}">

                        <p class="text-danger">{{ $errors->first('valor') }}</p>
                    </div>
                </div>
                {{-- Proveedor --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="proveedor">Proveedor</label>

                    <div class="col-sm-10">
                        <input id="proveedor" name="proveedor" placeholder="Proveedor" class="form-control" type="text" required="required"
                               value="{{ $material->proveedor }}">

                        <p class="text-danger">{{ $errors->first('proveedor') }}</p>
                    </div>
                </div>
                {{-- Unidad --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="unidad">Unidad</label>

                    <div class="col-sm-10">
                        <input id="unidad" name="unidad" placeholder="Unidad" class="form-control" type="text" required="required"
                               value="{{ $material->unidad }}">

                        <p class="text-danger">{{ $errors->first('unidad') }}</p>
                    </div>
                </div>

                {{-- Checkbox esOficial --}}
                <div id="es_oficial_div" class="form-group">
                    {{ Form::label('es_oficial', 'Oficial', array('class' => 'col-sm-2 control-label')) }}
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                @if( $material->es_oficial ) <input name="es_oficial" type="checkbox" value="true" checked="checked">
                                @else <input name="es_oficial" type="checkbox" value="true">
                                @endif
                                <abbr title="Quiere decir que será incluido en el Form 2-3-4">¿Qué es esto?</abbr>
                            </label>
                        </div>
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
            if ( confirm("¿Desea borrar el trabajo?") == true ) {
                if ( confirm("El registro no podrá ser recuperado, ¿Desea continuar?") ) {
                    $.ajax({
                        type: 'delete',
                        url: '/m/material/' + "{{ $material->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        if ( data.error ) alert("Se produjo un problema el intentar eliminar el Material {{ $material->nombre }}");

                        window.location.replace("{{ URL::to('/m/material') }}");
                    });
                }
            }
        };
    </script>
@stop