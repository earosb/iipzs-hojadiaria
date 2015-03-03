{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 04-02-15
 * Time: 22:53
--}}

{{-- Modal form TRABAJO
===================================================== --}}
<div class="modal fade" id="modalTrabajo" tabindex="-1" role="dialog" aria-labelledby="modalTrabajoLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTrabajoLabel">Nuevo Trabajo</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array(
                'url'		=>	'/trabajo',
                'method'	=>	'post',
                'id' 		=> 	'formTrabajo',
                'class' 	=> 	'form-horizontal')) }}
                <fieldset>
                    {{-- Nombre --}}
                    <div id="nombre_div" class="form-group">
                        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-3 control-label')) }}
                        <div class="col-sm-9">
                            {{ Form::text('nombre', null, array('placeholder' => 'Nombre Trabajo', 'class' => 'form-control')) }}
                            <div class="help-block" id="nombre_error"></div>
                        </div>
                    </div>

                    {{-- Trabajo Padre --}}
                    <div id="padre_div" class="form-group">
                        {{ Form::label('padre', 'Trabajo Asociado', array('class' => 'col-sm-3 control-label')) }}
                        <div class="col-sm-9">
                            <select name="padre" class="form-control">
                                <option selected="selected" value="none">Ninguno</option>
                                @foreach($tipoMantenimiento as $tMat)
                                    <optgroup label="{{ $tMat->nombre }}">
                                        @foreach($tMat->trabajos as $trabajo)
                                            <option value="{{ $trabajo->id }}">{{ $trabajo->nombre }}
                                                [{{ $trabajo->unidad }}]
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <div class="help-block" id="padre_error"></div>
                        </div>
                    </div>

                    {{-- Valor --}}
                    <div id="valor_div" class="form-group">
                        {{ Form::label('valor', 'Valor Unitario (UF)', array('class' => 'col-sm-3 control-label')) }}
                        <div class="col-sm-9">
                            {{ Form::text('valor', null, array('placeholder' => 'Valor del Trabajo', 'class' => 'form-control')) }}
                            <div class="help-block" id="valor_error"></div>
                        </div>
                    </div>

                    {{-- Unidad --}}
                    <div id="unidad_div" class="form-group">
                        {{ Form::label('unidad', 'Unidad de Medida', array('class' => 'col-sm-3 control-label')) }}
                        <div class="col-sm-9">
                            {{ Form::text('unidad', null, array('placeholder' => 'm3, nro, mlv, etc.', 'class' => 'form-control')) }}
                            <div class="help-block" id="unidad_error"></div>
                        </div>
                    </div>

                    {{-- Checkbox esOficial --}}
                    <div id="es_oficial_div" class="form-group">
                        {{ Form::label('es_oficial', 'Form 2-3-4', array('class' => 'col-sm-3 control-label')) }}
                        <div class="col-sm-9">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('es_oficial', 'true') }}
                                    <abbr title="Quiere decir que será incluido en los Formularios 2-3-4">¿Qué es esto?</abbr>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Radio tipo mantenimiento --}}
                    <div id="tMat" class="form-group">
                        <label class="col-sm-3 control-label">Mantenimiento</label>
                        <div class="col-sm-9">
                            @foreach($tipoMantenimiento as $tMat)
                                <div class="radio">
                                    <label>
                                        <input name="tMat" id="tMat{{ $tMat->id }}" value="{{ $tMat->id }}" checked=""
                                               type="radio">
                                        {{ $tMat->nombre }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="help-block" id="tMat_error"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        {{ Form::submit('Guardar', array('class'=>'btn btn-primary')) }}
                    </div>
                </fieldset>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

{{--{{ HTML::script('js/hd/modal/formTrabajo.js') }}--}}
{{ HTML::script('js/min/1425319861714.min.js') }}