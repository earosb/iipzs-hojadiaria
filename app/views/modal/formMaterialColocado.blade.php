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
                        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-3 control-label')) }}
                        <div class="col-sm-8">
                            {{ Form::text('nombre', null, array('placeholder' => 'Nombre', 'class' => 'form-control')) }}
                            <div class="help-block" id="nombre_error"></div>
                        </div>
                    </div>
                        {{-- Código del material --}}
                        {{--<div id="codigo_div" class="form-group">--}}
                        {{--{{ Form::label('codigo', 'Código', array('class' => 'col-sm-2 control-label')) }}--}}
                        {{--<div class="col-sm-4">--}}
                        {{--{{ Form::text('codigo', null, array('placeholder' => 'Códio del Material', 'class' => 'form-control')) }}--}}
                        {{--<div class="help-block" id ="codigo_error"></div>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        {{-- Valor del material --}}
                        <div id="valor_div" class="form-group">
                            {{ Form::label('valor', 'Valor Unitario (UF)', array('class' => 'col-sm-3 control-label')) }}
                            <div class="col-sm-6">
                                {{ Form::text('valor', null, array('placeholder' => 'Valor', 'class' => 'form-control')) }}
                                <div class="help-block" id="valor_error"></div>
                            </div>
                        </div>

                        {{-- Proveedor del material --}}
                        <div id="proveedor_div" class="form-group">
                            {{ Form::label('proveedor', 'Proveedor', array('class' => 'col-sm-3 control-label')) }}
                            <div class="col-sm-6">
                                {{ Form::text('proveedor', null, array('placeholder' => 'Proveedor', 'class' => 'form-control')) }}
                                <div class="help-block" id="proveedor_error"></div>
                            </div>
                        </div>
                        {{-- Unidad del material --}}
                        <div id="unidad_div" class="form-group">
                            {{ Form::label('unidad', 'Unidad', array('class' => 'col-sm-3 control-label')) }}
                            <div class="col-sm-6">
                                {{ Form::text('unidad', null, array('placeholder' => 'Unidad', 'class' => 'form-control')) }}
                                <div class="help-block" id="unidad_error"></div>
                            </div>
                        </div>

                        {{-- Clase del material --}}
                        <div id="clase_div" class="form-group">
                            {{ Form::label('clase', 'Clase', array('class' => 'col-sm-3 control-label')) }}
                            <div class="col-sm-6">
                                {{ Form::text('clase', null, array('placeholder' => 'Clase', 'class' => 'form-control')) }}
                                <div class="help-block" id="clase_error"></div>
                            </div>
                        </div>

                    {{-- Checkbox esOficial --}}
                    <div id="es_oficial_div" class="form-group">
                        {{ Form::label('es_oficial', 'Oficial', array('class' => 'col-sm-3 control-label')) }}
                        <div class="col-sm-8">
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
                        {{ Form::submit('Guardar', array('class'=>'btn btn-primary')) }}
                    </div>

                </fieldset>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

{{ HTML::script('js/hd/modal/formMaterialCol.js') }}