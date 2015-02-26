@extends('layout.landing')

@section('title')
    Nuevo Trabajo
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            {{ Form::open(array(
                'url'		=>	'/m/trabajo/'. $trabajo->id,
                'method'	=>	'put',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                <legend>Nuevo Trabajo
                    <a id="dlt" onclick="destroy()" class="text-danger pull-right"><span class="glyphicon glyphicon-trash"></span></a>
                </legend>
                {{-- Nombre --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nombre">Nombre</label>

                    <div class="col-sm-10">
                        <input id="nombre" name="nombre" placeholder="Nombre del trabajo" class="form-control" type="text"
                               value="{{ $trabajo->nombre }}">

                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                    </div>
                </div>

                {{-- Trabajo Padre --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="padre">Trabajo Asociado</label>

                    <div class="col-sm-10">
                        <select name="padre" class="form-control">
                            <option selected="selected" value="none">Ninguno</option>
                            @foreach($tipoMantenimiento as $tMat)
                                <optgroup label="{{ $tMat->nombre }}">
                                    @foreach($tMat->trabajos as $t)
                                        @if( $t->id == $trabajo->padre_id)
                                            <option selected="selected" value="{{ $t->id }}">{{ $t->nombre }} [{{ $t->unidad }}]</option>
                                        @else
                                            <option value="{{ $t->id }}">{{ $t->nombre }} [{{ $t->unidad }}]</option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>

                        <p class="text-danger">{{ $errors->first('padre') }}</p>
                    </div>
                </div>
                {{-- Valor --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="valor">Valor Unitario (UF)</label>

                    <div class="col-sm-10">
                        <input id="valor" name="valor" placeholder="Valor del Trabajo" class="form-control" type="number" step="0.01" min="0"
                               required="required" value="{{ $trabajo->valor }}">

                        <p class="text-danger">{{ $errors->first('valor') }}</p>
                    </div>
                </div>

                {{-- Unidad --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="unidad">Unidad de Medida</label>

                    <div class="col-sm-10">
                        <input id="unidad" name="unidad" placeholder="m3, nro, mlv, etc." class="form-control" type="text" required="required"
                               value="{{ $trabajo->unidad }}">

                        <p class="text-danger">{{ $errors->first('unidad') }}</p>
                    </div>
                </div>

                {{-- Checkbox esOficial --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="es_oficial">Oficial</label>

                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                @if($trabajo->es_oficial == true)
                                    <input name="es_oficial" type="checkbox" value="true" checked="checked">
                                @else
                                    <input name="es_oficial" type="checkbox" value="true">
                                @endif
                                <abbr title="Quiere decir que será incluido en el Form 2-3-4">¿Qué es esto?</abbr>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Radio tipo mantenimiento --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Mantenimiento</label>

                    <div class="col-sm-10">
                        @foreach($tipoMantenimiento as $tMat)
                            <div class="radio">
                                <label>
                                    @if( $tMat->id == $trabajo->tipo_mantenimiento_id )
                                        <input name="tMat" id="tMat{{ $tMat->id }}" value="{{ $tMat->id }}" checked="checked"
                                               type="radio">{{ $tMat->nombre }}
                                    @else
                                        <input name="tMat" id="tMat{{ $tMat->id }}" value="{{ $tMat->id }}" type="radio">{{ $tMat->nombre }}
                                    @endif
                                </label>
                            </div>
                        @endforeach
                        <p class="text-danger">{{ $errors->first('tMat') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                        <button id="btn_guardar" name="btn_guardar" class="btn btn-success pull-right">Guardar</button>
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
                        url: '/m/trabajo/' + "{{ $trabajo->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        if ( data.error ) alert("Se produjo un problema el intentar eliminar el Trabajo {{ $trabajo->nombre }}");

                        window.location.replace("{{ URL::to('/m/trabajo') }}");
                    });
                }
            }
        }
        ;
    </script>
@stop