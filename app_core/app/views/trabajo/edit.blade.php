@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la edición de un trabajo">
    <meta name="author" content="earosb">
@stop

@section('title')
    Editar Trabajo
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            {{ Form::open(array(
                'url'		=>	'/m/trabajo/'. $trabajo->id,
                'method'	=>	'put',
                'class' 	=> 	'form-horizontal')) }}

            <legend>Editar: {{ $trabajo->nombre }}
                <a id="dlt" onclick="destroy()" class="text-danger pull-right"><span
                            class="glyphicon glyphicon-trash"></span></a>
            </legend>
            {{-- Nombre --}}
            <div class="form-group">
                {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}

                <div class="col-sm-10">
                    {{ Form::text('nombre', $trabajo->nombre, array('placeholder' => 'Nombre del trabajo', 'class' => 'form-control', 'required' => 'required')) }}
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
                                        <option selected="selected" value="{{ $t->id }}">{{ $t->nombre }}
                                            [{{ $t->unidad }}]
                                        </option>
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
                {{ Form::label('valor', 'Valor Unitario (UF)', array('class' => 'col-sm-2 control-label')) }}

                <div class="col-sm-10">
                    {{ Form::number('valor', $trabajo->valor, array('class' => 'form-control', 'placeholder' => 'Valor del Trabajo', 'min' => '0', 'step' => '0.01', 'required' => 'required')) }}
                    <p class="text-danger">{{ $errors->first('valor') }}</p>
                </div>
            </div>

            {{-- Unidad --}}
            <div class="form-group">
                {{ Form::label('unidad', 'Unidad de Medida', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    {{ Form::text('unidad', $trabajo->unidad, array('placeholder' => 'm3, nro, mlv, etc.', 'class' => 'form-control', 'required' => 'required')) }}
                    <p class="text-danger">{{ $errors->first('unidad') }}</p>
                </div>
            </div>

            {{-- Checkbox esOficial --}}
            <div class="form-group">
                {{ Form::label('es_oficial', 'Form 2', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    <div class="checkbox">
                        <label>
                            @if($trabajo->es_oficial == true)
                                {{ Form::checkbox('es_oficial', 'true', true) }}
                            @else
                                {{ Form::checkbox('es_oficial', 'true') }}
                            @endif
                            <abbr title="Quiere decir que será incluido en Formulario 2">¿Qué es
                                esto?</abbr>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Radio tipo mantenimiento --}}
            <div class="form-group">
                {{ Form::label('tMat', 'Mantenimiento', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    @foreach($tipoMantenimiento as $tMat)
                        <div class="radio">
                            <label>
                                @if( $tMat->id == $trabajo->tipo_mantenimiento_id )
                                    {{ Form::radio('tMat', $tMat->id, true) }}
                                @else
                                    {{ Form::radio('tMat', $tMat->id) }}
                                @endif
                                {{ $tMat->nombre }}
                            </label>
                        </div>
                    @endforeach
                    <p class="text-danger">{{ $errors->first('tMat') }}</p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    {{ Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) }}
                </div>
            </div>

        </div>
        {{-- Checkboxes Materiales Asociados --}}
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Materiales Asociados</div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            @foreach($trabajo->materiales as $material)
                                <div class="checkbox">
                                    <label>
                                        @if($trabajo->id == $material->trabajo_id)
                                            {{ Form::checkbox('materiales['.$material->id.']', $material->id, true) }}
                                            <p>{{ $material->nombre }}</p>
                                        @else
                                            {{ Form::checkbox('materiales['.$material->id.']', $material->id, false) }}
                                            <p>{{ $material->nombre }}</p>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ Form::close() }}
    </div>
@stop

@section('js')
    <script type="text/javascript">
        function destroy() {
            if (confirm("¿Desea borrar el trabajo?") == true) {
                if (confirm("El registro no podrá ser recuperado, ¿Desea continuar?")) {
                    $.ajax({
                        type: 'delete',
                        url: '/m/trabajo/' + "{{ $trabajo->id }}"
                    }).error(function () {
                        alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                    }).done(function (data) {
                        if (data.error) {
                            alert("Se produjo un problema el intentar eliminar el Trabajo {{ $trabajo->nombre }}");
                            alert(data.msg);
                        }

                        window.location.replace("{{ URL::to('/m/trabajo') }}");
                    });
                }
            }
        }
        ;
    </script>
@stop