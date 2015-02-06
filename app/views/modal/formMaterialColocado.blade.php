{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 04-02-15
 * Time: 22:39
--}}

{{-- Modal form Material Colocado
===================================================== --}}
<div class="modal fade" id="modalMaterialCol" tabindex="-1" role="dialog" aria-labelledby="modalMaterialColLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalMaterialColLabel">Nuevo Material</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array(
                'url'		=>	'/material-colocado',
                'method'	=>	'post',
                'id' 		=> 	'formMaterialColocado',
                'class' 	=> 	'form-horizontal')) }}
                    <fieldset>
                        {{-- Nombre del material --}}
                        <div id="nombre_div" class="form-group">
                            {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
                            <div class="col-sm-10">
                                {{ Form::text('nombre', null, array('placeholder' => 'Nombre Material', 'class' => 'form-control')) }}
                                <div class="help-block" id ="nombre_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{-- Código del material --}}
                            <div id="codigo_div">
                                {{ Form::label('codigo', 'Código', array('class' => 'col-sm-2 control-label')) }}
                                <div class="col-sm-4">
                                    {{ Form::text('codigo', null, array('placeholder' => 'Códio del Material', 'class' => 'form-control')) }}
                                    <div class="help-block" id ="codigo_error"></div>
                                </div>
                            </div>

                            {{-- Proveedor del material --}}
                            <div id="proveedor_div">
                                {{ Form::label('proveedor', 'Proveedor', array('class' => 'col-sm-2 control-label')) }}
                                <div class="col-sm-4">
                                    {{ Form::text('proveedor', null, array('placeholder' => 'Proveedor del Material', 'class' => 'form-control')) }}
                                    <div class="help-block" id ="proveedor_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{-- Unidad del material --}}
                            <div id="unidad_div">
                                {{ Form::label('unidad', 'Unidad', array('class' => 'col-sm-2 control-label')) }}
                                <div class="col-sm-4">
                                    {{ Form::text('unidad', null, array('placeholder' => 'Unidad del Material', 'class' => 'form-control')) }}
                                    <div class="help-block" id ="unidad_error"></div>
                                </div>
                            </div>

                            {{-- Clase del material --}}
                            <div id="clase_div">
                                {{ Form::label('clase', 'Clase', array('class' => 'col-sm-2 control-label')) }}
                                <div class="col-sm-4">
                                    {{ Form::text('clase', null, array('placeholder' => 'Clase del Material', 'class' => 'form-control')) }}
                                    <div class="help-block" id ="clase_error"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox esOficial --}}
                        <div id="es_oficial_div" class="form-group">
                            {{ Form::label('es_oficial', 'Oficial', array('class' => 'col-sm-2 control-label')) }}
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('es_oficial', 'true'); }}
                                        <abbr title="Quiere decir que será incluido en el Form 2-3-4">¿Qué es esto?</abbr>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>